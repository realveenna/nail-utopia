<?php
  include '../alertMessage.php';
  require_once 'validateLogin.php'; 
  
  // If an admin, redirect
  if(isset($_SESSION['userType']) && ($_SESSION['userType'] === 'admin' || $_SESSION['userType'] === 'staff')){
    header('Location: ../admin/');
    exit();
  }
?>

<header class="container-lg">
    <div class="row align-items-center py-2 m-0">
      <!-- Hamburger Navbar -->
      <div class="navbar col-4 p-0 d-flex align-items-center justify-content-start d-lg-none">
        <button class="p-0 no-bg" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg" aria-controls="navbarOffcanvasLg" aria-label="Toggle navigation">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
         <?php if(!isset($_SESSION["loggedIn"]))
          { 
            echo "<a href='login.php' class='nav-svg'>";           
          }
          else{
            echo "<a href='account.php' class='nav-svg'>";
          }
          ?>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
          </svg>
        </a>
      </div>
      <!-- Top Header ( Logo, and SVGs) -->
      <div class="col-4 p-0 d-none d-lg-block">
         <?php if(!isset($_SESSION["loggedIn"]))
          { 
            echo "<a href='login.php' class='nav-svg'>";           
          }
          else{
            echo "<a href='account.php' class='nav-svg'>";
          }
          ?>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
          </svg>
        </a>
      </div>  
      
      <div class="col-4 p-0 logo">
        <a href="index.php"><img src="../uploads/logo/logo.png" alt="Nail Utopia Logo"></a>
      </div>

      <div class="col-4 p-0 d-flex align-items-center justify-content-end">
        <a href="cart.php" class="nav-svg">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
          </svg>
        </a>
        
        <a onclick="openFindProduct()" id="searchSvg" class="nav-svg">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </a>
        
      </div>
    </div>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg  d-none d-lg-block p-5 p-lg-0">
      <ul class="navbar-nav nav-underline d-flex justify-content-center gap-5">
        <li class="nav-item">
          <a class="nav-link"  href="index.php">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="shop.php">SHOP</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php#servicesSection">SERVICES</a>
        </li>
        <li class="nav-item">
           <a class="nav-link" href="canvas.php">CANVAS</a>
        </li>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="guidelines.php">GUIDELINES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">ABOUT US</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">CONTACT</a>
        </li>
      </ul>
  </nav>

  <!-- Off Canvas Navigation -->
  <nav class="navbar bg-body-main fixed-top">
    <div class="container-fluid">
      <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarOffcanvasLg" aria-labelledby="navbarOffcanvasLgLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="navbarOffcanvasLgLabel">
            <div class="logo">
              <a href="index.php"><img src="../uploads/logo/logo.png" alt="Nail Utopia Logo"></a>
            </div>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav ms-2 justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link"  href="index.php">HOME</a>
            </li> 
            <li class="nav-item">
              <a class="nav-link"  href="shop.php">SHOP</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#servicesSection">SERVICES</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="canvas.php">CANVAS</a>
            </li>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="guidelines.php">GUIDELINES</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">ABOUT US</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">CONTACT</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- Search Bar -->
  <div class="position-relative searchbar-position">
    <div class="container-fluid" id="searchBarCon">
      <div class="container-lg p-0">
          <div class="row py-2 m-0">
            <form method="get" action="shop.php" class="row g-2">
              <div class="position-relative">
                <!-- Search Icon -->
                <div class="svg-search">
                  <button type="submit" class="no-bg px-3 pb-1" class="d-flex justify-content-end align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 active" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </button>
                </div>
                <!-- Input Product -->
                <input type="text" class="form-control ps-5" id="productSearch" name="search" placeholder="Search Product" required> 
                
                <!--Close-->
                <div class="svg-close-search">
                    <button type="button" onclick="closeFindProduct()" class="no-bg px-3 pb-1" class="d-flex justify-content-end align-items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                      </svg>
                    </button>
                </div>
              </div>
            </form>       
          </div>
      </div>
    </div>
  </div>
</header>


