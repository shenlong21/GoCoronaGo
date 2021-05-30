<?= $this->extend('User/base') ?>
<?= $this->section('head') ?>
    <title>Bed Availability - User Panel - Go Corona Go</title>
<?= $this->endSection('head') ?>


<?= $this->section('content') ?>
    
    <div class="m-3" >
        <div class="d-flex justify-content-between">
        <h5 class="h5 my-3"><strong>BED AVAILABILITY </strong></h5>
        <button class="btn " type="button" data-bs-toggle="collapse" data-bs-target="#oxygen-supplier-form" aria-expanded="false" aria-controls="oxygen-supplier-form"> <i class="fas fa-plus"></i> Add Supplier</button>
        </div>
        <hr>

        <!-- <div class="my-3 mx-5" id="process_status"></div> -->
        <div class="collapse my-3 col-lg-9 col-md-11 col-sm-12 col-xl-7 mx-lg-5 mb-4" id="oxygen-supplier-form">

            <form  method="post" action = "<?= base_url('/user/add_bed_availability') ?>">
                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="name">Name</label>  
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="add_name" id="name" required autocomplete="off" >
                    </div>
                </div> 

                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="address">Address </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="add_address" id="name" required >
                    </div>
                </div>
                    
                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="description">Description </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="add_description" id="description" aria-describedby="descriptionHelp" required>                                
                        <div id="descriptionHelp" class="form-text">A short description of supplier.</div>

                    </div>
                </div>

                <div class="row mb-3">
                <label class="col-form-label col-sm-3" for="phone">Phone </label>
                    <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input class="form-control  " type="text" name="add_phone" id="phone" required onkeypress="return (event.charCode > 47 && event.charCode < 58)">
                    </div>
                        <div class="form-text" id="phone-feedback"></div>
                    </div>
                </div>

                <div class="row mb-3">
                <label class="col-form-label col-sm-3" for="whatsapp">Whatsapp </label>
                    <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input class="form-control  " type="text" name="add_whatsapp" id="whatsapp" required onkeypress="return (event.charCode > 47 && event.charCode < 58)">
                    </div>
                        <div class="form-text" id="phone-feedback"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="email">Email </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="email" name="add_email" id="email"  required>                                
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="beds">Beds Available </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="number" name="add_beds" id="beds"  required>                                
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="beds_with_oxygen">Beds with oxygen </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="number" name="add_beds_with_oxygen" id="beds_with_oxygen"  required>                                
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="icu">ICU Available </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="number" name="add_icu" id="icu"  required>                                
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="icu_with_ventilator">ICU with ventilator </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="number" name="add_icu_with_ventilator" id="icu_with_ventilator"  required>                                
                    </div>
                </div>

                <div class="row mb-3">
                <label class="col-form-label col-sm-3" for="verification">Verification </label>
                    <div class="col-sm-9">
                        <select class="form-select" name="add_verification" id="verification">
                            <option value="0">Not Verified</option>
                            <option value="1">Verified</option>
                        </select>
                    </div>
                </div>                

                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="pincode">Place </label>
                    <div class="col-sm-9">
                        <!-- <input class="form-control" type="number" name="add_pincode" id="pincode"  required>                                 -->
                        <select name="add_pincode" id="pincode" class="form-select" required>
                            <option value="">-- Select --</option>
                            <?php
                                foreach ($places as $p) {
                                    $pin = $p['pincode'];
                                    $place_name = $p['name'];

                                    echo "<option value=$pin>$place_name</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-3" for="city">City </label>
                    <div class="col-sm-9">
                        <select class="form-select" name="add_city" id="city">
                            <option value="ahmedabad">Ahmedabad</option>                            
                        </select>    
                    </div>
                </div>

                <div class="d-flex justify-content-end pb-4">
                    <button type="submit" class="btn border" id="submit">Add Availability</button>
                </div>
            </form>
            <hr>
        </div>



        <div class="h6" style="text-decoration: underline;">CURRENT BED AVAILABILITY</div>
        <table class="table table-striped">
            <thead class="thead thead-dark">
                <tr>
                    <td>City</td>
                    <td>Name</td>
                    <td>Phone</td>
                    <td>Beds</td>
                    <td>Bed with oxygen</td>
                    <td>ICU</td>
                    <td>ICU with ventilators</td>
                    <td>Verification</td>
                    <td>Reports</td>
                    <!-- <td>Edit</td> -->
                    <td>Save</td>
                    <?php if( session('access') >= 2): ?>
                        <td>Delete</td>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($details as $d ) {
                        $id = $d['id'];
                        $city = $d['city'];
                        $name = $d['name'];
                        $phone = $d['phone'];
                        $beds = $d['bed_available'];
                        $bed_with_oxygen = $d['oxygen'];
                        $icu = $d['icu'];
                        $icu_with_ventilator = $d['icu_with_ventilator'];
                        $verification = $d['verification'];
                        $reports = $d['reports'];
                        $pin = $d['pincode'];
                        $ago = $d['ago'];

                        // ago presentation conditioning
                        if($ago == "0 days ago")
                            $ago = "Today";
                        elseif( $ago == "1 days ago")
                            $ago = "Yesterday";
                        else{
                            
                        }

                        $verification_options = [0 => 'Not verified', 1 => 'Verified'];

                        echo "
                            <tr>
                                <td>$city</td>
                                <td id='$id-name'>$name</td>
                                <td>$phone</td>  
                                <td><input class='form-control' style='width:50px;' id='$id-beds' value=$beds></td>                              
                                <td><input class='form-control' style='width:50px;' id='$id-beds_with_oxygen' value=$bed_with_oxygen></td>                              
                                <td><input class='form-control' style='width:50px;' id='$id-icu' value=$icu></td>                              
                                <td><input class='form-control' style='width:50px;' id='$id-icu_with_ventilators' value=$icu_with_ventilator></td>                              
                                <td>
                                    <select class='form-select' id='$id-verification'>";                                        
                                    foreach ($verification_options as $vm => $value) {
                                        echo "<option value = $vm ";
                                        if($verification == $vm)
                                            echo "selected";
                                        echo "> $value </option>";
                                    }
                                echo "
                                    </select>   
                                </td>
                                <td>$reports</td>
                                <td><button class='btn' id='$id-save-btn' onclick='save_info($id)'>Save</button></td>
                                ";
                                 if(session('access') >= 2) {
                                    echo "
                                    <td>
                                    <button type='button' onclick='open_delete_diag($id)' class='btn' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                                    <i class='fas fa-trash'></i>
                                    </button>
                                    </td>
                                    ";
                                }
                                echo "
                                </tr>
                        ";
                    }
                
                ?>
            </tbody>
        </table>
    </div> 

    <div class="m-3 pt-4">
        <h5 class="h6" style="font-weight:650;">LAST 20 ACTIVITIES IN BED AVAILABILITY:</h5>
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
        
        function save_info(id) {
            console.log(id)
            var verification = $(`#${id}-verification`).val()
            var beds = $(`#${id}-beds`).val()
            var bed_oxy = $(`#${id}-beds_with_oxygen`).val()
            var icu = $(`#${id}-icu`).val()
            var icu_ven = $(`#${id}-icu_with_ventilators`).val()

            console.log("v " + verification)

            $.ajax({
                url: "bed_availability_save",
                type: "POST",
                data: {
                    id: id,
                    beds: beds,
                    bed_oxy: bed_oxy,
                    icu: icu,
                    icu_ven: icu_ven,
                    verification: verification,
                },
                datatype: "JSON",
                beforeSend: function() {
                    $(`#${id}-save-btn`).html(`<div class='spinner-border spinner-border-sm  mx-4' role='status'>
                                                 <span class='visually-hidden'>Loading...</span>
                                             </div>`)
                },
                success: function(response) {
                    var res = JSON.parse(response)
                    console.log(res)

                    $("#process_status").html("")
                    $(`#${id}-save-btn`).html("Save")
                    show_notification("Save successfull :)")

                }
            })
        }


        $( document ).ready(function() {
        // Run code
            // add details response
            <?php if((null != session('add_response'))): ?>
                <?php if(session('add_response')== "inserted"): ?>
                    show_notification("Information added successfully!")
                <?php elseif(session('add_response') == 'validation_error'): ?>
                    show_notification("Validation error! Check all the fields properly")
                <?php else: ?>
                    show_notification("Error in inserting information, try again in some time")
                <?php endif; ?>
            <?php endif; ?>


            // delete detail response
            <?php if((null != session('del_response'))): ?>
                <?php if(session('del_response')== "success"): ?>
                    show_notification("Entry deleted successfully!")
                <?php elseif(session('del_response') == 'validation_error'): ?>
                    show_notification("Validation error! Information provided is incorrect!")
                <?php else: ?>
                    show_notification("Error in deleting information, try again.")
                <?php endif; ?>
            <?php endif; ?>
        });
        
        function open_delete_diag(id) {
            var name = $(`#${id}-name`).html()
            $("#ModalLabel").addClass("text-danger").html(`Delete tiffin service from "${name}"?`)

            $("#model-body").html(` Are you sure you want to delete this service?`)

            $("#model-footer").html(`
                <form method='post' action='del_bed_availability'>
                    <input type='hidden' name='number' value=${id}>
                    <button type="button" class="btn " data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger"><i class='fas fa-trash'></i> Delete</button> 

                </form>
            
            `)
        }
    
    
    </script>

<?= $this->endSection('script') ?>
