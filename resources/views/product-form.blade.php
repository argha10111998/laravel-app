@extends('layouts')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('product.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Product Name</label>
                <input type="text" name="name" class="form-control" id="product_name" placeholder="Product Name" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="slug">Product Slug</label>
                <input type="text" name="slug" class="form-control" id="product_slug" placeholder="Product Slug" value="{{ old('slug') }}">
                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="short_description">Short Description</label>
                <textarea name="short_description" class="form-control" id="short_description" placeholder="Short Description">{{ old('short_description') }}</textarea>
                @error('short_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description" placeholder="Description">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="regular_price">Regular Price</label>
                <input type="text" name="regular_price" class="form-control" id="regular_price" placeholder="Regular Price" value="{{ old('regular_price') }}">
                @error('regular_price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="sale_price">Sale Price</label>
                <input type="text" name="sale_price" class="form-control" id="sale_price" placeholder="Sale Price" value="{{ old('sale_price') }}">
                @error('sale_price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="SKU">SKU</label>
                <input type="text" name="SKU" class="form-control" id="SKU" placeholder="SKU" value="{{ old('SKU') }}">
                @error('SKU')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="stock_status">Stock Status</label>
                <select id="stock_status" name="stock_status" class="form-control">
                    <option value="instock" {{ old('stock_status') == 'instock' ? 'selected' : '' }}>In Stock</option>
                    <option value="outofstock" {{ old('stock_status') == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
                @error('stock_status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Quantity" value="{{ old('quantity', 1) }}">
                @error('quantity')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control" id="image">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="images">Additional Images</label>
                <input type="file" name="images[]" class="form-control" id="images" multiple>
                @error('images')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div id="sizes" class="form-row">
        
        </div>
        <div id="size-select-container"></div>
        <!-- @if($sizes->isNotEmpty()) -->
        <button type="button" id="add-existing-size" class="btn btn-secondary">Add More Sizes</button>
        <!-- @endif -->

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Add New Sizes
        </button>

        @if($colors->isNotEmpty())
            <div class="product__details__option">
                               
                <div class="product__details__option__color">
                    <span>Color:</span>
                        @foreach($colors as $color)
                            <label for="color-{{ $color->id }}" style="background-color: {{ $color->color_code }};">
                                <input type="radio" name="color_id" id="color-{{ $color->id }}" value="{{ $color->id }}">
                            </label>
                        @endforeach
                    </div>

            </div>
        @endif

        <div class="form-row">
            @if($categories->isNotEmpty())
                <div class="form-group col-md-6">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="">....Choose Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @endif
            @if($brands->isNotEmpty())
                <div class="form-group col-md-6">
                    <label for="brand_id">Brand</label>
                    <select id="brand_id" name="brand_id" class="form-control">
                        <option value="">....Choose Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @endif



        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            @CSRF
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Size</label>
                <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" id="new-size" placeholder="small" value="">
                </div>
                <!-- <button type="submit" class="btn btn-primary">Add Size</button> -->
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add-new-size">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('product_name').addEventListener('input', function() {
        var name = this.value.toLowerCase();
        var slug = name.replace(/[^a-z0-9\s]/g, '').replace(/[_\s]+/g, '_');
        document.getElementById('product_slug').value = slug;
    });

    let newsizeIndex = 0;

    document.getElementById('add-new-size').addEventListener('click', function() {
        const sizesDiv = document.getElementById('sizes');

        const newSizeNameDiv = document.createElement('div');
        newSizeNameDiv.className = 'form-group col-md-6';
        newSizeNameDiv.innerHTML = `<label for="size_${newsizeIndex}_name">Size Name</label><input type="text" name="size_[${newsizeIndex}][name]" class="form-control" id="size_${newsizeIndex}_name" placeholder="Size Name">`;
        sizesDiv.appendChild(newSizeNameDiv);

        const newSizePriceDiv = document.createElement('div');
        newSizePriceDiv.className = 'form-group col-md-6';
        newSizePriceDiv.innerHTML = `<label for="size_${newsizeIndex}_price">Size Price</label><input type="text" name="size_[${newsizeIndex}][price]" class="form-control" id="size_${newsizeIndex}_price" placeholder="Size Price">`;
        sizesDiv.appendChild(newSizePriceDiv);

        newsizeIndex++;
    });

    let existingsizeIndex = 1;
    document.getElementById('add-existing-size').addEventListener('click', function() {
        let size_option_html = '';
        let sourceSelect = document.getElementById('size');
        sourceSelect.querySelectorAll('option').forEach(function(option) {
        let newOption = document.createElement('option');
        newOption.value = option.value;
        newOption.textContent = option.textContent;
        size_option_html += newOption.outerHTML; // Append the outerHTML of the newOption
});

console.log(size_option_html);


        const sizesDiv = document.getElementById('sizes');
        const newSizeNameDiv = document.createElement('div');
        newSizeNameDiv.className = 'form-group col-md-6';
        newSizeNameDiv.innerHTML = `<label for="existing_sizes_${existingsizeIndex}_name">Existing Size Name</label><select name="existing_sizes[${existingsizeIndex}][id]" class="form-control col-md-6" id="size">`+size_option_html+`</select>`;
        sizesDiv.appendChild(newSizeNameDiv);

        const newSizePriceDiv = document.createElement('div');
        newSizePriceDiv.className = 'form-group col-md-6';
        newSizePriceDiv.innerHTML = `<label for="existing_sizes_${existingsizeIndex}_price">Existing Size Price</label><input type="text" name="existing_sizes[${existingsizeIndex}][price]" class="form-control" id="existingsizes_${existingsizeIndex}_price" placeholder="Size Price">`;
        sizesDiv.appendChild(newSizePriceDiv);

        existingsizeIndex++;
    });
});
</script> -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('product_name').addEventListener('input', function() {
        var name = this.value.toLowerCase();
        var slug = name.replace(/[^a-z0-9\s]/g, '').replace(/[_\s]+/g, '_');
        document.getElementById('product_slug').value = slug;
    });

    let newsizeIndex = 0;

    $("#add-new-size").click(function(){
        alert("clicked");
        // event.preventDefault();
        var size = $("#new-size").val();
        alert(size);
        $.ajax({
                url: 'http://127.0.0.1:8000/add-size',
                type: 'POST',
                data: {
                    size: size,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success){
                        alert(response.success);
                    }
                    if(response.message){
                        alert(response.message);
                    }
                },
                error: function(response) {
                    console.log(response);
                    alert('Error: ' + response.responseJSON.message);
                }
        });
    
    });
        

    let existingSizeIndex = -1;
    document.getElementById('add-existing-size').addEventListener('click', function() {
        existingSizeIndex++;
            $.ajax({
                url: '{{ route('sizes.get') }}',
                type: 'GET',
                success: function(response) {
                    alert(existingSizeIndex);
                    var sizeSelect = document.createElement('select');
                    sizeSelect.id = 'size-select';
                    sizeSelect.name = `size[${existingSizeIndex}][size]`;
                    sizeSelect.className = 'form-control mb-2';

                    response.forEach(function(size) {
                        var option = document.createElement('option');
                        option.value = size.id;
                        option.text = size.size;
                        sizeSelect.appendChild(option);
                    });

                    var priceInput = document.createElement('input');
                    priceInput.type = 'text';
                    priceInput.id = 'price';
                    priceInput.name = `size[${existingSizeIndex}][price]`;
                    priceInput.placeholder = 'Enter price';
                    priceInput.className = 'form-control mb-2';

                    var quantityInput = document.createElement('input');
                    quantityInput.type = 'number';
                    quantityInput.id = 'quantity';
                    quantityInput.name = `size[${existingSizeIndex}][quan]`;
                   
                    quantityInput.placeholder = 'Enter quantity';
                    quantityInput.className = 'form-control mb-2';

                    var container = document.getElementById('size-select-container');
                    container.appendChild(sizeSelect);
                    container.appendChild(priceInput);
                    container.appendChild(quantityInput);
                },
                error: function(response) {
                    alert('Error fetching sizes');
                }
            });
           
        });

});
</script>
<style>
    .product__details__option__color label {
        position: relative;
        cursor: pointer;
        display: inline-block;
        padding-left: 25px; /* Space for the tick mark */
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorLabels = document.querySelectorAll('.product__details__option__color label');
        
        colorLabels.forEach(label => {
            label.addEventListener('click', function() {
                colorLabels.forEach(lbl => lbl.classList.remove('active')); // Remove 'active' from all labels
                this.classList.add('active'); // Add 'active' to the clicked label
            });
        });
    });
</script>

@endsection
