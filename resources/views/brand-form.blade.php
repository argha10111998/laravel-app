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

<form action="{{route('brand.form.submit')}}" method="POST" enctype="multipart/form-data">
  @CSRF
  <div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputEmail4">Brand Name</label>
        <input type="text" name="brand_name" class="form-control" id="brand_name" placeholder="Brand Name" value="{{ old('brand_name') }}">
        @error('brand_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="inputEmail4">Brand Slug</label>
        <input type="text" name="brand_slug" class="form-control" id="brand_slug" placeholder="Brand Slug" value="{{ old('brand_slug') }}">
        @error('brand_slug')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>


    <div class="form-group col-md-6">
        <label for="inputEmail4">Brand Image</label>
        <input type="file" name="brand_image" class="form-control" id="inputEmail4" placeholder="Image" value="{{ old('brand_image') }}">
        @error('brand_image')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
@endsection


<script>
    // JavaScript to generate slug based on Brand name
    document.addEventListener('DOMContentLoaded', function () {
        var BrandNameInput = document.getElementById('brand_name');
        var BrandSlugInput = document.getElementById('brand_slug');

        BrandNameInput.addEventListener('input', function () {
            var BrandName = BrandNameInput.value.trim().toLowerCase().replace(/\s+/g, '_');
            BrandSlugInput.value = BrandName;
        });
    });
</script>