@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900">Our Services</h1>
        <p class="text-gray-500 mt-1 text-sm">We provide dignified and compassionate burial services.</p>
    </div>

    <!-- Main Services -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="w-12 h-12 bg-gray-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-xl mb-3">Ground Burial</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Traditional ground burial with full service arrangements including preparation, ceremony, and interment.</p>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <p class="text-gray-400 text-xs uppercase tracking-wide">Starting at</p>
                <p class="text-xl font-bold text-gray-900 mt-1">Contact Us</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="w-12 h-12 bg-gray-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-xl mb-3">Mausoleum</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Above ground burial in our premium mausoleum facility. A dignified and protected resting place for your loved ones.</p>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <p class="text-gray-400 text-xs uppercase tracking-wide">Starting at</p>
                <p class="text-xl font-bold text-gray-900 mt-1">Contact Us</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="w-12 h-12 bg-gray-900 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-xl mb-3">Columbarium</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Dignified niche placement for cremated remains in our modern and well-maintained columbarium facility.</p>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <p class="text-gray-400 text-xs uppercase tracking-wide">Starting at</p>
                <p class="text-xl font-bold text-gray-900 mt-1">Contact Us</p>
            </div>
        </div>
    </div>

    <!-- Additional Services -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Additional Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-start gap-4 p-4 rounded-lg border border-gray-100">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Lot Maintenance</h4>
                    <p class="text-gray-500 text-sm mt-1">Regular maintenance and upkeep of burial lots to keep them clean and dignified.</p>
                </div>
            </div>
            <div class="flex items-start gap-4 p-4 rounded-lg border border-gray-100">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Document Processing</h4>
                    <p class="text-gray-500 text-sm mt-1">Assistance with burial permits and other required documentation.</p>
                </div>
            </div>
            <div class="flex items-start gap-4 p-4 rounded-lg border border-gray-100">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Memorial Services</h4>
                    <p class="text-gray-500 text-sm mt-1">Organization of memorial and prayer services for your loved ones.</p>
                </div>
            </div>
            <div class="flex items-start gap-4 p-4 rounded-lg border border-gray-100">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Floral Arrangements</h4>
                    <p class="text-gray-500 text-sm mt-1">Beautiful floral arrangements for burial ceremonies and memorial visits.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="bg-gray-950 text-white rounded-xl p-10 text-center">
        <h2 class="text-2xl font-bold mb-2">Ready to make arrangements?</h2>
        <p class="text-gray-400 text-sm mb-6">Contact us today and our staff will assist you every step of the way.</p>
        <a href="{{ route('public.contact') }}" class="bg-white text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition text-sm">Contact Us Now</a>
    </div>
</div>
@endsection