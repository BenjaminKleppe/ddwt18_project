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
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12 pt-4">
                <!-- Error message -->
                <?php if (isset($error_msg)){echo $error_msg;} ?>

                <h1><?= $page_title ?></h1>
                <h5><?= $page_subtitle ?></h5>
            </div>

        </div>
    </div>
</div>

<!-- Left content -->
<div class="container">
    <div class="pd-15">&nbsp;</div>
    <div class="col-md-7">
        <div class="row">
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
            <?php if (!check_owner($db)) { ?>
            <div class="col-md-12 pt-3">
                <div class="card">
                    <div class="card-header">
                        Opt-in rooms
                    </div>
                    <div class="card-body">
                        <p>The rooms you opt-in for.</p>
                        <?= $optinrooms ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>


    <div class="col-sm-12 col-md-5">
        <div class="col-md-12 py-3">
            <div class="card">
                <div class="card-header">
                    Welcome, <?= $usern ?>
                </div>
                <div class="card-body">
                    <p>You're logged in to Rooms overview.</p>
                    <a href="/DDWT18/ddwt18_project/logout/" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>

        <div class="col-md-12 py-3">
            <div class="card">
                <div class="card-header">
                    Your account details:
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="col-md-8 pb-4"><?= implode(" ", $imagename) ?></div>
                    </div>
                    <?php if ($display_buttons) { ?>
                        <?php if ($checkprofileimage) { ?>
                        <div class="">
                            <form action="/DDWT18/ddwt18_project/removeuserpic/" method="POST">
                                <input type="hidden" value="<?= $user ?>" name="user_id">
                                <a onclick="return confirm('Do you want to delete your profile picture?')"><button type="submit" class="btn btn-danger">Remove profile picture</button></a>
                            </form>
                        </div>
                        <?php } ?>
                    <?php if (!$checkprofileimage) { ?>
                        <div class="pb-2">
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

                    <div class="pb-4">
                        <div class="col-md-6">
                            <p><strong>First name:</strong></p>
                            <p><strong>Last name: </strong></p>
                            <p><strong>Role: </strong></p>
                            <p><strong>Date of birth: </strong></p>
                            <p><strong>Biography: </strong></p>
                            <p><strong>Study: </strong></p>
                            <p><strong>Language: </strong></p>
                            <p><strong>E-mail: </strong></p>
                            <p><strong>Phone number: </strong></p>
                        </div>
                        <div class="col-md-6 pb-4">
                            <p><?= $user_first ?></p>
                            <p><?= $user_last ?></p>
                            <p><?= $user_role ?></p>
                            <p><?= $user_dob ?></p>
                            <p><?= $user_bio ?></p>
                            <p><?= $user_study ?></p>
                            <p><?= $user_language ?></p>
                            <p><?= $user_mail ?></p>
                            <p><?= $user_phone ?></p>
                        </div>
                    </div>

                    <div class="pb-3">
                        <a href="/DDWT18/ddwt18_project/editdet/" class="btn btn-primary">Edit details</a>
                    </div>
                    <div>
                        <form action="/DDWT18/ddwt18_project/removeaccount/" method="POST">
                            <input type="hidden" value="<?= $user_id ?>" name="user_id">
                            <a onclick="return confirm('Do you want to delete your account?')"><button type="submit" class="btn btn-danger">Remove account</button></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $footer ?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

