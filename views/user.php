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
<body style="padding-bottom: 5%">
<!-- Menu -->
<?= $navigation ?>

<!-- Content -->
<div class="container">

    <div class="row">

        <!-- Left column -->
        <div class="col-md-7 pt-4">
            <!-- Error message -->
            <?php if (isset($error_msg)){echo $error_msg;} ?>
            <h1><?= $page_title ?></h1>
            <div class="col-md-12 py-3">
                <div class="card">
                    <div class="card-header">
                        Account details:
                    </div>
                    <div class="card-body">
                        <div style="text-align: center"><?= implode(" ", $imagename) ?></div>
                        <p><?php if ($display_buttons) { ?>
                            <?php if ($checkprofileimage) { ?>
                        <div class="pb-4">
                            <form action="/DDWT18/ddwt18_project/removeuserpic/" method="POST">
                                <input type="hidden" value="<?= $user ?>" name="user_id">
                                <a onclick="return confirm('Do you want to delete your profile picture Y/N')"><button type="submit" class="btn btn-danger">Remove profile picture</button></a>
                            </form>
                        </div>
                        <?php } ?>
                        <?php if (!$checkprofileimage) { ?>
                            <div class="pb-4">
                                <form action="/DDWT18/ddwt18_project/userpic/" method="post" enctype="multipart/form-data">
                                    <br/>
                                    <label>Select Image to upload</label>
                                    <input type="hidden" value="<?= $user ?>" name="user_id">
                                    <input class="pb-3" type="file" name="image">
                                    <input type="submit" value="Add profile picture" name="picture">
                                </form>
                            </div>
                        <?php } ?>
                        <?php } ?>
                        <div class="pt-4">
                            <h4>User profile:</h4>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td><?= $name ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Language</th>
                                    <td><?= $user_language ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Study</th>
                                    <td><?= $user_study ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Birth date</th>
                                    <td><?= $user_dob ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Phone number</th>
                                    <td><?= $user_phone ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td><?= $user_mail ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Biography</th>
                                    <td><?= $user_bio ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($display_buttons) { ?>
                            <div class="pb-2">
                                <a href="/DDWT18/ddwt18_project/editdet/" class="btn btn-primary">Edit details</a>
                            </div>
                            <div>
                                <form action="/DDWT18/ddwt18_project/removeaccount/" method="POST">
                                    <input type="hidden" value="<?= $user_id ?>" name="user_id">
                                    <a onclick="return confirm('Do you want to delete your account Y/N')"><button type="submit" class="btn btn-danger">Remove account</button></a>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($display_buttons) { ?>
        <?php if (check_owner($db)) { ?>
            <div class="col-md-12 py-3">
                <div class="card">
                    <div class="card-header">
                        Offered rooms
                    </div>
                    <div class="card-body">
                        <p>The rooms you offered.</p>
                        <?= $offeredrooms ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

</div>

<?php include $footer ?>

<!-- Optional JavaScript -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
</body>
</html>