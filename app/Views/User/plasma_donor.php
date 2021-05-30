<?= $this->extend('User/base') ?>
<?= $this->section('head') ?>
    <title>Plasma Donor - User Panel - Go Corona Go</title>
<?= $this->endSection('head') ?>


<?= $this->section('content') ?>
    
    <div class="m-3" >
        <div class="d-flex justify-content-between">
        <h5 class="h5 my-3"><strong>PLASMA DONORS</strong></h5>
        <button class="btn " type="button" data-bs-toggle="collapse" data-bs-target="#oxygen-supplier-form" aria-expanded="false" aria-controls="oxygen-supplier-form"> <i class="fas fa-plus"></i> Add Donor</button>
        </div>
        <hr>

        <!-- <div class="my-3 mx-5" id="process_status"></div> -->
        <div class="collapse my-3 col-lg-9 col-md-11 col-sm-12 col-xl-7 mx-lg-5 mb-4" id="oxygen-supplier-form">

            <form  method="post" action = "<?= base_url('/user/add_plasma_donor') ?>">
                <div class="row mb-3">
                    <label class="col-form-label col-sm-2 col-sm-2" for="name">Name</label>  
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="add_name" id="name" required autocomplete="off" >
                    </div>
                </div> 

                <div class="row mb-3">
                <label class="col-form-label col-sm-2" for="phone">Phone </label>
                    <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input class="form-control  " type="text" name="add_phone" id="phone" required onkeypress="return (event.charCode > 47 && event.charCode < 58)">
                    </div>
                        <div class="form-text" id="phone-feedback"></div>
                    </div>
                </div>

                <div class="row mb-3">
                <label class="col-form-label col-sm-2" for="whatsapp">Whatsapp </label>
                    <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input class="form-control  " type="text" name="add_whatsapp" id="whatsapp" required onkeypress="return (event.charCode > 47 && event.charCode < 58)">
                    </div>
                        <div class="form-text" id="phone-feedback"></div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-form-label col-sm-2" for="age">Age </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" name="add_age" id="age"  required>                                
                    </div>
                </div>

                <div class="row mb-3">
                <label class="col-form-label col-sm-2" for="verification">Verification </label>
                    <div class="col-sm-10">
                        <select class="form-select" name="add_verification" id="verification">
                            <option value="0">Not Verified</option>
                            <option value="1">Verified</option>
                        </select>
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-form-label col-sm-2" for="pincode">PIN </label>
                    <div class="col-sm-10">
                        <!-- <input class="form-control" type="number" name="add_pincode" id="pincode"  required>  -->
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
                    <label class="col-form-label col-sm-2" for="city">City </label>
                    <div class="col-sm-10">
                        <select class="form-select" name="add_city" id="city">
                            <option value="ahmedabad">Ahmedabad</option>                            
                        </select>    
                    </div>
                </div>

                <div class="d-flex justify-content-end pb-4">
                    <button type="submit" class="btn border" id="submit">Add Donor</button>
                </div>
            </form>
            <hr>
        </div>



        <div class="h6">CURRENT DONORS</div>
        <table class="table table-striped">
            <thead class="thead thead-dark">
                <tr>
                    <td>City</td>
                    <td>Name</td>
                    <td>Phone</td>
                    <td>Age</td>
                    <td>Verification</td>
                    <td>Reports</td>
                    <!-- <td>Edit</td> -->
                    <td>Save</td>
                    <?php if( session('access') >= 2): ?>
                        <td>Delete</td>
                    <?php endif; ?>
                </tr>
            </thead>

 <!-- Example split danger button -->
 <!-- <div class='btn-group'>
  <button type='button' class='btn  dropdown-toggle dropdown-toggle-split' data-bs-toggle='dropdown' aria-expanded='false'>
  <span class='visually-hidden'>Toggle Dropdown</span>
  </button>
  <ul class='dropdown-menu'>
  <li><a class='dropdown-item' href='#'>Action</a></li>
  <li><a class='dropdown-item' href='#'>Another action</a></li>
  <li><a class='dropdown-item' href='#'>Something else here</a></li>
  <li><hr class='dropdown-divider'></li>
  <li><a class='dropdown-item' href='#'>Separated link</a></li>
  </ul>
  </div>
  $oxygen_left   -->

            <tbody>
                <?php 
                    foreach ($details as $d ) {
                        $id = $d['id'];
                        $city = $d['city'];
                        $name = $d['name'];
                        $phone = $d['phone'];
                        $age = $d['age'];
                        // $oxygen_left = $d['oxygen_left'];
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


                        // $oxygen_left_options = [-1 => 'No Information', 0 => 'Not available', 1 => 'Low', 2 => 'Average', 3 => 'Available'];
                        $verification_options = [0 => 'Not verified', 1 => 'Verified'];

                        echo "
                            <tr>
                                <td>$city</td>
                                <td id='$id-name'>$name</td>
                                <td>$phone</td>                                
                                <td>$age</td>                                
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
        <h5 class="h6" style="font-weight:650;">LAST 20 ACTIVITIES IN PLASMA DONORS:</h5>
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
        // $( document ).ajaxStart(function() {
        //     $( "#process_status" ).html( `  <div class='d-flex align-items-center justify-content-end'> <div class='spinner-border  mx-4' role='status'>
        //                                         <span class='visually-hidden'>Loading...</span>
        //                                     </div> <div class='pl-3'> Processing Request.</div><hr></div>` )
        // })

        function save_info(id) {
            console.log(id)
            var oxygen = $(`#${id}-oxygen`).val()
            var verification = $(`#${id}-verification`).val()

            console.log("ox " + oxygen)
            console.log("v " + verification)

            $.ajax({
                url: "plasma_donor_save",
                type: "POST",
                data: {
                    id: id,
                    oxygen_left: oxygen,
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
            $("#ModalLabel").addClass("text-danger").html(`Delete entry of "${name}"?`)

            $("#model-body").html(` Are you sure you want to delete this entry?`)

            $("#model-footer").html(`
                <form method='post' action='del_plasma_donor'>
                    <input type='hidden' name='number' value=${id}>
                    <button type="button" class="btn " data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger"><i class='fas fa-trash'></i> Delete</button> 

                </form>
            
            `)
        }
    
    
    </script>

<?= $this->endSection('script') ?>
