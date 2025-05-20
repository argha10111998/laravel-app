<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Size;
use App\Models\ProductSize;
use App\Models\ProductSizeQuantity;
use App\Models\Color;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // dd($request->input('size'),$request->input('price'),$request->input('color'));
        
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images' => 'required',
            'category_id' => 'required|exists:category,id',
            'brand_id' => 'nullable|exists:brand,id',
            'color_id' => 'nullable|exists:color,id',
            // 'sizes' => 'required|array',
            // 'sizes.*' => 'exists:sizes,id', // validate each size
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/product/'), $imageName);
            $validatedData['image'] = $imageName;
        }
    
        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/product/'), $imageName);
                $imagePaths[] = $imageName;
            }
            $validatedData['images'] = json_encode($imagePaths); // Save as JSON-encoded string
        }

        // Save the form data to the database
        $product_id = Product::create($validatedData);
        $sizes = $request->input('size');
        echo '<pre>';
        print_r($sizes);
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
                $product_size = ProductSize::create([
                    'product_id' => $product_id->id,
                    'size_id' => $size['size'],
                    'price' => $size['price'],
                ]);
                echo $product_id->id;
                echo $size['size'];
                echo $size['quan'];
                $product_size_quantity = ProductSizeQuantity::create([
                    'product_id' => $product_id->id,
                    'size_id' => $size['size'],
                    'quantity' => $size['quan'],
                ]);
            }

        
        }
        $color = $request->input('color_id');
        if($color!=null){
            ProductColor::create([
                'product_id' => $product_id->id,
                'color_id' => $color,
            ]);
        }
        // dd($sizes);
        // Redirect to a success page
        return redirect()->route('product.create')->with('success', 'Product created successfully!');
    }


    public function findAllProducts(Request $request , $slug){
        $category = Category::where('slug', $slug)->first();
        $category_slug = $slug;
        $category_id = $category->id;
        if($category){
        $products = Product::where('category_id', $category->id)
        ->with(['brand' , 'color' , 'sizes' ])
        ->get();
        $sizes = $products->pluck('sizes')->flatten()->unique('id');

        $brands = $products->pluck('brand')->unique('id');
        // $colors = $products->flatMap->color->unique('id');
        $colors = $products->pluck('color')->unique('id');
        //dd($brands , $colors ,$sizes);
        $productsizewithprice = $products->pluck('productsize');

        $productsizewithprice = $productsizewithprice->flatMap(function ($each_product_size) {
                    return $each_product_size;
                });
                // echo "<pre>";
                $price_array = [];
                foreach ($productsizewithprice as $productSize) {
                    //print_r($productSize->price); // Assuming 'price' is an attribute of the ProductSize model
                    array_push($price_array,$productSize->price);
                }
                // print_r($price_array);
                
                $prices = [6578.00, 2698.00, 1569.00, 6587.00];

                // Determine the minimum and maximum prices
                $minPrice = min($prices);
                $maxPrice = max($prices);
                
                // Define the range interval (e.g., 1000)
                $interval = 1000;
                
                // Initialize an array to store the price limits
                $priceLimits = [];
                $closest_upper_limit = (ceil($maxPrice  / $interval) * $interval);
                // Generate the price ranges
                for ($i = floor($minPrice / $interval) * $interval; $i <= ceil($maxPrice / $interval) * $interval; $i += $interval) {
                    $lowerLimit = $i;
                    $upperLimit = $i + $interval;
                 if($upperLimit<=$closest_upper_limit){
                    // Store the limits in the desired structure
                    $priceLimits[] = [
                        'upper_limit' => $upperLimit,
                        'lower_limit' => $lowerLimit
                    ];
                    }
                }
                
                // Print the price limits
               // print_r($priceLimits);


               

        // dd($productsizewithprice);
        return view('category-products',compact('category_id','category_slug' ,'sizes', 'brands','colors' , 'priceLimits' ,'products'));
            }
            echo "wrong slug!";
    }

    public function filterProducts(Request $request , $slug){
        // die();

        $category = Category::where('slug', $slug)->first();
        $category_slug = $slug;
        $category_id = $category->id;
        if($category){
        $products = Product::where('category_id', $category->id)
        ->with(['brand' , 'color' , 'sizes' ])
        ->get();
        $sizes = $products->pluck('sizes')->flatten()->unique('id');

        $brands = $products->pluck('brand')->unique('id');
        // $colors = $products->flatMap->color->unique('id');
        $colors = $products->pluck('color')->unique('id');
        //dd($brands , $colors ,$sizes);
        $productsizewithprice = $products->pluck('productsize');

        $productsizewithprice = $productsizewithprice->flatMap(function ($each_product_size) {
                    return $each_product_size;
                });
                // echo "<pre>";
                $price_array = [];
                foreach ($productsizewithprice as $productSize) {
                    //print_r($productSize->price); // Assuming 'price' is an attribute of the ProductSize model
                    array_push($price_array,$productSize->price);
                }
                // print_r($price_array);
                
                $prices = [6578.00, 2698.00, 1569.00, 6587.00];

                // Determine the minimum and maximum prices
                $minPrice = min($prices);
                $maxPrice = max($prices);
                
                // Define the range interval (e.g., 1000)
                $interval = 1000;
                
                // Initialize an array to store the price limits
                $priceLimits = [];
                $closest_upper_limit = (ceil($maxPrice  / $interval) * $interval);
                // Generate the price ranges
                for ($i = floor($minPrice / $interval) * $interval; $i <= ceil($maxPrice / $interval) * $interval; $i += $interval) {
                    $lowerLimit = $i;
                    $upperLimit = $i + $interval;
                 if($upperLimit<=$closest_upper_limit){
                    // Store the limits in the desired structure
                    $priceLimits[] = [
                        'upper_limit' => $upperLimit,
                        'lower_limit' => $lowerLimit
                    ];
                    }
                }
            }










        $query = Product::query();

        // Apply filters based on request parameters
    
        // Filter by category
        if($category_id){
            $query->where('category_id', $category_id);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
    
        // Filter by size
        if ($request->has('size')) {
            $query->whereHas('sizes', function ($q) use ($request) {
                $q->whereIn('size_id', $request->input('size'));
            });
        }

         // Filter by size
         if ($request->has('brand')) {
            $query->whereIn('brand_id', $request->input('brand'));
        }


        // Filter by size
        if ($request->has('color')) {
        $query->whereIn('color_id', $request->input('color'));
        }
        
        $store_prices = array();
        // Filter by price range
        if ($request->has('price')) {
            $price_array = ($request->input('price'));
            foreach( $price_array  as $each_range){
                $priceRange = explode('-', $each_range);
                // print_r(  $priceRange );
                array_push( $store_prices,$priceRange[0] );
                array_push( $store_prices,$priceRange[1] );
            }
            // print_r($store_prices);
              $minPrice = min($store_prices);
              $maxPrice =  max($store_prices);
            // die();
            // $query->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
            $query->whereHas('productsize', function ($q) use ($request,$minPrice,$maxPrice ) {
                $q->whereBetween('price', [$minPrice,$maxPrice ]);
            });
        }
    
        // Get the filtered products
        $products = $query->get();
        echo "<pre>";
        print_r($products);
        dd($request->input());
       

        // Return the filtered products (adjust as needed for your application)
        // return response()->json($products);
        return view('category-products',compact('category_id','category_slug' ,'sizes', 'brands','colors' , 'priceLimits' ,'products'));
            
    }
}
