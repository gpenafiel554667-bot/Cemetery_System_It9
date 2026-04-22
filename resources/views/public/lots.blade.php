@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Available Burial Lots</h1>
        <p class="text-gray-500 mt-1 text-sm">Browse our available burial lots and their pricing.</p>
    </div>

    @if($lots->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($lots as $lot)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Lot {{ $lot->lot_number }}</h3>
                    <p class="text-gray-500 text-sm">Section {{ $lot->section }}, Row {{ $lot->row }}</p>
                </div>
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Available</span>
            </div>
            <div class="border-t border-gray-100 pt-4 space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Type</span>
                    <span class="font-semibold text-gray-800 text-sm capitalize">{{ $lot->type }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Price</span>
                    <span class="font-bold text-gray-900 text-lg">PHP {{ number_format($lot->price, 2) }}</span>
                </div>
                @if($lot->description)
                <p class="text-gray-400 text-sm pt-2">{{ $lot->description }}</p>
                @endif
            </div>
            <a href="{{ route('public.contact') }}" class="block w-full text-center bg-gray-900 text-white py-2.5 rounded-lg hover:bg-gray-700 transition text-sm font-semibold mt-4">Inquire Now</a>
        </div>
        @endforeach
    </div>
    <div>{{ $lots->links() }}</div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-16 text-center">
        <p class="text-gray-500 text-lg font-semibold">No available lots at the moment</p>
        <p class="text-gray-400 text-sm mt-2">Please contact us for more information.</p>
        <a href="{{ route('public.contact') }}" class="mt-6 inline-block bg-gray-900 text-white px-8 py-3 rounded-lg hover:bg-gray-700 transition text-sm font-semibold">Contact Us</a>
    </div>
    @endif
</div>
@endsection