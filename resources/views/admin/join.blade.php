@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		@if(Auth::user()->confirm != 2)
		<meta http-equiv="refresh" content="0;URL=confirm" />
		@endif

		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Scheme Name: <b>{{ Session::get('scheme') }}</b></h5>
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover">
					<tr>
						<th>Member Names</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Amount to be contributed</th>
					</tr>
					@foreach($data as $row)
					<tr>
						<td>{{ $row->name }}</td>
						<td>{{ $row->email }}</td>
						<td>{{ $row->phone }}</td>
						<td>NGN {{ $row->amount }}</td>
						@endforeach
					</tr>
				</table>
			</div>
		</div>
		<!--:::CHECKING IF THE TIMELAPSE HAVE NOT EXPIRES:::-->
		@php
			$datetime1 = $row->expire; 
			$datetime2 =  date('Y-m-d H:i:s', time());
		//	$datetime2 = '2019-03-06 17:15:04';
			
			 $diff = strtotime($datetime1) - strtotime($datetime2);

		@endphp
		<form method="post" action="{{ url('/join') }}">
			{{csrf_field()}}
			<input type="hidden" name="scheme" value="{{ Session::get('scheme') }}">
			<input type="hidden" name="name" value="{{ \Auth::user()->name }}">
			<input type="hidden" name="email" value="{{ \Auth::user()->email }}">
			<input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
			<input type="hidden" name="amount" value="{{ $row->amount }}">
			@if($diff > 0)
			<input type="submit" name="submit" value="Join Scheme now" class="btn btn-primary">
			@else
			<div class="alert alert-danger">
			{{ 'Timeline expired, You can no longer join the scheme' }}
		</div>
			@endif
		</form>


	</div>
</div>
@endsection
