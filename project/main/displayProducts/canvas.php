
<body>
    <div class="container-lg">
    <div class="row gy-3 gy-md-4">
        <div class="col-12">
          <ul class="nav-underline m-0">
            <div class="col navbar justify-content-center column-gap-5">
              <li class="nav-item">
                  <a onclick="canvasGallery()" class="nav-link"><h4>From Our Gallery</h4></a>
              </li>
              <li class="nav-item">
                  <a onclick="canvasPOV()" class="nav-link"><h4>From Her POV</h4></a>
              </li>
          </div>
          </ul>
        </div>
        
        <div class="col-12">
          <!-- Our Gallery Carousel -->
          <div id="ourGallery">
              <?php include 'canvasGallery.php';?>
          </div>
          <!-- Her POV Carousel Hidden by Default -->
          <div class="hidden" id="herPOV">
              <?php include 'canvasPOV.php';?>
          </div>
        </div>

        <div class="col-12">
          <div class="no-underline d-flex justify-content-end">
            <div class="hover-right">
              <a href="canvas.php"> View More 
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
              </a>
            </div>
          </div>
        </div>
    </div>
    </div>
    
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    function canvasGallery() {
      var gallery = document.getElementById("ourGallery").classList.remove("hidden");
      var pov = document.getElementById("herPOV").classList.add("hidden");
      swiper.update();
    }
    function canvasPOV() {
      var gallery = document.getElementById("ourGallery").classList.add("hidden");
      var pov = document.getElementById("herPOV").classList.remove("hidden");
      swiper.update();
    }

    var swiper = new Swiper(".mySwiper", {
      // Default parameters
      observer: true,
      observeParents: true,
      slidesPerView: 4,     
        spaceBetween: 8,  
        autoplay: {
          delay: 4000,
          stopOnLastSlide: true,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        scrollbar: {
          el: '.swiper-scrollbar',
          draggable: true,
        },
        breakpoints: {
            320: { slidesPerView: 2 }, // when window width is >= 320px
            640: { slidesPerView: 3 }, // when window width is >= 640px
            860: { slidesPerView: 4 }, // when window width is >= 860px
        }
      });
  </script>
</body>
