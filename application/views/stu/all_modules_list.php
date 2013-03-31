<div class="row">   

    <?php
//    echo '<pre>';
//    print_r($all_modules);
    
    if (empty($all_modules))
    {
        ?>
        <div class="twelve columns">
            <div class="panel">
                <h5>You haven't enrolled to any modules yet.</h5>
                <p>Click find modules in the navigation bar to view a list of available modules.</p>
            </div>
        </div>
        <?php
    }
    else
    {
        foreach ($all_modules as $module)
        {
            ?>
            <div class="twelve columns">
                <div class="panel">
                    <h5>Module Title : <?php echo $module['title']; ?></h5>
                    <p>Code : <?php echo $module['code']; ?></p>
                    <p>Description : <?php echo $module['description']; ?></p>
                    <p>Lecturer : <?php echo $module['first_name'].' '. $module['last_name'];?></p>
                    <p style="text-align: right" >

                        <?php
                        // if the user is already enrolled to some modules
                        if (!empty($my_modules))
                        {
                            // check is user is enrolled to this module and change button if true
                            $count = 0;
                            foreach ($my_modules as $my_module)
                            {
                                if ($module['id'] === $my_module['id'])
                                {
                                    $count = $count + 1;
                                }
                            }

                            if ($count != 0)
                            {
                                ?>
                                <a href="<?php echo base_url() . 'stu/student/module_un_enroll/' . $module['id'] ?>" class="alert button"/>Un-Enroll <i class="foundicon-remove"></i></a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="<?php echo base_url() . 'stu/student/module_enroll/' . $module['id'] ?>" class="radius button"/>Enroll <i class="foundicon-plus"></i></a>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <a href="<?php echo base_url() . 'stu/student/module_enroll/' . $module['id'] ?>" class="radius button"/>Enroll</a>
                            <?php
                        }
                        ?>
                    </p>
                </div>
            </div>                    
            <?php
        }
    }
    ?>

    <!-- Main Grid Section -->

</div>
<!-- End Grid Section -->