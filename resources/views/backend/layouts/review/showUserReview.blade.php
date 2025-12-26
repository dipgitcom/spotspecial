@extends('backend.master')

@section('content')
    <div class="w-50">
        <div class="container my-5">
            <div class="profile-card shadow-sm">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="{{ asset($review->user->profile_photo) }}" alt="User Profile Picture">
                    </div>
                    <div class="col">
                        <h5 class="fw-bold mb-0">John Abraham</h5>
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
                        <p class="mb-0">
                            {{ $review->review_content }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
