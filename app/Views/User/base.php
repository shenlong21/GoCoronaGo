<?php
    $role = "";
    $icon = "";
    if(session('access') == 3){
        $role = "Admin";
        $icon = "<i class='fas fa-user-secret fa-2x'></i>";
    }
    elseif( session('access') == 2) {
        $role = "Moderator";
        $icon = "<i class='fas fa-user-nurse fa-2x'></i>";
    }
    elseif( session('access')) {
        $role = "Covid Warrior";
        $icon = "<i class='fas fa-user-shield fa-2x'></i>";
    }
    else{
        $role = "";
        $icon = "";
    }
?>


<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap.css')?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= base_url('/assets/css/admin_base.css') ?>">

    <?= $this->renderSection('head') ?>


</head>
<body>
    <div class="wrapper">
        <!-- sidebar -->
        <nav id="sidebar" class="bg-light p-3">

            <!-- user details -->
            <div class="row">

                <div class="col-4 mb-3">
                    <a style="text-decoration: none; color:black;" href="<?= base_url('/user/profile') ?>">
                        <span class="h3"><?= $icon ?></span>
                    </a>
                </div>
                <div class="col-8 mb-3">
                    <a style="text-decoration: none; color:black;" href="<?= base_url('/user/profile') ?>">
                        <span class="h3 mb-0" id="username_display"><?=session('username')?></span> <br>
                        <span class="text-muted">  <?= $role ?> </span>
                    </a>
                </div>

                <hr>
            </div>

            <!-- categories -->
            <div>
                <?php if( session('access') == 3 ): ?>
                    <a class=" sidebar-item" href="<?= base_url('/user/all_users') ?>"><i class="fas fa-users"></i> Users</a>
                    <a class=" sidebar-item" href="<?= base_url('/user/requests') ?>"><i class="fas fa-user-plus"></i> Requests</a>
                    <hr>
                <?php endif; ?>


                <?php if( session('access') == 1 || session('access') == 2 || session('access') == 3 ): ?>
                    <a class="sidebar-item" href="<?= base_url('/user/oxygen_supply') ?>"><i class="fas fa-lungs "></i> Oxygen Supply</a>
                    <a class="sidebar-item" href="<?= base_url('/user/tiffin_service') ?>"><i class="fas fa-database "></i> Tiffin Services</a>
                    <a class="sidebar-item" href="<?= base_url('user/bed_availability') ?>"><i class="fas fa-bed "></i> Bed Availability</a>
                    <a class="sidebar-item" href="<?= base_url('user/plasma_donors') ?>"><i class="fas fa-hand-holding-water"></i> Plasma Donors</a>
                    <a class="sidebar-item" href="#"><i class="fas fa-syringe "></i> Vaccination Drives</a>
                    <a class="sidebar-item" href="#"><i class="fas fa-vials "></i> Testing Centers</a>
                    <a class="sidebar-item" href="#"><i class="fas fa-hospital "></i> Covid Hospitals</a>
                    <a class="sidebar-item" href="#"><i class="fas fa-clinic-medical "></i> Home Treatment Facility</a>

                <?php endif; ?>


                <?php if( session('access') == 2 || session('access') == 3 ): ?>
                        <hr>
                    <a class=" sidebar-item" href="#"><i class="fas fa-file-alt"></i> Reports</a>
                    <a class=" sidebar-item" href="#"><i class="fas fa-clipboard-list"></i> Logs</a>
                <?php endif; ?>

            </div>
        </nav>

        <!-- page content -->
        <div class="" id="content" >
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn "><i class="fas fa-bars"></i></button>
                    <div class="text-center mt-2">
                    <h4> GO CORONA GO</h4>
                    </div>
                    <a href="<?= base_url('User/Logout')?>" id="sidebarCollapse" class="btn "><i class="fas fa-sign-out-alt"></i> Log out</a>


                </div>
            </nav>
                <?= $this->renderSection('content') ?>

                <!-- footer do not change -->
                <footer class="footer mt-auto py-3 bg-light">
                    <div class="small text-muted bg-light text-center mx-1 px-5 py-3">
                    <div class="my-2">
                        <i class="fas fa-code "></i> with <i class="fas fa-heart"></i> by <a href="https://github.com/shenlong21">shenlong21</a> <br>
                    </div>

                        An initiative by a student to provide a medium for information regarding covid facilities available round the hood. This website only provided dummy data, any information in this website in not realted to real time data. Again this site do not contain any authentic informtion.
                    </div>
                </footer>
        </div>
    </div>

    <!-- utilities -->

    <!-- Modal -->
    <div class=" modal  fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">Loading...</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="model-body">
            Loading..
        </div>
        <div class="modal-footer" id="model-footer">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
    </div>


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
    <!-- utilities end -->

    <script src="<?= base_url('/assets/js/jquery.min.js')?>"></script>
    <script src="<?= base_url('/assets/js/bootstrap.bundle.js')?>"></script>
    <script src="<?= base_url('/assets/js/fa.all.min.js') ?>"></script>

    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active')
                if($( document ).width() < 576){
                    $("#content").toggleClass('d-none')
                }
            })
        })

        function show_notification(msg){
            $("#toast-body").html(msg)
            $('#liveToast').toast('show')
        }


    </script>

    <?= $this->renderSection('script') ?>

</body>
</html>
