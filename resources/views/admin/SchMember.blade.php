@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="panel panel-default col-sm-8">
			<div class="panel-heading">my scheme members</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<tr>
						<th colspan="3">Schem Name: {{Session::get('Scheme')}}<b></b></th>
					</tr>
					<tr>
						<th>Member</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Status</th>
					</tr>
					<tr>
						@foreach($data as $row)
						<td>{{ $row->name }}</td>
						<td> {{ $row->email }} </td>
						<td> {{ $row->phone }} </td>
						<td>
							<center>
							@if($row->active == 1)
							<img src="{{ asset('images/OK-512.png') }}" class="img img-responsive" width="20">
							@else
							<img src="{{ asset('images/Incorrect_Symbol-512.png') }}" class="img img-responsive" width="20">
							@endif
							</center>
						</td>
					</tr>


					@endforeach
				</table>
			</div>
		</div>

	</div>
</div>
@endsection
