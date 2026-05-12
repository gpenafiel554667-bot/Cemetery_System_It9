@extends('layouts.staff')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Staff Dashboard</h1>
    <p class="text-gray-500 text-sm mt-1">Welcome back, {{ auth()->user()->name }}.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Deceased</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalDeceased }}</h2>
        <p class="text-gray-400 text-xs mt-2">Deceased records</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Burials</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBurials }}</h2>
        <p class="text-gray-400 text-xs mt-2">Burial records</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Pending Inquiries</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $pendingInquiries }}</h2>
        <p class="text-gray-400 text-xs mt-2">Awaiting response</p>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">


    <!-- Burials per Month -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-1">Burials per Month</h2>
        <p class="text-gray-400 text-xs mb-4">{{ date('Y') }} burial records overview</p>
        <canvas id="burialsChart" height="140"></canvas>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Quick Actions</h2>
        <div class="space-y-3">
            <a href="{{ route('staff.deceased.create') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Add Deceased Record</p>
                    <p class="text-xs text-gray-500">Add a new deceased record</p>
                </div>
            </a>
            <a href="{{ route('staff.burials.create') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Add Burial Record</p>
                    <p class="text-xs text-gray-500">Record a new burial</p>
                </div>
            </a>
            <a href="{{ route('staff.families.create') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Add Family Record</p>
                    <p class="text-xs text-gray-500">Add next of kin information</p>
                </div>
            </a>
            <a href="{{ route('staff.payments.create') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Record Payment</p>
                    <p class="text-xs text-gray-500">Add a new payment record</p>
                </div>
            </a>
            <a href="{{ route('staff.inquiries.index') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">View Inquiries</p>
                    <p class="text-xs text-gray-500">Check and respond to inquiries</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Lot Map -->
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Cemetery Lot Map</h2>
            <p class="text-gray-400 text-xs mt-1">Visual overview of all cemetery lots and their status.</p>
        </div>
        <div class="flex gap-4 text-xs">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-green-500"></div>
                <span class="text-gray-600">Available</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-red-500"></div>
                <span class="text-gray-600">Occupied</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-yellow-500"></div>
                <span class="text-gray-600">Reserved</span>
            </div>
        </div>
    </div>

    @foreach($lots as $section => $sectionLots)
    <div class="mb-8">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">{{ $section }}</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($sectionLots as $lot)
            <div class="relative group cursor-pointer"
                onclick="showLotInfo({{ $lot->id }}, '{{ $lot->lot_number }}', '{{ $lot->section }}', '{{ $lot->row }}', '{{ $lot->type }}', '{{ $lot->status }}', '{{ $lot->price }}', '{{ $lot->burial ? $lot->burial->deceased->first_name . ' ' . $lot->burial->deceased->last_name : 'N/A' }}', '{{ $lot->burial ? $lot->burial->burial_date : 'N/A' }}')">

                <div class="w-16 h-16 rounded-lg flex flex-col items-center justify-center text-white text-xs font-bold shadow-sm transition hover:scale-105
                    @if($lot->status === 'available') bg-green-500 hover:bg-green-600
                    @elseif($lot->status === 'occupied') bg-red-500 hover:bg-red-600
                    @else bg-yellow-500 hover:bg-yellow-600
                    @endif">
                    <span class="text-xs">{{ $lot->lot_number }}</span>
                    <span class="text-xs opacity-75">{{ $lot->row }}</span>
                </div>

                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block z-10 w-40">
                    <div class="bg-gray-900 text-white text-xs rounded-lg p-2 text-center shadow-lg">
                        <p class="font-bold">Lot {{ $lot->lot_number }}</p>
                        <p>{{ $lot->section }}, {{ $lot->row }}</p>
                        <p class="capitalize">{{ $lot->type }}</p>
                        @if($lot->status === 'occupied' && $lot->burial)
                            <p class="mt-1 text-red-300">{{ $lot->burial->deceased->first_name }} {{ $lot->burial->deceased->last_name }}</p>
                        @endif
                        <p class="capitalize mt-1
                            @if($lot->status === 'available') text-green-300
                            @elseif($lot->status === 'occupied') text-red-300
                            @else text-yellow-300
                            @endif">{{ $lot->status }}</p>
                    </div>
                    <div class="w-2 h-2 bg-gray-900 rotate-45 mx-auto -mt-1"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<!-- Lot Info Modal -->
<div id="lotInfoModal" style="display:none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">Lot Details</h2>
            <button onclick="closeLotModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Lot Number</p>
                    <p class="font-bold text-gray-900 mt-1" id="modal_lot_number"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Section</p>
                    <p class="font-bold text-gray-900 mt-1" id="modal_section"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Row</p>
                    <p class="font-bold text-gray-900 mt-1" id="modal_row"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Type</p>
                    <p class="font-bold text-gray-900 mt-1 capitalize" id="modal_type"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Price</p>
                    <p class="font-bold text-gray-900 mt-1" id="modal_price"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Status</p>
                    <p class="font-bold mt-1 capitalize" id="modal_status"></p>
                </div>
            </div>
            <div id="burial_info" class="bg-red-50 rounded-lg p-4 hidden">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Buried Person</p>
                <p class="font-bold text-gray-900" id="modal_deceased"></p>
                <p class="text-sm text-gray-500 mt-1">Burial Date: <span id="modal_burial_date"></span></p>
            </div>
        </div>
        <div class="mt-6">
            <button onclick="closeLotModal()" class="w-full bg-gray-900 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Close</button>
        </div>
    </div>
</div>

<script>
function showLotInfo(id, lotNumber, section, row, type, status, price, deceased, burialDate) {
    document.getElementById('modal_lot_number').textContent = lotNumber;
    document.getElementById('modal_section').textContent = section;
    document.getElementById('modal_row').textContent = row;
    document.getElementById('modal_type').textContent = type;
    document.getElementById('modal_price').textContent = 'PHP ' + parseFloat(price).toLocaleString('en-PH', {minimumFractionDigits: 2});

    const statusEl = document.getElementById('modal_status');
    statusEl.textContent = status;
    statusEl.className = 'font-bold mt-1 capitalize';
    if (status === 'available') statusEl.classList.add('text-green-600');
    else if (status === 'occupied') statusEl.classList.add('text-red-600');
    else statusEl.classList.add('text-yellow-600');

    const burialInfo = document.getElementById('burial_info');
    if (status === 'occupied' && deceased !== 'N/A') {
        burialInfo.classList.remove('hidden');
        document.getElementById('modal_deceased').textContent = deceased;
        document.getElementById('modal_burial_date').textContent = burialDate;
    } else {
        burialInfo.classList.add('hidden');
    }

    document.getElementById('lotInfoModal').style.display = 'flex';
}

function closeLotModal() {
    document.getElementById('lotInfoModal').style.display = 'none';
}

window.onclick = function(e) {
    if (e.target.id === 'lotInfoModal') closeLotModal();
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<script>
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const burialData = @json($burialData->values());

    new Chart(document.getElementById('burialsChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Burials',
                data: burialData,
                backgroundColor: 'rgba(17, 24, 39, 0.8)',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#9ca3af', font: { size: 11 } },
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    ticks: { color: '#9ca3af', font: { size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection