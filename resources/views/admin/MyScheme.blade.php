@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="panel panel-default col-sm-8">
			<div class="panel-heading">my scheme(s)</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<tr>
						<th>Scheme Name</th>
						<th>Amount to be contributed</th>
						<th></th>
					</tr>
					<tr>

						@foreach($Scheme as $row)
						<td>{{ $row->scheme }}</td>
						<td>NGN {{ $row->amount }} </td>
						<td>
							<form method="post" action="{{ url('/view_members') }}">
								<input type="hidden" name="name" value="{{ $row->scheme }}">
								<input type="submit" name="submit" value="view members" class="btn btn-link">
							</form>
						</td>
					</tr>


					@endforeach
				</table>
			</div>
		</div>

	</div>
</div>
@endsection
