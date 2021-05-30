<?= $this->extend('User/base') ?>
<?= $this->section('head') ?>
    <title>Requests - User Panel - Go Corona Go</title>
<?= $this->endSection('head') ?>


<?= $this->section('content') ?>
    <div class="m-3" >
        <h5 class="h5 my-3"><strong>REQUESTS</strong></h5>
        <div class="form-text">Here you will get all the requests that were made by the users for promotions.</div>
        <hr>
        <div class="m-3 table-responsive">
            <table class="table table-borderless">
                <tbody>
                    <?php
                        // $count = 1;
                        // print_r($requests);
                        foreach ($requests as $r ) {
                            $username = $r['username'];
                            $message = $r['message'];
                            $time = $r['created_at'];
                            $current_access = $r['access'];

                            echo"
                                <td>
                                    <tr id='$username-row'>
                                        <td>$time</td>
                                        <td>$username</td>
                                        <td>$current_access</td>
                                        <td>$message</td>
                                        <td><button class='btn btn-danger' id='$username-discard_btn' onclick='discard(\"$username\")'> <i class='fas fa-times'></i> Discard Request</button></td>
                                        <td><button class='btn btn-success' id='$username-approve_btn' onclick='approve(\"$username\")'><i class='fas fa-check'></i> Approve</button></td>
                                    </tr>
                                </td>
                            
                            ";

                            // $count++;
                        }

                    ?>
                </tbody>
            </table>
        
        </div>

    </div> 
<?= $this->endSection('content') ?>

<?= $this->section('script') ?>

    <script>
        

        function approve(username) {
            console.log(username)
            $.ajax({
            url: "approve_request",
            type: "POST",
            data: {
                username: username
            },
            datatype: "JSON",
            beforeSend: function() {
                $(`#${username}-approve_btn`).prop("disabled", true).html(`<div class='spinner-border spinner-border-sm  mx-4' role='status'>
                                                <span class='visually-hidden'>Loading...</span>
                                            </div>`)
            },
            success: function(response) {
                var res = JSON.parse(response)
                console.log(res)
                
                if(res.promote_response == "success"){
                    show_notification("<div class='text-success'>Promotion completed!</div>")
                    $(`#${username}-approve_btn`).html("<i class='fas fa-check'></i> Approved")
                    
                    // delay for 2 sec
                    setTimeout(() => {
                        $(`#${username}-row`).delay(800).addClass("d-none")
                    }, 2000);

                }
                else{
                    show_notification("<div class='text-waring'>Error in promotion !</div>")

                }
               

            }
        })
        console.log("skdjf")
        }

        function discard(username) {
            $.ajax({
            url: "discard_request",
            type: "POST",
            data: {
                username: username
            },
            datatype: "JSON",
            beforeSend: function() {
                $(`#${username}-discard_btn`).prop("disabled", true).html(`<div class='spinner-border spinner-border-sm  mx-4' role='status'>
                                                <span class='visually-hidden'>Loading...</span>
                                            </div>`)
            },
            success: function(response) {
                var res = JSON.parse(response)
                console.log(res)
                
                if(res.discard_response == "success"){
                    show_notification("<div class='text-warning'>Request Discarded!</div>")
                    $(`#${username}-discard_btn`).html("<i class='fas fa-times'></i> Discarded")

                    // delay for 2 sec
                    setTimeout(() => {
                        $(`#${username}-row`).addClass("d-none")
                    }, 2000);

                }
                else{
                    show_notification("<div class='text-waring'>Error in discarding!</div>")

                }
               

            }
        })
        }
    
    
    </script>


<?= $this->endSection('script') ?>
