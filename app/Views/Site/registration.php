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

<div class="h1 text-center mt-3 mb-4">Sign Up</div>
<div class="container col-xl-6 col-lg-7 col-md-8 col-sm-12 mt-3 pt-4 mb-3">

    <form action="<?=base_url('/register_user')?>" method="post">
        <div class="row mb-3">
            <label class="col-form-label col-sm-2 col-sm-2" for="username">Username</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="username" id="username" required autocomplete="off"
                    onkeypress="return (event.charCode > 96 && event.charCode < 123) || (event.charCode > 47 && event.charCode < 58)">
                <div class="form-text" id="username-feedback">Type username to check availability</div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-form-label col-sm-2" for="name">Name </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="name" id="name" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-form-label col-sm-2" for="email">Email </label>
            <div class="col-sm-10">
                <input class="form-control" type="email" name="email" id="email" aria-describedby="emailHelp" required>

                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>

            </div>
        </div>

        <div class="row mb-3">
            <label class="col-form-label col-sm-2" for="phone">Phone </label>
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">+91</span>
                    <input class="form-control  " type="text" name="phone" id="phone" required
                        onkeypress="return (event.charCode > 47 && event.charCode < 58)">
                </div>
                <div class="form-text" id="phone-feedback"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-form-label col-sm-2" for="password">Password </label>
            <div class="col-sm-10">
                <input class="form-control  " type="password" name="password" id="password" required>
                <div class="form-text text-danger" id="password-feedback"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-form-label col-sm-2" for="password_conf">Confirm Password </label>
            <div class="col-sm-10">
                <input class="form-control" type="password" name="password_conf" id="password_conf" required>
                <div class="form-text" id="password_conf_feedback"></div>
            </div>
        </div>

        <div class="d-flex justify-content-end pb-4">
            <button type="submit" class="btn border" id="submit">Register</button>
        </div>
    </form>


    <hr>
    <div class="d-flex justify-content-between">
        <p>Already Registered? <a href="<?=base_url('/login') ?>" class="link">Click Here</a></p>
        <a class="btn">See registration guidelines</a>
    </div>




</div>



<?= $this->endSection('page_content'); ?>


<?= $this->section('custom_script') ?>
<script>
    $("#username").keyup(function () {
        var user = $("#username").val()
        if (user.length < 5) {
            $("#username-feedback").removeClass("text-success").addClass("text-danger").html(
                "Username must be at least of 5 letters")
            $("#submit").prop("disabled", true)
        } else {
            console.log("user " + user)
            $.ajax({
                url: "<?= base_url('/Site/Registration_controller/check_username') ?>",
                type: "POST",
                data: {
                    username: user
                },
                datatype: "JSON",
                success: function (res) {
                    response = JSON.parse(res)
                    if (response[0].response == "success") {
                        $("#username-feedback").removeClass("text-danger").addClass("text-success")
                            .html("Username available.")
                        $("#submit").prop("disabled", false)
                    } else if (response[0].response == "fail") {
                        $("#username-feedback").addClass("text-danger").removeClass("text-success")
                            .html("Username not available.")
                    } else {
                        $("#username-feedback").removeClass("text-danger").removeClass(
                            "text-success").html("Type username")

                    }
                }
            })
        }
    })


    function isEmail(email) {
        var EmailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-z0-9]{2,4})+$/;
        return EmailRegex.test(email)
    }

    $("#email").on('change', function () {
        var email = $("#email").val()
        console.log("user " + email)
        if (isEmail(email)) {
            $.ajax({
                url: "<?= base_url('/Site/Registration_controller/check_email') ?>",
                type: "POST",
                data: {
                    email: email
                },
                datatype: "JSON",
                success: function (res) {
                    console.log(res)
                    response = JSON.parse(res)
                    if (response[0].response == "success") {
                        $("#emailHelp").removeClass("text-danger").addClass("text-success").html(
                            "Email available")
                        $("#submit").prop("disabled", false)

                    } else if (response[0].response == "fail") {
                        $("#emailHelp").addClass("text-danger").removeClass("text-success").html(
                            "Username already used")
                    } else {
                        $("#emailHelp").removeClass("text-danger").removeClass("text-success").html(
                            "Enter a email")

                    }
                }
            })
        } else {
            $("#emailHelp").addClass("text-danger").html("Enter a valid email")
            $("#submit").prop("disabled", true)
        }
    })


    function isPhone(phone) {
        var phoneRegex = /^([0-9])/;
        return phoneRegex.test(phone)
    }

    $("#phone").on('change', function () {
        var phone = $("#phone").val()
        if (isPhone(phone) && phone.length == 10) {
            if (phone.length == 10) {
                console.log("user " + phone)
                $.ajax({
                    url: "<?= base_url('/Site/Registration_controller/check_phone') ?>",
                    type: "POST",
                    data: {
                        phone: phone
                    },
                    datatype: "JSON",
                    success: function (res) {
                        console.log(res)
                        response = JSON.parse(res)
                        if (response[0].response == "success") {
                            $("#phone-feedback").removeClass("text-danger").addClass("text-success")
                                .html("")
                            $("#submit").prop("disabled", false)

                        } else if (response[0].response == "fail") {
                            $("#phone-feedback").addClass("text-danger").removeClass("text-success")
                                .html("Phone already used")
                        } else {
                            $("#phone-feedback").removeClass("text-danger").removeClass(
                                "text-success").html("Enter phone number")

                        }
                    }
                })
            }
        } else {
            $("#phone-feedback").addClass("text-danger").removeClass("text-success").html(
                "Enter valid phone number")
            $("#submit").prop("disabled", true)

        }
    })


    $("#password").keyup(function () {
        var pass = $("#password").val()
        if (pass.length < 8) {
            $("#password-feedback").html("Password must be 8 characters long")
            $("#submit").prop("disabled", true)

        } else {
            $("#password-feedback").html("")
            $("#submit").prop("disabled", false)

        }
    })


    $("#password_conf").keyup(function () {
        var pass = $("#password").val()
        var pass_conf = $("#password_conf").val()

        if (pass != pass_conf) {
            $("#password_conf_feedback").addClass("text-danger").html("Password doesn't match!")
            $("#submit").prop("disabled", true)

        } else {
            $("#password_conf_feedback").html("")
            $("#submit").prop("disabled", false)

        }

    })
</script>


<?= $this->endSection('custom_script'); ?>