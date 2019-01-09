<!doctype html>
<html lang="en">
<style>
    #add {
        color: white;
        background: #337ab7;
        border-radius: 12px;
        box-shadow: 0 4px 4px 0 rgba(0,0,0,0.2), 0 4px 4px 0 rgba(0,0,0,0.19)
    }

    #add.button:hover{
        background: #2e4960;
    }

    #dan.btn{
        box-shadow: 0 4px 4px 0 rgba(0,0,0,0.2), 0 4px 4px 0 rgba(0,0,0,0.19)
    }

    #dan.btn:hover{
        background: darkred;
    }

    #war.btn{
        box-shadow: 0 4px 4px 0 rgba(0,0,0,0.2), 0 4px 4px 0 rgba(0,0,0,0.19)
    }

    #war.btn:hover{
        background: gold;
    }
</style>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Own CSS -->
        <link rel="stylesheet" href="/DDWT18/ddwt18_project/css/main.css">

        <title><?= $page_title ?></title>
    </head>
    <style>
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        /* Next & previous buttons */
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            margin-top: -22px;
            padding: 16px;
            background-color: rgba(255,255,255,0.8);
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }


        /* On hover, add a black background color with a little bit see-through */
        .prev:hover, .next:hover {
            background-color: rgba(255,255,255,0.3);
        }

    </style>
    <body>
        <!-- Menu -->
        <?= $navigation ?>

        <!-- Content -->
        <div class="container">

            <div class="row">

                <!-- Left column -->
                <div class="col-md-8 pt-4">
                    <!-- Error message -->
                    <?php if (isset($error_msg)){echo $error_msg;} ?>

                    <h1><?= $page_title ?></h1>
                    <h3>€<?= $price ?>,-</h3>
                    <p><?= $address ?></p>
                    <div class="slideshow-container pb-4">
                        <?= implode(" ", $imagename) ?>
                        <?php if ($checkimage) { ?>
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>

                        <?php } ?>
                    </div>
                    <?php if ($display_buttons) { ?>
                    <?php if ($checkimage) { ?>
                        <div class="pb-4">
                            <form action="/DDWT18/ddwt18_project/removeimages/" method="POST">
                                <input type="hidden" value="<?= $room_id ?>" name="room_id">
                                <a onclick="return confirm('Do you want to delete all images?')"><button type="submit" id="dan" class="btn btn-danger">Remove images</button></a>
                            </form>
                        </div>
                        <?php } ?>
                        <div>
                            <form action="/DDWT18/ddwt18_project/roompics/" method="post" enctype="multipart/form-data">
                                <br/>
                                <label>Select Image to upload</label>
                                <input type="hidden" value="<?= $room_id ?>" name="room_id">
                                <input class="pb-3" type="file" name="image">
                                <input type="submit" value="Add picture to room" name="picture">
                            </form>
                        </div>
                        <div class="row pb-5">
                            <div class="col-sm-2">
                                <a href="/DDWT18/ddwt18_project/edit/?room_id=<?= $room_id ?>" role="button" id="war" class="btn btn-warning">Edit</a>
                            </div>
                            <div class="col-sm-2">
                                <form action="/DDWT18/ddwt18_project/remove/" method="POST">
                                    <input type="hidden" value="<?= $room_id ?>" name="room_id">
                                    <a onclick="return confirm('Do you want to delete this room?')"><button type="submit" id="dan" class="btn btn-danger">Remove</button></a>
                                </form>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!check_owner($db)) { ?>
                        <?php if (!$optincheck) { ?>
                            <div class="pb-5">
                                <a href="/DDWT18/ddwt18_project/contact/?room_id=<?= $room_id ?>" role="button" id="suc" class="btn btn-success">Opt in</a>
                            </div>
                        <?php } ?>
                        <?php if ($optincheck) { ?>
                            <form action="/DDWT18/ddwt18_project/optout/" method="POST">
                                <a onclick="return confirm('Do you want to delete your opt-in?')"><button type="submit" id="dan" class="btn btn-danger">Opt out</button></a>
                            </form>
                        <?php } ?>
                    <?php } ?>
                    <h4>Information about the room:</h4>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">Description</th>
                            <td><?= $description ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Type</th>
                            <td><?= $type ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Size</th>
                            <td><?= $size ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Desired tenant</th>
                            <td><?= $tenant ?></td>
                        </tr>

                        </tbody>
                    </table>
                    <h4>Roomdetails:</h4>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">Living room</th>
                            <td><?= $living ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Kitchen</th>
                            <td><?= $kitchen ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Bathroom</th>
                            <td><?= $bathroom ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Toilet</th>
                            <td><?= $toilet ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Internet</th>
                            <td><?= $internet ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Housemate(s)</th>
                            <td><?= $mate ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Smoking</th>
                            <td><?= $smoke ?></td>
                        </tr>

                        </tbody>
                    </table>
            </div>
                <!-- Right column -->
                <div class="container col-md-4 pt-5">

                    <?php include $right_column ?>

                </div>
        </div>
        <div>
            <br/>
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
            <?php
            $address = str_replace(" ", "+",$address_variable);
            ?>
            <iframe class="pb-3" style="width:100%;height:300px;" frameborder="0" id="cusmap" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $address; ?>&output=embed"></iframe>
            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                <a class="a2a_button_twitter"></a>
                <a class="a2a_button_linkedin"></a>
                <a class="a2a_button_google_gmail"></a>
                <a class="a2a_button_whatsapp"></a>
            </div>
            <script async src="https://static.addtoany.com/menu/page.js"></script>
        </div>

        </div>
        <?php include $footer ?>

            <!-- Optional JavaScript -->
<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
    }
</script>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
    </body>
</html>