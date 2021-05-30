<?php
    // extending to the base layout
    echo $this->extend('site/base');
    
    // setting title of page
    $this->section('head');
        echo "<title>Tiffin Services - Go Corona Go</title>";
    $this->endSection('head');

    // main content goes here
    $this->section('page_content');
?>

<div class="h1 text-center my-3"><i class='fas fa-database'></i> Tiffin Services</div>


<!-- form -->
<div class="col-md-6 my-4 m-auto">
    <div  class="row g-3 p-2">
        <div class="col-md-4">
            <select class="form-select  " name="city" id="city">
                <option class="form-control" value="ahmedabad">Ahmedabad</option>
            </select>
        </div>
        <div class="col-md-5">
            <select class="form-select" name="place" id="place">
                <option class="form-control" value="all_places">All Places</option>
                <?php                    
                    foreach ($places as $p ) {                        
                        $name = $p['name'];
                            echo "<option class='form-control' value='$name' >$name</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-success" id="supply_search" onclick="fetch_suppliers()">Search</button>
        </div>
    </div>
    <hr>
</div>


<!-- display number of rows -->
<div class="container-md" id="result_summary"></div>

  
<!-- results container -->
<div class="container-lg" id="result_area"></div>

<!-- main content end -->
<?= $this->endSection('page_content'); ?>


<!-- custom scripts -->
<?= $this->section('custom_script') ?>

    <script>
        // ajax start script
        $( document ).ajaxStart(function() {
            $( "#result_summary" ).html( `<h4 class='h4 text-center'><div class="spinner-border" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                        </div> Fetching data... </h4>` );
                                        
            $( "#result_area" ).html("");

            $( "#supply_search").prop("disabled", true).html("Searching...")
        });

        

        function fetch_suppliers() {

            // $(document).on("click", "#oxygen_supply_search", function(){
            city_input = $("#city").val()
            place_value = $("#place").val()

            
            
            $.ajax({
                url: "tiffin_search",
                type: "POST",
                // headers: {'X-Requested-With': 'XMLHttpRequest'},
                data: {
                    city: city_input,
                    place: place_value
                },
                dataType: "JSON",
                success: function(response) {
                    // console.log("something retunr")

                    response_count = response.length

                    $("#result_summary").html(`<h4 class='h4'>Found ${response_count} supplier(s): </h4>`)
                    $("#result_area").html("")
                    $( "#supply_search").prop("disabled", false).html("Search")


                    if (response_count == 0) {
                        $("#result_area").css("display", "block")
                                                .addClass("text-muted")
                                                .addClass("text-center")                                               
                                                .html("<i class='fas fa-heart-broken fa-4x mb-2 mt-5'></i>")
                        
                        resultLine = document.createElement('div')
                        $(resultLine).html("<h4>No information found, try searching nearby areas </h4>").appendTo($("#result_area"))
                    }

                    response.forEach(element => {
                        // style="display:flex; flex-wrap: wrap;"
                        $("#result_area").css("display", "flex")
                                                .css("flex-wrap", "wrap")
                                    

                        wrapperDiv = document.createElement('div')  
                        $(wrapperDiv).addClass('col-md-6')
                                    .appendTo($("#result_area"))

                        // console.log("done")
                        
                        card = document.createElement('div')
                        $(card).addClass('m-3').addClass('card').appendTo($(wrapperDiv))

                        cardHeader = document.createElement('div')
                        $(cardHeader).addClass('card-header')
                                    .addClass('py-3')
                                    .css('text-transform', 'uppercase')
                                    .css('font-weight', '650')
                                    .html(` <i class='fas fa-chevron-right'></i> ${element['name']}`)
                                    // .html(`oxygen: ${element['oxygen_left']}, verification: ${element['verification']} updated at : ${element['updated_at']} `)
                                    .appendTo($(card))
                                    
                        cardBody = document.createElement('div')
                        $(cardBody).addClass('card-body').appendTo($(card))
                        
                        cardTable = document.createElement('table')
                        $(cardTable).addClass('table').appendTo($(cardBody))  
                        
                        tableBody = document.createElement('tbody')
                        $(tableBody).appendTo($(cardTable))
                        
                        let tableColumn = ["<i class='fas fa-address-card'></i> Address", 
                                            "<i class='fas fa-asterisk'></i> Description",  
                                            "<i class='fas fa-check'></i> Verification", 
                                            "<i class='fas fa-history'></i> Updated", 
                                            "<i class='fas fa-globe'></i> Place"]

                        let tableContents = ['address', 'description', 'verification', 'ago', 'pincode']
                        
                        for (let index = 0; index < tableColumn.length; index++) {
                            let col = tableColumn[index];
                            let val = element[tableContents[index]];

                            tr = document.createElement('tr')
                            $(tr).appendTo($(tableBody))
                            
                            td1 = document.createElement('td')
                            $(td1)
                                  .html(` ${col}`).appendTo($(tr))
                            
                            td2 = document.createElement('td')
                            $(td2).html(` - ${val}`).appendTo($(tr))
                        }

                        // tableContents.forEach(item => {
                        //     tr = document.createElement('tr')
                        //     $(tr).appendTo($(tableBody))
                            
                        //     td1 = document.createElement('td')
                        //     $(td1).css("text-transform", "capitalize").html(item).appendTo($(tr))
                            
                        //     td2 = document.createElement('td')
                        //     $(td2).html(` - ${element[item]}`).appendTo($(tr))
                            
                        // })
                        
                        form = document.createElement('form')
                        $(form).prop("action", "post")
                        .prop("method", "get")
                        .appendTo($(cardBody))
                        
                        inputCategory = document.createElement('input')
                        $(inputCategory).prop('type', 'hidden')
                        .prop('name', 'category')
                        .prop('value', 'tiffin_service')
                        .appendTo($(form))
                        
                        inputNumber = document.createElement('input')
                        $(inputNumber).prop('type', 'hidden')
                        .prop('name', 'number')
                        .prop('value', element['id']).appendTo($(form))
                        
                        submitButton = document.createElement('button')
                        $(submitButton).addClass('btn')
                        .prop('type', 'submit')
                        .html('<i class="fas fa-file"></i> View Details')
                        .appendTo($(form))
                        
                        cardFooter = document.createElement('div')
                        $(cardFooter).addClass('card-footer')
                        .append(`<span > <i class='fas fa-phone-alt'></i> <a href='tel:${element['phone']}'> ${element['phone']}</a></span> |`)
                        .append(`<span> <i class='fas fa-envelope'></i> <a href='mailto:${element['email']}'> ${element['email']}</a></span> |`)
                        .append(`<span> <i class='fab fa-whatsapp'></i> ${element['whatsapp']}</span>`)
                        .appendTo($(card))
                        
                    });
                }
            });
        }
        
        window.onload =  fetch_suppliers()

    </script>


<?= $this->endSection('custom_script') ?>
