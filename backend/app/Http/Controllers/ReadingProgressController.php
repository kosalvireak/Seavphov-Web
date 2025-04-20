<?php


namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use App\Models\Community;
use App\Models\ReadingChallenge;
use App\Models\ReadingProgress;
use App\Service\CopMemberService;
use App\Service\NotificationService;
use Carbon\Carbon;
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
}
