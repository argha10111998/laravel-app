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

<form action="{{route('color.form.submit')}}" method="POST" enctype="multipart/form-data">
  @CSRF
  <div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputEmail4">Color Name</label>
        <input type="text" name="color_name" class="form-control" id="color_name" placeholder="Color Name" value="{{ old('color_name') }}">
        @error('color_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="inputEmail4">Brand Slug</label>
        <input type="text" name="color_slug" class="form-control" id="color_slug" placeholder="Color Slug" value="{{ old('color_slug') }}">
        @error('color_slug')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>


    <div class="form-group col-md-6">
        <label for="inputEmail4">Color Image</label>
        <input type="color" name="color_code" class="form-control" id="color_code" placeholder="Image" value="{{ old('color_code') }}">
        @error('color_code')
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