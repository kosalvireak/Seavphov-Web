<?php

namespace App\Service;

use App\Models\BookReview;

class ReviewService
{
    public static function IncreaseReviewLike(BookReview $review)
    {
        $review->like = $review->like + 1;
        $review->save();
    }
}
