<!doctype html>
<html lang="en">
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
    <body>
        <!-- Menu -->
        <?= $navigation ?>

        <!-- Content -->
        <div class="container">

            <div class="row">

                <!-- Left column -->
                <div class="col-md-8">
                    <!-- Error message -->
                    <?php if (isset($error_msg)){echo $error_msg;} ?>
                    <h1><?= $page_title ?></h1>
                    <h4><?= $page_subtitle ?></h4>
                    <p><?= $page_content ?></p>
                    <?php if(isset($left_content)){echo $left_content;} ?>
                </div>
                <!-- Right column -->
                <div class="container col-sm-12 col-md-4">

                    <div class="col-sm-12 col-md-12">
                        <div class="card row">
                            <div class="card-header">
                                Rooms
                            </div>
                            <div class="card-body">
                                <p class="count">There are already</p>
                                <h2><?= $nbr_rooms ?></h2>
                                <p>rooms for you to look at!</p>
                                <a href="/DDWT18/ddwt18_project/add/" class="btn btn-primary">List yours</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="card row">
                            <div class="card-header">
                                Users
                            </div>
                            <div class="card-body">
                                <p class="count">Our community already has</p>
                                <h2><?= $nbr_users ?></h2>
                                <p>active users</p>
                                <a href="/DDWT18/ddwt18_project/register/" class="btn btn-primary">Join now</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="page-footer font-small blue-grey lighten-5">

            <div style="background-color: #grey;">
                <div class="container">

                    <!-- Grid row-->
                    <div class="row py-4 d-flex align-items-center">

                </div>
            </div>

            <!-- Footer Links -->
            <div class="container text-center text-md-left mt-5" style="background-color: #337ab7">

                <!-- Grid row -->
                <div class="row mt-3 dark-grey-text" style="color:white">

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mb-4">

                        <!-- Content -->
                        <h6 class="text-uppercase font-weight-bold">InterRooms</h6>
                        <hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <p>The best platform for internationals to connect with each other and get a home in the city of Groningen</p>

                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

                        <!-- Links -->
                        <h6 class="text-uppercase font-weight-bold">Products</h6>
                        <hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <p>Rooms</p>
                        <p>Apartments</p>
                        <p>Studio's</p>

                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4" style="color: white">

                        <!-- Links -->
                        <h6 class="text-uppercase font-weight-bold">Useful links</h6>
                        <hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <p>
                            <a class="dark-grey-text" href="https://toerisme.groningen.nl/en/about-groningen/city-of-groningen" style="color: white">More about Groningen</a>
                        </p>
                        <p>
                            <a class="dark-grey-text" href="https://www.rug.nl/" style="color: white">University of Groningen</a>
                        </p>
                        <p>
                            <a class="dark-grey-text" href="https://www.hanze.nl" style="color: white">HBO Groningen</a>
                        </p>

                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

                        <!-- Links -->
                        <h6 class="text-uppercase font-weight-bold">Contact</h6>
                        <hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <p>
                            <i class="fas fa-home mr-3"></i> Groningen, 9718 SG, NL</p>
                        <p>
                            <i class="fas fa-envelope mr-3"></i> info@interrooms.com</p>
                        <p>
                            <i class="fas fa-phone mr-3"></i> + 31 06 34763524</p>

                    </div>
                    <!-- Grid column -->

                </div>
                <!-- Grid row -->

            </div>
            <!-- Footer Links -->

            <!-- Copyright -->
            <div class="footer-copyright text-center text-black-50 py-3" >© 2018 Copyright:
                <a class="dark-grey-text" href="https://mdbootstrap.com/education/bootstrap/"> InterRooms.com</a>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>