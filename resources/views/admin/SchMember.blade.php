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
					</tr>
					<tr>
						@foreach($data as $row)
						<td>{{ $row->name }}</td>
						<td> {{ $row->email }} </td>
						<td> {{ $row->phone }} </td>
					</tr>


					@endforeach
				</table>
			</div>
		</div>

	</div>
</div>
@endsection
