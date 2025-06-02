@extends('layouts')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <form action="{{ route('product_filter', ['slug' => $category_slug]) }}" method="GET">
                            {{-- @dd($category_slug) --}}
                            @CSRF
                            <div class="shop__sidebar__search">
                                <!-- <form action=""> -->
                                    <input type="text" placeholder="Search...">
                                    <button type="submit"><span class="icon_search"></span></button>
                                <!-- </form> -->
                            </div>
                            <input name="category_slug" hidden value="{{$category_slug}}"></input>
                            <input name="category_id" hidden value="{{$category_id}}"></input>
                            <div class="shop__sidebar__accordion">
                                <div class="accordion" id="accordionExample">

                                    @if($brands->isNotEmpty())
                                        @php
                                            $selectedBrands = request()->input('brand', []);
                                        @endphp
                                        <div class="card">
                                            <div class="card-heading">
                                                <a data-toggle="collapse" data-target="#collapseTwo">Branding</a>
                                            </div>
                                            <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="shop__sidebar__brand">
                                                        <ul>
                                                        @foreach($brands as $brand)
                                                            <li>
                                                                <input type="checkbox" name="brand[]" value="{{ $brand->id }}"  @if(in_array($brand->id, $selectedBrands)) checked @endif>
                                                                <label for="">{{ $brand->name }}</label>
                                                            </li>
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($priceLimits)
                                        @php
                                            $selectedPrice = request()->input('price', []);
                                            // @dd($selectedPrice);
                                        @endphp
                                        <div class="card">
                                            <div class="card-heading">
                                                <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
                                            </div>
                                            <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="shop__sidebar__price">
                                                        <ul>
                                                        @foreach($priceLimits as $each_priceLimits)
                                                        @php
                                                            $priceRange = $each_priceLimits['lower_limit'] . '-' . $each_priceLimits['upper_limit'];
                                                        @endphp
                                                            <li>
                                                                <input type="checkbox" name="price[]" value="{{ $each_priceLimits['lower_limit'] }}-{{ $each_priceLimits['upper_limit'] }}" @if(in_array($priceRange, $selectedPrice)) checked @endif>
                                                                <label for="">{{ $each_priceLimits['lower_limit'] }} - {{ $each_priceLimits['upper_limit'] }}</label>
                                                            </li>
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($sizes->isNotEmpty())
                                        @php
                                            $selectedSize = request()->input('size',[]);
                                            // print_r ($selectedSize);
                                        @endphp
                                        <div class="card">
                                            <div class="card-heading">
                                                <a data-toggle="collapse" data-target="#collapseFour">Size</a>
                                            </div>
                                            <div id="collapseFour" class="collapse show" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="shop__sidebar__size shop_sidebar_shop_size">
                                                        @foreach($sizes as $size)
                                                            <label for="size_{{ $size->id }}" @if(in_array($size->id,$selectedSize)) class="active shop_size_label" @else class="shop_size_label" @endif>
                                                                <input type="checkbox" 
                                                                    id="size_{{ $size->id }}" 
                                                                    name="size[]" 
                                                                    value="{{ $size->id }}" 
                                                                    @if(in_array($size->id,$selectedSize)) checked @endif
                                                                    class="shop_size_checkbox">
                                                                {{ $size->size }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($colors->isNotEmpty())
                                       @php
                                        $selectedColor = request()->input('color',[]);
                                       @endphp
                                        <div class="card">
                                            <div class="card-heading">
                                                <a data-toggle="collapse" data-target="#collapseFive">Colors</a>
                                            </div>
                                            <div id="collapseFive" class="collapse show" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="shop__sidebar__color product__details__option__color">
                                                        @foreach($colors as $color)
                                                            <label for="color" style="background-color: {{ $color->color_code }};" class="shop_color @if(in_array($color->id,$selectedColor)) {{'active'}} @endif" >
                                                                <input type="checkbox"  name="color[]" value="{{ $color->id }}">
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <button type="submit" class="primary-btn">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <!-- <p>/p> -->
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select name="sort" id="sort">
                                        <option value="low_high">Low To High</option>
                                        <option value="high_low">High To Low</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    
                    @if($products->isNotEmpty()) 
                        @foreach($products as $each_product)
                            <?php //echo "<pre> "; print_r($each_product);echo "</pre>" ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    {{-- <a href="/single-product/{{$each_product->id}}}"> --}}
                                        <div class="product__item__pic set-bg" data-setbg="{{ asset('images/product/' . $each_product->image) }}">
                                            <ul class="product__hover">
                                                <li><a href="#"><img src="{{ asset('img/icon/heart.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ asset('img/icon/compare.png')}}" alt=""> <span>Compare</span></a></li>
                                                <li><a href="#"><img src="{{ asset('img/icon/search.png')}}" alt=""></a></li>
                                            </ul>
                                        </div>
                                    {{-- </a> --}}
                                    <div class="product__item__text">
                                        {{-- <a href="/single-product/{{$each_product->id}}}"> --}}
                                            <h6>{{ $each_product->name }}</h6>
                                        {{-- </a> --}}
                                        <a href="#" class="add-cart">+ Add To Cart</a>
                                        <div class="rating">
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        
                                        {{-- Updated price display logic --}}
                                        @if(isset($each_product->min_price) && isset($each_product->max_price))
                                            @if($each_product->min_price == $each_product->max_price)
                                                {{-- Single price if min and max are the same --}}
                                                <h5>${{ number_format($each_product->min_price, 2) }}</h5>
                                            @else
                                                {{-- Price range if different --}}
                                                <h5>${{ number_format($each_product->min_price, 2) }} - ${{ number_format($each_product->max_price, 2) }}</h5>
                                            @endif
                                        @else
                                            {{-- Fallback to original sale_price if no size prices --}}
                                            <h5>${{ number_format($each_product->sale_price ?: $each_product->regular_price, 2) }}</h5>
                                        @endif
                                        
                                        <div class="product__color__select">
                                            <label for="pc-4">
                                                <input type="radio" id="pc-4">
                                            </label>
                                            <label class="active black" for="pc-5">
                                                <input type="radio" id="pc-5">
                                            </label>
                                            <label class="grey" for="pc-6">
                                                <input type="radio" id="pc-6">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="/single-product/{{$each_product->id}}">More<a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product__pagination">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
    <style>
        .product__details__option__color label {
            position: relative;
            cursor: pointer;
            display: inline-block;
            padding-left: 10px; /* Space for the tick mark */
        }
        .product__details__option__color .active::before {
            content: '✔'; /* Unicode for the tick mark */
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: white; /* Color of the tick mark */
        }
        .product__details__option__color input[type="radio"] {
            display: none; /* Hide the radio button */
        }
    </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    // Replace your existing JavaScript with this:
    $(()=> {
        jQuery(".shop_color").on('click', function(e){
            e.preventDefault();
            
            var checkbox = $(this).find('input[type="checkbox"]');
            
            if (checkbox.is(':checked')) {
                checkbox.prop('checked', false);
                $(this).removeClass('active');
            } else {
                checkbox.prop('checked', true);
                $(this).addClass('active');
            }
        });
        
        jQuery(".shop_color input[type='checkbox']").on('click', function(e){
            e.stopPropagation(); 
            
            var label = $(this).closest('.shop_color');
            
            if ($(this).is(':checked')) {
                label.addClass('active');
            } else {
                label.removeClass('active');
            }
        });


        // Handle size checkbox clicks
        jQuery(".shop_size_checkbox").on('change', function(){
            console.log('Size checkbox clicked!');
            console.log('Checkbox ID:', $(this).attr('id'));
            console.log('Checkbox value:', $(this).val());
            console.log('Is checked:', $(this).is(':checked'));
            
            var label = $(this).closest('.shop_size_label');
            
            if ($(this).is(':checked')) {
                label.addClass('active');
                console.log('Added active class to label');
            } else {
                label.removeClass('active');
                console.log('Removed active class from label');
            }
        });
        
        // Handle label clicks (in case someone clicks the label text)
        jQuery(".shop_size_label").on('click', function(e){
            // Don't prevent default here - let the checkbox handle it naturally
            console.log('Size label clicked!');
        });
        
    });
</script>
@endsection