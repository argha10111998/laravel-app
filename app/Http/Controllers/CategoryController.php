<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function viewCategoryForm(Request $request){

        $categories = Category::all();
        // dd($categories);
        // Pass the categories to the view
        return view('category-form', compact('categories'));
    }
    
    
    
    
    public function submitCategoryForm(Request $request)
    {
        // dd($request->input());
        // Validate the form data
        $validatedData = $request->validate([
            'category_name' => 'required',
            'category_slug' => [
                'required',
                'string',
                'max:255',
                'unique:category,slug',
                'regex:/^[a-z]+(_[a-z]+)*$/', // Slug format validation
            ],
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent_cat' => 'nullable|exists:category,id',
        ]);

        $parentCatId = $validatedData['parent_cat'] ?? 0;
        $imageName=null;
        if ($request->hasFile('category_image')) {
            $imageName = time().'.'.$request->category_image->extension();
            $request->category_image->move(public_path('images/category/'), $imageName);
            $validatedData['category_image'] = $imageName;
        }
        // Save the form data to the database
        if($imageName!=null){
            Category::create([
                'name' => $validatedData['category_name'],
                'slug' => $validatedData['category_slug'],
                'image' => $validatedData['category_image'],
                'parent_id' => $parentCatId,
            ]);
        }else{
            Category::create([
                'name' => $validatedData['category_name'],
                'slug' => $validatedData['category_slug'],
                'parent_id' => $parentCatId,
            ]);
        }


        // Redirect to a success page
        return redirect('/admin/category-form')->with('success', 'Category Submitted successfully!');
    }

}
