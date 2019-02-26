@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">

		@if(Auth::user()->confirm != 2)
		<meta http-equiv="refresh" content="0;URL=confirm" />
		@endif

		<!--:::::THE SESSION::::::-->
		@if (Session::has('info'))
		<div class="alert alert-info">
			<ul>
				{{Session::get('info')}}
			</ul>
		</div>
		@endif
		<!--:::::THE SESSION::::::-->


	</div>
</div>
@endsection
