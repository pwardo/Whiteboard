<!-- Main Grid Section -->
<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <h5><?php echo $module_details['title'] ?>, <?php echo $module_details['code']; ?></h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="twelve columns">
        <?php
        if (empty($module_students))
        {
            ?>
            <div class="panel">
                <h5>No students have enrolled for this module yet.</h5>
            </div>
            <?php
        }
        else
        {
            ?>
            <table class="twelve">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Email</th>
                        <th>Continuous Assessment Mark</th>
                        <th></th>
                    </tr>
                </thead>

                <?php
                foreach ($module_students as $module_student)
                {
                    ?>
                    <tr>
                        <td><?php echo $module_student['student_number']; ?></td>
                        <td><?php echo $module_student['first_name'] . ' ' . $module_student['last_name']; ?></td>
                        <td><?php echo $module_student['dob']; ?></td>
                        <td><?php echo $module_student['email']; ?></td>
                        <td><?php echo 'ca_mark'; ?></td>
                        <td>
                            <button type="submit" id="updateButton" class="small alert button">Remove <i class="foundicon-remove"></i></button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
        ?>
    </div>
</div>
