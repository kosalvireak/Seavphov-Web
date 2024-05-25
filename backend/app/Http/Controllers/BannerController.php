<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function getBanner() {
        try {

            $banner = collect(Banner::where('order_priority',1)->first());
            $filteredData = $banner->except(['created_at','id','order_priority','updated_at']);
            
            return response()->json([
                'success' => true,
                'data' => $filteredData,
            ], 200);
       } catch (QueryException  $exception) {
           return response()->json([
               'success' => false,
               'message' => 'An error occurred while fetching banner.',
               'error' => $exception->getMessage()
           ], 500);
       }
    }
    public function changeSelectedBanner($id) {
        try {

            DB::table('banners')->update([
                'order_priority' => 0,
                ]);
            
            $banner = Banner::where('id',$id)->first();
            $banner->order_priority = 1;
            $banner->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Done',
            ], 200);
       } catch (QueryException  $exception) {
           return response()->json([
               'success' => false,
               'message' => 'An error occurred while fetching banner.',
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

            if($validatedData['order_priority'] == 1){
                DB::table('banners')->update([
                    'order_priority' => 0,
                  ]);
            }
            
            Banner::create($validatedData);
            
            return response()->json([
                'success' => true,
                'message' => 'Done'
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
    public function adminDeleteBanner($id)
    {
        try{
            $banner = Banner::findOrFail($id);
            if($banner->order_priority == 1){
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete banner, it is selected as the main banner!',
                ], 400);
            }
            $banner->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted "'.$banner->title.'"',
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