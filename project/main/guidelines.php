<?php 
    session_start();
    require_once '../connect.php';  
?>

<!--Login HTML-->
<?php include 'php/head.php';?>    
    <body>
        <?php include './php/nav.php';?>  
       
        <main>
            <!-- Guidelines Side -->
            <div class="container-lg">
               <div class="row g-3 g-md-4">
                    <!-- Side -->
                    <div class="col-12 col-lg-4 light-accent" style="min-height: 300px;">
                        <div class="p-4 sticky">
                            <div class="d-flex flex-column justify-content-between gap-2">
                                <div class="xs-line-height">
                                    <h1>Guidelines</h1>
                                    <h6>Everything you need to know.</h6>
                                    <!-- Accordion -->
                                    <div class="accordion" id="guidelinesAccordion">
                                        <div class="accordion-item">
                                            <h4 class="accordion-header">
                                                <button class="accordion-button ps-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFitPreferences" aria-expanded="true" aria-controls="collapseFitPreferences">
                                                    NAIL FIT & PREFERENCES 
                                                </button>
                                            </h4>
                                            <div id="collapseFitPreferences" class="accordion-collapse collapse show" data-bs-parent="#guidelinesAccordion">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li><a href="#sizing">Sizing</a></li>
                                                        <li><a href="#length">Length</a></li>
                                                        <li><a href="#shape">Shape</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h4 class="accordion-header">
                                                <button class="accordion-button ps-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePressOn" aria-expanded="false" aria-controls="collapsePressOn">
                                                    PRESS ON GUIDE
                                                </button>
                                            </h4>
                                            <div id="collapsePressOn" class="accordion-collapse collapse" data-bs-parent="#guidelinesAccordion">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li><a href="#application">Application</a></li>
                                                        <li><a href="#removal">Removal</a></li>
                                                        <li><a href="#aftercare">Aftercare</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h4 class="accordion-header">
                                                <button class="accordion-button ps-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseServices" aria-expanded="false" aria-controls="collapseServices">
                                                    SERVICES
                                                </button>
                                            </h4>
                                            <div id="collapseServices" class="accordion-collapse collapse" data-bs-parent="#guidelinesAccordion">
                                            <div class="accordion-body">
                                                     <ul>
                                                        <li><a href="#booking-services">Booking & Order Confirmation</a></li>
                                                        <li><a href="#custom-design">Custom Designs</a></li>
                                                        <li><a href="#payment-processing">Payment & Processing</a></li>
                                                        <li><a href="#hygiene">Hygiene & Quality Standards</a></li>
                                                        <li><a href="#cancellations-refunds">Cancellations & Refunds</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                          <div class="accordion-item">
                                            <h4 class="accordion-header">
                                                <button class="accordion-button ps-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBookings" aria-expanded="false" aria-controls="collapseBookings">
                                                    BOOKINGS
                                                </button>
                                            </h4>
                                            <div id="collapseBookings" class="accordion-collapse collapse" data-bs-parent="#guidelinesAccordion">
                                            <div class="accordion-body">
                                                    <ul>
                                                        <li><a href="#booking-process">Booking Process</a></li>
                                                        <li><a href="#cancellations-rescheduling">Cancellations & Rescheduling</a></li>
                                                        <li><a href="#deposits-payments">Deposits & Payments</a></li>
                                                        <li><a href="#late-arrivals">Late Arrivals & No-Shows</a></li>
                                                        <li><a href="#refund-policy">Refund Policy</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h4 class="accordion-header">
                                                <button class="accordion-button ps-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePromotionals" aria-expanded="false" aria-controls="collapsePromotionals">
                                                    PROMOTIONAL OFFERS
                                                </button>
                                            </h4>
                                            <div id="collapsePromotionals" class="accordion-collapse collapse" data-bs-parent="#guidelinesAccordion">
                                            <div class="accordion-body">
                                                    <ul>
                                                        <li><a href="#new-user">New User Discount</a></li>
                                                        <li><a href="#refer-a-bestie">Refer-a-Bestie Program</a></li>
                                                        <li><a href="#free-shipping">Free Shipping Threshold</a></li>
                                                        <li><a href="#limited-time">Limited-Time Drop Sale</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-8 d-flex flex-column gap-3">
                        <!-- Nail Fit & Preferences -->
                        <div class="d-flex flex-column gap-3" id="nail-fit">
                            <!-- #sizing -->
                            <div class="form-box small-gap w-100">
                                <div class="xs-line-height scroll-center" id="sizing">
                                    <h2>Size Guide</h2>
                                    <h6>Not sure of your nail sizes? Follow this easy guide to find the perfect fit.</h6>
                                </div>
                                <div>
                                    <h4>What You'll Need</h4>
                                    <ul>
                                        <li>A flexible measuring tape (in millimetres) or a small strip of paper and a ruler.</li>
                                        <li>A pen to mark your measurements.</li>
                                        <li>Good lighting.</li>
                                    </ul>
                                </div>
                                <div>
                                    <h4>Step-by-Step Guide</h4>
                                    <ol type="1">
                                        <li>Measure each nail across the widest part (usually the middle) in millimetres (mm).</li>
                                        <li>If using a paper strip, mark where each side of your nail ends, then measure the distance between marks with a ruler.</li>
                                        <li>Record the width for both hands — nails on each hand may differ slightly.</li>
                                        <li>Use the chart below to find your corresponding nail size number.</li>
                                        <li>If you're between sizes or your measurement doesn't match the chart, use a custom size for the best fit.</li>
                                    </ol>
                                </div>
                                <div>
                                    <h4>Nail Size Chart</h4>
                                    <table class="table table-hover table-responsive text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-dark">Size</th>
                                                <th scope="col" class="text-dark">Thumb</th>
                                                <th scope="col" class="text-dark">Index</th>
                                                <th scope="col" class="text-dark">Middle</th>
                                                <th scope="col" class="text-dark">Ring</th>
                                                <th scope="col" class="text-dark">Pinky</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold text-dark" scope="row"> XS </td>
                                                <td> 14 </td>
                                                <td> 10</td>
                                                <td> 11 </td>
                                                <td> 10 </td>
                                                <td> 8 </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-dark" scope="row"> S </td>
                                                <td> 15 </td>
                                                <td> 11</td>
                                                <td> 12 </td>
                                                <td> 11 </td>
                                                <td> 9 </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-dark" scope="row"> M </td>
                                                <td> 16 </td>
                                                <td> 12</td>
                                                <td> 13 </td>
                                                <td> 12 </td>
                                                <td> 10 </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-dark" scope="row"> L </td>
                                                <td> 17 </td>
                                                <td> 13</td>
                                                <td> 14 </td>
                                                <td> 13 </td>
                                                <td> 11 </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <h4>Pro Sizing Tips</h4>
                                    <ul>
                                        <li>Measure at least twice to ensure accuracy</li>
                                        <li>Measure flat across, not around the nail</li>
                                        <li>Avoid measuring right after removing nails (natural nails may be swollen)</li>
                                        <li>If unsure, size up — filing is easier than forcing a tight fit</li>
                                        <li>If your measurement falls between two sizes, choose larger size for comfort or select  
                                            <u><a href="#customSize">custom size</a></u> for perfection</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- #length -->
                            <div class="form-box small-gap w-100">
                                <div class="xs-line-height scroll-center" id="length">
                                    <h2>Length Guide</h2>
                                    <h6>Choosing the right nail length helps ensure comfort, durability, and the look you want.</h6>
                                </div>
                                <div class="guidelines-images">
                                    <div class="row gx-3 gy-5">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <h5>Ballerina Length</h5>
                                            <img src="../uploads/guidelines/ballerina-length.jpg" alt="ballerina-length">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <h5>Almond Length </h5>
                                            <img src="../uploads/guidelines/almond-length.jpg" alt="almond-length">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <h5>Square Length </h5>
                                            <img src="../uploads/guidelines/square-length.jpg" alt="square-length">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <h5>Round Length </h5>
                                            <img src="../uploads/guidelines/round-length.jpg" alt="round-length">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4>Short</h4>
                                    <ul>    
                                        <li>Natural and practical</li>
                                        <li>Ideal for everyday wear, work, or active lifestyles</li>
                                        <li>Comfortable and low-maintenance</li>
                                        <li>Great if you're new to press-on nails</li>                                    
                                    </ul>
                                </div>
                                <div>
                                    <h4>Medium</h4>
                                    <ul>    
                                        <li>Balanced and versatile</li>
                                        <li>Slightly longer for a polished, elegant look</li>
                                        <li>Comfortable for daily wear with added style</li>
                                        <li>A popular all-round choice</li>                                    
                                    </ul>
                                </div>
                                <div>
                                    <h4>Long</h4>
                                    <ul>    
                                        <li>Bold, glam, and eye-catching</li>
                                        <li>Perfect for special occasions or statement looks</li>
                                        <li>Best suited for experienced nail wearers</li>
                                        <li>Less practical for heavy typing or hands-on tasks</li>                                    
                                    </ul>
                                </div>
                                <div>
                                    <h4>X-Long</h4> 
                                    <ul>    
                                        <li>Ultra-dramatic, fierce, and show-stopping</li>
                                        <li>Perfect for photos, events, and full glam moments</li>
                                        <li>Designed to make a statement and turn heads</li>
                                        <li>Less practical for everyday tasks or active lifestyles</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- #shape -->
                            <div class="form-box small-gap w-100">
                                <div class="xs-line-height scroll-center" id="shape">
                                    <h2>Shape Guide</h2>
                                    <h6>Select Your Ideal Shape</h6>
                                </div>
                                <div>
                                    <div class="guidelines-images">
                                        <img src="../uploads/guidelines/nail-shape-comparison.jpg" alt="nail-shape-comparison">
                                    </div>
                                <p><strong>Round: </strong>
                                    Soft curved edges that follow the natural shape of your nail. Perfect for a clean, simple, everyday look.</p>

                                    <p><strong>Square: </strong>
                                    Straight edges with sharp corners. Bold, modern, and great for shorter lengths.</p>

                                    <p><strong>Squoval: </strong>
                                    A mix of square and oval. Flat tip with softened corners — flattering on all hand shapes.</p>

                                    <p><strong>Oval: </strong>
                                    Slim and softly rounded. Elegant, feminine, and elongates the fingers.</p>

                                    <p><strong>Almond: </strong>
                                    Tapered sides with a rounded tip. Chic, slimming, and perfect for a classy glam look.</p>

                                    <p><strong>Coffin: </strong>
                                    Long with tapered sides and a flat tip. Trendy, dramatic, and made to stand out.</p>

                                    <p><strong>Stiletto: </strong>
                                    Sharp, pointed tip. Fierce, bold, and ultra-glam.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Press On Guide -->
                        <div class="d-flex flex-column gap-3" id="press-on-guide">
                            <!-- #application -->
                            <div class="form-box small-gap w-100">
                                <div class="xs-line-height scroll-center" id="application">
                                    <h2>Application Guide</h2>
                                    <h6>Proper preparation ensures longer wear and a flawless finish.</h6>
                                </div>
                                <div>
                                    <h4>Step-by-Step Guide</h4>
                                    <ol type="1">
                                        <li>Begin with clean, dry hands. Remove any old polish and gently push back cuticles.</li>
                                        <li>Lightly buff the natural nail surface to remove shine — this helps the adhesive grip better.</li>
                                        <li>Clean each nail with alcohol or a nail prep wipe to remove oils and residue. <strong>Do not skip this step.</strong></li>
                                        <li>Select the correct press-on size for each finger. If between sizes, choose the smaller one and gently file the sides for a perfect fit.</li>
                                        <li>Apply a thin, even layer of nail glue to the natural nail (or adhesive tab if using tabs).</li>
                                        <li>Align the press-on slightly above the cuticle, then press down firmly at a 45° angle to prevent air bubbles. Hold for 20-30 seconds.</li>
                                    </ol>
                                    <p>Avoid water, hand creams, and heavy pressure for at least 1-2 hours after application for maximum hold.</p>
                                </div>
                            </div>
                            <!-- #removal -->
                            <div class="form-box small-gap w-100">
                                <div class="xs-line-height scroll-center" id="removal">
                                    <h2>Removal Guide</h2>
                                    <h6>Gentle removal protects your natural nails. Never force them off.</h6>
                                </div>
                                 <div>
                                    <h4>Step-by-Step Guide</h4>
                                    <ol type="1">
                                        <li>Soak nails in warm, soapy water for 10-15 minutes to loosen the adhesive.</li>
                                        <li>Gently wiggle the sides and use a wooden cuticle stick to lift from the edge.</li>
                                        <li>If resistance is felt, soak longer or apply a small amount of acetone around the edges.</li>
                                        <li>Once removed, gently buff off remaining glue — do not scrape aggressively.</li>
                                    </ol>
                                    <p>Taking your time during removal prevents nail thinning and damage.</p>
                                </div>
                            </div>
                            <!-- #aftercare -->
                            <div class="form-box small-gap w-100">
                                <div class="xs-line-height scroll-center" id="aftercare">
                                    <h2>Aftercare Guide</h2>
                                    <h6>Healthy natural nails = better future sets.</h6>
                                </div>
                                 <div>
                                    <h4>Step-by-Step Guide</h4>
                                    <ul>
                                        <li>Apply cuticle oil daily to keep nails and surrounding skin hydrated.</li>
                                        <li>Moisturise hands regularly, especially after washing.</li>
                                        <li>Avoid using your nails as tools to open cans or scratch surfaces.</li>
                                        <li>Store reusable press-ons in their original box to maintain shape and design.</li>
                                        <li>If using glue regularly, allow your natural nails a short rest period between sets when needed.</li>
                                    </ul>
                                    <p>With proper application and care, your press-ons can last 1-3 weeks and be reused multiple times.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="d-flex flex-column gap-3" id="service-guidelines">
                            <!-- #services -->
                            <div class="form-box small-gap w-100 d-flex flex-column gap-4">
                                <div class="xs-line-height scroll-center" id="services">
                                    <h2>Services Guidelines</h2>
                                </div>
                                <!-- #booking-services -->
                                <div id="booking-services">
                                    <h4>Booking & Order Confirmation</h4>
                                    <p>All orders must be confirmed before production begins. For custom sets, accurate sizing information 
                                        must be provided at the time of purchase. Please ensure measurements are correct, as we are not 
                                        responsible for incorrect sizes submitted. Once confirmed, you will receive an estimated 
                                        processing timeline.</p>
                                </div>
                                <!-- #custom-design -->
                                <div id="custom-design">
                                    <h4>Custom Designs</h4>
                                    <p>
                                        Custom press-on sets are handmade and created according to the details provided. Clear reference 
                                        images and accurate instructions help us achieve the best result. Minor variations may occur due 
                                        to the handcrafted nature of each set. Design changes may not be possible once production has started.
                                    </p>
                                </div>
                                <!-- #payment-processing -->
                                <div id="payment-processing">
                                    <h4>Payment & Processing</h4>
                                    <p>
                                        Full payment is required before production begins. Orders will not be processed without payment 
                                        confirmation. Processing times may vary depending on design complexity and order volume. Custom 
                                        sets are final sale unless an error has occurred on our part.
                                    </p>
                                </div>
                                <!-- #hygiene -->
                                <div id="hygiene">
                                    <h4>Hygiene & Quality Standards</h4>
                                    <p>
                                        All products are made using sanitised tools and professional-grade materials to ensure quality 
                                        and safety. For hygiene reasons, worn or used items cannot be returned or exchanged. We prioritise 
                                        cleanliness and craftsmanship in every set produced.
                                    </p>
                                </div>
                                <!-- #cancellations-refunds -->
                                <div id="cancellations-refunds">
                                    <h4>Cancellations & Refunds</h4>
                                    <p>
                                        Cancellations must be requested within 24 hours of placing an order. Once production has begun, 
                                        cancellations and refunds may not be possible. Any concerns must be reported within 48 hours of 
                                        receiving your order, with clear photo evidence where applicable.
                                    </p>
                                </div>
                            </div>
                        </div>

                         <!-- Booking -->
                        <div class="d-flex flex-column gap-3" id="booking-guidelines">
                            <!-- #booking -->
                            <div class="form-box small-gap w-100 d-flex flex-column gap-4">
                                <div class="xs-line-height scroll-center" id="booking">
                                    <h2>Booking Guidelines</h2>
                                </div>
                                <div id="booking-process">
                                    <h4>Booking Process</h4>
                                    <p>
                                        All bookings must be made in advance to secure your preferred date and time. A confirmation 
                                        message will be sent once your appointment has been successfully scheduled. Please ensure all 
                                        required details are provided accurately during booking to avoid delays or misunderstandings.
                                    </p>
                                </div>

                                <div id="cancellations-rescheduling">
                                    <h4>Cancellations & Rescheduling</h4>
                                    <p>
                                        Cancellations or rescheduling requests must be made at least 24 hours before the scheduled 
                                        appointment time. Requests made within less than 24 hours may result in forfeiture of the 
                                        booking deposit. Rescheduling is subject to availability.
                                    </p>
                                </div>

                                <div id="deposits-payments">
                                    <h4>Deposits & Payments</h4>
                                    <p>
                                        A non-refundable deposit of £20 is required to secure your appointment. The remaining balance 
                                        must be paid on the day of the service unless otherwise agreed. Appointments are not confirmed 
                                        until the deposit has been received.
                                    </p>
                                </div>

                                <div id="late-arrivals">
                                    <h4>Late Arrivals & No-Shows</h4>
                                    <p>
                                        Clients arriving more than 15 minutes late may have their appointment shortened or cancelled 
                                        depending on schedule availability. Failure to attend an appointment without notice will be 
                                        considered a no-show, and the deposit will be forfeited.
                                    </p>
                                </div>

                                <div id="refund-policy">
                                    <h4>Refund Policy</h4>
                                    <p>
                                        Due to the nature of nail services, refunds are not provided once the service has been completed. 
                                        If there are concerns regarding the service provided, please notify us within 24 hours so that 
                                        we may assess and offer a reasonable solution where appropriate.
                                    </p>
                                </div>

                            </div>
                        </div>

                         <!-- Promotional -->
                        <div class="d-flex flex-column gap-3" id="promotional-guidelines">
                            <!-- #promotional -->
                            <div class="form-box small-gap w-100 d-flex flex-column gap-4">
                                <div class="xs-line-height scroll-center">
                                    <h2>Promotional Guidelines</h2>
                                </div>
                                <div id="new-user">
                                    <h4>New User Discount</h4>
                                    <p>
                                        The New User Discount is available to first-time customers only and can be redeemed using 
                                        the voucher code <strong>NEWUSER2026</strong>. This offer may be used once per registered 
                                        account and cannot be transferred, reused, or exchanged for cash.
                                    </p>
                                    <br>
                                    <p>
                                        The discount must be applied at checkout before payment is completed and cannot be added 
                                        after an order has been placed. Nail Utopia reserves the right to cancel orders that misuse 
                                        this promotion, including duplicate or fraudulent accounts created to access the offer 
                                        multiple times.
                                    </p>
                                </div>

                                <div id="refer-a-bestie">
                                    <h4>Refer-A-Bestie Program</h4>
                                    <p>
                                        Existing customers may refer a friend to Nail Utopia and <strong>both will receive 10% off their next 
                                        nail appointment</strong> once the referred friend successfully completes a qualifying booking. 
                                        The referral reward is valid for one-time use per person.
                                    </p>
                                    <br>
                                    <p>
                                        The referred client must be a new customer and must not have previously booked or received 
                                        services with Nail Utopia. Referral discounts cannot be combined with other promotional offers 
                                        unless stated otherwise.
                                    </p>
                                </div>

                                <div id="free-shipping">
                                    <h4>Free Shipping Threshold</h4>
                                    <p>
                                        <strong>Free standard UK shipping is available on orders over £60.</strong> The minimum spend requirement 
                                        must be met after all discounts and promotional codes have been applied.
                                    </p>
                                    <p>
                                        This promotion applies to standard delivery only and does not include express or special 
                                        shipping options. Nail Utopia reserves the right to adjust the minimum spend threshold or 
                                        withdraw this offer at any time without prior notice.
                                    </p>
                                </div>

                                <div id="limited-time">
                                    <h4>Limited-Time Drop Sale</h4>
                                    <p>
                                        Limited-Time Drop Sales are promotional discounts available for a specific period only. 
                                        These offers are valid within the stated dates and cannot be extended once expired. 
                                        Discounts must be applied during the promotional period.
                                    </p>
                                    <br>
                                    <p>
                                        Products included in limited-time promotions are subject to availability. Once sold out, 
                                        items may not be restocked at the promotional price.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </main>

        <?php include './php/footer.php';?> 
        <?php include './php/script.php';?>
    </body>
</html> 
