<div class="row">
    <div class="six columns">
        <div class="panel" style="min-height: 150px; max-height: 150px;">
            <h5>Welcome back <?php echo $user_details['first_name']; ?></h5>
            <?php
            if(!empty($my_modules))
            {
                ?>
                <p>You can click on any on the modules below to manage information regarding that module.</p>
                <?php
            }
            ?>
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
    <?php
    if (empty($my_modules))
    {
        ?>
        <div class="twelve columns">
            <div class="panel">
                <h5>You have not been assigned to teach any modules yet.</h5>
            </div>
        </div>
        <?php
    }
    else
    {
        foreach ($my_modules as $module)
        {
            ?>
            <div class="twelve columns">
                <div class="panel">
                    <h5>Module Title : <?php echo $module['title'] ?></h5>
                    <p>Module Description : <?php echo $module['description'] ?></p>
                    <p style="text-align: right" ><a href="<?php echo base_url() . 'lec/lecturer/manage_module/' . $module['module_id'] ?>" class="radius button"/>Manage</a></p>
                </div>
            </div>
            <?php
        }
    }
    ?>
    <!-- Main Grid Section -->
</div>
<!-- End Grid Section -->