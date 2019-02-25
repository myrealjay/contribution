@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">


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
