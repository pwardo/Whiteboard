<!-- Main Grid Section -->

<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <h5><?php echo $module_details['title']; ?></h5>
            <h6><?php echo $module_details['code']; ?></h6>
            <p><?php echo $module_details['description']; ?></p>
<!--            <p style="text-align: right">
                <a href="" class="radius button" data-reveal-id="editModule">Edit</a>
            </p>-->
<!--            <p style="text-align: right"><a href="<?php echo base_url() . 'lec/lecturer/edit_module/' . $module_details['id'] ?>" />Edit</a></p>-->
        </div>
    </div>
</div>

<div class="row">
    <div class="six columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="<?php echo base_url() . 'lec/assessments/index/' . $module_details['id'] ?>" />Assessments</a></h5>
        </div>
    </div>
    <div class="six columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="<?php echo base_url() . 'lec/notes/index/' . $module_details['id'] ?>" />Notes</a></h5>
        </div>
    </div>
</div>
<div class="row">
    <div class="six columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="<?php echo base_url() . 'lec/students/index/' . $module_details['id'] ?>" />Students</a></h5>
        </div>
    </div>
    <div class="six columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="<?php echo base_url() . 'lec/announcements/index/' . $module_details['id'] ?>" />Announcements</a></h5>
        </div>
    </div>
</div>