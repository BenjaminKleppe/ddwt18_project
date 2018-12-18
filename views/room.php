<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- Own CSS -->
        <link rel="stylesheet" href="/DDWT18/week2/css/main.css">

        <title><?= $page_title ?></title>
    </head>
    <body>
        <!-- Menu -->
        <?= $navigation ?>

        <!-- Content -->
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="pd-15">&nbsp</div>
            <?= $breadcrumbs ?>

            <div class="row">

                <!-- Left column -->
                <div class="col-md-8">
                    <!-- Error message -->
                    <?php if (isset($error_msg)){echo $error_msg;} ?>

                    <h1><?= $page_title ?></h1>
                    <h3>€<?= $price ?>,-</h3>
                    <p><?= $address ?></p>
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
                            <th scope="row">Facilities</th>
                            <td><?= $facilities ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Desired tenant</th>
                            <td><?= $tenant ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Location</th>
                            <td><div id="googleMap" style="width:100%;height:400px;"></div></td>
                        </tr>

                        </tbody>
                    </table>
                    <?php if ($display_buttons) { ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="/DDWT18/week2/edit/?serie_id=<?= $serie_id ?>" role="button" class="btn btn-warning">Edit</a>
                        </div>
                        <div class="col-sm-2">
                            <form action="/DDWT18/week2/remove/" method="POST">
                                <input type="hidden" value="<?= $serie_id ?>" name="serie_id">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                    <?php } ?>

            </div>
        </div>


        <!-- Optional JavaScript -->
            <script>
                function myMap() {
                    var mapProp= {
                        center:new google.maps.LatLng(51.508742,-0.120850),
                        zoom:5,
                    };
                    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
                }
            </script>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
    </body>
</html>