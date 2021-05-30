<?php
    // extending to the base layout
    echo $this->extend('site/base');
    
    // setting title of page
    $this->section('head');
        echo "<title>Rsitration Success - Go Corona Go</title>";
    $this->endSection('head');

    // main content goes here
    $this->section('page_content');
?>

<div class="h1 text-center my-3"> <i class="fas fa-check"></i> Registration Successful</div>
<div class="container pt-4">
    <div class="    ">Thank you, <strong><?= $username ?> </strong> for registring yourself on Go Corona Go.</div>
    <p>A verification will be sent to <strong> <?= $email ?> </strong> with verification link, open that link to activate your account.</p>
    <p>Go to  <a href="<?= base_url('login') ?>">login page</a></p>
</div>


<?= $this->endSection('page_content'); ?>
