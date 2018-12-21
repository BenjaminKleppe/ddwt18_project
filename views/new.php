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

    <!-- Own CSS -->
    <link rel="stylesheet" href="DDWT18/ddwt18_project/css/main.css">

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
            <h5><?= $page_subtitle ?></h5>
            <p><?= $page_content ?></p>
            <form action="<?= $form_action ?>" method="POST">
                <div class="form-group row">
                    <label for="street" class="col-sm-3 col-form-label">Street</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="street" name="street" placeholder="Grote Markt" value="<?php if (isset($room_info)){echo $room_info['street'];} ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="houseNumber" class="col-sm-3 col-form-label">House number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="houseNumber" name="house_number" placeholder="36B" value="<?php if (isset($room_info)){echo $room_info['house_number'];} ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postalCode" class="col-sm-3 col-form-label">Postal code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="postalCode" name="postalcode" placeholder="9718AV" value="<?php if (isset($room_info)){echo $room_info['postal_code'];} ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-sm-3 col-form-label">City</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="city" name="city" placeholder="Groningen" value="<?php if (isset($room_info)){echo $room_info['city'];} ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type" class="col-sm-3 col-form-label"> Select type: </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="type" name="type">
                            <option value="" disabled selected hidden>Choose a type...</option>
                            <option value="room">Room</option>
                            <option value="apartment">Apartment</option>
                            <option value="studio">Studio</option>
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
                    <label for="facilities" class="col-sm-3 col-form-label"> Select your facilities: </label>
                    <div class="col-sm-3 col-form-label">
                        <input type="checkbox" id="facilities" name="facilities[]" value="Kitchen"> Kitchen<br>
                        <input type="checkbox" id="facilities" name="facilities[]" value="Wi-Fi"> Wi-Fi<br>
                        <input type="checkbox" id="facilities" name="facilities[]" value="Dishwasher"> Dishwasher<br>
                        <input type="checkbox" id="facilities" name="facilities[]" value="Private"> Private bathroom<br>
                        <input type="checkbox" id="facilities" name="facilities[]" value="Shared"> Shared bathroom<br>
                        <input type="checkbox" id="facilities" name="facilities[]" value="Shower"> Shower<br>
                        <input type="checkbox" id="facilities" name="facilities[]" value="Furniture"> Furniture<br>
                        <input type="checkbox" id="facilities" name="facilities[]" value="Stove"> Stove<br>
                        <input type="checkbox" id="facilities" name="facilities[]" value="Microwave"> Microwave<br>
                        <input type="checkbox" id="facilities" name="facilities[]" value="living"> Shared living room<br>
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


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
