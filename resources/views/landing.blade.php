@extends ('layouts.container')
@section('content')

        <div class="container">
            <!-- banner-text -->
            <div class="banner-text">
                <div class="slider-info">
                    <h3>Start enjoying Esusu contributions today</h3>
                </div>
            </div>
			<div class="banner-top pb-5">
                <div class="row slider-bottom">
                    <div class="col-md-3 slider-bottom-lft">
						<h4>Log In</h4>
						<p class="text-white mt-2">Enter your Esusu space</p>
					</div>
					 <div class="col-md-9 n-right-w3ls">
						<div class="row">
							<div class="col-md-4 form-group news-rt">
								<input class="form-control" type="text" name="Name" placeholder="Name" required="">
							</div>
							<div class="col-md-4 form-group news-lt">
								<input class="form-control" type="email" name="Email" placeholder=" Email Address" required="">
							</div>
							<div class="col-md-4 form-group news-last">
								<div class="sbm-it">
									<div class="form-group">
										<input class="form-control submit text-uppercase" type="submit" value="Log in">
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <h5>Not yet a member?<a href="{{ route('register') }}"> register Now</a></h5>
				</div>
            </div>
        </div>
    </div>
	 <!-- //banner-text -->
	<section class="about-w3ls py-5">
		<div class="container pt-xl-5 pb-lg-3">
			<div class="row">
				<div class="col-lg-7">
					<img src="images/2.jpg" alt="" class="img-section4 img-fluid">
				</div>
				<div class="col-lg-5 section-4">
					<div class="agil_mor">
						<h2 class="heading-agileinfo">What <span> We Do</span></h2>
						<p class="vam">Vivamus sed porttitor felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.Sed lorem enim, </p>
						<a href="{{url ('/about')}}" class="mt-3">Read More</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="about-w3ls py-5">
		<div class="container pt-xl-5 pb-lg-3">
			<div class="row">
				<div class="col-lg-5 section-5">
					<div class="agil_mor">
						<h3 class="heading-agileinfo">We <span> Offer</span></h3>
						<p class="vam">Vivamus sed porttitor felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.Sed lorem enim, </p>
						<a href="{{url ('/about')}}" class="mt-3">Read More</a>
					</div>
				</div>
				<div class="col-lg-7">
					<img src="images/1.jpg" alt="" class="img-section4 img-fluid">
				</div>
				
			</div>
		</div>
	</section>
 <!-- stats -->
    <section class="agile_stats py-sm-5">
        <div class="container">
            <div class="py-lg-5 w3-abbottom">
                <div class="row py-5">
                    <div class="counter col-lg-3 col-6">
                        <span class="fa fa-smile-o"></span>
                        <h4 class="timer mt-2">5,100</h4>
                        <p class="count-text text-capitalize">HAPPY STUDENTS</p>
                    </div>

                    <div class="counter col-lg-3 col-6">
                        <span class="fa fa-fighter-jet"></span>
                         <h4 class="timer mt-2">971</h4>
                        <p class="count-text text-capitalize">BRANCHES</p>
                    </div>
                    <div class="counter col-lg-3 col-6 mt-lg-0 mt-4">
                        <span class="fa fa-users"></span>
                        <h4 class="timer mt-2">21</h4>
                        <p class="count-text text-capitalize">TEACHERS</p>
                    </div>
                    <div class="counter col-lg-3 col-6 mt-lg-0 mt-4">
                       <span class="fa fa-comments"></span>
                         <h4 class="timer mt-2">27</h4>
                        <p class="count-text text-capitalize">QUESTIONS ANSWERED </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //stats -->
	 <!-- services -->
    <div class="more-services py-lg-5">
		<div class="container py-5">
            <div class="title-section pb-sm-5 pb-3">
               <h3 class="heading-agileinfo text-center pb-4">Best <span> Offers</span></h3>
            </div>
            <div class="row grid">
                <div class="col-lg-3 col-6 more-services-1">
                    <figure class="effect-1 left-round-out">
                        <img src="images/p1.jpg" alt="img" class="img-fluid left-round" />
                        <h4>Porttitor Felis</h4>
                        <p> Pellentesque habitant morbi tristique senectus et netus et malesuada fames.</p>
					</figure>
				 </div>
                <div class="col-lg-3 col-6 more-services-1">
                    <figure class="effect-1 right-round-out">
                        <img src="images/p2.jpg" alt="img" class="img-fluid right-round" />
                       <h4>Porttitor Felis</h4>
                        <p> Pellentesque habitant morbi tristique senectus et netus et malesuada fames.</p>
					</figure>
                </div>

                <div class="col-lg-3 col-6 more-services-1">
                    <figure class="effect-1 left-round-out">
                        <img src="images/p3.jpg" alt="img" class="img-fluid left-round" />
                       <h4>Porttitor Felis</h4>
                      <p> Pellentesque habitant morbi tristique senectus et netus et malesuada fames.</p>
					</figure>
                </div>
                <div class="col-lg-3 col-6 more-services-1">
                    <figure class="effect-1 right-round-out">
                        <img src="images/p4.jpg" alt="img" class="img-fluid right-round" />
                        <h4>Porttitor Felis</h4>
						<p> Pellentesque habitant morbi tristique senectus et netus et malesuada fames.</p>
					</figure>
                </div>
            </div>
			
        </div>
    </div>
    <!-- //services -->
	<!-- testimonials -->
	<div class="testimonials py-lg-5">
		<div class="container py-5">
			 <div class="title-section pb-sm-5 pb-3">
               <h3 class="heading-agileinfo text-center pb-4">What Our <span> People Say</span></h3>
            </div>
			<div class="mis-stage">
				<!-- The element to select and apply miSlider to - the class is optional -->
				<div class="row mis-slider">
					<!-- The slider element - the class is optional -->
					<div class="col-lg-3 col-6 mis-slide mb-6">
						<img src="images/te3.jpg" alt=" " class="img-fluid rounder" />
						<h6>Nwanchukwu James</h6>
					</div>
					<div class="col-lg-3 col-6 mis-slide mb-6">
						<img src="images/te4.jpg" alt=" " class="img-fluid rounder" />
						<h6>Odole Kayode</h6>
					</div>
					<div class="col-lg-3 col-6 mis-slide mb-6">
						<img src="images/te5.jpg" alt=" " class="img-fluid rounder" />
						<h6>Dapo Ogunlana</h6>
					</div>
					<div class="col-lg-3 col-6 mis-slide mb-6">
						<img src="images/te6.jpg" alt=" " class="img-fluid rounder" />
						<h6>Yakubu Damilola</h6>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- //testimonials -->
