@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12 container">
			<div class="col-sm-4">
				<form method="POST" action="{{ url('/reg_scheme') }}">
					<h2>Create new scheme</h2>
					{{csrf_field()}}
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>

					@endif
					<!--:::::GETTING THE ERROR::::-->
					@if (Session::has('info'))
					<div class="alert alert-danger">
						<ul>
							{{Session::get('info')}}
						</ul>
					</div>
					@endif

					<div class="form-group">
						<label>Enter Scheme Name</label>
						<input type="text" name="Name" class="form-control">
					</div>
					<input type="hidden" name="Email" value="{!! Auth::user()->name !!}">

					<div class="form-group">
						<label>Amount to be contributed</label>
						<input type="text" onkeypress="allowNumbersOnly(event)" id="onlyNumbers" name="Amount" class="form-control">
					</div>

					<div class="form-group">
						<label>Total Members</label>
						<input type="number" min="5" max="50" onkeypress="allowNumbersOnly(event)" id="onlyNumbers" name="Members" class="form-control">
					</div>

					<input type="submit" name="chk" value="continue" class="btn btn-primary">

				</form>

			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
	function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
        e.preventDefault();
    }
}
</script>
@endsection
