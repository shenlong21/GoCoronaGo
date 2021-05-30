<?php
    // extending to the base layout
    echo $this->extend('Site/base');
    
    // setting title of page
    $this->section('head');
        echo "<title>About - Go Corona Go</title>";
    $this->endSection('head');

    // main content goes here
    $this->section('page_content');
?>

<div class="h1 text-center my-3">About</div>


<div class="container-md my-3">

    <div class="mt-4">

        <div class="h4">About Project</div>
        <div class="mx-3">
            <p>This project comprise of a website, intended to provide information about the services that will be
                helpful to a COVID-19 patient. Service includes information like oxygen suppliers, tiffin services, bed
                avilability, plasma donors and few other. A person can visit the respective page and will be able to
                search the required information by the search functionlity at every service page. </p>
        </div>
    </div>

    <div class="mt-4">
        <div class="h4">Tech Used</div>
        <div class="mx-3">
            <i class="fas fa-chevron-right"></i> <a href="https://codeigniter.com/" target="_blank" style="text-decoration: none;">CodeIgniter4</a> - <div class="badge bg-secondary"> backend framework
            </div> <br>
            <i class="fas fa-chevron-right"></i> <a href="https://getbootstrap.com/" target="_blank" style="text-decoration: none;">Bootstrap5 </a> - <div class="badge bg-secondary"> frontend framework
            </div> <br>
            <i class="fas fa-chevron-right"></i> jQuery3.6 <br>
            <i class="fas fa-chevron-right"></i> AJAX <br>
            <i class="fas fa-chevron-right"></i> Font Awesome Icons <br>
            <i class="fas fa-chevron-right"></i> JavaScript <br>
            <i class="fas fa-chevron-right"></i> HTML5 <br>
            <i class="fas fa-chevron-right"></i> CSS3 <br>
            <i class="fas fa-chevron-right"></i> SMTP mail service <br>
        </div>
    </div>

    <div class="mt-4">
        <div class="h4">Work Flow</div>
        <div class="mx-3">
            <div class="h6" style='text-decoration: underline;'>VISITOR</div>
            <p>A visitor can visit the site and can start to search for the information that he/she intend to find.
                Homepage and navigation bar contains links to various service pages that he/she can visit.</p>
            <p>On visiting the respective page one will find a search bar, which contains city and specific place of
                where infirmation to be searched from. Visitor can input the places available and can see the result.
            </p>
            <p>Results are first abstracted, and only inportant information is provided, if visitor need more
                information about the information then he/she can click the "View Details" button to view all
                information about the service.</p>
            <p>If the visitor finds information to be false, then as a measure of quality control, visitor can report
                the information and number of reports is increased by one for the post. </p>
            <p>Report count for every post will be available to public, so one can proceed with precaution if report
                counts are too high.</p>
            <p>If a post gets over 100 reports, then this will be reported to admin and moderators, they can take action
                accordingly.</p>
            <br>
            <div class="h6" style='text-decoration: underline;'>USER</div>
            <p>If one want to contribute to website, he/she can register himself/herself through signup form available
                in navbar, after filling form, that person will recieve a verification email with a verification link,
                visiting that link will activate account of that person.</p>
            <p>After that, that person can login in and can add information about that various services that are
                available.</p>
            <p>However, he will be not able to delete any post, this functionality will only be available to moderators
                and admins.</p>
            <p>One can elevate their rights by requesting it to admin.</p>
            <p>Interface of panel is quite simple, one will get everything quite easily.</p>
        </div>
    </div>

    <div class="mt-4 mb-5">
        <div class="h4">About Me</div>
        <div class="mx-3">
            <p>I am a Computer Engineering student studying in Government Engineering College, Sector 28, Gandhinagar,
                Guajrat, India <a href="https://gecg28.ac.in/" target="_blank"> <i class="fas fa-external-link-alt"></i></a> . Currently
                i am developing my skills to get prepared for future market.</p>
            Github Profile - <a href="https://github.com/shenlong21" target="_blank">shenlong21</a> <br>
            LinkedIn - <a href="https://www.linkedin.com/in/sachin-jangir-6854301a0/" target="_blank">Sachin Jangir</a> <br>
            Email - <a href="mailto:sachinjangir0181@gmail.com">sachinjangir0181@gmail.com</a>
        </div>
    </div>
</div>


<?= $this->endSection('page_content'); ?>