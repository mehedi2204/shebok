@extends('layouts.app')

@section('content')
<section class="bg-slate-50 py-12 sm:py-20 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Profile Info -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2.5rem] p-8 sm:p-12 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.03)] border border-slate-50">
                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8 mb-10">
                            @if($provider->user->avatar)
                                <img src="{{ asset('storage/' . $provider->user->avatar) }}" class="w-32 h-32 rounded-[2rem] object-cover shadow-2xl ring-8 ring-slate-50">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($provider->user->name) }}&size=200&background=random" class="w-32 h-32 rounded-[2rem] object-cover shadow-2xl ring-8 ring-slate-50">
                            @endif
                            <div class="text-center sm:text-left">
                                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-2">{{ $provider->user->name }}</h1>
                                <p class="text-blue-600 font-bold text-lg uppercase tracking-wider mb-4">{{ $provider->profession }}</p>
                                <div class="flex flex-wrap justify-center sm:justify-start gap-4">
                                    <span class="flex items-center text-slate-500 font-bold text-sm bg-slate-50 px-4 py-2 rounded-xl">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        {{ $provider->location }}
                                    </span>
                                    <span class="flex items-center text-green-600 font-bold text-sm bg-green-50 px-4 py-2 rounded-xl">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        {{ number_format($provider->averageRating(), 1) }} ({{ $provider->reviews->count() }} Reviews)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h2 class="text-2xl font-extrabold text-slate-900">Experience & Skills</h2>
                            <p class="text-slate-600 leading-relaxed font-medium">
                                {{ $provider->bio ?? 'No detailed bio provided yet.' }}
                            </p>

                            @if($provider->additional_data)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
                                @foreach($provider->additional_data as $key => $value)
                                <div class="p-4 bg-slate-50 rounded-2xl">
                                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">{{ $key }}</p>
                                    <p class="font-bold text-slate-800">{{ $value }}</p>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="bg-white rounded-[2.5rem] p-8 sm:p-12 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.03)] border border-slate-50">
                        <h2 class="text-2xl font-extrabold text-slate-900 mb-8">Client Reviews</h2>
                        <div class="space-y-8">
                            @forelse($provider->reviews as $review)
                            <div class="flex gap-6">
                                @if($review->user->avatar)
                                    <img src="{{ asset('storage/' . $review->user->avatar) }}" class="w-12 h-12 rounded-xl shrink-0 object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=random" class="w-12 h-12 rounded-xl shrink-0">
                                @endif
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h5 class="font-bold text-slate-800">{{ $review->user->name }}</h5>
                                        @if($review->rating > 0)
                                        <div class="flex text-orange-400">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                        @else
                                            <span class="bg-slate-100 text-slate-400 text-[9px] font-black px-2 py-0.5 rounded uppercase tracking-tighter">Comment Only</span>
                                        @endif
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed">{{ $review->comment }}</p>
                                    <p class="text-[10px] text-slate-300 font-bold uppercase mt-2">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-slate-400 font-medium italic">No reviews yet. Be the first to rate!</p>
                            @endforelse
                        </div>

                        @auth
                            @if(Auth::id() !== $provider->user_id)
                            <div class="mt-12 pt-10 border-t border-slate-50">
                                @php
                                    $alreadyRated = \App\Models\Review::where('user_id', Auth::id())
                                        ->where('provider_profile_id', $provider->id)
                                        ->where('rating', '>', 0)
                                        ->exists();
                                @endphp

                                <h4 class="font-extrabold text-slate-800 mb-6">
                                    {{ $alreadyRated ? 'Add another review comment' : 'Leave a Rating & Review' }}
                                </h4>
                                <form action="{{ route('provider.rate', $provider->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @if(!$alreadyRated)
                                    <div class="flex gap-2 star-rating">
                                        @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer group">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                            <svg class="w-8 h-8 text-slate-200 peer-checked:text-orange-400 group-hover:text-orange-300 transition-colors pointer-events-none" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        </label>
                                        @endfor
                                    </div>
                                    @endif
                                    <textarea name="comment" rows="3" required placeholder="Write your feedback..." class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-medium"></textarea>
                                    <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-600 transition">
                                        {{ $alreadyRated ? 'Post Comment' : 'Submit Review' }}
                                    </button>
                                </form>
                            </div>
                            @endif
                        @else
                            <div class="mt-12 pt-10 border-t border-slate-50 text-center">
                                <p class="text-slate-400 font-bold italic">Please <a href="/login" class="text-blue-600 underline">login</a> to leave a review.</p>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Right: Pricing & Contact -->
                <div class="space-y-6">
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.03)] border border-slate-50 sticky top-8 text-center">
                        @if(($globalSettings['payment_required'] ?? '1') == '1')
                        <h3 class="text-xl font-extrabold text-slate-900 mb-6">Service Rate</h3>
                        <div class="mb-8">
                            <span class="text-5xl font-black text-slate-900 tracking-tighter">৳{{ number_format($provider->price_per_hour) }}</span>
                            <span class="text-slate-400 font-bold uppercase text-[10px] block mt-2 tracking-widest">Expected {{ ucfirst($provider->rate_type) }} Rate</span>
                        </div>
                        @else
                        <h3 class="text-xl font-extrabold text-slate-900 mb-6">Provider Info</h3>
                        @endif

                        <!-- Public Contact Info -->
                        <div class="mb-8 p-6 bg-slate-50 rounded-[2rem] text-left space-y-4">
                            <div>
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Mobile Number</p>
                                <p class="text-lg font-extrabold text-slate-800">{{ $provider->user->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Email Address</p>
                                <p class="text-sm font-bold text-slate-600 truncate">{{ $provider->user->email }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @if(Auth::id() !== $provider->user_id)
                                <a href="{{ route('chat.start', $provider->user->id) }}" class="w-full inline-block text-center bg-blue-600 text-white py-5 rounded-2xl font-bold text-lg hover:bg-blue-700 transition shadow-xl shadow-blue-500/20 active:scale-95">
                                    Send Message
                                </a>
                                @auth
                                @php $isSaved = \App\Models\SavedProfile::where('user_id', Auth::id())->where('provider_profile_id', $provider->id)->exists(); @endphp
                                <form action="{{ route('provider.save', $provider->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full {{ $isSaved ? 'bg-red-50 text-red-600' : 'bg-slate-900 text-white' }} py-5 rounded-2xl font-bold text-lg hover:opacity-90 transition active:scale-95">
                                        {{ $isSaved ? 'Remove from Shortlist' : 'Shortlist Profile' }}
                                    </button>
                                </form>
                                @else
                                <a href="/login" class="w-full inline-block text-center bg-slate-100 text-slate-600 py-5 rounded-2xl font-bold text-lg hover:bg-slate-200 transition">
                                    Login to Shortlist
                                </a>
                                @endauth
                            @else
                                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                                    <p class="text-xs text-blue-600 font-bold">This is your own profile. You can manage it from your <a href="/user/dashboard" class="underline">Dashboard</a>.</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-8 flex items-center justify-center space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Verified Provider</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ratingInputs = document.querySelectorAll('.star-rating input');
        const labels = document.querySelectorAll('.star-rating label');

        ratingInputs.forEach((input, index) => {
            input.addEventListener('change', () => {
                highlightStars(index);
            });
        });

        labels.forEach((label, index) => {
            label.addEventListener('mouseenter', () => {
                highlightStars(index);
            });

            label.addEventListener('mouseleave', () => {
                const checkedIndex = Array.from(ratingInputs).findIndex(input => input.checked);
                highlightStars(checkedIndex);
            });
        });

        function highlightStars(limitIndex) {
            labels.forEach((label, i) => {
                const svg = label.querySelector('svg');
                if (i <= limitIndex) {
                    svg.classList.add('text-orange-400');
                    svg.classList.remove('text-slate-200');
                } else {
                    svg.classList.remove('text-orange-400');
                    svg.classList.add('text-slate-200');
                }
            });
        }
    });
</script>
@endpush
@endsection
