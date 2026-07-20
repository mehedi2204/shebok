@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-8 text-center">Help Center</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-xl font-bold text-slate-800 mb-4">Getting Started</h3>
                <ul class="space-y-3 text-slate-600">
                    <li><a href="#" class="hover:text-blue-600 transition">How to create an account?</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">How to find a service?</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Setting up your profile</a></li>
                </ul>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-xl font-bold text-slate-800 mb-4">For Service Givers</h3>
                <ul class="space-y-3 text-slate-600">
                    <li><a href="#" class="hover:text-blue-600 transition">How to list your service?</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Verification process</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Managing appointments</a></li>
                </ul>
            </div>
        </div>

        <div class="bg-blue-600 rounded-[2rem] p-8 md:p-12 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Still need help?</h2>
            <p class="text-blue-100 mb-8 max-w-xl mx-auto">Our support team is available 24/7 to assist you with any questions or concerns you may have.</p>
            <a href="/contact-us" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold hover:bg-blue-50 transition shadow-xl">Contact Support</a>
        </div>
    </div>
</div>
@endsection
