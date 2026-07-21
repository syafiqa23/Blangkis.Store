<?php
$cart = \Config\Services::cart();
$cartCount = 0;
foreach ($cart->contents() as $cartItem) {
    $cartCount += (int) $cartItem['qty'];
}
$avatar = session('avatar') ? base_url('uploads/avatar/' . session('avatar')) : base_url('NiceAdmin/assets/img/profile-img.jpg');
?>
 <!-- ======= Header ======= -->
 <header id="header" class="header fixed-top d-flex align-items-center">

   <div class="d-flex align-items-center justify-content-between">
     <a href="<?= base_url('/') ?>" class="logo d-flex align-items-center">
       <img src="<?php echo base_url() ?>NiceAdmin/assets/img/logo_blangkon.jpg" alt="">
       <span class="d-none d-lg-block">Blangkis Store</span>
     </a>
     <i class="bi bi-list toggle-sidebar-btn"></i>
   </div><!-- End Logo -->

   <div class="search-bar">
     <form class="search-form d-flex align-items-center" method="POST" action="<?= base_url('search') ?>">
       <input type="text" name="query" placeholder="Search" title="Enter search keyword">
       <button type="submit" title="Search"><i class="bi bi-search"></i></button>
     </form>
   </div><!-- End Search Bar -->

   <nav class="header-nav ms-auto">
     <ul class="d-flex align-items-center">

       <li class="nav-item d-block d-lg-none">
         <a class="nav-link nav-icon search-bar-toggle " href="#">
           <i class="bi bi-search"></i>
         </a>
       </li><!-- End Search Icon-->

       <li class="nav-item">
         <a class="nav-link nav-icon" href="<?= base_url('keranjang') ?>" title="Keranjang">
           <i class="bi bi-bag"></i>
           <?php if ($cartCount > 0) : ?>
             <span class="badge bg-primary badge-number"><?= $cartCount ?></span>
           <?php endif; ?>
         </a>
       </li>

       <li class="nav-item dropdown pe-3">

         <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
       <img src="<?= $avatar ?>" 
     class="rounded-circle" 
     width="32" height="32"
     style="object-fit: cover;" 
     alt="Avatar">

           <span class="d-none d-md-block dropdown-toggle ps-2"><?= esc(session()->get('username')); ?> <?= session()->get('role') ? '(' . esc(session()->get('role')) . ')' : '' ?></span>
         </a><!-- End Profile Iamge Icon -->

         <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
           <li class="dropdown-header">
             <h6><?= esc(session()->get('username') ?? 'Pengguna') ?></h6>
             <span><?= esc(session()->get('email') ?? 'Blangkis Store') ?></span>
           </li>
           <li>
             <hr class="dropdown-divider">
           </li>

           <li>
             <a class="dropdown-item d-flex align-items-center" href="<?= base_url('account') ?>">
               <i class="bi bi-person"></i>
               <span>My Profile</span>
             </a>
           </li>
           <li>
             <hr class="dropdown-divider">
           </li>

          
           <li>
             <hr class="dropdown-divider">
           </li>

           <li>
             <a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout') ?>">
               <i class="bi bi-box-arrow-right"></i>
               <span>Sign Out</span>
             </a>
           </li>


         </ul><!-- End Profile Dropdown Items -->
       </li><!-- End Profile Nav -->

     </ul>
   </nav><!-- End Icons Navigation -->

 </header><!-- End Header -->
