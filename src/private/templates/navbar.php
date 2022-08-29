<?php 
$isLogged = isset($_SESSION['userId']);
?>

<header class="p-3">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start mb">
      <a href="./" class="d-flex align-items-center mb-2 mb-lg-0 text-black text-decoration-none" id="titleLink">
        <b>CubeSat</b>
      </a>
      <style>
        @media (min-width:992px) {
          #titleLink {
            margin-right: 24px;
          }
        }
      </style>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 ml-5 justify-content-center mb-md-0">
        <li><a href="./<?php 
        // if user is logged, navbar home will be dashboard
        if($isLogged) {echo 'dashboard.php';} 
        ?>" class="nav-link px-2 text-black"><?php if (!$isLogged) {echo 'Home';} else {echo 'Dashboard';}?></a></li>
      </ul>

      <?php if (!$isLogged) : ?>
        <div class="text-end">
          <a href="./login.php" class="btn ">Login</a>
          <a href="./register.php" class="btn btn-outline-dark">Sign-up</a>
        </div>
      <?php else : ?>
        <div class="text-end">
          <!-- <span class="text-black align-middle mb-0">Hello, <?php echo $_SESSION['realName']; ?></span> -->
          <a class="text-black text-decoration-none d-inline align-middle" href="logout.php">
          <span class="d-inline d-lg-none ">Logout  </span>  
          <span class="material-symbols-outlined align-middle">
              logout
            </span>
          </a>
        <?php endif; ?>
        </div>
    </div>
  </div>
</header>