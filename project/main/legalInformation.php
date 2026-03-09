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
        <!-- Privacy Policy Section -->
        <section>
            <div class="container-lg">
                <div class="row g-3 g-md-4">
                    <!-- Side -->
                    <div class="col-12 col-lg-4 light-accent" style="min-height: 300px;">
                        <div class="p-4 sticky">
                            <div class="d-flex flex-column justify-content-between gap-2">
                                <div class="xs-line-height">
                                    <h1>Legal Information</h1>
                                    <h6>Privacy policy, terms, and website guidelines.</h6>
                                    <!-- Accordion -->
                                    <div class="accordion" id="legalAccordion">
                                        <!-- Privacy -->
                                        <div class="accordion-item">
                                            <div class="accordion-item">
                                                <h4 class="accordion-header">
                                                <button class="accordion-button ps-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrivacy" aria-expanded="true" aria-controls="collapsePrivacy">
                                                    PRIVACY & POLICY
                                                </button>
                                                </h4>
                                                <div id="collapsePrivacy" class="accordion-collapse collapse show" data-bs-parent="#legalAccordion">
                                                    <div class="accordion-body">
                                                        <ul>
                                                            <li><a href="#cookie-policy">Cookie Policy</a></li>
                                                            <li><a href="#information-collected">Information We Collect</a></li>
                                                            <li><a href="#how-we-use">How We Use Your Information</a></li>
                                                            <li><a href="#data-protection">Data Protection</a></li>
                                                            <li><a href="#third-parties">Third-Party Services</a></li>
                                                            <li><a href="#your-rights">Your Rights</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Terms -->
                                         <div class="accordion-item">
                                            <div class="accordion-item">
                                                <h4 class="accordion-header">
                                                <button class="accordion-button ps-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTerms" aria-expanded="true" aria-controls="collapseTerms">
                                                    TERMS & CONDITONS
                                                </button>
                                                </h4>
                                                <div id="collapseTerms" class="accordion-collapse collapse" data-bs-parent="#legalAccordion">
                                                    <div class="accordion-body">
                                                        <ul>
                                                            <li><a href="#terms-introduction">Introduction</a></li>
                                                            <li><a href="#terms-disclaimer">Academic Disclaimer</a></li>
                                                            <li><a href="#terms-account">User Accounts</a></li>
                                                            <li><a href="#terms-product">Products & Services</a></li>
                                                            <li><a href="#terms-order">Orders & Payments</a></li>
                                                            <li><a href="#terms-email">Email Functionality</a></li>
                                                            <li><a href="#terms-intellectual">Intellectual Property</a></li>
                                                            <li><a href="#terms-use">Website Use</a></li>
                                                            <li><a href="#terms-limitation">Limitation of Liability</a></li>
                                                            <li><a href="#terms-privacy">Privacy</a></li>
                                                            <li><a href="#terms-change">Changes to Terms</a></li>
                                                            <li><a href="#terms-contact">Contact</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 d-flex flex-column gap-3">
                        <!-- Privacy Policy -->
                        <div class="d-flex flex-column gap-3" id="privacy-policy">
                            <!-- #privacy-policy -->
                            <div class="form-box small-gap w-100 d-flex flex-column gap-4">
                                <div >
                                    <h1 class="xs-line-height">Privacy & Policy</h1>
                                    <p> Nail Utopia is committed to protecting your personal information and respecting your privacy. 
                                        This policy explains how we collect, use, and safeguard your data when you visit our website 
                                        or make a purchase.</p>
                                </div>
                                <div>
                                    <strong>Important Notice:</strong>
                                    <p>Nail Utopia is a demonstration website developed for <strong>academic purposes only</strong> as part of a university project. The website is not intended for real commercial transactions, and any data entered is used solely for testing and demonstration. </p>
                                </div>

                                <div id="cookie-policy">
                                    <h4>Cookie Policy</h4>
                                    <p>Nail Utopia uses essential cookies to ensure the proper functioning of the website. 
                                        These cookies are required for core features such as:
                                    </p>
                                    <ul>
                                        <li>secure login sessions</li>
                                        <li>shopping cart management</li>
                                        <li>checkout functionality</li>
                                    </ul>
                                    <p>
                                        These cookies are necessary for the system to operate correctly and do not track users 
                                        for advertising or marketing purposes.
                                    </p>
                                    <br>
                                    <p>
                                        By continuing to use the website, you acknowledge the use of these essential cookies 
                                        required for system functionality.
                                    </p>
                                </div>

                                <div id="information-collected">
                                    <h4>Information We Collect</h4>
                                    <p>
                                        We may collect personal information such as:
                                    </p>
                                    <ul>
                                        <li>name</li>
                                        <li>email address</li>
                                        <li>birthday</li>
                                        <li>billing or shipping address</li>
                                        <li>order details</li>
                                        <li>nail sizes, shape, and length</li>
                                    </ul>
                                    <p>
                                        This information is used only within the demonstration environment of the project 
                                        and is not intended for real purchases or commercial processing.
                                    </p>
                                </div>

                                <div id="how-we-use">
                                    <h4>How We Use Your Information</h4>
                                    <p>
                                        Information entered into the system may be used to demonstrate website features including:
                                    </p>
                                    <ul>
                                        <li>order processing simulation</li>
                                        <li>account management</li>
                                        <li>customer interaction features</li>
                                        <li>testing system functionality</li>
                                        <li>testing email notification features within a sandbox environment</li>
                                    </ul>
                                    <p>
                                        The information is used solely for academic demonstration and system testing purposes.
                                        Email functionality within this project is tested using a development or sandbox environment
                                        and does not represent a live commercial email service.
                                    </p>
                                </div>

                                <div id="data-protection">
                                    <h4>Data Protection</h4>
                                    <p>
                                    Reasonable security measures have been implemented within the system to protect stored 
                                    data from unauthorised access. However, as this website is a student project environment, 
                                    users should avoid entering sensitive or real personal information.
                                    </p>
                                </div>

                                <div id="third-parties">
                                    <h4>Third-Party Services</h4>
                                    <p>
                                        We may use trusted third-party providers for payment processing, delivery services, 
                                        or website analytics. These providers only receive the information necessary to 
                                        perform their services and are required to protect your data.
                                    </p>
                                </div>

                                <div id="your-rights">
                                    <h4>Your Rights</h4>
                                    <p>
                                        Under UK data protection principles, individuals generally have the right to access, 
                                        correct, or request deletion of their personal data. Since this website is a 
                                        demonstration system, any test data can be removed upon request.
                                    </p>
                                </div>
                            </div>
                        </div>

                         <!-- Tems and Conditions -->
                        <div class="d-flex flex-column gap-3" id="terms-condition">
                            <!-- #terms-condition -->
                            <div class="form-box small-gap w-100 d-flex flex-column gap-4">
                                <div >
                                    <h1 class="xs-line-height">Terms & Conditions</h1>
                                    <p><strong>Last Updated:</strong> March 2026</p>
                                </div>

                                <div id="terms-introduction">
                                    <h4>1. Introduction</h4>
                                    <p>Welcome to Nail Utopia. These Terms and Conditions govern your use of the Nail Utopia 
                                        website and its services. By accessing or using this website, you agree to 
                                        comply with and be bound by these Terms and Conditions.
                                    </p>
                                    <br>
                                    <p>If you do not agree with any part of these terms, you should not use this website.</p>
                                </div>

                                <div id="terms-disclaimer">
                                    <h4>2. Academic Demonstration Disclaimer</h4>
                                    <p>
                                        Nail Utopia is a website developed as part of an academic coursework 
                                        project. The platform is intended for educational and demonstration 
                                        purposes only.
                                    </p>
                                    <br>
                                    <p>
                                        This website does not represent a live commercial business. Any products, 
                                        orders, accounts, or transactions displayed on the website are part of a 
                                        simulated system used to demonstrate the functionality of an 
                                        e-commerce platform.
                                    </p>    
                                    <br>
                                    <p>
                                        No real financial transactions are processed through this website.
                                    </p>
                                </div>

                                <div id="terms-account">
                                    <h4>3. User Accounts</h4>
                                    <p>
                                        Users may create accounts on the website to demonstrate system 
                                        functionality such as order management and address storage.
                                    </p>
                                    <p>
                                        By creating an account, users agree to:
                                    </p>
                                    <ul>
                                        <li>provide accurate information for testing purposes</li>
                                        <li>maintain the confidentiality of their login credentials</li>
                                        <li>use the system only for demonstration or testing purposes</li>
                                    </ul>
                                    <p>
                                        The website administrator reserves the right to remove or modify test 
                                        accounts if necessary for system maintenance.
                                    </p>
                                </div>

                                <div id="terms-product">
                                    <h4>4. Products and Services</h4>
                                    <p>
                                        Nail Utopia displays press-on nail products and related items as 
                                        part of the academic demonstration of an online store.
                                        Product descriptions, images, and prices displayed on the website are used 
                                        solely to simulate an e-commerce environment. Availability, pricing, and product 
                                        details may be changed at any time for testing purposes.
                                    </p>
                                </div>

                                <div id="terms-order">
                                    <h4>5. Orders and Payments</h4>
                                    <p>
                                        Orders placed through the website are simulated transactions used to 
                                        demonstrate the order processing functionality of the system.
                                        No real payment processing occurs and no financial transactions are 
                                        completed through the website.
                                        Users <strong>should not enter real financial or sensitive payment</strong> information into the system.
                                    </p>
                                </div>

                                 <div id="terms-email">
                                    <h4>6. Email Functionality</h4>
                                   <p>
                                        The website may include features that simulate email notifications such as order confirmations, 
                                        newsletters, or system alerts.For this academic project, email functionality is tested using development 
                                        or sandbox environments and is intended solely to demonstrate how automated emails may work within an 
                                        e-commerce system. These emails do not represent real commercial communications.
                                   </p>
                                </div>

                                 <div id="terms-email">
                                    <h4>6. Email Functionality</h4>
                                   <p>
                                        The website may include features that simulate email notifications such as order confirmations, 
                                        newsletters, or system alerts.For this academic project, email functionality is tested using development 
                                        or sandbox environments and is intended solely to demonstrate how automated emails may work within an 
                                        e-commerce system. These emails do not represent real commercial communications.
                                   </p>
                                </div>

                                 <div id="terms-intellectual">
                                    <h4>7. Intellectual Property</h4>
                                   <p>
                                        All website content including text, layout, graphics, and design elements form 
                                        part of the Nail Utopia academic project unless otherwise stated.
                                   </p>
                                   <br>
                                   <p>
                                        Some product images used on the website may belong to third-party brands or 
                                        suppliers, including Mimiyaga, and are used solely for demonstration purposes. 
                                        These images remain the property of their respective owners.
                                        <br>
                                        Users may not copy, reproduce, distribute, or reuse any website content without 
                                        appropriate permission from the rightful owner.
                                   </p>
                                </div>

                                <div id="terms-use">
                                    <h4>8. Website Use</h4>
                                    <p>
                                        Users agree to use the website responsibly and only for its 
                                        intended academic demonstration purposes.
                                    </p>
                                    <br>
                                    <p>Users must not attempt to:</p>
                                    <ul>
                                        <li>interfere with the functionality of the website</li>
                                        <li>access restricted areas without authorisation</li>
                                        <li>misuse system features or testing tools</li>
                                    </ul>
                                </div>

                                <div id="terms-limitation">
                                    <h4>9. Limitation of Liability</h4>
                                   <p>
                                        Nail Utopia is provided as part of an academic project and is supplied 
                                        for demonstration purposes only.The website developer is not 
                                        responsible for any damages, losses, or issues arising from the 
                                        use of this demonstration system. Users interact with the 
                                        website at their own discretion.
                                   </p>
                                </div>

                                <div id="terms-privacy">
                                    <h4>10. Privacy</h4>
                                   <p>
                                        The collection and use of personal information on the website 
                                        is governed by the Privacy Policy. Users are encouraged to review 
                                        the Privacy Policy to understand how information is handled 
                                        within this academic project.
                                   </p>
                                </div>

                                <div id="terms-change">
                                    <h4>11. Changes to Terms</h4>
                                   <p>
                                        These Terms and Conditions may be updated or modified at any time to support ongoing development or improvements to the project.
                                        <br>
                                        Continued use of the website after updates indicates acceptance of the revised terms.
                                   </p>
                                </div>

                                <div id="terms-contact">
                                    <h4>12. Contact</h4>
                                   <p>
                                        If you have any questions regarding these Terms and Conditions, please contact 
                                        Nail Utopia support at <a href="mailto:spamnidisneyprincess@gmail.com">support@nailutopia.com</a>.
                                   </p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>   
   </main>
     
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>
</body>
</html>

