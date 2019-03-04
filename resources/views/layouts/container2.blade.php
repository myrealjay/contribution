
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Esusu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="Esusu, Contribution" />
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- Custom Theme files -->
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="all">
    <!-- font-awesome icons -->
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
	<!-- //Custom Theme files -->
    <!-- online-fonts -->
    <link href="//fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
    <!-- //online-fonts -->
</head>

<body>
    <!-- banner -->
    <div class="banner">
        <!-- header -->
        <header>	
        <nav class="mnu navbar-light">
                <div class="logo" id="logo">
                    <h1><a href="index.html">Esusu</a></h1>
                </div>
                    <label for="drop" class="toggle"><span class="fa fa-bars"></span></label>
                    <input type="checkbox" id="drop">
                        <ul class="menu">
                            <li class="mr-lg-4 mr-3"><a href="{{url ('/')}}">Home</a></li>
                            <li class="mr-lg-4 mr-3"><a href="{{url ('/about')}}">About</a></li>
                            <li class="mr-lg-4 mr-3"><a href="{{ route('login') }}">Log in</a></li>
                            <li class="mr-lg-4 mr-3"><a href="{{ route('register') }}">Register</a></li>
                        </ul>
        </nav>
        </header>
    </div>
<!-- //header -->

@yield('content')

<!--footer-->
<footer>
		<div class="container py-md-4 mt-md-3">
			<div class="row footer-top-w3layouts-agile py-5">
				<div class="col-md-4 footer-grid">
					<div class="footer-title">
						<h3>About Us</h3>
					</div>
					<div class="footer-text">
						<p>Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. lacinia eget consectetur sed, convallis at tellus.tempus convallis quis ac lectus sit amet nisl tempus convallis quis ac lectus</p>
					</div>
				</div>
				<div class="col-md-4 footer-grid">
					<div class="footer-title">
						<h3>Contact Us</h3>
					</div>
					<div class="contact-info">
					<h4>Location :</h4>
					<p>30 Lanre Awolokun street, Gbagada Express way, Lagos.</p>
					<div class="phone">
						<h4>Phone :</h4>
						<p>Phone : +121 098 8907 9987</p>
						<p>Email : <a href="mailto:info@okbcoy.com">info@okbcoy.com</a></p>
					</div>
				</div>
				</div>
				<div class="col-md-4 footer-grid">
					<div class="footer-title">
						<h3>Recent Posts</h3>
					</div>
					<div class="footer-list">
						<div class="flickr-grid">
							<a href="services.html">
								<img src="images/g1.jpg" class="img-fluid" alt=" ">
							</a>
						</div>
						<div class="flickr-grid">
							<a href="services.html">
								<img src="images/g2.jpg" class="img-fluid" alt=" ">
							</a>
						</div>
						<div class="flickr-grid">
							<a href="services.html">
								<img src="images/g3.jpg" class="img-fluid" alt=" ">
							</a>
						</div>
						<div class="flickr-grid">
							<a href="services.html">
								<img src="images/g4.jpg" class="img-fluid" alt=" ">
							</a>
						</div>
						<div class="flickr-grid">
							<a href="services.html">
								<img src="images/g5.jpg" class="img-fluid" alt=" ">
							</a>
						</div>
						<div class="flickr-grid">
							<a href="services.html">
								<img src="images/g6.jpg" class="img-fluid" alt=" ">
							</a>
						</div>
						<div class="flickr-grid">
							<a href="services.html">
								<img src="images/g7.jpg" class="img-fluid" alt=" ">
							</a>
						</div>
						<div class="flickr-grid">
							<a href="services.html">
								<img src="images/g9.jpg" class="img-fluid" alt=" ">
							</a>
						</div>
						<div class="flickr-grid">
							<a href="services.html">
								<img src="images/g8.jpg" class="img-fluid" alt=" ">
							</a>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				
			</div>
		</div>
	</footer>
	<!---->
	<div class="copyright py-3">
		<div class="container">
			<div class="copyrighttop">
				<ul>
					<li>
						<h4>Follow us on:</h4>
					</li>
					<li>
						<a href="#">
							<span class="fa fa-facebook"></span>
						</a>
					</li>
					<li>
						<a href="#">
							<span class="fa fa-twitter"></span>
						</a>
					</li>
					<li>
						<a href="#">
							<span class="fa fa-google-plus"></span>
						</a>
					</li>
					<li>
						<a href="#">
							<span class="fa fa-pinterest"></span>
						</a>
					</li>
				</ul>
			</div>
			<div class="copyrightbottom">
				<p>© 20{{date('y')}} Esusus. All Rights Reserved | Powered by
					<a href="http://okbestate.com.ng">OKB and Associates</a>
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<!-- //footer -->

</body>
</html>