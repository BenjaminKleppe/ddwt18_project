<?php if ($disp_buttons) { ?>
<div class="card">
    <div class="card-header">
        Owner
    </div>
    <div class="card-body">
        <div class="ml-4 pb-4"><h2><?= $added_by ?></h2></div>
        <div>
            <div class="pb-4" style="text-align: center"><?= implode(" ", $profilepicture) ?></div>
        </div>
        <div class="pb-4">
            <div class="col-md-6">
                <p><strong>Birth Date: </strong></p>
                <p><strong>Language: </strong></p>
                <p><strong>Email: </strong></p>
                <p><strong>Phone number: </strong></p>
            </div>
            <div class="col-md-6">
                <p><?= $birthdate ?></p>
                <p><?= $language ?></p>
                <p><?= $email ?></p>
                <p><?= $phonenumber ?></p>
            </div>
            <p><a href="<?= $ownerlink ?>" role="button" class="col-md-6 btn btn-primary ml-4 mt-4">Owner info</a></p>
        </div>
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

