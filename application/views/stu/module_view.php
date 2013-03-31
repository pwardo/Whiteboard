<!-- Main Grid Section -->
<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <h5><?php echo $module_details['title']; ?></h5>
            <h6>Module Code : <?php echo $module_details['code']; ?></h6>
            <h6>Module Lecturer : 
                <?php
                if (!empty($module_lecturer))
                {
                    echo $module_lecturer['first_name'] . ' ' . $module_lecturer['last_name'];
                }
                else
                {
                    echo 'Lecturer has not yet been assigned.';
                }
                ?>
            </h5>
            <p><?php echo $module_details['description']; ?></p>
            <dl class="contained tabs">
                <dd class="active">
                    <a href="#assignments">Assignments</a>
                </dd>
                <dd>
                    <a href="#exams">Exams</a>
                </dd>
                <dd>
                    <a href="#notes">Notes</a>
                </dd>
                <dd>
                    <a href="#announcements">Announcements</a>
                </dd>

                <dd>
                    <a href="#grades">My Grades</a>
                </dd>
            </dl>
            <ul class="tabs-content contained">
                <li id="assignmentsTab" class="active" style="background-color: white;">
                    <?php
                    if (empty($module_assignments))
                    {
                        ?>
                        <div class="panel">
                            <h5>Your lecturer has not added any assignment yet.</h5>
                        </div>
                        <?php
                    }
                    else
                    {
                        foreach ($module_assignments as $module_assignment)
                        {
                            ?>
                            <div class="panel">
                                <h5><?php echo $module_assignment['title']; ?></h5>
                                <table>
                                    <tr style="width: 100%;">
                                        <td style="text-align:center; width: 25%"><b>Date: </b><?php echo $module_assignment['date']; ?></td>
                                        <td style="text-align:center; width: 50%"><b> | </b></td>

                                        <?php
                                        if (!empty($module_assignment['file_name']))
                                        {
                                            ?>
                                            <td style="text-align: center; width: 25%">
                                                <a href="<?php echo base_url() . 'uploads/module_notes/' . $module_details['id'] . '/assignments/'.$module_assignment['id']. '/' . $module_assignment['file_name']; ?>" />Download</a>
                                            </td>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <td style="text-align: center; width: 25%"><b>No Document</b></td>
                                            <?php
                                        }
                                        ?> 

                                    </tr>
                                </table>
                                <p><b>Percentage of overall mark: </b><?php echo $module_assignment['assessment_weighting']; ?>%</p>

                                <?php
                                if ($module_assignment['description'] !== '')
                                {
                                    ?>
                                    <p><b>Description: </b><br/><?php echo $module_assignment['description']; ?></p>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </li>

                <li id="examsTab" style="background-color: white;">
                    <?php
                    if (empty($module_exams))
                    {
                        ?>
                        <div class="panel">
                            <h5>Your lecturer has not scheduled any exams yet.</h5>
                        </div>
                        <?php
                    }
                    else
                    {
                        foreach ($module_exams as $module_exam)
                        {
                            ?>
                            <div class="panel">
                                <h5><?php echo $module_exam['title']; ?></h5>
                                <table>
                                    <tr style="width: 100%;">
                                        <td style="text-align:center;"><b>Date: </b><?php echo $module_exam['date']; ?></td>
                                        <td style="text-align:center;"><b>Start Time: </b><?php echo substr($module_exam['start_time'], 0, 5); ?></td>
                                        <td style="text-align:center;"><b>End Time: </b><?php echo substr($module_exam['end_time'], 0, 5); ?></td>
                                    </tr>
                                </table>
                                <p><b>Percentage of overall mark: </b><?php echo $module_exam['assessment_weighting']; ?>%</p>

                                <?php
                                if ($module_exam['description'] !== '')
                                {
                                    ?>
                                    <p><b>Description: </b><br/><?php echo $module_exam['description']; ?></p>
                                    <?php
                                }
                                ?>
                            </div>     
                            <?php
                        }
                    }
                    ?>
                </li>
                <li id="notesTab" style="background-color: white;">
                    <?php
                    if (empty($module_notes))
                    {
                        ?>
                        <div class="panel">
                            <h5>Your lecturer has not added any notes yet.</h5>
                        </div>
                        <?php
                    }
                    else
                    {
                        foreach ($module_notes as $note)
                        {
                            ?>
                            <div class="panel">
                                <h5><?php echo $note['id'] . ', ' . $note['file_name'] ?></h5>
                                <p style="text-align: right">
                                    <a href="<?php echo base_url() . 'uploads/module_notes/' . $module_details['id'] . '/' . $note['file_name'] ?>" />Download</a>
                                </p>
                            </div>                
                            <?php
                        }
                    }
                    ?>
                </li>

                <li id="announcementsTab" style="background-color: white;">
                    <?php
                    if (empty($module_announcements))
                    {
                        ?>
                        <div class="panel">
                            <h5>Your lecturer has not added any notes yet.</h5>
                        </div>
                        <?php
                    }
                    else
                    {
                        foreach ($module_announcements as $announcement)
                        {
                            ?>
                            <div class="panel">
                                <h5><?php echo $announcement['title']; ?></h5>
                                <p><?php echo $announcement['content'];?></p>
                          
                            </div>                
                            <?php
                        }
                    }
                    ?>
                </li>

                <li id="gradesTab" style="background-color: white;">
                    <p>Grades</p>
                </li>
            </ul>            
        </div>
    </div>
</div>