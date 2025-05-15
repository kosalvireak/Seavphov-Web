<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\ResponseUtil;
use App\Models\Book;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/books/newest",
     *     summary="Get 6 newest books",
     *     tags={"Book"},*
     *     @OA\Response(response=200, description="Get newest book success"),
     *     @OA\Response(response=500, description="Cannot get newest book!")
     * )
     */
    public function getNewest()
    {
        try {
            $books = Book::orderBy('created_at', 'desc')->take(6)->get();

            return ResponseUtil::Success('Get newest book success', $books);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('Cannot get newest book!', $exception->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/books/mostReviewed",
     *     summary="Get 6 most reviewed books",
     *     tags={"Book"},*
     *     @OA\Response(response=200, description="Get most reviewed book success"),
     *     @OA\Response(response=500, description="Cannot get most reviewed book!")
     * )
     */
    public function getMostReviewed()
    {
        try {
            $books = Book::withCount('reviews') // Count the number of reviews
                ->orderBy('reviews_count', 'desc') // Order by the review count
                ->take(6) // Limit the result to the top 6 books
                ->get();

            return ResponseUtil::Success('Get most reviewed book success', $books, false);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('Cannot get most reviewed book!', $exception->getMessage());
        }
    }

    public function getBooksWithFilter(Request $request)
    {

        $title = $request->get('title');
        $author = $request->get('author');
        $Category = $request->get('Category');
        $Condition = $request->get('Condition');
        $Availability = $request->get('Availability');
        $PDF = $request->get('PDF');
        $uuid = $request->get('uuid');
        $max = $request->get('max');
        $excludeId = $request->get('excludeId');

        $query = Book::query(); // Start with a base query

        if ($excludeId) {
            $query->where('id', '!=', $excludeId); // remove current view book
        }

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%'); // Filter by title
        }
        if (!empty($Category)) {
            $query->whereIn('categories', $Category);
        }

        if (!empty($Condition)) {
            $query->whereIn('condition', $Condition);
        }

        if (!empty($Availability)) {
            // Normalize to array if not already
            $Availability = is_array($Availability) ? $Availability : [$Availability];

            // Map human-readable status to database values
            $mappedAvailability = [];

            foreach ($Availability as $status) {
                if ($status == 'Available') {
                    $mappedAvailability[] = 1;
                } elseif ($status == 'Not-Available') {
                    $mappedAvailability[] = 0;
                }
            }

            if (!empty($mappedAvailability)) {
                $query->whereIn('availability', $mappedAvailability);
            }
        }

        if (!empty($PDF)) {
            $query->where('has_pdf', in_array('Yes', $PDF));
        }

        if ($author) {
            $query->where('author', $author); // Filter by author
        }

        if ($uuid) {
            $user = User::where('uuid', $uuid)->first();
            $query->where('owner_id', $user->id); // Filter by uuid
        }


        if ($max > 0) {
            $books = $query->paginate($max); // Apply max for related book
        } else {
            $books = $query->paginate(12); // Apply pagination 
        }

        try {
            return ResponseUtil::Success(null, $books);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('Cannot get filtered book!', $exception->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/auth/book",
     *     summary="Get books belonging to the authenticated user",
     *     tags={"Book"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Get my book success"),
     *     @OA\Response(response=401, description="Unauthorized: Missing, invalid, or expired token"),
     *     @OA\Response(response=500, description="Server error while retrieving books")
     * )
     */
    public function getMyBooks(Request $request)
    {
        $user = $request->attributes->get('user');

        broadcast(new MessageSent('Hello', $user))->toOthers();

        $books = $user->books()->get();

        try {
            return ResponseUtil::Success('Get my book success', $books);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('Cannot get my book!', $exception->getMessage());
        }
    }

    public function getMyBook(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $book = $user->book($id);

            if (!$book) {
                return ResponseUtil::NoPermission();
            }
            return ResponseUtil::Success('Get my book success', $book);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('Cannot get my book!', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/books/{bookId}",
     *     summary="Get book detail",
     *     tags={"Book"},*     
     *     @OA\Parameter(
     *         name="bookId",
     *         in="path",
     *         required=true,
     *         description="Id of the book",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Get book detail success"),
     *     @OA\Response(response=500, description="Cannot get book detail!")
     * )
     */
    public function getBookDetailWithOwner(Request $request, $bookId)
    {
        try {

            $book = Book::find($bookId);

            if (!$book) {
                return ResponseUtil::NotFound('Book not found');
            }

            $book->makeHidden(['owner_id', 'updated_at', 'created_at']);

            $userId = null;

            // Check if the user attribute exists and get the user ID
            if ($request->attributes->has('user')) {
                $userId = $request->attributes->get('user')->id;
            }

            $issaved = false;

            if ($userId != null) {
                $user = User::where('id', $userId)->first();
                $savedBooks = $user->savedBooks;
                if ($savedBooks) {
                    $issaved = $savedBooks->contains('id', $bookId);
                }
            }
            $book->issaved = $issaved;

            return ResponseUtil::Success('Get book detail success', [
                'book' => $book,
                'owner' => $book->owner(),
            ]);
        } catch (\Exception $exception) {
            return ResponseUtil::ServerError('Cannot get book detail!', $exception->getMessage());
        }
    }

    public function addBook(Request $request)
    {
        $user = $request->attributes->get('user');
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'categories' => 'required|string',
                'condition' => 'required|string',
                'descriptions' => 'required|string',
                'availability' => 'required|int',
                'images' => 'required|string',
                'has_pdf' => 'required|in:true,false',
            ]);


            if ($validatedData['has_pdf'] == true) {
                $validatedData['pdf_url'] = $request->get('pdf_url');
                $validatedData['pdf_filename'] = $request->get('pdf_filename');
                if ($validatedData['pdf_url'] == null) {
                    return ResponseUtil::UnProcessable('PDF URL is required');
                }
            }

            // Convert the string value to a boolean
            $validatedData['has_pdf'] = filter_var($validatedData['has_pdf'], FILTER_VALIDATE_BOOLEAN);

            $validatedData['owner_id'] = $user->id;

            $book = Book::create($validatedData);
            return ResponseUtil::Success('Add book success', $book->id);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot add book!', $exception->getMessage());
        }
    }

    public function modifyBook(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');

            $book = Book::findOrFail($id);

            if ($book->owner_id != $user->id) {
                return ResponseUtil::NoPermission();
            }

            $validatedData = $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'categories' => 'required|string',
                'condition' => 'required|string',
                'descriptions' => 'required|string',
                'availability' => 'required|int',
                'images' => 'required|string',
                'has_pdf' => 'required|in:true,false',
            ]);

            if ($validatedData['has_pdf'] == true) {
                $validatedData['pdf_url'] = $request->get('pdf_url');
                $validatedData['pdf_filename'] = $request->get('pdf_filename');
                if ($validatedData['pdf_url'] == null) {
                    return ResponseUtil::UnProcessable('PDF URL is required');
                }
            } else {
                $validatedData['pdf_url'] = null;
                $validatedData['pdf_filename'] = null;
            }

            // Convert the string value to a boolean
            $validatedData['has_pdf'] = filter_var($validatedData['has_pdf'], FILTER_VALIDATE_BOOLEAN);

            $book->update($validatedData);
            return ResponseUtil::Success('Update book success', 'Updated ' . $book->title);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot update book!', $exception->getMessage());
        }
    }

    public function changeAvailability(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $book = Book::findOrFail($id);

            if ($book->owner_id != $user->id) {
                return ResponseUtil::NoPermission();
            }
            $book->availability = !$book->availability;
            $book->save();

            return ResponseUtil::Success('Update availability', true, true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot change availability!', $exception->getMessage());
        }
    }
    public function deleteBook(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');

            $book = Book::findOrFail($id);

            if ($book->owner_id != $user->id) {
                return ResponseUtil::NoPermission();
            }

            $book->delete();
            return ResponseUtil::Success("Deleted " . $book->title);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot delete book!', $exception->getMessage());
        }
    }
}
