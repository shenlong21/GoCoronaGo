<?= $this->extend('User/base') ?>
<?= $this->section('head') ?>
    <title>User Panel - Go Corona Go</title>
<?= $this->endSection('head') ?>


<?= $this->section('content') ?>
    
    <?php 
        // access levels


    ?>


    <div class="m-3" >
        <h5 class="h5 my-3"><strong>PROFILE</strong></h5>
        <hr>

        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12">           
                <dl class="row">
                    <dt class="col-sm-3">Username</dt>
                    <dd class="col-sm-9"> - <?= $user_details['username'] ?></dd>

                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9"> - <?= $user_details['name'] ?> </dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9"> - <?= $user_details['email'] ?> </dd>

                    <dt class="col-sm-3">Phone number</dt>
                    <dd class="col-sm-9"> - <?= $user_details['phone'] ?> </dd> 

                    <dt class="col-sm-3">Access Level</dt>
                    <dd class="col-sm-9"> - <?= $user_details['access_level'] ?> </dd>            
                </dl>

                <?php if($user_details['access'] < 3 && $promote_req == FALSE): ?>
                    <div class="collapse mt-5 " id="elevate_req_form">
                        <h5 class="h5 mt-3"> <strong> ELEVATE REQUEST FORM </strong></h5>
                        <!-- <form  method="post" action = "<?= base_url() ?>/user/submit_request"> -->
                            <input class="form-control" type="hidden" name="username" required readonly value="<?= session('username') ?>" >

                            <div class="row mt-3">
                                <label class="col-form-label col-sm-12" for="address">Messsage </label>
                                <div class="col-sm-12">
                                    <textarea class="w-100 form-control" name="message" id="message" rows="10" placeholder="Type a message to be submitted with your request..."></textarea>
                                </div>
                            </div>
                            <div class="form-text text-danger" id="elevate_req_feedback"></div>
                            <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn border mx-2" id="elevate_req_form_close"> <i class="fas fa-times"></i> Close Form</button> 
                            <button  class="btn btn-primary mx-2" id="elivate_request_submit_btn"  onclick="submit_elivate_request()"> <i class="fas fa-paper-plane"></i> Submit Request </button> 
                            </div>
                        <!-- </form> -->
                    </div>
                <?php endif; ?>


            </div>

            <div class="col-lg-3 col-md-4 col-sm-12 mr-3 bg-light" style="min-height:80vh">
                
                <div class="m-3 lead" style="font-weight:600">RELATED</div>
                
                <div class=" my-2"><button class="btn"><i class="fas fa-key"></i> Change Password</button></div> <hr>
                <div class=" my-2">
                    <?php if($user_details['access'] == 3): ?>
                        <button class="btn disabled" disabled><i class="fas fa-upload"></i> Elevate Access ( disabled )</button> 
                        <br>
                        <div class="form-text">
                         As already at the highest access level
                         </div>
                    <?php else: ?>
                        <?php if($promote_req == TRUE): ?>
                            <button class="btn disabled" disabled><i class="fas fa-upload"></i> Elevate Access ( disabled )</button> 
                            <br>
                            <div class="form-text">
                            Already requested</div>
                        <?php else: ?>
                            <button class="btn" id="elivate_access_btn" data-bs-toggle="collapse" data-bs-target="#elevate_req_form" aria-expanded="false" aria-controls="elevate_req_form"><i class="fas fa-upload"></i> Elevate Access </button> 
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>  
        </div>
    </div> 
<?= $this->endSection('content') ?>





<?= $this->section('script') ?>

    <script>
        function submit_elivate_request(){
            var message = $( "#message" ).val();
            console.log(message) 
            
            if(message != ""){
                $.ajax({
                    
                    url:"submit_request",
                    type: "POST",
                    data: {
                        username: "<?= $user_details['username'] ?>",
                        message: message
                    },
                    datatype: "JSON",
                    beforeSend: function() {
                        $( "#elivate_request_submit_btn" ).html("Submitting request...").prop("disabled", true)
                    },

                    success: function(response){
                        var res = JSON.parse(response)
                        console.log(res.submit_response)

                        if(res.submit_response == "success"){
                            $( "#elivate_request_submit_btn" ).html("Requested Successfully")
                            $("#elivate_access_btn").addClass("disabled").prop("disabled", true).html("<i class='fas fa-upload'></i> Alredy Requested")
                        
                            show_notification("Request submitted successfully! You can close the form.")
                        }


                    }
                })   
            }
            else{
                $("#elevate_req_feedback").html("This field is required!")
            }
        }
        
        // $("#elivate_access_btn").on("click", function(){
        //     $("#elevate_req_form").toggleClass("d-none")
        // })

        $("#elevate_req_form_close").on("click", function() {
            $("#elevate_req_form").addClass("d-none")
        })

    </script>

<?= $this->endSection('script') ?>
