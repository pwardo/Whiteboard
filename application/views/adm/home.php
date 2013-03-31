<div class="row">
    <div class="six columns">
        <div class="panel" style="min-height: 150px; max-height: 150px;">
            <h5>Welcome back <?php echo $user_details['first_name']; ?></h5>
                <p>Click on any of the options below.</p>
        </div>
    </div>   
    <div class="six columns">
        <div class="panel" style="min-height: 150px; max-height: 150px;">
            <h5><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></h5>
            <p>
                <b>Username :</b> <?php echo $user_details['username']; ?>
                <br/><b>Email :</b> <?php echo $user_details['email']; ?>
                <br/><b>Date of Birth :</b> <?php echo $user_details['dob']; ?>
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="four columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="<?php echo base_url().'adm/modules/index'; ?>" />Modules</a></h5>
        </div>
    </div>
    <div class="four columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="<?php echo base_url().'adm/lecturers/index'; ?>" />Lecturers</a></h5>
        </div>
    </div>
    <div class="four columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="<?php echo base_url().'adm/students/index'; ?>" />Students</a></h5>
        </div>
    </div>
</div>