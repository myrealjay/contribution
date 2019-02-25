@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>

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
		@foreach($data as $row)

		<div class="panel panel-default col-sm-12">
			<div class="panel-heading"><center>Scheme name: <b>{{$row->Name}}</b></center></div>
			<div class="panel-body">
				<p>Amount to be contributed: <b>NGN{{ $row->Amount }}</b></p>
				<p>Members: <b>{{ $row->Members }}</b></p>
				<p>Scheme Admin: <b>{{ Auth::user()->name }}</b></p>

				<input type="hidden" id="box-0" name="box-0" value="{{ $mem = $row->Members - 1 }}" readonly="" />
				<input type="button" id="btnGenBoxes" class="btn btn-primary" value="Add {{ $mem = $row->Members - 1 }} other members" />
				
				<h3>Members</h3>
				<form method="post" action="{{ url('RegMember') }}">
					{{csrf_field()}}
					<input type="hidden" name="Scheme" value="{{ $row->Name }}">
					<input type="hidden" name="amount" value="{{ $row->Amount }}">
					<div id="putThemHere">
						<label for="box-'+i+'">Admin </label>&nbsp;<input id="box-'+i+'" name="name[]" type="text" value="{{ Auth::user()->name }}" readonly="" style="width: 25%" /> <label for="box-'+i+'"> Email</label>&nbsp;<input id="box-'+i+'" name="email[]" type="email" value="{{ Auth::user()->email }}" readonly="" style="width: 25%" /> <label for="box-'+i+'">Phone </label>&nbsp;<input id="box-'+i+'" name="phone[]" value="{{ Auth::user()->phone }}" readonly="" type="text" style="width: 25%" /><br>
					</div>
					<center>
					<input type="submit" class="btn btn-success" ID="Button2" value="Add members" style="display: none;" />
				</center>
			</form>
		</div>
	</div>




	@endforeach


	<script>
		var generateTextBoxes = function( qty, container ) {
			if (container) {
				for (var i = 1; i <= qty; i++ ) {
					$('<label for="box-'+i+'">Name '+i+'</label>&nbsp;<input id="box-'+i+'" name="name[]" type="text" style="width: 25%" required /> &nbsp;<label for="box-'+i+'">Email '+i+'</label>&nbsp;<input id="box-'+i+'" name="email[]" type="email" style="width: 25%" required /> <label for="box-'+i+'">Phone '+i+'</label>&nbsp;<input onkeypress="allowNumbersOnly(event)" id="box-'+i+'" name="phone[]" type="text" style="width: 25%" required /><br>').appendTo( container );
				}
			}
		}
		var init = function() {
			$('#btnGenBoxes').on('click', function() {
				generateTextBoxes( $('#box-0').val(), $('#putThemHere') );
			});
		}
		window.onload = init;
	</script>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>



	<script type="text/javascript">
		$(function () {
			$("#btnGenBoxes").on('click', function () {
				$("#Button2").show();
			});
		});
	</script>

	<script type="text/javascript">
	function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
        e.preventDefault();
    }
}
</script>


</div>
</div>

@endsection





