<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UploadsController extends Controller
{
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
    //     ]);

    //     $file = $request->file('file');
    //     $fileName = time() . '_' . $file->getClientOriginalName();
    //     $imagePath = $file->move(public_path('uploads/image/'), $fileName);

    //     // Kembalikan URL file yang diunggah
    //     $optimizerChain = OptimizerChainFactory::create();
    //     $optimizerChain->optimize($imagePath);

    //     return response()->json([
    //         'location' => asset('uploads/image/' . $fileName),
    //     ]);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        try {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path('uploads/image/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            if(!file_exists($destinationPath . $fileName)){
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(420, 300);
                $image->save($destinationPath . $fileName, 1);
            }
            return response()->json([
                'location' => asset('uploads/image/' . $fileName),
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
