<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<body>
	<div class="col-sm-4">
		<div class="alert alert-success">
			<p>Check you email address, we have sent a six digit code, it will expire shortly so enter it as soon as possible</p>
		</div>
		<form method="POST" action="{{url('verifynow')}}">
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
        @if (Session::has('info'))
          <div class="alert alert-info">
              <ul>
                  {{Session::get('info')}}
              </ul>
          </div>
        @endif
			<div class="form-group">
				<label>Email</label>
				<input type="email"  readonly name="email" value="{{ Auth::user()->email }}" class="form-control">
			</div>
      <div class="form-group">
        <label>Enter code here</label>
        <input type="text" name="token" class="form-control">
      </div>
			<input type="submit" name="chk" value="confirm" class="btn btn-primary">
		</form>
	</div>
</body>