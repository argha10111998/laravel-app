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

<form action="{{route('category.form.submit')}}" method="POST" enctype="multipart/form-data">
  @CSRF
  <div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputEmail4">Category Name</label>
        <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Category Name" value="{{ old('category_name') }}">
        @error('category_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="inputEmail4">Category Slug</label>
        <input type="text" name="category_slug" class="form-control" id="category_slug" placeholder="Category Slug" value="{{ old('category_slug') }}">
        @error('category_slug')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    @if($categories->isNotEmpty())
    <div class="form-group col-md-4">
        <label for="parent_cat">Parent Category</label>
        <select id="parent_cat" name="parent_cat" class="form-control">
            <option value="">Choose...</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('parent_cat')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
@endif

    <div class="form-group col-md-6">
        <label for="inputEmail4">Category Image</label>
        <input type="file" name="category_image" class="form-control" id="inputEmail4" placeholder="Image" value="{{ old('category_image') }}">
        @error('category_image')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
@endsection


<script>
    // JavaScript to generate slug based on category name
    document.addEventListener('DOMContentLoaded', function () {
        var categoryNameInput = document.getElementById('category_name');
        var categorySlugInput = document.getElementById('category_slug');

        categoryNameInput.addEventListener('input', function () {
            var categoryName = categoryNameInput.value.trim().toLowerCase().replace(/\s+/g, '_');
            categorySlugInput.value = categoryName;
        });
    });
</script>