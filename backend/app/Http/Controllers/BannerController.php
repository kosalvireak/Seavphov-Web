<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function adminGetBanners() {
        try {
        $banners = Banner::all();
           return response()->json([
               'success' => true,
               'data' => $banners,
           ], 200);
       } catch (QueryException  $exception) {
           return response()->json([
               'success' => false,
               'message' => 'An error occurred while fetching banners.',
               'error' => $exception->getMessage()
           ], 500);
       }
    }
    
    public function postBanners(Request $request) {
        try {
            
            $validatedData = $request->validate([
                'title' => 'required|string',
                'order_priority' => 'required|int',
                'image_url' => 'required|string',
                'link_url' => 'nullable|string',
            ]);
            
            Banner::create($validatedData);
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully add new banner'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Banner validation error!',
                'error' => $exception->getMessage()
            ], 442);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot add Banner!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function deleteBanners(Request $request, $id)
    {
        try{
            $banner = Banner::findOrFail($id);
            $banner->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully delete "'.$banner->title.'"',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete banner!',
                'error' => $exception->getMessage()
            ], 500);
        }
        
    }
}