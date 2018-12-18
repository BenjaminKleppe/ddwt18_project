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
                    <h5><?= $page_subtitle ?></h5>
                    <p><?= $page_content ?></p>
                    <form action="<?= $form_action ?>" method="POST">
                        <div class="form-group row">
                            <label for="street" class="col-sm-3 col-form-label">Street</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="street" name="street" value="<?php if (isset($room_info)){echo $room_info['street'];} ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="houseNumber" class="col-sm-3 col-form-label">House number<br/>(e.g. 34A)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="houseNumber" name="house_number" value="<?php if (isset($room_info)){echo $room_info['house_number'];} ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postalCode" class="col-sm-3 col-form-label">Postal code<br/>(e.g. 9711AN)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="postalCode" name="postalcode" value="<?php if (isset($room_info)){echo $room_info['postal_code'];} ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="city" name="city" value="<?php if (isset($room_info)){echo $room_info['city'];} ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="type" class="col-sm-3 col-form-label"> Select type: </label>
                            <div class="col-sm-3">
                                <select class="form-control" id="type">
                                    <option value="room">Room</option>
                                    <option value="apartment">Apartment</option>
                                    <option value="studio">Studio</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-3 col-form-label">Price in €</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="price" name="price" value="<?php if (isset($room_info)){echo $room_info['price'];} ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="size" class="col-sm-3 col-form-label">Size in m2</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="size" name="size" value="<?php if (isset($room_info)){echo $room_info['size'];} ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDescription" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="inputDescription" rows="3" name="description" required><?php if (isset($room_info)){echo $room_info['description'];} ?></textarea>
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

                <!-- Right column -->
                <!--
                <div class="col-md-4">

                    <?php include $right_column ?>

                </div>
                -->

            </div>
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>