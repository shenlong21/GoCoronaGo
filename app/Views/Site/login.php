<?php
    // extending to the base layout
    echo $this->extend('Site/base');
    
    // setting title of page
    $this->section('head');
        echo "<title>Registration - Go Corona Go</title>";
    $this->endSection('head');

    // main content goes here
    $this->section('page_content');
?>
        <!-- show previous msg if any -->
<div class="h1 text-center my-3">Log In</div>
        
        <!-- <div class="container-md col-md-5 col-sm-10 " id="login-area"> -->
<div class="container col-xl-6 col-lg-7 col-md-8 col-sm-12 mt-3 py-4" id="login-area">

            
            <div class="m-4 text-center">
                <i class="fas fa-user fa-7x" id="icon"></i>
                <form action="<?= base_url('/login_user') ?>" method="post" class="">
                    <div class="mt-5 col-md-8 col-sm-10 m-auto   " >
                        <select name="role" class="form-select my-2 " id="role" required>
                            <option value="">-- Select Role--</option>
                            <option value="covidWarrior">Covid Warrior</option>
                            <option value="moderator">Moderator</option>
                            <option value="admin">Admin</option>
                        </select>
                    
                        <input class="form-control my-2" type="text" name="username" id="username" placeholder="Username" required>
                
                        <input class="form-control my-2" type="password" name="password" id="password" placeholder="Password" required>                        

                        <div class="my-4 pb-4 d-flex justify-content-end">
                            <button type="submit" class="btn border"><i class="fas fa-sign-in-alt">   </i> Log In</button>
                        </div>
                        <hr>
                    </div>
                </form>
                <div class="col-md-8 col-sm-10 m-auto d-flex justify-content-between pb-4">
                    <button class="btn"> <i class="fas fa-user-plus"></i> Register</button>
                    <button class="btn"> <i class="fas fa-key"></i> Forgot Password</button>
                </div>
            </div>
        </div>

    
    
    

    
    

    <!-- utilities -->
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

<?= $this->endSection('page_content'); ?>


<?= $this->section('custom_script') ?>
    <script>
        $("#role").on("change", function() {
            if($("#role").val() == "admin"){
                $("#icon").removeClass()
                $("#icon").addClass("fas").addClass("fa-user-secret").addClass("fa-7x")
            }
            else if($("#role").val() == "moderator"){
                $("#icon").removeClass()
                $("#icon").addClass("fas").addClass("fa-user-nurse").addClass("fa-7x")
            }
            else if($("#role").val() == "covidWarrior"){
                $("#icon").removeClass()
                $("#icon").addClass("fas").addClass("fa-user-shield").addClass("fa-7x")
            }
            else {
                $("#icon").removeClass()
                $("#icon").addClass("fas").addClass("fa-user").addClass("fa-7x")
            }
        })

        function show_notification(msg){
            $("#toast-body").html(msg)
            $('#liveToast').toast('show')
        }
        
        $( document ).ready(function() {
        // Run code
            // login response
            <?php if((null != session('login_response'))): ?>
                <?php if(session('login_response')== "verification_fails"): ?>
                    show_notification("User name or password incorrect!")
                <?php elseif(session('login_response')== "account_deactivated"): ?>
                    show_notification("<div class='text-danger'>Your account has beed deactivated by the admin. Contact via email for activation.</div>")
                    
                <?php else: ?>
                    show_notification("Validation error")
                <?php endif; ?>
            <?php endif; ?>
        });
        

    </script>

<?= $this->endSection('custom_script'); ?>

