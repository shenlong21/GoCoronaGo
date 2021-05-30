<?= $this->extend('User/base') ?>
<?= $this->section('head') ?>
    <title>Access Denied - User Panel - Go Corona Go</title>
<?= $this->endSection('head') ?>


<?= $this->section('content') ?>
    <div class="m-3 text-center" >
        <h5 class="h5 my-3"><strong>ACCESS DENIED</strong></h5>
        <hr>
        <div class="text-center">
            This page is out of bounds of your access rights.
            <br>
            <br>
            <br>
        </div>
    </div> 
<?= $this->endSection('content') ?>

<?= $this->section('script') ?>
<?= $this->endSection('script') ?>
