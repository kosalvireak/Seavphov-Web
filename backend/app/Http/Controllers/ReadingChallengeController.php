<?php


namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use App\Models\Community;
use App\Models\Discussion;
use App\Models\ReadingChallenge;
use App\Models\User;
use App\Service\CopMemberService;
use App\Service\NotificationService;
use App\Service\ReactionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;


class ReadingChallengeController extends Controller
{

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
