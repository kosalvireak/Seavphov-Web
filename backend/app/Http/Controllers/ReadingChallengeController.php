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


class ReadingChallengeController extends Controller
{

    public function startReadingChallenge(Request $request, $route, $id)
    {
        try {
            $cop = Community::where('route', $route)->first();
            $userId = $request->attributes->get('user')->id;
            $readingChallenge = ReadingChallenge::where('id', $id)->first();

            if (!$readingChallenge)
                return ResponseUtil::NotFound("Reading challenge not found");

            // Add user to reading progress table
            // Send Notification to owner

            if (!CopMemberService::isAdminOrMember($userId, $cop->id))
                return ResponseUtil::Success("You need to be member of this community to start this reading challenge", false, true, 'info');

            ReadingProgress::create([
                'user_id' => $userId,
                'reading_challenge_id' => $readingChallenge->id,
                'progress' => 0,
            ]);

            $readingChallenge->total_member = $readingChallenge->total_member + 1;
            $readingChallenge->save();

            NotificationService::storestartReadingChallengeNotification($userId, $readingChallenge->user_id, $cop->id,  " joined reading challenge " . $readingChallenge->book_title);

            return ResponseUtil::Success("Successfully join reading challenge", true, true);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot join reading challenge!', $exception->getMessage());
        }
    }

    public function getReadingChallenge(Request $request, $route, $id)
    {
        try {
            $cop = Community::where('route', $route)->first();
            $userId = $request->attributes->get('user')->id;

            if (!CopMemberService::isAdminOrMember($userId, $cop->id) && $cop->private == true) {
                return ResponseUtil::Success("You need to be member of this community to see this reading challenge", [], true, 'info');
            }

            $readingChallenge = ReadingChallenge::where('cop_id', $cop->id)->where('id', $id)->first();
            if (!$readingChallenge) {
                return ResponseUtil::NotFound("Reading challenge not found");
            }
            return ResponseUtil::Success("Successfully get reading challenge", $readingChallenge->getData($userId));
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot get reading challenge!', $exception->getMessage());
        }
    }

    public function getReadingChallenges(Request $request, $route)
    {
        try {
            $cop = Community::where('route', $route)->first();

            if ($cop->private == true && !CopMemberService::isAdminOrMember($request->attributes->get('user')->id, $cop->id)) {
                return ResponseUtil::Success("You can't get reading challenges for a private community", []);
            }

            $readingChallenges = ReadingChallenge::where('cop_id', $cop->id)
                ->orderBy('created_at', 'desc')->get();

            $items = [];
            foreach ($readingChallenges as $readingChallenge) {
                $items[] = $readingChallenge->getData($request->attributes->get('user')->id);
            }

            return ResponseUtil::Success("Successfully get reading challenges", $items);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot get reading challenges!', $exception->getMessage());
        }
    }

    public function getReadingChallengeMembers(Request $request, $id)
    {
        try {
            $userId = $request->attributes->get('user')->id;
            $readingChallenge = ReadingChallenge::where('id', $id)->first();
            if (!$readingChallenge) {
                return ResponseUtil::NotFound("Reading challenge not found");
            }

            if (!CopMemberService::isAdminOrMember($userId, $readingChallenge->cop_id) && $readingChallenge->cop->private == true) {
                return ResponseUtil::Success("You need to be member of this community to see this reading challenge", [], true, 'info');
            }

            $members = [];
            $readingProgresses = $readingChallenge->getAllProgress();
            foreach ($readingProgresses as $readingProgress) {
                $members[] = $readingProgress->getData();
            }

            return ResponseUtil::Success("Successfully get reading challenge members", $members);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot get reading challenge members!', $exception->getMessage());
        }
    }

    public function addReadingChallenge(Request $request)
    {
        try {
            $cop = $request->attributes->get('cop');
            $user = $request->attributes->get('user');

            $validatedData = $request->validate([
                'book_image' => 'required|string',
                'book_title' => 'required|string',
                'book_author' => 'required|string',
                'description' => 'required|string',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:today',
            ]);

            // Convert to Carbon instance
            $startDate = Carbon::createFromFormat('Y-m-d', $validatedData['start_date']);
            $endDate = Carbon::createFromFormat('Y-m-d', $validatedData['end_date']);

            $readingChallenge = ReadingChallenge::create([
                'user_id' => $user->id,
                'cop_id' => $cop->id,
                'book_image' => $validatedData['book_image'],
                'book_title' => $validatedData['book_title'],
                'book_author' => $validatedData['book_author'],
                'description' => $validatedData['description'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_member' => 0,
            ]);

            return ResponseUtil::Success("Successfully create reading challenge", $readingChallenge, true);
        } catch (Exception $e) {
            return ResponseUtil::ServerError("Cannot create reading challenge", $e->getMessage());
        }
    }
}
