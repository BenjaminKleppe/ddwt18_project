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
                    <label for="street" class="col-sm-3 col-form-label">Street</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="street" name="street" placeholder="Grote Markt" value="<?= $street ?>" disabled required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="houseNumber" class="col-sm-3 col-form-label">House number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="houseNumber" name="house_number" placeholder="36B" value="<?= $number ?>" disabled required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postalCode" class="col-sm-3 col-form-label">Postal code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="postalCode" name="postal_code" placeholder="9718AV" value="<?= $postal_code ?>" disabled required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-sm-3 col-form-label">City</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="city" name="city" placeholder="Groningen" value="<?= $city ?>" disabled required>
                    </div>
                </div>
                <?php if (!isset($room_info['room_id'])) { ?>
                <div class="form-group row">
                    <label></label>
                    <div class="col-sm-10 p-3 m-3">
                        <a id="add" href="/DDWT18/ddwt18_project/add" class="button py-3 px-3">Not the right address, click here...</a>
                    </div>
                </div>
                <?php } ?>
                <div class="form-group row">
                    <label for="type" class="col-sm-3 col-form-label"> Select type: </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="type" name="type">
                            <option value="<?php if (isset($room_info)){echo $room_info['type'];} else {echo "";} ?>" hidden><?php if (isset($room_info)){echo $room_info['type'];} else {echo "Choose a type...";} ?></option>
                            <option value="Room">Room</option>
                            <option value="Apartment">Apartment</option>
                            <option value="Studio">Studio</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class="col-sm-3 col-form-label">Price in €</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="price" name="price" placeholder="375" value="<?php if (isset($room_info)){echo $room_info['price'];} ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="size" class="col-sm-3 col-form-label">Size in m2</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="size" name="size" placeholder="20" value="<?php if (isset($room_info)){echo $room_info['size'];} ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="living" class="col-sm-3 col-form-label"> Living room: </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="living" name="living">
                            <option value="<?php if (isset($room_info)){echo $room_info['living'];} else {echo "";}?>" hidden><?php if (isset($room_info)){echo $room_info['living'];} else {echo "Choose one...";} ?></option>
                            <option value="Shared">Shared</option>
                            <option value="None">None</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kitchen" class="col-sm-3 col-form-label"> Kitchen </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="kitchen" name="kitchen">
                            <option value="<?php if (isset($room_info)){echo $room_info['kitchen'];} else {echo "";}?>" hidden><?php if (isset($room_info)){echo $room_info['kitchen'];} else {echo "Choose one...";} ?></option>
                            <option value="Shared">Shared</option>
                            <option value="Privat">Private</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bathroom" class="col-sm-3 col-form-label"> Bathroom </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="bathroom" name="bathroom">
                            <option value="<?php if (isset($room_info)){echo $room_info['bathroom'];} else {echo "";}?>" hidden><?php if (isset($room_info)){echo $room_info['bathroom'];} else {echo "Choose one...";} ?></option>
                            <option value="Shared">Shared</option>
                            <option value="Private">Private</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="toilet" class="col-sm-3 col-form-label"> Toilet </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="toilet" name="toilet">
                            <option value="<?php if (isset($room_info)){echo $room_info['toilet'];} else {echo "";}?>" hidden><?php if (isset($room_info)){echo $room_info['toilet'];} else {echo "Choose one...";} ?></option>
                            <option value="Shared">Shared</option>
                            <option value="Private">Private</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="internet" class="col-sm-3 col-form-label"> Internet </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="internet" name="internet">
                            <option value="<?php if (isset($room_info)){echo $room_info['internet'];} else {echo "";}?>" hidden><?php if (isset($room_info)){echo $room_info['internet'];} else {echo "Choose one...";} ?></option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mate" class="col-sm-3 col-form-label"> Housemate(s) </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="mate" name="mate">
                            <option value="<?php if (isset($room_info)){echo $room_info['mate'];} else {echo "";}?>" hidden><?php if (isset($room_info)){echo $room_info['mate'];} else {echo "Choose one...";} ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value=">6">>6</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="smoke" class="col-sm-3 col-form-label"> Smoking </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="smoke" name="smoke">
                            <option value="<?php if (isset($room_info)){echo $room_info['smoke'];} else {echo "";}?>" hidden><?php if (isset($room_info)){echo $room_info['smoke'];} else {echo "Choose one...";} ?></option>
                            <option value="Allowed">Allowed</option>
                            <option value="Not allowed">Not allowed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDescription" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="inputDescription" rows="3" placeholder="Write here your description of the room..." name="description" required><?php if (isset($room_info)){echo $room_info['description'];} ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputtenant" class="col-sm-3 col-form-label">Desired tenant:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="inputtenant" rows="3" placeholder="Write here your description of the desired tenant..." name="tenant" required><?php if (isset($room_info)){echo $room_info['tenant'];} ?></textarea>
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

<?php include $footer ?>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

