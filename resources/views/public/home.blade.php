@extends('layouts.public')

@section('content')

<!-- Hero -->
<div class="bg-gray-950 text-white py-24">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-5xl font-bold tracking-tight mb-4">Cemetery Management System</h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto mb-10">Helping families find peace and closure. Search for your loved ones or inquire about burial lots.</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('public.search') }}" class="bg-white text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition text-sm">Search Deceased</a>
            <a href="{{ route('public.lots') }}" class="border border-gray-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-800 transition text-sm">View Available Lots</a>
        </div>
    </div>
</div>

<!-- Features -->
<div class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="w-12 h-12 bg-gray-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Search Records</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-4">Find deceased individuals and their burial location easily by name.</p>
            <a href="{{ route('public.search') }}" class="text-gray-900 text-sm font-semibold hover:underline">Search now</a>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="w-12 h-12 bg-gray-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Available Lots</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-4">Browse available burial lots and their pricing information.</p>
            <a href="{{ route('public.lots') }}" class="text-gray-900 text-sm font-semibold hover:underline">View lots</a>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="w-12 h-12 bg-gray-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Send Inquiry</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-4">Contact us for any questions, concerns, or burial arrangements.</p>
            <a href="{{ route('public.contact') }}" class="text-gray-900 text-sm font-semibold hover:underline">Contact us</a>
        </div>
    </div>

    <!-- How It Works -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-10 mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">How It Works</h2>
        <p class="text-gray-500 text-center text-sm mb-10">Simple steps to arrange burial services with us.</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4">1</div>
                <h4 class="font-bold text-gray-900 mb-2">Send Inquiry</h4>
                <p class="text-gray-500 text-sm">Fill out our online inquiry form or call us directly.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4">2</div>
                <h4 class="font-bold text-gray-900 mb-2">We Contact You</h4>
                <p class="text-gray-500 text-sm">Our staff will reach out to discuss burial arrangements.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4">3</div>
                <h4 class="font-bold text-gray-900 mb-2">Visit Our Office</h4>
                <p class="text-gray-500 text-sm">Bring required documents and finalize everything in person.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4">4</div>
                <h4 class="font-bold text-gray-900 mb-2">Burial Arranged</h4>
                <p class="text-gray-500 text-sm">We handle everything with care, dignity, and respect.</p>
            </div>
        </div>
    </div>

    <!-- Services Preview -->
    <div class="bg-gray-950 text-white rounded-xl p-10">
        <h2 class="text-2xl font-bold mb-2 text-center">Our Services</h2>
        <p class="text-gray-400 text-center text-sm mb-10">We provide dignified and compassionate burial services.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="border border-gray-800 rounded-xl p-6">
                <h4 class="font-bold text-lg mb-2">Ground Burial</h4>
                <p class="text-gray-400 text-sm">Traditional ground burial with full service arrangements including preparation, ceremony, and interment.</p>
            </div>
            <div class="border border-gray-800 rounded-xl p-6">
                <h4 class="font-bold text-lg mb-2">Mausoleum</h4>
                <p class="text-gray-400 text-sm">Above ground burial in our premium mausoleum facility. A dignified and protected resting place.</p>
            </div>
            <div class="border border-gray-800 rounded-xl p-6">
                <h4 class="font-bold text-lg mb-2">Columbarium</h4>
                <p class="text-gray-400 text-sm">Dignified niche placement for cremated remains in our modern columbarium facility.</p>
            </div>
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('public.services') }}" class="bg-white text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition text-sm">View All Services</a>
        </div>
    </div>
</div>

@endsection