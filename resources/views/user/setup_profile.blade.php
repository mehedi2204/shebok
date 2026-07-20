@extends('layouts.app')

@section('content')
<section class="bg-slate-50 py-12 sm:py-20 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[3rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
                <div class="p-8 sm:p-12 border-b border-slate-50 {{ $profile && $profile->status === 'approved' ? 'bg-green-600' : 'bg-slate-900' }} text-white relative overflow-hidden">
                    <div class="relative z-10">
                        @if(!$profile)
                            <h1 class="text-3xl sm:text-4xl font-extrabold mb-2">Apply as Service Provider</h1>
                            <p class="text-slate-400 font-medium">Join our community of professionals and start helping people.</p>
                        @elseif($profile->status === 'pending')
                            <h1 class="text-3xl sm:text-4xl font-extrabold mb-2">Application Under Review</h1>
                            <p class="text-slate-400 font-medium">You can still update your information while we review your profile.</p>
                        @elseif($profile->status === 'approved')
                            <div class="flex items-center justify-between">
                                <div>
                                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-2">Professional Dashboard</h1>
                                    <p class="text-green-100 font-medium opacity-80">Your profile is live and verified.</p>
                                </div>
                                <form action="{{ route('user.toggle-provider-status') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-6 py-3 {{ $profile->is_available ? 'bg-white text-green-600' : 'bg-red-500 text-white' }} rounded-xl font-black text-xs uppercase tracking-widest shadow-xl">
                                        {{ $profile->is_available ? 'Profile Active' : 'Profile Inactive' }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                @if($profile && $profile->status === 'approved' && $profile->pending_update)
                    <div class="bg-orange-50 p-6 border-b border-orange-100 text-orange-700 font-bold text-sm flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        You have a pending update request. Admin will review it soon.
                    </div>
                @endif

                @if($errors->any())
                    <div class="m-8 p-6 bg-red-50 border border-red-100 rounded-2xl">
                        <ul class="list-disc list-inside text-sm text-red-600 font-bold">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/service-giver/setup-profile') }}" method="POST" enctype="multipart/form-data" class="p-8 sm:p-12 space-y-12">
                    @csrf
                    @php $isApproved = $profile && $profile->status === 'approved'; @endphp

                    <!-- Section 1: Professional Identity -->
                    <div class="space-y-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                            <h2 class="text-2xl font-extrabold text-slate-800">Professional Identity</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Current Profession</label>
                                <input type="text" name="profession" required value="{{ old('profession', ($isApproved && $profile->pending_update) ? ($profile->pending_update['profession'] ?? $profile->profession) : ($profile->profession ?? '')) }}" placeholder="e.g. Registered Nurse" class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 shadow-inner">
                            </div>
                            <div class="space-y-3">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Years of Experience</label>
                                <input type="text" name="experience" value="{{ old('experience', ($isApproved && $profile->pending_update) ? ($profile->pending_update['experience'] ?? $profile->experience) : ($profile->experience ?? '')) }}" placeholder="e.g. 5 Years" class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 shadow-inner">
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Professional Bio / Description</label>
                            <textarea name="bio" rows="4" placeholder="Tell us about your skills and experience..." class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 shadow-inner">{{ old('bio', ($isApproved && $profile->pending_update) ? ($profile->pending_update['bio'] ?? $profile->bio) : ($profile->bio ?? '')) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Service Category</label>
                                @if(!$isApproved)
                                <div class="relative">
                                    <select name="category_id" id="category_id" required onchange="showFields(this.value)" class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 appearance-none shadow-inner">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ ($profile && $profile->category_id == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="w-5 h-5 absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                </div>
                                @else
                                    <input type="hidden" name="category_id" value="{{ $profile->category_id }}">
                                    <div class="w-full px-7 py-5 bg-slate-100 border-none rounded-2xl font-bold text-slate-500 cursor-not-allowed">
                                        {{ $profile->category->name }}
                                    </div>
                                    <p class="text-[9px] text-slate-400 ml-1 italic">Category cannot be changed after approval.</p>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Expected Rate (BDT)</label>
                                <div class="bg-slate-50 p-5 rounded-2xl shadow-inner border border-slate-100/50">
                                    <div class="flex items-center">
                                        <span class="text-slate-400 font-bold mr-2">৳</span>
                                        <input type="number" name="hourly_rate" required value="{{ old('hourly_rate', ($isApproved && $profile->pending_update) ? ($profile->pending_update['price_per_hour'] ?? $profile->price_per_hour) : ($profile->price_per_hour ?? '')) }}" placeholder="0" class="w-full bg-transparent border-none p-0 focus:ring-0 font-extrabold text-slate-800 text-xl">
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Rate Type</label>
                                <div class="relative">
                                    <select name="rate_type" required class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 appearance-none shadow-inner">
                                        @php $currentRateType = old('rate_type', ($isApproved && $profile->pending_update) ? ($profile->pending_update['rate_type'] ?? $profile->rate_type) : ($profile->rate_type ?? 'hourly')); @endphp
                                        <option value="hourly" {{ $currentRateType == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                        <option value="daily" {{ $currentRateType == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ $currentRateType == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="monthly" {{ $currentRateType == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    </select>
                                    <svg class="w-5 h-5 absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Category Fields -->
                    <div id="dynamic_fields" class="space-y-8">
                        @foreach($categories as $cat)
                            <div id="cat_fields_{{ $cat->id }}" class="category-fields-group space-y-8" style="display: none;">
                                @if($cat->fields->count() > 0)
                                    <div class="flex items-center space-x-4 mb-6">
                                        <div class="w-1.5 h-8 bg-orange-500 rounded-full"></div>
                                        <h2 class="text-2xl font-extrabold text-slate-800">{{ $cat->name }} Specific Details</h2>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        @foreach($cat->fields as $field)
                                            <div class="space-y-3">
                                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">
                                                    {{ $field->label }}
                                                    @if($field->is_required) <span class="text-red-500">*</span> @endif
                                                </label>
                                                @php
                                                    $sourceData = ($isApproved && $profile->pending_update && isset($profile->pending_update['additional_data']))
                                                        ? $profile->pending_update['additional_data']
                                                        : ($profile->additional_data ?? []);
                                                    $val = $sourceData[$field->label] ?? '';
                                                @endphp
                                                @if($field->type == 'text')
                                                    <input type="text" name="field_{{ $field->id }}" value="{{ $val }}" {{ $field->is_required ? 'required' : '' }} class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 shadow-inner">
                                                @elseif($field->type == 'number')
                                                    <input type="number" name="field_{{ $field->id }}" value="{{ $val }}" {{ $field->is_required ? 'required' : '' }} class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 shadow-inner">
                                                @elseif($field->type == 'dropdown')
                                                    <select name="field_{{ $field->id }}" {{ $field->is_required ? 'required' : '' }} class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 appearance-none shadow-inner">
                                                        @foreach($field->options ?? [] as $opt)
                                                            <option {{ $val == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Section 2: Work Location -->
                    <div class="space-y-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                            <h2 class="text-2xl font-extrabold text-slate-800">Work Location</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-3">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Country</label>
                                <div class="relative">
                                    <select name="country_id" id="country_id" required onchange="loadChildren(this.value, 'division_id')" class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 appearance-none shadow-inner">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id', $profile->country_id ?? '') == $country->id ? 'selected' : ($country->name == 'Bangladesh' ? 'selected' : '') }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="w-5 h-5 absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Division</label>
                                <div class="relative">
                                    <select name="division_id" id="division_id" required onchange="loadChildren(this.value, 'district_id')" class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 appearance-none shadow-inner">
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $div)
                                            <option value="{{ $div->id }}" {{ old('division_id', $profile->division_id ?? '') == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="w-5 h-5 absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">District / City</label>
                                <div class="relative">
                                    <select name="district_id" id="district_id" required class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 appearance-none shadow-inner">
                                        <option value="">Select District</option>
                                        @foreach($districts as $dist)
                                            <option value="{{ $dist->id }}" {{ old('district_id', $profile->district_id ?? '') == $dist->id ? 'selected' : '' }}>{{ $dist->name }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="w-5 h-5 absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Thana / Upazila / City Corp.</label>
                                <input type="text" name="thana_upazila" value="{{ old('thana_upazila', $profile->thana_upazila ?? '') }}" placeholder="e.g. Banani" class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 shadow-inner">
                            </div>
                            <div class="space-y-3">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1">Full Street Address</label>
                                <input type="text" name="address" required value="{{ old('address', ($isApproved && $profile->pending_update) ? ($profile->pending_update['address'] ?? $profile->address) : ($profile->address ?? '')) }}" placeholder="House #, Road #, Sector..." class="w-full px-7 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-slate-800 shadow-inner">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Verification Documents -->
                    @if(!$isApproved)
                    <div class="space-y-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                            <h2 class="text-2xl font-extrabold text-slate-800">Verification Documents</h2>
                        </div>

                        <div id="document_inputs" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1 flex justify-between">
                                    <span>National ID / Passport</span>
                                    <span class="text-red-500 text-[10px]">{{ $profile ? 'Optional (Already uploaded)' : 'Required' }}</span>
                                </label>
                                <div class="relative group">
                                    <input type="file" name="nid" {{ $profile ? '' : 'required' }} onchange="updateFileName(this)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="px-7 py-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] text-center group-hover:border-blue-400 group-hover:bg-blue-50/30 transition-all">
                                        <p class="text-sm font-bold text-slate-600 file-name-display">Click to {{ $profile ? 'Update' : 'Upload' }} NID</p>
                                    </div>
                                </div>
                            </div>

                            <div id="certificate_input" class="space-y-3" style="display: none;">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1 flex justify-between">
                                    <span>Educational Certificate</span>
                                    <span id="cert_req_label" class="text-red-500 text-[10px]">Required</span>
                                </label>
                                <div class="relative group">
                                    <input type="file" name="certificate" id="certificate_file" onchange="updateFileName(this)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="px-7 py-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] text-center group-hover:border-blue-400 group-hover:bg-blue-50/30 transition-all">
                                        <p class="text-sm font-bold text-slate-600 file-name-display">Upload Certificate</p>
                                    </div>
                                </div>
                            </div>

                            <div id="experience_input" class="space-y-3" style="display: none;">
                                <label class="text-xs font-extrabold text-slate-500 uppercase tracking-[0.15em] ml-1 flex justify-between">
                                    <span>Experience Certificate</span>
                                    <span id="exp_req_label" class="text-red-500 text-[10px]">Required</span>
                                </label>
                                <div class="relative group">
                                    <input type="file" name="experience_file" id="experience_file_input" onchange="updateFileName(this)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="px-7 py-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] text-center group-hover:border-blue-400 group-hover:bg-blue-50/30 transition-all">
                                        <p class="text-sm font-bold text-slate-600 file-name-display">Upload Exp. Proof</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="space-y-8">
                         <div class="flex items-center space-x-4 mb-6">
                            <div class="w-1.5 h-8 bg-slate-300 rounded-full"></div>
                            <h2 class="text-2xl font-extrabold text-slate-400">Verification Documents (Verified)</h2>
                        </div>
                        <p class="text-xs text-slate-400 italic">Identity documents cannot be changed online. Contact support for verification updates.</p>
                    </div>
                    @endif

                    <!-- Final Submission -->
                    <div class="pt-10 border-t border-slate-50">
                        <div class="bg-blue-50 p-8 rounded-[2.5rem] flex flex-col md:flex-row items-center justify-between gap-8">
                            <div class="flex-1">
                                <h4 class="text-xl font-extrabold text-slate-800 mb-2">
                                    {{ $isApproved ? 'Update your profile?' : 'Ready to join Shebok?' }}
                                </h4>
                                <p class="text-sm text-slate-500 font-medium">
                                    {{ $isApproved
                                        ? 'Any changes to professional details will need to be approved by an administrator before they appear on your public profile.'
                                        : 'By submitting, you agree to our terms and verify that all information is true. Your application will be processed within 24-48 hours.' }}
                                </p>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-12 py-5 rounded-2xl font-extrabold text-lg hover:bg-blue-700 transition shadow-2xl shadow-blue-500/30 active:scale-95 whitespace-nowrap">
                                {{ $isApproved ? 'Request Update' : ($profile ? 'Update Application' : 'Submit for Approval') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : 'Choose file';
        const display = input.nextElementSibling.querySelector('.file-name-display');
        if (display) display.textContent = fileName;
    }

    function showFields(catId) {
        document.querySelectorAll('.category-fields-group').forEach(el => el.style.display = 'none');

        // Document requirements mapping
        const requirements = {
            @foreach($categories as $cat)
            '{{ $cat->id }}': {
                cert: {{ $cat->require_certificate ? 'true' : 'false' }},
                exp: {{ $cat->require_experience ? 'true' : 'false' }}
            },
            @endforeach
        };

        if (catId) {
            const el = document.getElementById('cat_fields_' + catId);
            if (el) el.style.display = 'block';

            const req = requirements[catId];
            const certInput = document.getElementById('certificate_input');
            const expInput = document.getElementById('experience_input');
            const profileExists = {{ $profile ? 'true' : 'false' }};

            if (req) {
                if (req.cert) {
                    certInput.style.display = 'block';
                    document.getElementById('certificate_file').required = !profileExists;
                } else {
                    certInput.style.display = 'none';
                    document.getElementById('certificate_file').required = false;
                }

                if (req.exp) {
                    expInput.style.display = 'block';
                    document.getElementById('experience_file_input').required = !profileExists;
                } else {
                    expInput.style.display = 'none';
                    document.getElementById('experience_file_input').required = false;
                }
            }
        }
    }

    async function loadChildren(parentId, targetId) {
        const targetSelect = document.getElementById(targetId);
        targetSelect.innerHTML = '<option value="">Loading...</option>';

        // If loading divisions, also clear districts
        if (targetId === 'division_id') {
            document.getElementById('district_id').innerHTML = '<option value="">Select District</option>';
        }

        try {
            const response = await fetch(`/api/locations/${parentId}/children`);
            const data = await response.json();

            targetSelect.innerHTML = `<option value="">Select ${targetId === 'division_id' ? 'Division' : 'District'}</option>`;
            data.forEach(item => {
                targetSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            });
        } catch (error) {
            console.error('Error fetching locations:', error);
            targetSelect.innerHTML = '<option value="">Error loading</option>';
        }
    }

    // Run on load to show existing selection
    document.addEventListener('DOMContentLoaded', () => {
        const catId = document.getElementById('category_id').value;
        if (catId) showFields(catId);

        // Auto-load divisions if Bangladesh is pre-selected and divisions are empty
        const countrySelect = document.getElementById('country_id');
        const divisionSelect = document.getElementById('division_id');
        if (countrySelect.value && divisionSelect.options.length <= 1) {
            loadChildren(countrySelect.value, 'division_id');
        }
    });
</script>
@endsection
