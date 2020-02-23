@extends('layouts.app')
@section('content')
        <div class="flex-center position-ref full-height">
           <div class="content">
                <h1>
				Product Details
                </h1>
				
				<form action="{{URL::current()}}">		
				<div class="row">    <div class="col-sm-3 pull-left">
				<select id="speed" name="speed">
				<option value="">Choose Speed</option>				
				<option value="greater">Greater than 10</option>
                <option value="lessthan">Less than 10</option>
				</select>
				</div>
                <div class="col-sm-3 pull-left">
				<select id="color" name="color">
				<option value="">Choose Color</option>				
				<option value="black">Black</option>
                <option value="other">Other</option>
				</select>
				</div>
<div class="col-sm-3 pull-left">
<select id="price" name="price">
				<option value="">Choose Price</option>				
				<option value="greater">Above 500</option>
                <option value="lessthan">Below 500</option>
				</select></div>
    <div class="col-sm-3"><button id="findButton">Search</button></div>
</div>
</form>

<div class="row" style="margin-top:5px;">
			<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">Product Name</th>
      <th scope="col">Speed</th>
      <th scope="col">Color</th>
	   <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($products as $row)
  <tr>
      <th>{{$row->id}}</th>
      <td>{{$row->name}}</td>
      <td>{{$row->speed}}</td>
      <td>{{$row->color}}</td>
	   <td>{{$row->price}}</td>
    </tr>
  @endforeach
    
    
  </tbody>
</table>
</div>
            </div>
        </div>
@endsection 