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

<div class="h1 text-center my-3">Some Error Occured!</div>
<p class="text-center"><a href="<?=base_url() ?>">Click Here</a> to go to home page.</p>

<?= $this->endSection('page_content'); ?>