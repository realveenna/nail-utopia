<!-- Collection Section -->
<section class="secondary">
    <div class="container-lg py-3 py-md-5">
        <div class="row gy-3 gy-md-4">
            <div class="col-12">
                <div class="text-center">
                    <h2>Shop by Collection</h2> 
                    <h6>This is a subheading</h6>
                </div>
            </div>

            <div class="col-12">
                <!-- List Shop by Collection -->
                <?php include './displayProducts/collection.php';?>
            </div>

            <div class="col-12" id="buttonCollection">
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