<?php
    // extending to the base layout
    echo $this->extend('site/base');
    
    // setting title of page
    $this->section('head');
    $name = $p['name'];
        echo "<title>$name - Go Corona Go | Posts</title>";
    $this->endSection('head');

    // main content goes here
    $this->section('page_content');
?>

<div class="h1 text-center my-2">
    <?= $p['name'] ?>
    <br>
    <span class="h3">
        ( <?=$category ?> )
    </span>

</div>
<div class="m-auto my-3 text-center">
    <a href="tel:<?=$p['phone']?>" class='btn btn-sm'><i class='fas fa-phone-alt'></i> Call</a>
    <?php if(isset($p['email'])): ?>
        <a href="mailto:<?=$p['email']?>" class='btn btn-sm '><i class='fas fa-envelope'></i> Send Email</a>
    <?php endif; ?>
    <a href="whatsapp://send?text=<?=$p['whatsapp']?>" data-action="share/whatsapp/share" class='btn btn-sm'><i
            class='fab fa-whatsapp'></i> Share via Whatsapp</a>
</div>
<!-- <div class="text-center mb-2 h3"></div> -->
<div class="col-md-7 m-auto mt-3">
    <?php 
            $verification = "";
            $availability = "";
            $updated_at = null;             

            if($p['verification'] == 0)
                $verification = '<span class="badge bg-warning"> <i class="fas fa-mobile"></i> Not Verified</span>';
            else
                $verification = '<span class="badge bg-success"> <i class="fas fa-mobile"></i> Phone Verified</span>';

            
            // setting oxygen_left attribute for front end
            if( isset($p['oxygen_left'])){

                if($p['oxygen_left'] == 3)
                    $availability = '<span class="badge bg-success"> <i class="fas fa-atom"></i> Oxygen Available</span>';
                else if($p['oxygen_left'] == 2)
                    $availability = '<span class="badge bg-info"> <i class="fas fa-atom"></i> Moderate Amount Available</span>';
                else if( $p['oxygen_left'] == 1)
                    $availability = '<span class="badge bg-danger"> <i class="fas fa-atom"></i> Oxygen Amount Low</span>';
                else if ($p['oxygen_left'] == 0)
                    $availability = '<span class="badge bg-secondary"> <i class="fas fa-atom"></i> No Oxygen</span>';
                else
                    $availability = '<span class="badge bg-secondary"> <i class="fas fa-atom"></i> No information about oxygen</span>';
            }

            // setting bed availability
            if( isset($p['bed_available'])){
                // setting bed_available attribute for front end
                if($p['bed_available'] > 100)
                    $availability = '<span class="badge bg-success"> <i class="fas fa-atom"></i> Beds Available )'.$p['bed_available'].')</span>';
                else if($p['bed_available'] > 50)
                    $availability = '<span class="badge bg-info"> <i class="fas fa-atom"></i> Moderate Amount of beds Available ('.$p['bed_available'].')</span>';
                else if( $p['bed_available'] > 20)
                    $availability = '<span class="badge bg-danger"> <i class="fas fa-atom"></i> Few Beds left ('.$p['bed_available'].')</span>';
                else if ($p['bed_available'] == 0)
                    $availability = '<span class="badge bg-secondary"> <i class="fas fa-atom"></i> No Beds ('.$p['bed_available'].')</span>';
                else
                    $availability = '<span class="badge bg-secondary"> <i class="fas fa-atom"></i> No information about Beds</span>';                                
            }

            // setting oxygen availability from bed availability
            if( isset($p['oxygen'])){                   // keeping next two data in one as those comes from same table so will be available
                $oxygen = $p['oxygen'];
                $icu = $p['icu'];
                $icu_with_ventilator = $p['icu_with_ventilator'];


                // oxygen available
                if($oxygen > 0)
                    $oxygen = '<span class="badge bg-success">'.$oxygen.'</span>';
                else
                    $oxygen = '<span class="badge bg-secondary">'.$oxygen.'</span>';
                
                
                // icu
                if($p['icu'] > 0)
                    $icu = '<span class="badge bg-success">'.$icu.'</span>';                
                else 
                    $icu = '<span class="badge bg-secondary">'.$icu.'</span>';
                

                // // icu with ventilator
                if($p["icu_with_ventilator"] > 0 ) {
                    // $icu_with_ventilator = 1;
                    $icu_with_ventilator =  '<span class="badge bg-success"> '.$icu_with_ventilator.'</span>';
                }
                else {
                    $icu_with_ventilator = '<span class="badge bg-secondary"> '.$icu_with_ventilator.'</span>';
                }

            }


            // setting updated time             
            $date_db = date_create_from_format('Y-m-d H:i:s', $p['updated_at']);
            $updated_ago = date_format($date_db, 'd-m-Y | H:i:s');
            $updated = '<span class="badge bg-info">  <i class="fas fa-clock"></i>'.$updated_ago.'</span>';
            
            // setting reports
            if($p['reports'] > 80) 
                $p['reports'] = '<span class="badge bg-danger">'.$p['reports'].'</span>';
            else if ( $p['reports'] > 40)
                $p['reports'] = '<span class="badge bg-warning">'.$p['reports'].'</span>';


            
    ?>
    <div class="table-responsive m-2">
        <table class='table table-borderless table-hover table-striped'>
            <tbody>
                <tr>
                    <td>Name</td>
                    <td><?=$p['name']?></td>
                    <!-- <td></td> -->
                </tr>
                <?php if(isset($p['address'])): ?>
                <tr>
                    <td>Address</td>
                    <td><?=$p['address']?></td>
                    <!-- <td></td> -->
                </tr>
                <?php endif; ?>
                <?php if(isset($p['description'])): ?>
                <tr>
                    <td>Description</td>
                    <td><?=$p['description']?></td>
                    <!-- <td></td> -->
                </tr>
                <?php endif; ?>
                <tr>
                    <td>Phone Number</td>
                    <td><?=$p['phone']?></td>
                </tr>
                <?php if(isset($p['email'])): ?>
                <tr>
                    <td>Email</td>
                    <td><?=$p['email']?></td>
                </tr>
                <?php endif; ?>

                <tr>
                    <td>Whatsapp</td>
                    <td><?=$p['whatsapp']?></td>
                </tr>
                <?php 
                if(isset($p['bed_available'])){
                    echo "
                        <tr>
                        <td>No of Beds</td>
                        <td>$availability</td>
                        <!-- <td></td> -->
                        </tr>
                    ";
                }
            ?>
                <?php 
                if(isset($p['oxygen_left'])){
                    echo "
                        <tr>
                        <td>Oxygen Levels</td>
                        <td>$availability</td>
                        <!-- <td></td> -->
                        </tr>
                    ";
                }
             ?>
                <?php 

                if(isset($p['oxygen'])){
                    echo "
                        <tr>
                        <td>Beds with Oxygen</td>
                        <td>$oxygen</td>
                        <!-- <td></td> -->
                        </tr>
                    ";
                }

                if(isset($p['icu'])){
                    echo "
                        <tr>
                        <td>ICU</td>
                        <td>$icu</td>
                        <!-- <td></td> -->
                        </tr>
                    ";
                }

                if(isset($p['icu_with_ventilators'])){
                    echo "
                        <tr>
                        <td>ICU with ventilators</td>
                        <td>$icu_with_ventilator</td>
                        <!-- <td></td> -->
                        </tr>
                    ";
                }
           
                
            ?>

                <tr>
                    <td>Phone verification</td>
                    <td><?=$verification?></td>
                    <!-- <td></td> -->
                </tr>
                <tr>
                    <td>Date Updated</td>
                    <td><?=$updated?></td>
                    <!-- <td></td> -->
                </tr>
                <tr>
                    <td>First Informed On</td>
                    <td><?=$p['created_at']?></td>
                    <!-- <td></td> -->
                </tr>
                <tr>
                    <td>City</td>
                    <td style='text-transform: capitalize;'><?=$p['city']?></td>
                    <!-- <td></td> -->
                </tr>
                <?php if(isset($p['pincode'])): ?>
                <tr>
                    <td>Pin</td>
                    <td><?=$p['pincode']?></td>
                    <!-- <td></td> -->
                </tr>
                <?php endif; ?>

                <tr>
                    <td>Reports</td>
                    <td><?=$p['reports']?></td>
                </tr>
            </tbody>
        </table>

        <div class="mt-5 mx-2 justify-text">
            <hr>
            <form action="<?= base_url()?>/report_post" method='post'>
                <input type="hidden" value="<?= $previous_page ?>" name="category">
                <input type="hidden" value=<?=$p['id']?> name="number">
                <button class='btn' type='submit'><i class='fas fa-flag'></i> Report false information</button>
            </form>
            <div class="text-muted ">Report only when you find any false information, unnecessry reporting will render
                people of not getting useful information.</div>
        </div>

    </div>
    <hr>
    <div class="text-center my-4">
        <button class="btn btn-lg"><i class='fas fa-paper-plane'></i> Share this page </button> <br>


    </div>
    <div class="text-center my-4">
        <a href='<?= base_url("$previous_page")?>' class="btn btn-md"><i class='fas fa-chevron-left'></i> Go Back </a> |
        <a href='<?= base_url()?>' class="btn btn-md"><i class='fas fa-home'></i> Home Page </a>
    </div>

</div>

<?= $this->endSection('page_content'); ?>

<?= $this->section('custom_script') ?> 
    <script>
    $( document ).ready(function() {
        // Run code
        // add details response
        <?php if((null != session('report_response'))): ?>
            <?php if(session('report_response')== "success"): ?>
                show_notification("Post reported successfully!")            
            <?php else: ?>
                show_notification("Error in reporting post, try again in some time")
            <?php endif; ?>
        <?php endif; ?>
    })
    </script>

<?= $this->endSection('custom_script'); ?>

