<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cemetery Management System - Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #111827; background: #fff; }

        .header { background: #111827; color: #fff; padding: 24px 32px; margin-bottom: 24px; }
        .header h1 { font-size: 18px; font-weight: bold; letter-spacing: 1px; }
        .header p { font-size: 11px; color: #9ca3af; margin-top: 4px; }
        .header .date { font-size: 11px; color: #9ca3af; margin-top: 2px; }

        .section { margin: 0 32px 24px 32px; }
        .section-title { font-size: 10px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; padding-bottom: 6px; border-bottom: 1px solid #e5e7eb; }

        .grid-4 { display: table; width: 100%; margin-bottom: 16px; }
        .grid-4 .col { display: table-cell; width: 25%; padding-right: 12px; }
        .grid-3 { display: table; width: 100%; margin-bottom: 16px; }
        .grid-3 .col { display: table-cell; width: 33.33%; padding-right: 12px; }

        .stat-card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px; }
        .stat-card .label { font-size: 9px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .stat-card .value { font-size: 22px; font-weight: bold; color: #111827; }
        .stat-card .sub { font-size: 9px; color: #9ca3af; margin-top: 4px; }

        .stat-card.green .value { color: #16a34a; }
        .stat-card.red .value { color: #dc2626; }
        .stat-card.yellow .value { color: #ca8a04; }

        table { width: 100%; border-collapse: collapse; }
        table thead tr { background: #f9fafb; }
        table thead th { text-align: left; padding: 10px 12px; font-size: 9px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e5e7eb; }
        table tbody tr { border-bottom: 1px solid #f3f4f6; }
        table tbody tr:last-child { border-bottom: none; }
        table tbody td { padding: 10px 12px; font-size: 11px; color: #374151; }
        table tbody tr:nth-child(even) { background: #f9fafb; }

        .table-wrapper { border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; }

        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: bold; }
        .badge.green { background: #dcfce7; color: #16a34a; }
        .badge.red { background: #fee2e2; color: #dc2626; }
        .badge.yellow { background: #fef9c3; color: #ca8a04; }

        .footer { margin: 32px 32px 24px 32px; padding-top: 12px; border-top: 1px solid #e5e7eb; display: table; width: calc(100% - 64px); }
        .footer .left { display: table-cell; font-size: 10px; color: #9ca3af; }
        .footer .right { display: table-cell; text-align: right; font-size: 10px; color: #9ca3af; }

        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Cemetery Management System</h1>
        <p>Official System Report</p>
        <p class="date">Generated on: {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <!-- Overview Stats -->
    <div class="section">
        <div class="section-title">Overview</div>
        <div class="grid-4">
            <div class="col">
                <div class="stat-card">
                    <div class="label">Total Deceased</div>
                    <div class="value">{{ $totalDeceased }}</div>
                    <div class="sub">Deceased records</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="label">Total Burials</div>
                    <div class="value">{{ $totalBurials }}</div>
                    <div class="sub">Burial records</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="label">Total Inquiries</div>
                    <div class="value">{{ $totalInquiries }}</div>
                    <div class="sub">All inquiries</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="label">Total Users</div>
                    <div class="value">{{ $totalUsers }}</div>
                    <div class="sub">Admin & Staff</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lots Summary -->
    <div class="section">
        <div class="section-title">Lot Status Summary</div>
        <div class="grid-3">
            <div class="col">
                <div class="stat-card green">
                    <div class="label">Available Lots</div>
                    <div class="value">{{ $availableLots }}</div>
                    <div class="sub">out of {{ $totalLots }} total lots</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card red">
                    <div class="label">Occupied Lots</div>
                    <div class="value">{{ $occupiedLots }}</div>
                    <div class="sub">out of {{ $totalLots }} total lots</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card yellow">
                    <div class="label">Reserved Lots</div>
                    <div class="value">{{ $reservedLots }}</div>
                    <div class="sub">out of {{ $totalLots }} total lots</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Summary -->
    <div class="section">
        <div class="section-title">Payment Summary</div>
        <div class="grid-3">
            <div class="col">
                <div class="stat-card">
                    <div class="label">Total Collections</div>
                    <div class="value" style="font-size: 16px;">PHP {{ number_format($totalPayments, 2) }}</div>
                    <div class="sub">All payments combined</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card green">
                    <div class="label">Paid</div>
                    <div class="value" style="font-size: 16px;">PHP {{ number_format($paidPayments, 2) }}</div>
                    <div class="sub">Fully settled</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card red">
                    <div class="label">Unpaid</div>
                    <div class="value" style="font-size: 16px;">PHP {{ number_format($unpaidPayments, 2) }}</div>
                    <div class="sub">Outstanding balance</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Deceased -->
    <div class="section">
        <div class="section-title">Recent Deceased Records</div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Date of Birth</th>
                        <th>Date of Death</th>
                        <th>Cause of Death</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentDeceased as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $record->first_name }} {{ $record->last_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->date_of_birth)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->date_of_death)->format('M d, Y') }}</td>
                        <td>{{ $record->cause_of_death ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #9ca3af;">No records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Recent Payments -->
    <div class="header">
        <h1>Cemetery Management System</h1>
        <p>Official System Report — Payment Records</p>
        <p class="date">Generated on: {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Recent Payment Records</div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Deceased</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPayments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payment->burial->deceased->first_name }} {{ $payment->burial->deceased->last_name }}</td>
                        <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $payment->type) }}</td>
                        <td>PHP {{ number_format($payment->amount, 2) }}</td>
                        <td>
                            @if($payment->status === 'paid')
                                <span class="badge green">Paid</span>
                            @elseif($payment->status === 'unpaid')
                                <span class="badge red">Unpaid</span>
                            @else
                                <span class="badge yellow">Partial</span>
                            @endif
                        </td>
                        <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #9ca3af;">No records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="left">Cemetery Management System &copy; {{ date('Y') }}. All rights reserved.</div>
        <div class="right">Davao City, Philippines &nbsp;|&nbsp; (082) 123-4567 &nbsp;|&nbsp; info@cemetery.com</div>
    </div>

</body>
</html>