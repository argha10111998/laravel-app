@extends('layouts')

@section('content')
@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
@endif

@if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{route('admin.registeration.submit')}}" method="POST">
  @CSRF
  <div class="form-row">

    <div class="form-group col-md-6">
      <label for="inputEmail4">Full Name</label>
      <input type="text" name="name" class="form-control" id="inputName" placeholder="Full Name">
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Register</button>
</form>
@endsection