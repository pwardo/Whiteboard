<!-- Main Grid Section -->

<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <h5><?php echo $module_details['title'] ?>, <?php echo $module_details['code'] ?></h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="six columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="<?php echo base_url() . 'lec/lecturer/manage_module/' . $module_details['id'] ?>" />Back to Manage Module</a></h5>
        </div>
    </div>
    <div class="six columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="<?php echo base_url() . 'lec/notes/add_notes/'  . $module_details['id'] ?>" />Add Notes</a></h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="twelve columns">
        <?php if (!$module_notes)
        {
            ?>
            <div class="panel">
                <h5>You have not add any notes for this module.</h5>
            </div>
            <?php
        }
        else{
            foreach ($module_notes as $note){
                ?>
                <div class="panel">
                    <h5><?php echo $note['id'].', '. $note['file_name'] ?></h5>
                    <p style="text-align: right">
                        <a href="<?php echo base_url(). 'uploads/module_notes/'. $module_details['id'] .'/'. $note['file_name'] ?>" />Download</a>
                    </p>
                </div>                
                <?php
            }
        }
        ?>

    </div>
</div>