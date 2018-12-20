<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- Own CSS -->
        <link rel="stylesheet" href="/DDWT18/ddwt18_project/css/main.css">

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
                            <select class="form-control col-sm-3" id="inputrole" name="role" required>
                                <option value="" disabled selected hidden>Choose a Role...</option>
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
                            <input type="text" class="form-control" id="inputstudy" name="study" placeholder="Information Science" required>
                        </div>
                        <div class="form-group">
                            <label for="inputlanguage">Language</label>
                            <select class="form-control col-sm-3" data-placeholder="Choose a Language..." required>
                                <option value="" disabled selected hidden>Choose a Language...</option>
                                <option value="Afrikanns">Afrikanns</option>
                                <option value="Afrikanns">Afrikanns</option>
                                <option value="Albanian">Albanian</option>
                                <option value="Arabic">Arabic</option>
                                <option value="Armenian">Armenian</option>
                                <option value="Basque">Basque</option>
                                <option value="Bengali">Bengali</option>
                                <option value="Bulgarian">Bulgarian</option>
                                <option value="Catalan">Catalan</option>
                                <option value="Cambodian">Cambodian</option>
                                <option value="Chinese (Mandarin)">Chinese (Mandarin)</option>
                                <option value="Croation">Croation</option>
                                <option value="Czech">Czech</option>
                                <option value="Danish">Danish</option>
                                <option value="Dutch">Dutch</option>
                                <option class="active" value="English">English</option>
                                <option value="Estonian">Estonian</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finnish">Finnish</option>
                                <option value="French">French</option>
                                <option value="Georgian">Georgian</option>
                                <option value="German">German</option>
                                <option value="Greek">Greek</option>
                                <option value="Gujarati">Gujarati</option>
                                <option value="Hebrew">Hebrew</option>
                                <option value="Hindi">Hindi</option>
                                <option value="Hungarian">Hungarian</option>
                                <option value="Icelandic">Icelandic</option>
                                <option value="Indonesian">Indonesian</option>
                                <option value="Irish">Irish</option>
                                <option value="Italian">Italian</option>
                                <option value="Japanese">Japanese</option>
                                <option value="Javanese">Javanese</option>
                                <option value="Korean">Korean</option>
                                <option value="Latin">Latin</option>
                                <option value="Latvian">Latvian</option>
                                <option value="Lithuanian">Lithuanian</option>
                                <option value="Macedonian">Macedonian</option>
                                <option value="Malay">Malay</option>
                                <option value="Malayalam">Malayalam</option>
                                <option value="Maltese">Maltese</option>
                                <option value="Maori">Maori</option>
                                <option value="Marathi">Marathi</option>
                                <option value="Mongolian">Mongolian</option>
                                <option value="Nepali">Nepali</option>
                                <option value="Norwegian">Norwegian</option>
                                <option value="Persian">Persian</option>
                                <option value="Polish">Polish</option>
                                <option value="Portuguese">Portuguese</option>
                                <option value="Punjabi">Punjabi</option>
                                <option value="Quechua">Quechua</option>
                                <option value="Romanian">Romanian</option>
                                <option value="Russian">Russian</option>
                                <option value="Samoan">Samoan</option>
                                <option value="Serbian">Serbian</option>
                                <option value="Slovak">Slovak</option>
                                <option value="Slovenian">Slovenian</option>
                                <option value="Spanish">Spanish</option>
                                <option value="Swahili">Swahili</option>
                                <option value="Swedish ">Swedish </option>
                                <option value="Tamil">Tamil</option>
                                <option value="Tatar">Tatar</option>
                                <option value="Telugu">Telugu</option>
                                <option value="Thai">Thai</option>
                                <option value="Tibetan">Tibetan</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Turkish">Turkish</option>
                                <option value="Ukranian">Ukranian</option>
                                <option value="Urdu">Urdu</option>
                                <option value="Uzbek">Uzbek</option>
                                <option value="Vietnamese">Vietnamese</option>
                                <option value="Welsh">Welsh</option>
                                <option value="Xhosa">Xhosa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputemail">Email</label>
                            <input type="text" class="form-control" id="inputemail" name="email" placeholder="someone@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="inputphonenumber">Phone number</label>
                            <input type="tel" class="form-control" id="inputphonenumber" name="phonenumber" placeholder="+31612345678" required>
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