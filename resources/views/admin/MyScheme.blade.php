@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	@foreach($Scheme as $row)
    		<div class="card">
  <div class="card-header">Header</div>
  <div class="card-body">Content</div> 
  <div class="card-footer">Footer</div>
</div>
    	@endforeach

    </div>
</div>
@endsection
