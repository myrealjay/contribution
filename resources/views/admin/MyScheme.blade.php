@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		@foreach($Scheme as $row)
		<div class="panel panel-default">
			<div class="panel-heading">my scheme(s)</div>
			<div class="panel-body">Panel Content</div>
		</div>

		@endforeach

	</div>
</div>
@endsection
