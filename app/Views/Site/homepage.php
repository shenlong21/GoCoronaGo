<?php
    // extending to the base layout
    echo $this->extend('site/base');
    
    // setting title of page
    $this->section('head');
        echo "<title>Go Corona Go</title>";
    $this->endSection('head');

    // main content goes here
    $this->section('page_content');
?>

<!-- Image of website -->

<img src="<?= base_url('/assets/img/corona-headline.jpg') ?>" alt="Together We Will Fight With Corona"
    width="100%" height="200px" style="margin-top: 3rem;  position: absolute;
        left: 0px;
        top: 0px;
        z-index: -1;">

<div class="container-md bg-white mb-3" style="margin-top: 4rem; border: 2px rgb(92, 52, 52) solid;">
    <div class="text-center h2 m-4">
        TOGETHER LETS FIGHT WITH CORONA
        <p class="lead mt-2">We provide Information regarding following</p>

        <div class="w-75 m-auto">
            <hr>
        </div>

    </div>
    <div class="" style="display: flex; flex-wrap: wrap; justify-content: center;">
        <div class="m-3 p-3" style=" width: 200px; border: 0px red solid;">
            <a style="text-decoration:none;color:inherit;" href="<?= base_url('oxygen_supply') ?>">
                <i class="fas fa-lungs fa-7x mb-2"></i>
                <div class="heading lead">
                    Oxygen Supply
                </div>
                <p class="text-muted">Information about oxygen Avaiability around ahmedabad</p>
            </a>
        </div>

        <div class="m-3 p-3" style=" width: 200px; border: 0px red solid;">
            <a style="text-decoration:none;color:inherit;" href="<?= base_url('tiffin_service') ?>">
                <i class="fas fa-database fa-7x mb-2"></i>
                <div class="heading lead">
                    Tiffin Services
                </div>
                <p class="text-muted">Information about tiffin services around ahmedabad</p>
            </a>
        </div>

        <div class="m-3 p-3" style=" width: 200px; border: 0px red solid;">
            <a style="text-decoration:none;color:inherit;" href="<?= base_url('bed_availability') ?>">
                <i class="fas fa-bed fa-7x mb-2"></i>
                <div class="heading lead">
                    Beds Availability
                </div>
                <p class="text-muted">Information about Beds Availability around ahmedabad</p>
            </a>
        </div>

        <div class="m-3 p-3" style=" width: 200px; border: 0px red solid;">
            <a style="text-decoration:none;color:inherit;" href="<?= base_url('plasma_donor') ?>">
                <i class="fas fa-hand-holding-water fa-7x mb-2"></i>
                <div class="heading lead">
                    Plasma Donors
                </div>
                <p class="text-muted">Information about plasma doners around ahmedabad</p>
            </a>
        </div>

        <div class="m-3 p-3" style=" width: 200px; border: 0px red solid;">
            <a style="text-decoration:none;color:inherit;" href="#">
                <i class="fas fa-syringe fa-7x mb-2"></i>
                <div class="heading lead">
                    Vaccination Drives
                </div>
                <p class="text-muted">Coming Soon</p>
            </a>
        </div>

        <div class="m-3 p-3" style=" width: 200px; border: 0px red solid;">
            <a style="text-decoration:none;color:inherit;" href="#">
                <i class="fas fa-vials fa-7x mb-2"></i>
                <div class="heading lead">
                    Testing Centers
                </div>
                <p class="text-muted">Coming Soon</p>
            </a>
        </div>

        <div class="m-3 p-3" style=" width: 200px; border: 0px red solid;">
            <a style="text-decoration:none;color:inherit;" href="#">
                <i class="fas fa-hospital fa-8x mb-2"></i>
                <div class="heading lead">
                    Covid Hospitals
                </div>
                <p class="text-muted">Coming Soon</p>
            </a>
        </div>

        <div class="m-3 p-3" style=" width: 200px; border: 0px red solid;">
            <a style="text-decoration:none;color:inherit;" href="#">
                <i class="fas fa-clinic-medical fa-6x mb-2"></i>
                <div class="heading lead">
                    Home Treatment Facility
                </div>
                <p class="text-muted">Coming Soon.</p>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection('page_content'); ?>