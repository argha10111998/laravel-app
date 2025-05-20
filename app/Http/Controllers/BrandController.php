<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    
    
    
    
    public function submitBrandForm(Request $request)
    {
        // dd($request->input());
        // Validate the form data
        $validatedData = $request->validate([
            'brand_name' => 'required',
            'brand_slug' => [
                'required',
                'string',
                'max:255',
                'unique:category,slug',
                'regex:/^[a-z]+(_[a-z]+)*$/', // Slug format validation
            ],
            'brand_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $imageName=null;
        if ($request->hasFile('brand_image')) {
            $imageName = time().'.'.$request->category_image->extension();
            $request->category_image->move(public_path('images/brand/'), $imageName);
            $validatedData['brand_image'] = $imageName;
        }
        // Save the form data to the database
        if($imageName!=null){
            Brand::create([
                'name' => $validatedData['brand_name'],
                'slug' => $validatedData['brand_slug'],
                'image' => $validatedData['brand_image'],
            ]);
        }else{
            Brand::create([
                'name' => $validatedData['brand_name'],
                'slug' => $validatedData['brand_slug'],
            ]);
        }


        // Redirect to a success page
        return redirect('/admin/brand-form')->with('success', 'Brand Submitted successfully!');
    }

}
