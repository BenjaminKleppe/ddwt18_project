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
        <div class="col-md-8 pt-4">
            <!-- Error message -->
            <?php if (isset($error_msg)){echo $error_msg;} ?>
            <h4>Information about the room:</h4>
            <table class="table">
                <tbody>
                <tr>
                    <th scope="row">Address</th>
                    <td><?= $address ?></td>
                </tr>
                <tr>
                    <th scope="row">Owner</th>
                    <td><?= $owner ?></td>
                </tr>
                </tbody>
            </table>
            <h4>Your profile:</h4>
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

                </tbody>
            </table>
            <form action="/DDWT18/ddwt18_project/contact/" method="POST">
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea class="form-control" id="message" rows="3" name="message" placeholder="Write here your message to the owner..." required></textarea>
                </div>
                <?php if ($display_buttons) {} ?>
                <input type="hidden" value="<?= $room_id ?>" name="room_id">
                <button type="submit" id="suc" class="btn btn-success">Opt in</button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
</body>
</html>