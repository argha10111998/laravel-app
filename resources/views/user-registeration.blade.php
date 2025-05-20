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

<form action="{{route('registeration.submit')}}" method="POST">
  @CSRF
  <div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputEmail4">Full Name</label>
        <input type="text" name="name" class="form-control" id="inputEmail4" placeholder="Full Name" value="{{ old('name') }}">
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Email</label>
        <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email" value="{{ old('email') }}">
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="inputPassword4">Password</label>
        <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" name="address1" class="form-control" id="inputAddress" placeholder="1234 Main St" value="{{ old('address1') }}">
    @error('address1')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="inputAddress2">Address 2</label>
    <input type="text" name="address2" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" value="{{ old('address2') }}">
    @error('address2')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputCity">City</label>
        <input type="text" name="city" class="form-control" id="inputCity" value="{{ old('city') }}">
        @error('city')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label for="inputState">State</label>
        <select id="inputState" name="state" class="form-control">
            <option value="">Choose...</option>
            <option value="West Bengal" {{ old('state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
        </select>
        @error('state')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group col-md-2">
        <label for="inputZip">Zip</label>
        <input type="text" name="zip" class="form-control" id="inputZip" value="{{ old('zip') }}">
        @error('zip')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>


  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
@endsection