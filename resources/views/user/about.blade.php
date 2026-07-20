@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-8">{{ __('messages.about_shebok') }}</h1>
        <div class="prose prose-slate lg:prose-xl">
            <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                {{ __('messages.shebok_desc') }}
            </p>
            <h2 class="text-2xl font-bold text-slate-800 mb-4">{{ __('messages.our_vision') }}</h2>
            <p class="text-slate-600 mb-6">
                {{ __('messages.vision_desc') }}
            </p>
            <h2 class="text-2xl font-bold text-slate-800 mb-4">{{ __('messages.our_values') }}</h2>
            <ul class="list-disc list-inside text-slate-600 space-y-2 mb-6">
                <li>{{ __('messages.val_compassion') }}</li>
                <li>{{ __('messages.val_integrity') }}</li>
                <li>{{ __('messages.val_innovation') }}</li>
                <li>{{ __('messages.val_accessibility') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
