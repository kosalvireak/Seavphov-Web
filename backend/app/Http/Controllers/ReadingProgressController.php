<?php


namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use App\Models\ReadingChallenge;
use App\Models\ReadingProgress;
use App\Service\NotificationService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class ReadingProgressController extends Controller
{
    public function getMyReadingProgress(Request $request, $id)
    {
        try {
            $userId = $request->attributes->get('user')->id;
            $readingChallenge = ReadingChallenge::where('id', $id)->first();
            if (!$readingChallenge)
                return ResponseUtil::NotFound("Reading challenge not found");

            $readingProgress = ReadingProgress::where('user_id', $userId)->where('reading_challenge_id', $readingChallenge->id)->first();
            if (!$readingProgress)
                return ResponseUtil::Success("Reading progress not found");

            return ResponseUtil::Success('Successfully get your reading progress', $readingProgress);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot get your reading progress!', $exception->getMessage());
        }
    }

    public function withDrawChallenge(Request $request, $id)
    {
        try {
            $userId = $request->attributes->get('user')->id;
            $readingProgress = ReadingProgress::where('user_id', $userId)->where('id', $id)->first();
            if (!$readingProgress)
                return ResponseUtil::NoPermission("You don't have any progress");

            $readingProgress->delete();

            // Reduce total member of original challenge
            $readingChallenge = $readingProgress->readingChallenge;
            $readingChallenge->total_member = $readingChallenge->total_member - 1;
            $readingChallenge->save();

            NotificationService::storeLeaveReadingChallengeNotification($userId, $readingChallenge->user_id, $readingChallenge->cop_id,  " leave reading challenge " . $readingChallenge->book_title);

            return ResponseUtil::Success('Successfully delete your reading progress', true, true);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot delete your reading progress!', $exception->getMessage());
        }
    }

    public function updateReadingProgress(Request $request, $id)
    {
        try {
            $userId = $request->attributes->get('user')->id;
            $readingProgress = ReadingProgress::where('user_id', $userId)->where('id', $id)->first();
            if (!$readingProgress)
                return ResponseUtil::Success("Reading progress not found");

            $readingChallenge = $readingProgress->readingChallenge;

            if (Carbon::parse($readingChallenge->end_date)->lt(Carbon::today())) {
                return ResponseUtil::Success('You cannot update progress, the challenge is due', false, true, 'info');
            }

            $validatedData = $request->validate([
                'progress' => 'required|integer|between:0,100',
            ]);

            $readingProgress->progress = $validatedData['progress'];
            $readingProgress->save();

            return ResponseUtil::Success('Successfully update your reading progress', $readingProgress->progress, true);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot update your reading progress!', $exception->getMessage());
        }
    }
}
