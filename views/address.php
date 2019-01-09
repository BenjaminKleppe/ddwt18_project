<!doctype html>
<html lang="en">
<style>
    select: { color: gray; }
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
<body>
<!-- Menu -->
<?= $navigation ?>

<!-- Content -->
<div class="container">
    <div class="row">
        <!-- Left column -->
        <div class="col-md-9 pt-4">
            <!-- Error message -->
            <?php if (isset($error_msg)){echo $error_msg;} ?>

            <h1><?= $page_title ?></h1>
            <h5><?= $page_subtitle ?></h5>
            <p><?= $page_content ?></p>

            <div class="pd-15">&nbsp;</div>
            <form action="<?= $form_action ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="postalCode" class="col-sm-3 col-form-label">Postal code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="9718AV" value="<?php if (isset($room_info)){echo $room_info['postal_code'];} ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="houseNumber" class="col-sm-3 col-form-label">House number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="houseNumber" name="house_number" placeholder="36B" value="<?php if (isset($room_info)){echo $room_info['house_number'];} ?>" required>
                    </div>
                </div>
                <?php if(isset($room_id)){ ?><input type="hidden" name="room_id" value="<?php echo $room_id ?>"><?php } ?>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary"><?= $submit_btn ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

