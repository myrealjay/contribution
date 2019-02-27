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
		<!--:::::THE SESSION IF SCHEME DOES NOT EXIST::::::-->
		@if (Session::has('not_found'))
		<div class="alert alert-danger">
			<ul>
				{{Session::get('not_found')}}
			</ul>
		</div>
		@endif
		<div class="panel panel-default col-sm-4">
			<div class="panel-heading">Join new scheme</div>
			<div class="panel-body">
				<div>
					@if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
					<form method="post" action="{{ url('/chk_scheme') }}">
						{{ csrf_field() }}
						<div class="form-group">
							<label>Scheme Name</label>
							<input type="text" name="scheme" class="form-control" placeholder="eneter scheme name">
						</div>
						<input type="submit" name="submit" value="continue" class="btn btn-primary">
					</form>
				</div>
			</div>
		</div>


	</div>
</div>
@endsection
