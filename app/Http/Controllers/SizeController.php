<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Size;
use Illuminate\Http\Request;


class SizeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string|max:255',
        ]);
// dd($request->input());
        // Check if the size already exists
        $size = Size::where('size', $request->input('size'))->first();

        if ($size) {
            // Size already exists
            return response()->json(['message' => 'Size already exists!']);
        }

        // Create new size
        $newSize = new Size();
        $newSize->size = $request->input('size');
        $newSize->save();

        return response()->json(['success' => 'Size added successfully!']);
    }

    public function fetch_sizes(Request $request)
    {
    
        $sizes = Size::all();
        return response()->json($sizes);
    
    }
    
    
}