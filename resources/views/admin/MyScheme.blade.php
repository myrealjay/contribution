@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="panel panel-default col-sm-8">
			<div class="panel-heading">my scheme(s)</div>
			<div class="panel-body">
				<!--:::::THE SCHEME I CREATED::::::-->
				<table class="table table-bordered">
					<tr>
						<th colspan="3"><h4><center>My Created Scheme</center></h4></th>
					</tr>
					<tr>
						<th>Scheme Name</th>
						<th>Amount to be contributed</th>
						<th></th>
						<th></th>
					</tr>
					<tr>

						@foreach($my_scheme as $row)
						<td>{{ $row->Name }}</td>
						<td>NGN {{ $row->Amount }} </td>
						<td>
							<form method="post" action="{{ url('/view_members') }}">
								{{ csrf_field() }}
								<input type="hidden" name="name" value="{{ $row->Name }}">
								<input type="submit" name="submit" value="view members" class="btn btn-link">
							</form>
						</td>
						<td>
							@if($row->mem_added == 0)
							<form method="post" action="{{ url('/add_mem') }}">
								{{ csrf_field() }}
								<input type="hidden" name="name" value="{{ $row->Name }}">
								<input type="submit" name="submit" value="Add members" class="btn btn-link">
							</form>
							@endif
						</td>
					</tr>

					@endforeach
				</table>
				<!--:::::THE SCHEME I CREATED::::::-->
				<p>&nbsp;</p>
				<table class="table table-bordered">
					<tr>
						<th colspan="3"><h4><center>Joined Scheme</center></h4></th>
					</tr>
					<tr>
						<th>Scheme Name</th>
						<th>Amount to be contributed</th>
						<th></th>
					</tr>
					<tr>
						@foreach($Scheme as $row)

						
						@if( Auth::User()->email == $row->creator )
						
						@else
						
						<td>{{ $row->scheme }}</td>
						<td>NGN {{ $row->amount }} </td>
						<td>
							<form method="post" action="{{ url('/view_members') }}">
								{{ csrf_field() }}
								<input type="hidden" name="name" value="{{ $row->scheme }}">
								<input type="submit" name="submit" value="view members" class="btn btn-link">
							</form>
						</td>
					</tr>
					@endif

					@endforeach
				</table>
			</div>
		</div>

	</div>
</div>
@endsection
