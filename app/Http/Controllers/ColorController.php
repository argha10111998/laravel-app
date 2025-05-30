<?php

namespace App\Http\Controllers;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    
    public function submitColorForm(Request $request)
    {
        // dd($request->input());
        // Validate the form data
        $validatedData = $request->validate([
            'color_name' => 'required',
            'color_slug' => [
                'required',
                'string',
                'max:255',
                'unique:color,color_code',
            ],
            'color_code' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

            Color::create([
                'color' => $validatedData['color_name'],
                'slug' => $validatedData['color_slug'],
                'color_code' => $validatedData['color_code'],
            ]);
        

        // Redirect to a success page
        return redirect('/admin/color-form')->with('success', 'Color Submitted successfully!');
    }

}
