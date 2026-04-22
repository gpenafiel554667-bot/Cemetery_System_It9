@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Contact Us</h1>
        <p class="text-gray-500 mt-1 text-sm">Send us an inquiry and we will get back to you as soon as possible.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 border border-green-200 px-6 py-4 rounded-xl mb-6 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <!-- Inquiry Form -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Send an Inquiry</h2>
                <form method="POST" action="{{ route('public.inquiry.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Number <span class="text-red-500">*</span></label>
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}" placeholder="Enter your contact number"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                            @error('contact_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email (optional)"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                            <textarea name="message" rows="5" placeholder="Write your inquiry or message here..."
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">{{ old('message') }}</textarea>
                            @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-lg hover:bg-gray-700 transition font-semibold text-sm">Send Inquiry</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Address</p>
                            <p class="text-gray-500 text-sm mt-0.5">Cemetery Road, Davao City, Philippines</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Phone</p>
                            <p class="text-gray-500 text-sm mt-0.5">(082) 123-4567</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Email</p>
                            <p class="text-gray-500 text-sm mt-0.5">info@cemetery.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Office Hours</p>
                            <p class="text-gray-500 text-sm mt-0.5">Monday - Saturday</p>
                            <p class="text-gray-500 text-sm">8:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-950 text-white rounded-xl p-6">
                <h3 class="font-bold text-lg mb-2">Need urgent help?</h3>
                <p class="text-gray-400 text-sm mb-4">Call us directly for immediate assistance with burial arrangements.</p>
                <a href="tel:0821234567" class="block text-center bg-white text-gray-900 py-2.5 rounded-lg font-semibold hover:bg-gray-200 transition text-sm">Call Now</a>
            </div>
        </div>
    </div>

    <!-- What to Bring -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">What to Bring</h2>
        <p class="text-gray-500 text-sm mb-6">When visiting our office for burial arrangements, please bring the following documents.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Required Documents</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-bold mt-0.5 flex-shrink-0">Required</span>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Death Certificate</p>
                            <p class="text-gray-500 text-xs mt-0.5">Original copy issued by the Local Civil Registry</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-bold mt-0.5 flex-shrink-0">Required</span>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Burial Permit</p>
                            <p class="text-gray-500 text-xs mt-0.5">Issued by the Local Health Office or City Health Officer</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-bold mt-0.5 flex-shrink-0">Required</span>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Valid ID of Next of Kin</p>
                            <p class="text-gray-500 text-xs mt-0.5">Any government-issued ID of the family representative</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-bold mt-0.5 flex-shrink-0">Required</span>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Transfer Permit</p>
                            <p class="text-gray-500 text-xs mt-0.5">Required if the deceased passed away in another location</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Optional Documents</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold mt-0.5 flex-shrink-0">Optional</span>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Marriage Certificate</p>
                            <p class="text-gray-500 text-xs mt-0.5">If the next of kin is the spouse of the deceased</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold mt-0.5 flex-shrink-0">Optional</span>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Birth Certificate</p>
                            <p class="text-gray-500 text-xs mt-0.5">To verify relationship to the deceased</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold mt-0.5 flex-shrink-0">Optional</span>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Photo of Deceased</p>
                            <p class="text-gray-500 text-xs mt-0.5">For record purposes in our system</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold mt-0.5 flex-shrink-0">Optional</span>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Proof of Payment</p>
                            <p class="text-gray-500 text-xs mt-0.5">If payment was made via bank transfer or GCash</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="bg-gray-950 text-white rounded-xl p-10">
        <h2 class="text-2xl font-bold mb-2 text-center">How It Works</h2>
        <p class="text-gray-400 text-sm text-center mb-10">Simple steps to arrange burial services with us.</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-12 h-12 bg-white text-gray-900 rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4">1</div>
                <h4 class="font-bold mb-2">Send Inquiry</h4>
                <p class="text-gray-400 text-sm">Fill out the inquiry form above or call us directly.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-white text-gray-900 rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4">2</div>
                <h4 class="font-bold mb-2">We Contact You</h4>
                <p class="text-gray-400 text-sm">Our staff will reach out to discuss arrangements.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-white text-gray-900 rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4">3</div>
                <h4 class="font-bold mb-2">Visit Our Office</h4>
                <p class="text-gray-400 text-sm">Bring required documents and finalize arrangements.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-white text-gray-900 rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4">4</div>
                <h4 class="font-bold mb-2">Burial Arranged</h4>
                <p class="text-gray-400 text-sm">We handle everything with care and dignity.</p>
            </div>
        </div>
    </div>
</div>
@endsection