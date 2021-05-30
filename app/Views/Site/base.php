<!doctype html>
<html lang="en" class="h-100">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/jpg" href="<?= base_url('public/favicon.png') ?>" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap.css')?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('/assets/css/site_base.css')?>">

  <?= $this->renderSection('head') ?>
</head>

<body class="d-flex flex-column h-100">

  <!-- Navbar starts -->
  <nav class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand mr-4" href="<?= base_url() ?>" style="font-weight:600;">GO CORONA GO</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item navbar-hover mx-2 ">
            <a class="nav-link <?php if(uri_string() == "oxygen_supply"){echo "active";} ?> "
              href="<?= base_url('/oxygen_supply') ?>">Oxygen Supply</a>
          </li>
          <li class="nav-item navbar-hover mx-2 ">
            <a class="nav-link <?php if(uri_string() == "tiffin_service"){echo "active";} ?> "
              href="<?= base_url('/tiffin_service') ?>">Tiffin Services</a>
          </li>
          <li class="nav-item navbar-hover mx-2 ">
            <a class="nav-link <?php if(uri_string() == "bed_availability"){echo "active";} ?>"
              href="<?= base_url('bed_availability') ?>">Bed Avaliability</a>
          </li>
          <li class="nav-item navbar-hover mx-2">
            <a class="nav-link <?php if(uri_string() == "plasma_donor"){echo "active";} ?>"
              href="<?= base_url('plasma_donor') ?>">Plasma Donors </a>
          </li>
        </ul>

        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item navbar-hover mx-2 ">
            <a class="nav-link <?php if(uri_string() == "about"){echo "active";} ?> "
              href="<?= base_url('/about') ?>">About</a>
          </li>
          <li class="nav-item navbar-hover mx-2 ">
            <a class="nav-link <?php if(uri_string() == "login"){echo "active";} ?> "
              href="<?= base_url('/login') ?>">Login</a>
          </li>
          <li class="nav-item navbar-hover mx-2 ">
            <a class="nav-link <?php if(uri_string() == "registration"){echo "active";} ?>"
              href="<?= base_url('registration') ?>">Sign Up</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar ends -->


  <!-- extending content -->
  <div class="page_content" id="page_content">
    <?=$this->renderSection('page_content') ?>
  </div>


<!-- utility -->
<!-- toast -->
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-secondary text-white">
        <strong class="me-auto">User Panel - Message</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body" id="toast-body"></div>
    </div>
  </div>
<!-- toast end -->


<!-- footer -->
<footer class="footer mt-auto py-3 bg-light">
  <div class="container-md text-center">
    <i class="fas fa-code "></i> with <i class="fas fa-heart"></i> by <a
      href="https://github.com/shenlong21">shenlong21</a> <br>
  </div>
</footer>
<!-- footer ends -->

  <!-- jquery -->
  <script src="<?= base_url('/assets/js/jquery.min.js')?>"></script>
  <!-- bootstrap js -->
  <script src="<?= base_url('/assets/js/bootstrap.bundle.js')?>"></script>

  <!-- for custom js -->
  <script>
    function show_notification(msg) {
      $("#toast-body").html(msg)
      $('#liveToast').toast('show')
    }
  </script>
  <?=$this->renderSection('custom_script') ?>

</body>

</html>