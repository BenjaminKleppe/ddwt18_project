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
                <div class="col-md-12">
                    <!-- Error message -->
                    <?php if (isset($error_msg)){echo $error_msg;} ?>

                    <h1><?= $page_title ?></h1>
                    <h5><?= $page_subtitle ?></h5>

                    <div class="pd-15">&nbsp;</div>

                    <form action="/DDWT18/ddwt18_project/register/" method="POST">
                        <div class="form-group">
                            <label for="inputusername">Username</label>
                            <input type="text" class="form-control" id="inputusername" placeholder="j.jansen" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="inputpassword">Password</label>
                            <input type="password" class="form-control" id="inputpassword" placeholder="******" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="inputfirstname">First name</label>
                            <input type="text" class="form-control" id="inputfirstname" placeholder="Jan" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="inputlastname">Last name</label>
                            <input type="text" class="form-control" id="inputlastname" placeholder="Jansen" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="inputrole">Role</label>
                            <select class="form-control" id="inputrole" name="role" required>
                                <option value="owner">Owner</option>
                                <option value="tenant">Tenant</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputdateofbirth">Date of birth</label>
                            <input type="date" class="form-control" id="inputdateofbirth" name="dateofbirth" required>
                        </div>
                        <div class="form-group">
                            <label for="inputstudy">Study</label>
                            <input type="text" class="form-control" id="inputstudy" name="study" required>
                        </div>
                        <div class="form-group">
                            <label for="inputlanguage">Language</label>
                            <input type="text" class="form-control" id="inputlanguage" name="language" required>
                        </div>
                        <div class="form-group">
                            <label for="inputemail">E-mail</label>
                            <input type="text" class="form-control" id="inputemail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="inputphonenumber">Phone number</label>
                            <input type="text" class="form-control" id="inputphonenumber" name="phonenumber" required>
                        </div>
                        <div class="form-group">
                            <label for="inputbiography">Biography</label>
                            <textarea class="form-control" id="inputbiography" rows="3" name="biography" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Register now</button>
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