<!-- video and events -->
	<div class="video-choose-agile py-lg-5">
		<div class="container py-5">
			<div class="title-section pb-sm-5 pb-3">
				<h3 class="heading-agileinfo text-center pb-4">Latest  <span>News</span></h3>
			</div>
			<div class="row">
				<div class="col-lg-5 events">
					<div class="events-w3ls">
						<div class="d-flex">
							<div class="col-sm-2 col-3 events-up p-2 text-center">
								<h5 class="font-weight-bold">18
									<span class="border-top font-weight-light pt-2 mt-2">Feb</span>
								</h5>
							</div>
							<div class="col-sm-10 col-9 events-right">
								<h4 class="Cur">Curabitur mattis orci </h4>
								<ul class="list-unstyled">
									<li class="my-2">
										<span class="fa fa-clock-o mr-2"></span>5.00 pm - 7.30 pm</li>
									<li>
										<span class="fa fa-map-marker mr-2"></span>25 Newyork City.</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="d-flex my-4">
						<div class="col-sm-2 col-3 events-up p-2 text-center">
							<h5 class="font-weight-bold">22
								<span class="border-top font-weight-light pt-2 mt-2">Feb</span>
							</h5>
						</div>
						<div class="col-sm-10 col-9 events-right">
							<h4 class="Cur">Curabitur mattis orci </h4>
							<ul class="list-unstyled">
								<li class="my-2">
									<span class="fa fa-clock-o mr-2"></span>5.00 pm - 7.30 pm</li>
								<li>
									<span class="fa fa-map-marker mr-2"></span>25 Newyork City.</li>
							</ul>
						</div>
					</div>
					<div class="d-flex">
						<div class="col-sm-2 col-3 events-up p-2 text-center">
							<h5 class="font-weight-bold">25
								<span class="border-top font-weight-light pt-2 mt-2">Feb</span>
							</h5>
						</div>
						<div class="col-sm-10 col-9 events-right">
							<h4 class="Cur">Curabitur mattis orci </h4>
							<ul class="list-unstyled">
								<li class="my-2">
									<span class="fa fa-clock-o mr-2"></span>5.00 pm - 7.30 pm</li>
								<li>
									<span class="fa fa-map-marker mr-2"></span>25 Newyork City.</li>
							</ul>
						</div>
					</div>
					<div class="d-flex mt-4">
						<div class="col-sm-2 col-3 events-up p-2 text-center">
							<h5 class="font-weight-bold">28
								<span class="border-top font-weight-light pt-2 mt-2">Feb</span>
							</h5>
						</div>
						<div class="col-sm-10 col-9 events-right">
							<h4 class="Cur">Curabitur mattis orci </h4>
							<ul class="list-unstyled">
								<li class="my-2">
									<span class="fa fa-clock-o mr-2"></span>5.00 pm - 7.30 pm</li>
								<li>
									<span class="fa fa-map-marker mr-2"></span>25 Newyork City.</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-7 video">
					<img src="images/g1.jpg" class="img-fluid" alt="" />
				</div>
			</div>
		</div>
	</div>
	<!-- //video and events -->
@endsection