<?php 
    session_start();
    include '../connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include './php/head.php';?>    
<body>
    <?php include './php/nav.php';?>
   <main>
        <!-- Index Banner -->
        <section class="banner" id="main-banner">
            <div class="row container-lg gy-3">
                <div class="text-color light xs-line-height">
                    <h6> Designed for your everyday glow</h6>
                    <h1> Elevate Your Everyday Look!</h1>
                    <h3> Find your perfect sets!</h3>
                </div>
                <div class="gap-2 d-flex">
                    <a href="shop.php" class="btn btn-primary w-auto">Shop Now</a>
                    <a href="index.php#servicesSection" class="btn btn-light w-auto">View Services</a>
                </div>
            </div>
            <!-- Marquee  -->
            <div class="marquee-line-wrapper">
                <div class="marquee-line">
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                    <span> •   Create your account today for 15% off your next purchase!  </span>
                </div>
            </div>
        </section>

        <!-- Featured Section -->
        <section>
            <div class="container-lg py-3 py-md-5">
                <div class="row gy-3 gy-md-4 m-0">
                    <div class="col-12">
                        <div class="text-center">
                            <h2>Featured Design</h2> 
                            <h6>This is a subheading</h6>
                        </div>
                    </div>
                    <div class="col-12">
                         <!-- List Featured Products -->
                        <?php include './displayProducts/featured.php';?>
                    </div>
                    <div class="col-12">
                        <div class="no-underline d-flex justify-content-end">
                            <div class="hover-right">
                            <a href="shop.php"> View More 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                </svg>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>    

        <!-- Shop By Collection -->
        <?php include './section/collection.php';?>
        

        <!-- The Canvas -->
        <section class="light">
            <div class="container-lg py-3 py-md-5">
                <div class="text-center">
                    <h2>The Canvas</h2>
                </div>
                <!-- Display Canvas -->   
                <?php include './displayProducts/canvas.php';?>
            </div>
        </section>

         <!-- Our Services -->
        <?php include './section/services.php';?>

        <?php include './section/whyChooseUs.php';?>

        <!-- What Our Client Says -->
        <section class="secondary">
            <div class="container-lg py-3 py-md-5 d-flex justify-content-center">
                <div class="row gy-3 gy-md-4">
                    <div class="col-12">
                        <div class="text-center">
                            <h2>What Our Client Says </h2> 
                            <h6>This is a subheading</h6>
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- Client Reviews -->
                        <?php include './section/reviews.php';?>
                    </div>
                     <div class="col-12">
                        <div class="no-underline d-flex justify-content-end">
                            <div class="hover-right">
                                <a href="review.php"> Make a Review 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Schedule a Visit -->
        <section class="light">
            <div class="container-lg py-3 py-md-5 d-flex justify-content-center">
                <div class="row align-items-stretch gy-3 gy-md-4">
                    <div class="col-md-7">
                        <div class="form-box h-100 d-flex justify-content-center flex-column align-items-center gap-3">
                            <div class="text-center">
                                <h6 class="text-main">Your perfect nail day starts here.</h6>
                                <h1>Schedule Your Visit</h1>
                                <h4 class="text-main">Because You Deserve It</h4>
                            </div>
                            <a href="https://www.instagram.com/nailxutopia/" class="btn btn-primary"> Book Now </a>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <img class="img-fluid object-fit-cover h-100 w-100"
                            src="https://images.unsplash.com/photo-1667242196587-33f541537cc6?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                            alt="a-group-of-different-colored-nail-polish">
                    </div>
                </div>
            </div>
        </section>
                
   </main>
   <!-- Additional script for carousel -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>
</body>
</html>

