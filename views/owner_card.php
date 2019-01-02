<!-- Room count -->
<?php if ($disp_buttons) { ?>
<div class="card">
    <div class="card-header">
        Owner
    </div>
    <div class="card-body">
        <h2><?= $added_by ?></h2>
        <p></p>
        <p>Birth Date: <?= $birthdate ?></p>
        <p>Language: <?= $language ?></p>
        <p>Email: <?= $email ?></p>
        <p>Phone number: <?= $phonenumber ?></p>
    </div>
</div>
<?php } ?>
<?php if ($display_buttons) { ?>
<div class="card">
    <div class="card-header">
        Users that have opt-in for this room:
    </div>
    <div class="card-body">
        <?= $optinusers ?>
    </div>
</div>
<?php } ?>

