<?php
    // extending to the base layout
    echo $this->extend('site/base');
    
    // setting title of page
    $this->section('head');
        echo "<title>Email Verification - Go Corona Go</title>";
    $this->endSection('head');

    // main content goes here
    $this->section('page_content');
?>


<?php if(isset($message) && $message == "success"): ?>

    <div class="h1 text-center my-3"> <i class="fas fa-envelope"></i> Email Verification done</div>
    <div class="container py-4">
        <div class="p text-success">Email Verification Done.</div>
        <div class="p">You can now go to <a href="<?= base_url('/login') ?>">  login page </a> and be a Covid Warrior</div>
    </div>
    <div class="d-flex justify-content-center my-4">
        <a class = "btn mx-2" href="<?= base_url() ?>"> <i class="fas fa-home"></i> Home Page</a> 
        <a class = "btn mx-2" href="<?= base_url('login') ?>"> <i class="fas fa-sign-in-alt"></i> login page</a>
        <a href="#" class="btn mx-2"> <i class="fas fa-info-circle"></i> About </a>
    </div>


<?php elseif(isset($message) && $message == "done_already"): ?>
    <div class="h1 text-center my-3"> <i class="fas fa-envelope"></i> Email Already Verified</div>
    <div class="container py-4">
        <div class="p text-success">Your Email Verification is already done.</div>
        <div class="p">You can now go to <a href="<?= base_url('/login') ?>">  login page </a> and be a Covid Warrior</div>
    </div>
    <div class="d-flex justify-content-center my-4">
        <a class = "btn mx-2" href="<?= base_url() ?>"> <i class="fas fa-home"></i> Home Page</a> 
        <a class = "btn mx-2" href="<?= base_url('login') ?>"> <i class="fas fa-sign-in-alt"></i> login page</a>
        <a href="#" class="btn mx-2"> <i class="fas fa-info-circle"></i> About </a>
    </div>


<?php elseif(isset($message) && $message == "error"): ?>
    <div class="h1 text-center my-3"> <i class="fas fa-heart-broken"></i> Error in Email Verification</div>
    <div class="container py-4">
        <div class="p">There seems to be an error from our side.</div>
        <p>We will fix this as soon as possible.</p>
        <div class="p">You can now go to <a href="<?= base_url('/login') ?>">  login page </a> and be a Covid Warrior</div>
    </div>
    <div class="d-flex justify-content-center my-4">
        <a class = "btn mx-2" href="<?= base_url() ?>"> <i class="fas fa-home"></i> Home Page</a> 
        <a class = "btn mx-2" href="<?= base_url('login') ?>"> <i class="fas fa-sign-in-alt"></i> login page</a>
        <a href="#" class="btn mx-2"> <i class="fas fa-info-circle"></i> About </a>
    </div>


<?php else: ?>
    <div class="h1 text-center text-danger my-3">  <i class="fas fa-heart-broken"></i> Invalid Link</div>
    <div class="container py-4 text-center">
        <p>This seems to an invalid link....</p>
        <p>We don't process these kind of links.</p>
        <hr class="my-5">
        <div class="d-flex justify-content-center">
        <a class = "btn mx-2" href="<?= base_url() ?>"> <i class="fas fa-home"></i> Home Page</a> 
        <a class = "btn mx-2" href="<?= base_url('login') ?>"> <i class="fas fa-sign-in-alt"></i> login page</a>
        <a href="#" class="btn mx-2"> <i class="fas fa-info-circle"></i> About </a>

        </div>
    </div>

<?php endif; ?>


<?= $this->endSection('page_content'); ?>
