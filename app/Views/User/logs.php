<?= $this->extend('User/base') ?>
<?= $this->section('head') ?>
    <title>Users - User Panel - Go Corona Go</title>
<?= $this->endSection('head') ?>


<?= $this->section('content') ?>

    <div class="m-3" >
        <h5 class="h5 my-3"><strong>LOGS</strong></h5>
        <hr>

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


<?= $this->endSection('script') ?>
