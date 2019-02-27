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
		<form method="post" action="{{ url('/join') }}">
			{{csrf_field()}}
			<input type="hidden" name="scheme" value="{{ Session::get('scheme') }}">
			<input type="hidden" name="name" value="{{ \Auth::user()->name }}">
			<input type="hidden" name="email" value="{{ \Auth::user()->email }}">
			<input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
			<input type="hidden" name="amount" value="{{ $row->amount }}">
			<input type="submit" name="submit" value="Join Scheme now" class="btn btn-primary">
		</form>


	</div>
</div>
@endsection
