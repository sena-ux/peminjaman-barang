<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/image/'), $fileName);

        // Kembalikan URL file yang diunggah
        return response()->json([
            'location' => asset('uploads/image/' . $fileName),
        ]);

        // $fileName=$request->file('file')->getClientOriginalName();
        //     $path=$request->file('file')->storeAs('uploads', $fileName, 'public');
        //     return response()->json(['location'=>"/storage/$path"]); 

        /*$imgpath = request()->file('file')->store('uploads', 'public'); 
        return response()->json(['location' => "/storage/$imgpath"]);*/
    }
}
