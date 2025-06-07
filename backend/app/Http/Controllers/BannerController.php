<?php

namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use App\Models\Banner;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function adminGetBanners()
    {
        try {
            $banners = Banner::all();

            return response()->json([
                'success' => true,
                'data' => $banners,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while get banners.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/books/banner",
     *     summary="Get platform banner",
     *     tags={"Banner"},
     *     @OA\Response(response=200, description=""),
     *     @OA\Response(response=500, description="An error occurred while get banner.")
     * )
     */
    public function getBanner()
    {
        try {

            $banner = collect(Banner::where('order_priority', 1)->first());
            $filteredData = $banner->except(['created_at', 'id', 'order_priority', 'updated_at']);

            return response()->json([
                'success' => true,
                'data' => $filteredData,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while get banner.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function changeSelectedBanner($id)
    {
        try {

            DB::table('banners')->update([
                'order_priority' => 0,
            ]);

            $banner = Banner::where('id', $id)->first();
            $banner->order_priority = 1;
            $banner->save();

            return ResponseUtil::Success('Done', null, true);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('An error occurred while get banner.', $exception->getMessage());
        }
    }


    public function adminAddBanner(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'title' => 'required|string',
                'order_priority' => 'required|int',
                'image_url' => 'required|string',
                'link_url' => 'nullable|string',
            ]);

            if ($validatedData['order_priority'] == 1) {
                DB::table('banners')->update([
                    'order_priority' => 0,
                ]);
            }

            Banner::create($validatedData);

            return ResponseUtil::Success('Done', null, true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot add banner!', $exception->getMessage());
        }
    }
    public function adminDeleteBanner($id)
    {
        try {
            $banner = Banner::findOrFail($id);
            if ($banner->order_priority == 1) {
                return ResponseUtil::Success("Cannot delete banner, it is selected as the main banner!", null, true);
            }
            $banner->delete();
            return ResponseUtil::Success('Deleted "' . $banner->title . '"', null, true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot delete banner!', $exception->getMessage());
        }
    }
}
