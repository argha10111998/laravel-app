<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Size;
use App\Models\ProductSizeTemplate;
use App\Models\Color;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    
    public function viewProductForm(Request $request){

        $categories = Category::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $colors = Color::all();
        // dd($categories,$brands,$sizes);

        // dd($categories);
        // Pass the categories to the view
        return view('product-form', compact('sizes', 'categories', 'brands','colors'));
    }
    
    
    
    
    public function storeProduct(Request $request)
    {
        // $product_id=1;
        // dd($request->input('size_'));
        
        // dd($request->input('size_'));
        // $validatedData = $request->validate([
        //     'size' => 'required|string|max:255|unique:product',
        // ]);
        // Size::create();
        // Validate the form data
        // dd($request->input('size'),$request->input('price'));
        // dd($request->input('size'));
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:product',
            'slug' => 'required|string|max:255|unique:product|regex:/^[a-z]+([a-z\'_]*)*$/',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'SKU' => 'required|string|max:50|unique:product',
            'stock_status' => 'required|in:instock,outofstock',
            'quantity' => 'required|integer|min:1',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Validate each image
            'category_id' => 'required|exists:category,id',
            'brand_id' => 'nullable|exists:brand,id',
            'color_id' => 'nullable|exists:color,id',
            'size' => 'required|array',
            'size.*.size' => 'required|exists:size,id',
            'size.*.price' => 'required|numeric',
            'size.*.quan' => 'required|numeric'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/product/'), $imageName);
            $validatedData['image'] = $imageName;
        }
    
        // Handle multiple images upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Skip files with upload errors
                if ($image->isValid()) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images/product/'), $imageName);
                    $imagePaths[] = $imageName;
                }
            }
            if (!empty($imagePaths)) {
                $validatedData['images'] = json_encode($imagePaths); // Save as JSON-encoded string
            } else {
                $validatedData['images'] = null; // Set to null if no valid images
            }
        } else {
            $validatedData['images'] = null; // Set to null if no images uploaded
        }

        // Save the form data to the database
        // dd($validatedData);
        $product = Product::create($validatedData);
        
        $sizes = $request->input('size');
        // echo '<pre>';
        // print_r($sizes);
        if(!empty($sizes)){

            $errors = [];

            // Loop through each size input
            foreach ($sizes as $index => $input) {
                // Create a validator for each set of inputs
                $validator = Validator::make($input, [
                    'size' => 'required|string|max:255',
                    'price' => 'required|numeric',
                    'quan' => 'required|numeric'
                ]);
    
                // If validation fails, add errors to the array
                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $error) {
                        $errors["size.{$index}.{$error}"] = $error;
                    }
                }
            }
    
            // If there are any errors, redirect back with errors and input
            if (!empty($errors)) {
                return redirect()->back()->withErrors($errors)->withInput();
            }
            // Extract size name and price
            foreach ($sizes as $size) {
            // This creates the pivot table entry
            DB::table('product_size')->insert([
                'product_id' => $product->id,
                'size_id' => $size['size'],
                'price' => $size['price'],
                'stock' => $size['quan'],  // Assuming 'quan' is stock
                'sku' => 'SKU-' . $product->id . '-' . $size['size'] . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2),  // Creating a unique SKU
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // If you also need to update the ProductSizeTemplate table:
            ProductSizeTemplate::create([
                'product_id' => $product->id,
                'size_id' => $size['size'],
                'quantity' => $size['quan'],
            ]);
        }
        
        }
        $color = $request->input('color_id');
        if($color!=null){
            ProductColor::create([
                'product_id' => $product->id, // Updated to use $product->id instead of $product_id->id
                'color_id' => $color,
            ]);
        }
        // dd($sizes);
        // Redirect to a success page
        return redirect()->route('product.create')->with('success', 'Product created successfully!');
    }


    public function findAllProducts(Request $request, $slug){
        $category = Category::where('slug', $slug)->first();
        $category_slug = $slug;
        $category_id = $category->id;
        
        if($category){
            $products = Product::where('category_id', $category->id)
                ->with(['brand', 'color', 'size' => function($query) {
                    $query->withPivot('price', 'stock', 'sku');
                }])
                ->get();

            // Calculate price ranges for each product
            $products = $products->map(function($product) {
                $sizes = $product->size;
                if($sizes->count() > 0) {
                    $prices = $sizes->pluck('pivot.price');
                    $product->min_price = $prices->min();
                    $product->max_price = $prices->max();
                } else {
                    // Fallback to regular/sale price if no sizes
                    $product->min_price = $product->sale_price ?: $product->regular_price;
                    $product->max_price = $product->sale_price ?: $product->regular_price;
                }
                return $product;
            });

            $sizes = $products->pluck('size')->flatten()->unique('id');
            $brands = $products->pluck('brand')->unique('id');
            $colors = $products->pluck('color')->unique('id');

            // Your existing price limits calculation code...
            $productsizewithprice = $products->pluck('size')->flatten();
            $price_array = [];
            foreach ($productsizewithprice as $productSize) {
                if(isset($productSize->pivot->price)) {
                    array_push($price_array, $productSize->pivot->price);
                }
            }
            
            $prices = !empty($price_array) ? $price_array : [0];
            $minPrice = min($prices);
            $maxPrice = max($prices);
            
            $interval = 1000;
            $priceLimits = [];
            $closest_upper_limit = (ceil($maxPrice / $interval) * $interval);
            
            for ($i = floor($minPrice / $interval) * $interval; $i <= ceil($maxPrice / $interval) * $interval; $i += $interval) {
                $lowerLimit = $i;
                $upperLimit = $i + $interval;
                if($upperLimit <= $closest_upper_limit){
                    $priceLimits[] = [
                        'upper_limit' => $upperLimit,
                        'lower_limit' => $lowerLimit
                    ];
                }
            }

            return view('category-products', compact('category_id','category_slug', 'sizes', 'brands','colors', 'priceLimits', 'products'));
        }
        echo "wrong slug!";
    }

    
    public function filterProducts(Request $request, $slug){
        $category = Category::where('slug', $slug)->first();
        $category_slug = $slug;
        $category_id = $category->id;
        
        if($category){
            $query = Product::where('category_id', $category->id)
                ->with(['brand', 'color', 'size' => function($query) {
                    $query->withPivot('price', 'stock', 'sku');
                }]);
                
            // Your existing filter logic...
            if ($request->has('size')) {
                $query->whereHas('size', function ($q) use ($request) {
                    $q->whereIn('size_id', $request->input('size'));
                });
            }

            if ($request->has('brand')) {
                $query->whereIn('brand_id', $request->input('brand'));
            }

            if ($request->has('color')) {
                $query->whereIn('color_id', $request->input('color'));
            }
            
            if ($request->has('price')) {
                $price_array = ($request->input('price'));
                $store_prices = array();
                foreach($price_array as $each_range){
                    $priceRange = explode('-', $each_range);
                    array_push($store_prices, $priceRange[0]);
                    array_push($store_prices, $priceRange[1]);
                }
                $minPrice = min($store_prices);
                $maxPrice = max($store_prices);
                
                $query->whereExists(function ($subQuery) use ($minPrice, $maxPrice) {
                    $subQuery->select(DB::raw(1))
                        ->from('product_size')
                        ->whereColumn('product_size.product_id', 'product.id')
                        ->whereBetween('product_size.price', [$minPrice, $maxPrice]);
                });
            }
            
            $products = $query->get();
            
            // Calculate price ranges for filtered products
            $products = $products->map(function($product) {
                $sizes = $product->size;
                if($sizes->count() > 0) {
                    $prices = $sizes->pluck('pivot.price');
                    $product->min_price = $prices->min();
                    $product->max_price = $prices->max();
                } else {
                    $product->min_price = $product->sale_price ?: $product->regular_price;
                    $product->max_price = $product->sale_price ?: $product->regular_price;
                }
                return $product;
            });
            
            // Get all products for filter options
            $allProducts = Product::where('category_id', $category->id)->with(['brand', 'color', 'size'])->get();
            $brands = $allProducts->pluck('brand')->unique('id')->filter();
            $colors = $allProducts->pluck('color')->unique('id')->filter();
            $sizes = $allProducts->pluck('size')->flatten()->unique('id');
            
            // Your existing price limits calculation...
            $productsWithSizes = $allProducts->map(function($product) {
                return $product->size;
            })->flatten();
            
            $price_array = [];
            foreach ($productsWithSizes as $productSize) {
                if (isset($productSize->pivot->price)) {
                    array_push($price_array, $productSize->pivot->price);
                }
            }
            
            $prices = !empty($price_array) ? $price_array : [0];
            $minPrice = min($prices);
            $maxPrice = max($prices);
            
            $interval = 1000;
            $priceLimits = [];
            $closest_upper_limit = (ceil($maxPrice / $interval) * $interval);
            
            for ($i = floor($minPrice / $interval) * $interval; $i <= ceil($maxPrice / $interval) * $interval; $i += $interval) {
                $lowerLimit = $i;
                $upperLimit = $i + $interval;
                if($upperLimit <= $closest_upper_limit){
                    $priceLimits[] = [
                        'upper_limit' => $upperLimit,
                        'lower_limit' => $lowerLimit
                    ];
                }
            }
            
            return view('category-products', compact(
                'category_id', 
                'category_slug', 
                'sizes', 
                'brands', 
                'colors', 
                'priceLimits', 
                'products'
            ));
        }
        
        return redirect()->back()->with('error', 'Category not found!');
    }
}