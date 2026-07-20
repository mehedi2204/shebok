@extends('layouts.admin')

@section('title', 'Website Settings')

@section('content')
<div class="max-w-4xl space-y-8 pb-20">
    @if(session('success'))
        <div class="bg-green-50 border border-green-100 text-green-600 px-6 py-4 rounded-2xl font-bold text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        <!-- General Configuration -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-xl font-bold text-slate-800">General Configuration</h3>
                <p class="text-slate-500 text-sm">Manage your website's basic settings and behavior.</p>
            </div>

            <div class="p-8 space-y-8">
                <!-- Website Name -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700">Website Name</label>
                        <p class="text-xs text-slate-400 mt-1">Displayed in the header and footer.</p>
                    </div>
                    <div class="md:col-span-2">
                        <input type="text" name="website_name" value="{{ $settings['website_name'] ?? 'Shebok' }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all font-medium">
                    </div>
                </div>

                <hr class="border-slate-50">

                <!-- User Approval -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700">User Approval</label>
                        <p class="text-xs text-slate-400 mt-1">Manual approval for new service givers.</p>
                    </div>
                    <div class="md:col-span-2">
                        <input type="hidden" name="require_approval" value="0">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="require_approval" value="1" {{ ($settings['require_approval'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-slate-600">Require Approval</span>
                        </label>
                    </div>
                </div>

                <hr class="border-slate-50">

                <!-- Listing Payment -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center" x-data="{ paymentRequired: {{ ($settings['payment_required'] ?? '1') == '1' ? 'true' : 'false' }} }">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700">Listing Payment</label>
                        <p class="text-xs text-slate-400 mt-1">Require payment for service listings.</p>
                    </div>
                    <div class="md:col-span-2 space-y-4">
                        <input type="hidden" name="payment_required" value="0">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="payment_required" value="1" x-model="paymentRequired" class="sr-only peer">
                            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-slate-600">Payment Required</span>
                        </label>

                        <div x-show="paymentRequired" x-transition class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                            <p class="text-xs text-blue-600 font-medium">When enabled, users will be prompted to choose a package before their listing goes live.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-xl font-bold text-slate-800">Contact Information</h3>
                <p class="text-slate-500 text-sm">Update your support and contact details.</p>
            </div>

            <div class="p-8 space-y-8">
                <!-- Support Email -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700">Support Email</label>
                    </div>
                    <div class="md:col-span-2">
                        <input type="email" name="support_email" value="{{ $settings['support_email'] ?? 'support@shebok.com' }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all font-medium">
                    </div>
                </div>

                <hr class="border-slate-50">

                <!-- Contact Number -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700">Contact Number</label>
                    </div>
                    <div class="md:col-span-2">
                        <input type="text" name="contact_number" value="{{ $settings['contact_number'] ?? '+880 1700 000 000' }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all font-medium">
                    </div>
                </div>

                <hr class="border-slate-50">

                <!-- WhatsApp Number -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700">WhatsApp Number</label>
                    </div>
                    <div class="md:col-span-2">
                        <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '+880 1700 000 000' }}" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all font-medium">
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-xl font-bold text-slate-800">Social Media</h3>
                <p class="text-slate-500 text-sm">Links to your official social media profiles.</p>
            </div>

            <div class="p-8 space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-xl shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <input type="text" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" placeholder="Facebook URL" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all font-medium">
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 flex items-center justify-center bg-blue-50 text-blue-500 rounded-xl shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.23 0H1.77C.8 0 0 .77 0 1.72v20.56C0 23.23.8 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.72V1.72C24 .77 23.2 0 22.23 0zM7.12 20.45H3.56V9h3.56v11.45zM5.34 7.58c-1.14 0-2.06-.93-2.06-2.06 0-1.14.92-2.06 2.06-2.06 1.14 0 2.06.93 2.06 2.06 0 1.14-.92 2.06-2.06 2.06zM20.45 20.45h-3.56v-5.6c0-1.34-.03-3.06-1.87-3.06-1.87 0-2.15 1.46-2.15 2.96v5.7h-3.56V9h3.42v1.56h.05c.48-.9 1.63-1.85 3.37-1.85 3.6 0 4.26 2.37 4.26 5.46v6.28z"/></svg>
                    </div>
                    <input type="text" name="linkedin_url" value="{{ $settings['linkedin_url'] ?? '' }}" placeholder="LinkedIn URL" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all font-medium">
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 flex items-center justify-center bg-pink-100 text-pink-600 rounded-xl shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </div>
                    <input type="text" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" placeholder="Instagram URL" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all font-medium">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 transition shadow-xl shadow-blue-200 active:scale-95 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                <span>Save All Settings</span>
            </button>
        </div>
    </form>
</div>
@endsection
