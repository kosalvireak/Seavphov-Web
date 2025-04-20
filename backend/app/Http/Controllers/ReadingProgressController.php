<?php


namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use App\Models\ReadingChallenge;
use App\Models\ReadingProgress;
use Exception;
use Illuminate\Http\Request;

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

    public function updateReadingProgress(Request $request, $id)
    {
        try {
            $userId = $request->attributes->get('user')->id;
            $readingProgress = ReadingProgress::where('user_id', $userId)->where('id', $id)->first();
            if (!$readingProgress)
                return ResponseUtil::Success("Reading progress not found");

            $validatedData = $request->validate([
                'progress' => 'required|integer|between:0,100',
            ]);

            $readingProgress->progress = $validatedData['progress'];
            $readingProgress->save();

            return ResponseUtil::Success('Successfully update your reading progress', $readingProgress, true);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot update your reading progress!', $exception->getMessage());
        }
    }
}
