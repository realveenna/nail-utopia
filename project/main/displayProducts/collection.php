<?php
    // Image Path
    $image_path = "/nail_utopia_new/project/uploads/products/";

    // Arrays for displaying tags and images
    $tagsDisplay = array(
        array("Cute",         $image_path . "Starlight_Ribbons2.webp"),
        array("Chrome",       $image_path . "Silver_Starry_Night_1.webp"),
        array("Cateye",       $image_path . "Emerald_Cosmos1.webp"),
        array("Flower",       $image_path . "amber_wild2.webp"),
        array("Pearl Aura",   $image_path . "Sage_Glow1.webp"),
        array("Artistic",     $image_path . "Red_Pop_Galaxy1.webp"),
        array("French Tip",   $image_path . "Pearl_Whisper1.webp"),
        array("Seasonal",     $image_path . "Cherry_Romance_1.webp"),
        array("3D",           $image_path . "Blue Chrome2.webp"),
        array("Aerochrome",   $image_path . "Crimson_Voltage_1.webp")
    );

    $tagCount = count($tagsDisplay);

    echo '<div class="container-lg" id="ListCollection">';
        // Return the number of rows in result set
        echo'<div class="swiper mySwiperCollection">
                <div class="swiper-wrapper" id="collection">';
                for ($row = 0; $row < $tagCount ; $row++) {
                        $tagName = $tagsDisplay[$row][0];
                        $tagImage = $tagsDisplay[$row][1];
                        echo '
                        <div class="swiper-slide">
                            <div class="card-carousel no-underline">
                                <a href="../main/shop.php?selectTag=' . $tagName.'#shopProducts">
                                    <div class="round">
                                        <img src="' . $tagImage .'" alt="' . $tagName . '" loading="lazy"/>
                                        <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                                        <h5 class="pt-3"> '.$tagName.' </h5>
                                    </div>
                                </a>
                            </div>
                        </div>';
                }
            echo'</div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            
            </div>'; // Close swiper-wrapper and swiper
    echo'</div>'; // Close container-lg
?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper1 = new Swiper(".mySwiperCollection", {
            loop: true,
            spaceBetween: 8,
            scrollbar: {
                el: ".mySwiperCollection .swiper-scrollbar",
                draggable: true,
            },
             navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
              breakpoints: {
                320: { slidesPerView: 3 }, // when window width is >= 320px
                640: { slidesPerView: 4 }, // when window width is >= 640px
                860: { slidesPerView: 5 }, // when window width is >= 860px
                1100: { slidesPerView: 7 } // when window width is >= 1100px
            }
        });
    });
</script>




