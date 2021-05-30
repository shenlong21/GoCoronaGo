<?= $this->extend('User/base') ?>
<?= $this->section('head') ?>
    <title>Users - User Panel - Go Corona Go</title>
<?= $this->endSection('head') ?>


<?= $this->section('content') ?>

    <div class="m-3" >
        <h5 class="h5 my-3"><strong>USERS</strong></h5>
        <hr>


        <div class="d-flex justify-content-end d-none" id="refresh_page_btn">[  <a class="mx-2" href="<?= base_url() ."/". uri_string() ?>"> <i class="fas fa-sync"></i> Refresh Page</a> ]</div>
        <div class="table-responsive my-3">
        <table class="table">
            <thead>
                <tr>
                    <td>Username</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Access Level</td>
                    <td>Promote</td>
                    <td>Demote</td>
                </tr>
            </thead>
            <tbody>
            <?php
                // print_r($users);

                foreach($users as $u) {
                    $username = $u['username'];
                    $name = $u['name'];
                    $email = $u['email'];
                    $access = $u['access_level'];

                    if ($username == session("username") || $username == "admin") {
                        continue;
                    }

                    $promote_able = "";
                    $promote = "onclick='promote_user(\"$username\")'";
                    if($u['access'] == 3){
                        $promote_able = "disabled";
                        $promote = "";
                    }

                    $demote_able = "";
                    $demote = "onclick='demote_user(\"$username\")'";
                    if($u['access'] == 0){
                        $demote_able = "disabled";
                        $demote = "";
                    }

                    echo "
                        <tr>
                            <td>$username</td>
                            <td>$name</td>
                            <td>$email</td>
                            <td id='$username-access_face'>$access</td>
                            <td><button id='$username-promote_btn' class='btn btn-success $promote_able' $promote_able $promote><i class='fas fa-arrow-up'></i> Promote</button></td>
                            <td><button id='$username-demote_btn' class='btn btn-danger $demote_able' $demote_able $demote><i class='fas fa-arrow-down'></i> Demote</button></td>
                        </tr>
                        ";
                }

            ?>
            </tbody>
        </table>

        </div>
    </div>

    <div class="m-3 pt-4">
        <h5 class="h6" style="font-weight:650;">LAST 20 ACTIVITIES:</h5>
        <?php

            foreach ($activities as $a ) {
                $time = $a['time'];
                $user = $a['username'];
                $act = $a['act'];
                $domain = $a['domain'];
                $entity = $a['entity'];

                echo "
                    <div class='my-2'>
                        <i class='fas fa-chevron-right'></i> $time --> $user $act $entity in $domain
                    </div>
                ";
            }
        ?>

    </div>
<?= $this->endSection('content') ?>





<?= $this->section('script') ?>

<script>
    $( document ).ajaxComplete(function(){
        $("#refresh_page_btn").removeClass("d-none")
    })


    function promote_user(username){
        $.ajax({
            url: "promote_user",
            type: "POST",
            data: {
                username: username
            },
            datatype: "JSON",
            beforeSend: function() {
                $(`#${username}-promote_btn`).prop("disabled", true).html(`<div class='spinner-border spinner-border-sm  mx-4' role='status'>
                                                <span class='visually-hidden'>Loading...</span>
                                            </div>`)
            },
            success: function(response) {
                var res = JSON.parse(response)
                console.log(res)

                $(`#${username}-promote_btn`).html("<i class='fas fa-arrow-up'></i> Promote").prop("disabled", false)

                if(res['promote_response'] == false){
                    show_notification("<div class='text-danger'>Error in promoting! Try again later</div>")
                    return;
                }

                var access_now = res['access']
                console.log(access_now)

                if(access_now == 3){
                    $(`#${username}-access_face`).html("<i class='fas fa-user-secret fa-2x'></i> Admin")
                    $(`#${username}-promote_btn`).prop("disabled", true)
                }
                else if(access_now == 2){
                    $(`#${username}-access_face`).html("<i class='fas fa-user-nurse fa-2x'></i> Moderator")
                }
                else if(access_now == 1){
                    $(`#${username}-access_face`).html("<i class='fas fa-user-shield fa-2x'></i> Covid Warrior")
                    $(`#${username}-demote_btn`).removeClass("disabled").prop("disabled", false).attr("onclick","")
                                                .attr("onclick", promote_user(username))
                }
                else if(access_now == 0){
                    $(`#${username}-access_face`).html("<i class='fas fa-times-circle fa-2x'></i> Dectivated")
                }
                else{
                    $(`#${username}-access_face`).html("Error")
                }
                show_notification("<div class='text-success'>Promotion completed!</div>")

            }
        })
        console.log("skdjf")
    }

    function demote_user(username){
        $.ajax({
            url: "demote_user",
            type: "POST",
            data: {
                username: username
            },
            datatype: "JSON",
            beforeSend: function() {
                $(`#${username}-demote_btn`).prop("disabled", true).html(`<div class='spinner-border spinner-border-sm  mx-4' role='status'>
                                                <span class='visually-hidden'>Loading...</span>
                                            </div>`)
            },
            success: function(response) {
                var res = JSON.parse(response)
                console.log(res)

                $(`#${username}-demote_btn`).html("<i class='fas fa-arrow-down'></i> Promote").prop("disabled", false)

                if(res['promote_response'] == false){
                    show_notification("<div class='text-danger'>Error in demoting! Try again later</div>")
                    return;
                }
                var access_now = res['access']
                console.log(access_now)

                if(access_now == 3){
                    $(`#${username}-access_face`).html("<i class='fas fa-user-secret fa-2x'></i> Admin")
                }
                else if(access_now == 2){
                    $(`#${username}-access_face`).html("<i class='fas fa-user-nurse fa-2x'></i> Moderator")
                    $(`#${username}-promote_btn`).removeClass("disabled").prop("disabled", false)
                                                .attr(`onclick`,"")
                                                .attr("onclick", demote_user(username))
                }
                else if(access_now == 1){
                    $(`#${username}-access_face`).html("<i class='fas fa-user-shield fa-2x'></i> Covid Warrior")
                }
                else if(access_now == 0){
                    $(`#${username}-access_face`).html("<i class='fas fa-times-circle fa-2x'></i> Deactivated")
                    $(`#${username}-demote_btn`).prop("disabled", true)
                }
                else{
                    $(`#${username}-access_face`).html("Error")
                }
                show_notification("<div class='text-success'>Demotion completed!</div>")

            }
        })
        console.log("skdjf")
    }
</script>


<?= $this->endSection('script') ?>
