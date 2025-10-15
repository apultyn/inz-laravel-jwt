<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ReviewService;
use App\Http\Requests\SaveReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $reviewService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $reviews = $this->reviewService->getReviews();
        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveReviewRequest $req): JsonResponse
    {
        $review = $this->reviewService->createReview($req->all());
        return response()->json($review, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review): Review
    {
        return $review;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $req, Review $review)
    {
        $updatedReview = $this->reviewService->updateReview($review, $req->validated());
        return response()->json($updatedReview);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->reviewService->deleteReview($review);
    }
}
