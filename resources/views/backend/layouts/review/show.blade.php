@extends('backend.master')

@section('title', 'Banner')


@section('content')
    <div class="w-50">
        <div class="my-5">
            <div class="card p-4 shadow-sm">
                <div class="d-flex align-items-center">
                    <img src="{{ asset($review->photo) }}" class="rounded-circle me-3" alt="{{ $review->name }}"
                        style="width: 70px; height: 70px;">
                    <div>
                        <h5 class="fw-bold mb-0">{{ $review->name }}</h5>
                        <p class="text-muted mb-0">{{ $review->profession }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-secondary">{{ $review->review_content }}</p>
                </div>

                {{-- DYNAMIC STAR RATING SECTION --}}
                <div class="rating-stars mt-3">
                    @php
                        // Assuming $review->rating_point is a float or integer from 0 to 5
                        $rating = $review->rating_point;
                        $fullStars = floor($rating);
                        $halfStar = $rating - $fullStars >= 0.5;
                        $emptyStars = 5 - ceil($rating);
                    @endphp

                    <span class="text-warning">
                        {{-- Display full stars --}}
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor

                        {{-- Display half star if needed --}}
                        @if ($halfStar)
                            <i class="bi bi-star-half"></i>
                        @endif

                        {{-- Display empty stars --}}
                        @for ($i = 0; $i < $emptyStars; $i++)
                            <i class="bi bi-star"></i>
                        @endfor
                    </span>
                </div>
                {{-- END DYNAMIC STAR RATING SECTION --}}

                <div class="mt-5 text-end">
                    <a href="{{ route('review.index') }}" class="btn btn-outline-secondary">
                        ← Back to All Reviews
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
