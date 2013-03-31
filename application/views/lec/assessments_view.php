<!-- Main Grid Section -->
<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <h5><?php echo $module_details['title'] ?>, <?php echo $module_details['code']; ?></h5>
        </div>
    </div>
</div>
<?php
//echo '<pre>';
//print_r($module_assignments);
?>
<div class="row">
    <div class="six columns">
        <div class="panel">
            <h5 style="text-align: center"><a href="" data-reveal-id="addAssignment">Add a New Assignment</a></h5>
        </div>
    </div>    
    <div class="six columns">
        <div class="panel">
            <h5 style="text-align: center;"><a href="" data-reveal-id="scheduleExam">Schedule a New Exam</a></h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="six columns">
        <?php
        if (!$module_assignments)
        {
            ?>
            <div class="panel">
                <h5>You have not add any notes for this module.</h5>
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
                                <td style="text-align: center; width: 25%"><b>
                                    <a href="<?php echo base_url() . 'lec/assessments/add_assignment_doc/' . $module_details['id'] . '/' . $module_assignment['id']; ?>" />Upload Document</a></b>
                                </td>
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
                    <p style="text-align: center;" >
                        <a href="" class="radius button"  data-reveal-id="editAssignment-<?php echo $module_assignment['id']; ?>">Edit</a>
                    </p>                    
                </div>

                <!-- Edit an assignment ------------------------------------------------------------------------------------- -->
                <?php $id = $module_assignment['id']; ?>
                <div class="reveal-modal" id="editAssignment-<?php echo $id; ?>">
                    <form id="assignment_update_form-<?php echo $id; ?>" action="<?php echo base_url() . 'lec/assessments/edit_assignment'; ?>" method="POST">

                        <label for="assignmentTitle">Assignment Title: (i.e. class assignment, final assignment)</label>
                        <input type="hidden" id="assignmentID-<?php echo $id; ?>" name="assignmentID" value="<?php echo $module_assignment['id']; ?>"/>         
                        <input type="text" id="assignmentTitle-<?php echo $id; ?>" name="assignmentTitle" value="<?php echo $module_assignment['title']; ?>" />
                        <small id="validateAssignmentTitle-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <label for="assignmentDate">Assignment date: </label>
                        <input type="text" id="assignmentDate-<?php echo $id; ?>" name="assignmentDate" class="twelve" value="<?php echo $module_assignment['date']; ?>" />
                        <small id="validateAssignmentDate-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <label for="assessmentWeighting-<?php echo $id; ?>">Percentage of Overall Assessment: </label>
                        <input type="text" id="assessmentWeighting-<?php echo $id; ?>" name="assessmentWeighting" class="twelve" value="<?php echo $module_assignment['assessment_weighting']; ?>" />
                        <small id="validateAssessmentWeighting-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <label for="assignmentDescription-<?php echo $id; ?>">Assignment Description: </label>
                        <textarea style="max-width: 100%;" id="assignmentDescription-<?php echo $id; ?>" name="assignmentDescription" ><?php
        if ($module_assignment['description'])
        {

            echo $module_assignment['description'];
        }
        else
        {
            echo '(Optional)';
        }
                ?></textarea>
                        <small id="validateAssignmentDescription-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <small id="validateAssignmentSubmit-<?php echo $id; ?>" style="display:none" id="error_msg" class="error"></small>

                        <p style="text-align: right;" >
                            <button type="submit" id="updateButton-<?php echo $id; ?>" class="radius button">Update <i class="foundicon-edit"></i></button>
                        </p>
                    </form>
                    <a href="" class="close-reveal-modal">&times;</a>
                </div>

                <script type="text/javascript">
                    $("#assignmentTitle-<?php echo $id; ?>").keyup(function(){                                        
                        if($("#assignmentTitle-<?php echo $id; ?>").val().length >= 4)
                        {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>lec/assessments/check_assessment_title",
                                data: "assessmentTitle="+$("#assignmentTitle-<?php echo $id; ?>").val(),
                                success: function(msg){
                                    if(msg){
                                        document.getElementById('validateAssignmentTitle-<?php echo $id; ?>').innerHTML=msg;
                                        $('#validateAssignmentTitle-<?php echo $id; ?>').show('normal', 'linear');  
                                    }
                                    else
                                    {
                                        $('#validateAssignmentTitle-<?php echo $id; ?>').hide('normal', 'linear');
                                    }
                                }
                            });
                        }
                    });
                                                                                                                                                                    
                                                                                                                                                                    
                    $("#assignmentDate-<?php echo $id; ?>").keyup(function(){                                        
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>lec/assessments/check_assessment_date",
                            data: "assessmentDate="+$("#assignmentDate-<?php echo $id; ?>").val(),
                            success: function(msg){
                                if(msg){
                                    document.getElementById('validateAssignmentDate-<?php echo $id; ?>').innerHTML=msg;
                                    $('#validateAssignmentDate-<?php echo $id; ?>').show('normal', 'linear');  
                                }
                                else
                                {
                                    $('#validateAssignmentDate-<?php echo $id; ?>').hide('normal', 'linear');
                                }
                            }
                        });
                    });
                                                                                                                                    
                                                                                                                                    
                    //  compares the assessment weighting to existing weightings to ensure total does not exceed 100%                    $("#assessmentWeighting-<?php echo $id; ?>").keyup(function(){  
                    $("#assessmentWeighting-<?php echo $id; ?>").keyup(function(){  
                        var assessmentWeighting = $("#assessmentWeighting-<?php echo $id; ?>").val();
                        var moduleID = <?php echo $module_details['id']; ?>;
                        var assignmentID = $("#assessmentWeighting-<?php echo $id; ?>").siblings("#assignmentID-<?php echo $id; ?>").val();
                                                                                                                                                            
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>lec/assessments/check_assessment_weighting",
                            data: {
                                'assessmentWeighting': assessmentWeighting,
                                'moduleID': moduleID,
                                'assignmentID': assignmentID
                            },
                            success: function(msg){
                                if(msg){
                                    document.getElementById('validateAssessmentWeighting-<?php echo $id; ?>').innerHTML=msg;
                                    $('#validateAssessmentWeighting-<?php echo $id; ?>').show('normal', 'linear');                        
                                }
                                else{
                                    $('#validateAssessmentWeighting-<?php echo $id; ?>').hide('normal', 'linear');
                                }
                            }
                        });           
                                                                                                                                                            
                    });
                                                                            
                    // check desctipion does not exceed 255 characters
                    $("#assignmentDescription-<?php echo $id; ?>").keyup(function(){                                        
                        if($("#assignmentDescription-<?php echo $id; ?>").val().length >= 2)
                        {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>lec/assessments/check_assessment_description",
                                data: "assessmentDescription="+$("#assignmentDescription-<?php echo $id; ?>").val(),
                                success: function(msg){
                                    if(msg){
                                        document.getElementById('validateAssignmentDescription-<?php echo $id; ?>').innerHTML=msg;
                                        $('#validateAssignmentDescription-<?php echo $id; ?>').show('normal', 'linear');                        
                                    }
                                    else{
                                        $('#validateAssignmentDescription-<?php echo $id; ?>').hide('normal', 'linear');
                                    }
                                }
                            });
                        }
                    });
                                                            
                                                            
                    $('#assignment_update_form-<?php echo $id; ?>').submit(function(event){
                        event.preventDefault();
                        /* get some values from elements on the page: */

                        var $form = $( this ),
                        assignmentID = $form.find('input[id="assignmentID-<?php echo $id; ?>"]').val(),
                        moduleID = <?php echo $module_details['id']; ?>,
                        assessmentTitle = $form.find('input[id="assignmentTitle-<?php echo $id; ?>"]').val(),
                        assessmentDate = $form.find('input[id="assignmentDate-<?php echo $id; ?>"]').val(),
                        assessmentWeighting = $form.find("#assessmentWeighting-<?php echo $id; ?>").val(),
                        assessmentDescription = $form.find('textarea[id="assignmentDescription-<?php echo $id; ?>"]').val(),
                        url = $form.attr( 'action' );

                        var request = $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                'assignmentID': assignmentID,
                                'moduleID': moduleID,
                                'assessmentTitle': assessmentTitle,
                                'assessmentDate': assessmentDate,
                                'assessmentWeighting' : assessmentWeighting,
                                'assessmentDescription' : assessmentDescription
                            },
                            cache:false,
                            dataType: 'json'
                        });
                                                                                                                                       
                        request.always(function(msg) {
                            if(msg.responseText != 'everything is good to go'){
                                document.getElementById('validateAssignmentSubmit-<?php echo $id; ?>').innerHTML=msg.responseText;
                                $('#validateAssignmentSubmit-<?php echo $id; ?>').show('normal', 'linear');
                                //display login error message 
                            }
                            else
                            {
                                $('#validateAssignmentSubmit-<?php echo $id; ?>').hide('normal', 'linear');
                                $('#scheduleAssignment-<?php echo $id; ?>').hide('normal', 'linear');
                                window.location.reload(true);
                            }
                        });
                    });                     
                </script>
                <?php
            } //  END OF foreach ($module_assignments as $module_assignment)
        }
        ?>
    </div>
    <!-- Edit an assignment END -------------------------------------------------------------------------------- -->        

    <div class="six columns">
        <?php
        if (!$module_exams)
        {
            ?>
            <div class="panel">
                <h5>You have not scheduled any exams for this module.</h5>
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
                    <?php }
                    ?>
                    <p style="text-align: center;" >
                        <a href="" class="radius button"  data-reveal-id="editExam-<?php echo $module_exam['id']; ?>">Edit</a>
                    </p>
                </div>        
                <!-- End Grid Section ----------------------------------------------------------------------------------->


                <!-- Edit an exam --------------------------------------------------------------------------------------->
                <?php $id = $module_exam['id']; ?>
                <div class="reveal-modal" id="editExam-<?php echo $id; ?>">
                    <form id="exam_update_form-<?php echo $id; ?>" action="<?php echo base_url() . 'lec/assessments/edit_exam'; ?>" method="POST">

                        <label for="examTitle">Exam Title: (i.e. class exam, final exam)</label>
                        <input type="hidden" id="examID-<?php echo $id; ?>" name="examID" value="<?php echo $module_exam['id']; ?>"/>         
                        <input type="text" id="examTitle-<?php echo $id; ?>" name="examTitle" value="<?php echo $module_exam['title']; ?>" />
                        <small id="validateExamTitle-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <label for="examDate">Exam date: </label>
                        <input type="text" id="examDate-<?php echo $id; ?>" name="examDate" class="twelve" value="<?php echo $module_exam['date']; ?>" />
                        <small id="validateExamDate-<?php echo $id; ?>" class="error" style="display: none"></small>
                        <label for="examStartTime">Exam Start Time: </label>
                        <select id="examStartTime-<?php echo $id; ?>" name="examStartTime" class="twelve" />
                        <?php
                        foreach ($times as $time)
                        {
                            if ($time === substr($module_exam['start_time'], 0, 5))
                            {
                                echo '<option value=' . substr($module_exam['start_time'], 0, 5) . ' selected >' . substr($module_exam['start_time'], 0, 5) . '</option>';
                            }
                            else
                            {
                                echo '<option value=' . $time . '>' . $time . '</option>';
                            }
                        }
                        ?>

                        </select>
                        <p></p>
                        <small id="validateStartTime-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <label for="examEndTime-<?php echo $id; ?>">Exam Ends: </label>
                        <select id="examEndTime-<?php echo $id; ?>" name="examEndTime" class="twelve" />
                        <?php
                        foreach ($times as $time)
                        {
                            if ($time === substr($module_exam['end_time'], 0, 5))
                            {
                                echo '<option value=' . substr($module_exam['end_time'], 0, 5) . ' selected >' . substr($module_exam['end_time'], 0, 5) . '</option>';
                            }
                            else
                            {
                                echo '<option value=' . $time . '>' . $time . '</option>';
                            }
                        }
                        ?>                        
                        </select>
                        <p></p>
                        <small id="validateExamEndTime-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <label for="assessmentWeighting-<?php echo $id; ?>">Percentage of Overall Assessment: </label>
                        <input type="text" id="assessmentWeighting-<?php echo $id; ?>" name="assessmentWeighting" class="twelve" value="<?php echo $module_exam['assessment_weighting']; ?>" />
                        <small id="validateAssessmentWeighting-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <label for="examDescription-<?php echo $id; ?>">Exam Description: </label>
                        <textarea style="max-width: 100%;" id="examDescription-<?php echo $id; ?>" name="examDescription" ><?php
                if ($module_exam['description'])
                {

                    echo $module_exam['description'];
                }
                else
                {
                    echo '(Optional)';
                }
                        ?></textarea>
                        <small id="validateExamDescription-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <small id="validateExamSubmit-<?php echo $id; ?>" style="display:none" id="error_msg" class="error"></small>

                        <p style="text-align: right;" >
                            <button type="submit" id="updateButton-<?php echo $id; ?>" class="radius button">Update <i class="foundicon-edit"></i></button>
                        </p>
                    </form>
                    <a href="" class="close-reveal-modal">&times;</a>
                </div>

                <script type="text/javascript">
                    $("#examTitle-<?php echo $id; ?>").keyup(function(){                                        
                        if($("#examTitle-<?php echo $id; ?>").val().length >= 4)
                        {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>lec/assessments/check_assessment_title",
                                data: "assessmentTitle="+$("#examTitle-<?php echo $id; ?>").val(),
                                success: function(msg){
                                    if(msg){
                                        document.getElementById('validateExamTitle-<?php echo $id; ?>').innerHTML=msg;
                                        $('#validateExamTitle-<?php echo $id; ?>').show('normal', 'linear');  
                                    }
                                    else
                                    {
                                        $('#validateExamTitle-<?php echo $id; ?>').hide('normal', 'linear');
                                    }
                                }
                            });
                        }
                    });
                                                                                                                                                                            
                                                                                                                                                                            
                    $("#examDate-<?php echo $id; ?>").keyup(function(){                                        
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>lec/assessments/check_assessment_date",
                            data: "assessmentDate="+$("#examDate-<?php echo $id; ?>").val(),
                            success: function(msg){
                                if(msg){
                                    document.getElementById('validateExamDate-<?php echo $id; ?>').innerHTML=msg;
                                    $('#validateExamDate-<?php echo $id; ?>').show('normal', 'linear');  
                                }
                                else
                                {
                                    $('#validateExamDate-<?php echo $id; ?>').hide('normal', 'linear');
                                }
                            }
                        });
                    });
                    //  compares start and end times and checks that they start time is before end time
                    $("#examEndTime-<?php echo $id; ?>").change(function(){  
                        var examEndTimeValue = $("#examEndTime-<?php echo $id; ?> option:selected").val();
                        var examStartTimeValue = $("#examEndTime-<?php echo $id; ?>").siblings("#examStartTime-<?php echo $id; ?>").val();
                                                                                                                                                                    
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>lec/assessments/check_exam_end_time",
                            data: {
                                'examEndTime': examEndTimeValue,
                                'examStartTime': examStartTimeValue
                            },
                            success: function(msg){
                                if(msg){
                                    document.getElementById('validateExamEndTime-<?php echo $id; ?>').innerHTML=msg;
                                    $('#validateExamEndTime-<?php echo $id; ?>').show('normal', 'linear');                        
                                }
                                else{
                                    $('#validateExamEndTime-<?php echo $id; ?>').hide('normal', 'linear');
                                }
                            }
                        });           
                                                                                                                                                                    
                    });
                                                                                                                                                                
                    //  compares start and end times and checks that they start time is before end time
                    $("#examStartTime-<?php echo $id; ?>").change(function(){  
                        var examStartTimeValue = $("#examStartTime-<?php echo $id; ?> option:selected").val();
                        var examEndTimeValue = $("#examStartTime-<?php echo $id; ?>").siblings("#examEndTime-<?php echo $id; ?>").val();
                                                                                                                                                                    
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>lec/assessments/check_exam_end_time",
                            data: {
                                'examEndTime': examEndTimeValue,
                                'examStartTime': examStartTimeValue
                            },
                            success: function(msg){
                                if(msg){
                                    document.getElementById('validateExamEndTime-<?php echo $id; ?>').innerHTML=msg;
                                    $('#validateExamEndTime-<?php echo $id; ?>').show('normal', 'linear');                        
                                }
                                else{
                                    $('#validateExamEndTime-<?php echo $id; ?>').hide('normal', 'linear');
                                }
                            }
                        });           
                                                                                                                                                                    
                    });
                                                                                                                                            
                                                                                                                                            
                    //  compares the assessment weighting to existing weightings to ensure total does not exceed 100%                    $("#assessmentWeighting-<?php echo $id; ?>").keyup(function(){  
                    $("#assessmentWeighting-<?php echo $id; ?>").keyup(function(){  
                        var assessmentWeighting = $("#assessmentWeighting-<?php echo $id; ?>").val();
                        var moduleID = <?php echo $module_details['id']; ?>;
                        var examID = $("#assessmentWeighting-<?php echo $id; ?>").siblings("#examID-<?php echo $id; ?>").val();
                                                                                                                                                                    
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>lec/assessments/check_assessment_weighting",
                            data: {
                                'assessmentWeighting': assessmentWeighting,
                                'moduleID': moduleID,
                                'examID': examID
                            },
                            success: function(msg){
                                if(msg){
                                    document.getElementById('validateAssessmentWeighting-<?php echo $id; ?>').innerHTML=msg;
                                    $('#validateAssessmentWeighting-<?php echo $id; ?>').show('normal', 'linear');                        
                                }
                                else{
                                    $('#validateAssessmentWeighting-<?php echo $id; ?>').hide('normal', 'linear');
                                }
                            }
                        });           
                                                                                                                                                                    
                    });
                                                                                    
                    // check desctipion does not exceed 255 characters
                    $("#examDescription-<?php echo $id; ?>").keyup(function(){                                        
                        if($("#examDescription-<?php echo $id; ?>").val().length >= 2)
                        {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>lec/assessments/check_assessment_description",
                                data: "assessmentDescription="+$("#examDescription-<?php echo $id; ?>").val(),
                                success: function(msg){
                                    if(msg){
                                        document.getElementById('validateExamDescription-<?php echo $id; ?>').innerHTML=msg;
                                        $('#validateExamDescription-<?php echo $id; ?>').show('normal', 'linear');                        
                                    }
                                    else{
                                        $('#validateExamDescription-<?php echo $id; ?>').hide('normal', 'linear');
                                    }
                                }
                            });
                        }
                    });
                                                                    
                                                                    
                    $('#exam_update_form-<?php echo $id; ?>').submit(function(event){
                        event.preventDefault();
                        /* get some values from elements on the page: */

                        var $form = $( this ),
                        examID = $form.find('input[id="examID-<?php echo $id; ?>"]').val(),
                        moduleID = <?php echo $module_details['id']; ?>,
                        assessmentTitle = $form.find('input[id="examTitle-<?php echo $id; ?>"]').val(),
                        assessmentDate = $form.find('input[id="examDate-<?php echo $id; ?>"]').val(),
                        examStartTime = $form.find("#examStartTime-<?php echo $id; ?>").val(),
                        examEndTime = $form.find("#examEndTime-<?php echo $id; ?>").val(),
                        assessmentWeighting = $form.find("#assessmentWeighting-<?php echo $id; ?>").val(),
                        assessmentDescription = $form.find('textarea[id="examDescription-<?php echo $id; ?>"]').val(),
                        url = $form.attr( 'action' );

                        var request = $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                'examID': examID,
                                'moduleID': moduleID,
                                'assessmentTitle': assessmentTitle,
                                'assessmentDate': assessmentDate,
                                'examStartTime': examStartTime,
                                'examEndTime': examEndTime,
                                'assessmentWeighting' : assessmentWeighting,
                                'assessmentDescription' : assessmentDescription
                            },
                            cache:false,
                            dataType: 'json'
                        });
                                                                                                                                               
                        request.always(function(msg) {
                            if(msg.responseText != 'everything is good to go'){
                                document.getElementById('validateExamSubmit-<?php echo $id; ?>').innerHTML=msg.responseText;
                                $('#validateExamSubmit-<?php echo $id; ?>').show('normal', 'linear');
                                //display login error message 
                            }
                            else
                            {
                                $('#validateExamSubmit-<?php echo $id; ?>').hide('normal', 'linear');
                                $('#scheduleExam-<?php echo $id; ?>').hide('normal', 'linear');
                                window.location.reload(true);
                            }
                        });
                    });                     
                </script>
                <?php
            } // End of foreach ($module_exams as $module_exam)
        }
        ?>
    </div>
    <!-- Edit an exam END ----------------------------------------------------------------------------------->

    <!-- Add a new Assignment  ------------------------------------------------------------------------------>
    <div class="reveal-modal" id="addAssignment">
        <form id="add_assignment_form" action="<?php echo base_url() . 'lec/assessments/add_assignment'; ?>" method="POST">
            <label for="assignmentTitle">Assignment Title: (i.e. class assignment, final assignment)</label>
            <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_details['id']; ?>"/>         
            <input type="text" id="assignmentTitle" name="assignmentTitle" value="" />
            <small id="validateNewAssignmentTitle" class="error" style="display: none"></small>

            <label for="assignmentDate">Assignment Due Date: </label>
            <input type="text" id="assignmentDate" name="assignmentDate" class="twelve" value="YYYY-MM-DD" />
            <small id="validateNewAssignmentDate" class="error" style="display: none"></small>

            <label for="assignmentWeighting">Percentage of Overall Assessment: </label>
            <input type="text" id="assignmentWeighting" name="assignmentWeighting" class="twelve" value="% - What percentage of the overall assessment?" />
            <small id="validateNewAssignmentWeighting" class="error" style="display: none"></small>

            <label for="assignmentDescription">Assignment Description: </label>
            <textarea style="max-width: 100%;" id="assignmentDescription" name="assignmentDescription" >(Optional)</textarea>
            <small id="validateNewAssignmentDescription" class="error" style="display: none"></small>

            <small id="validateNewAssignmentSubmit" style="display:none" id="error_msg" class="error"></small>

            <p style="text-align: center;" >
                <button type="submit" id="updateButton" class="radius button">Add New Assignment <i class="foundicon-edit"></i></button>
            </p>
        </form>
        <a href="" class="close-reveal-modal">&times;</a>
    </div>
    <script type="text/javascript">
        // NEW ASSIGNMENT SCRIPTS        
        
        // this will check assignment title while user is typing
        $("#assignmentTitle").keyup(function(){                                        
            if($("#assignmentTitle").val().length >= 4)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>lec/assessments/check_assessment_title",
                    data: "assessmentTitle="+$("#assignmentTitle").val(),
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateNewAssignmentTitle').innerHTML=msg;
                            $('#validateNewAssignmentTitle').show('normal', 'linear');  
                        }
                        else
                        {
                            $('#validateNewAssignmentTitle').hide('normal', 'linear');
                        }
                    }
                });
            }
        });        
        // check the date format is correct
        // check date is valid and in the future
        $("#assignmentDate").keyup(function(){                                        
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>lec/assessments/check_assessment_date",
                data: "assessmentDate="+$("#assignmentDate").val(),
                success: function(msg){
                    if(msg){
                        document.getElementById('validateNewAssignmentDate').innerHTML=msg;
                        $('#validateNewAssignmentDate').show('normal', 'linear');  
                    }
                    else
                    {
                        $('#validateNewAssignmentDate').hide('normal', 'linear');
                    }
                }
            });
        });
        
        //  compares the assessment weighting to existing weightings to ensure total does not exceed 100%
        $("#assignmentWeighting").keyup(function(){  
            var assessmentWeighting = $("#assignmentWeighting").val();
            var moduleID = <?php echo $module_details['id']; ?>;
            var assignmentID = $("#assignmentWeighting").siblings("#assignmentID").val();
                                                                    
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>lec/assessments/check_assessment_weighting",
                data: {
                    'assessmentWeighting': assessmentWeighting,
                    'moduleID': moduleID,
                    'assignmentID': assignmentID
                },
                success: function(msg){
                    if(msg){
                        document.getElementById('validateNewAssignmentWeighting').innerHTML=msg;
                        $('#validateNewAssignmentWeighting').show('normal', 'linear');                        
                    }
                    else{
                        $('#validateNewAssignmentWeighting').hide('normal', 'linear');
                    }
                }
            });           
                                                                    
        });
            
        // check desctipion does not exceed 255 characters
        $("#assignmentDescription").keyup(function(){                                        
            if($("#assignmentDescription").val().length >= 2)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>lec/assessments/check_assessment_description",
                    data: "assessmentDescription="+$("#assignmentDescription").val(),
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateNewAssignmentDescription').innerHTML=msg;
                            $('#validateNewAssignmentDescription').show('normal', 'linear');                        
                        }
                        else{
                            $('#validateNewAssignmentDescription').hide('normal', 'linear');
                        }
                    }
                });
            }
        });
        
        // This will do final check when "Add new assignment" button is pressed
        $('#add_assignment_form').submit(function(event){
            event.preventDefault();
            /* get some values from elements on the page: */

            var $form = $( this ),
            moduleID = $form.find('input[id="moduleID"]').val(),
            assessmentTitle = $form.find('input[id="assignmentTitle"]').val(),
            assessmentDate = $form.find('input[id="assignmentDate"]').val(),
            assessmentWeighting = $form.find("#assignmentWeighting").val(),
            assessmentDescription = $form.find('textarea[id="assignmentDescription"]').val(),

            url = $form.attr( 'action' );

            var request = $.ajax({
                url: url,
                type: 'POST',
                data: {
                    'moduleID': moduleID,
                    'assessmentTitle': assessmentTitle,
                    'assessmentDate': assessmentDate,
                    'assessmentWeighting' : assessmentWeighting,
                    'assessmentDescription' : assessmentDescription
                },
                cache:false,
                dataType: 'json'
            });
               
            request.always(function(msg) {
                if(msg.responseText != 'everything is good to go'){
                    document.getElementById('validateNewAssignmentSubmit').innerHTML=msg.responseText;
                    $('#validateNewAssignmentSubmit').show('normal', 'linear');
                }
                else
                {
                    $('#validateNewAssignmentSubmit').hide('normal', 'linear');
                    $('#addAssignment').hide('normal', 'linear');
                    window.location.reload(true);
                }
            });
        });   
    </script>

    <!-- Schedule a new Exam -------------------------------------------------------------------------------->
    <div class="reveal-modal" id="scheduleExam">
        <form id="schedule_exam_form" action="<?php echo base_url() . 'lec/assessments/schedule_exam'; ?>" method="POST">
            <label for="examTitle">Exam Title: (i.e. class exam, final exam)</label>
            <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_details['id']; ?>"/>         
            <input type="text" id="examTitle" name="examTitle" value="" />
            <small id="validateNewExamTitle" class="error" style="display: none"></small>

            <label for="examDate">Exam date: </label>
            <input type="text" id="examDate" name="examDate" class="twelve" value="YYYY-MM-DD" />
            <small id="validateNewExamDate" class="error" style="display: none"></small>

            <label for="examStartTime">Exam Start Time: </label>
            <select id="examStartTime" name="examStartTime" class="twelve" />
            <?php
            foreach ($times as $time)
            {
                echo '<option value=' . $time . '>' . $time . '</option>';
            }
            ?>
            </select>
            <p></p>
            <small id="validateNewExamStartTime" class="error" style="display: none"></small>

            <label for="examEndTime">Exam Ends: </label>
            <select id="examEndTime" name="examEndTime" class="twelve" />
            <?php
            foreach ($times as $time)
            {
                echo '<option value=' . $time . '>' . $time . '</option>';
            }
            ?>            
            </select>
            <p></p>
            <small id="validateNewExamEndTime" class="error" style="display: none"></small>

            <label for="examWeighting">Percentage of Overall Assessment: </label>
            <input type="text" id="examWeighting" name="examWeighting" class="twelve" value="% - What percentage of the overall assessment?" />
            <small id="validateNewExamWeighting" class="error" style="display: none"></small>

            <label for="examDescription">Exam Description: </label>
            <textarea style="max-width: 100%;" id="examDescription" name="examDescription" >(Optional)</textarea>
            <small id="validateNewExamDescription" class="error" style="display: none"></small>

            <small id="validateNewExamSubmit" style="display:none" id="error_msg" class="error"></small>

            <p style="text-align: right;" >
                <button type="submit" id="updateButton" class="radius button">Schedule New Exam <i class="foundicon-edit"></i></button>
            </p>
        </form>
        <a href="" class="close-reveal-modal">&times;</a>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            // function for schedule new exam form ------------
            // this will check exam title while user is typing
            $("#examTitle").keyup(function(){                                        
                //                if($("#examTitle").val().length > 4)
                //                {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>lec/assessments/check_assessment_title",
                    data: "assessmentTitle="+$("#examTitle").val(),
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateNewExamTitle').innerHTML=msg;
                            $('#validateNewExamTitle').show('normal', 'linear');  
                        }
                        else
                        {
                            $('#validateNewExamTitle').hide('normal', 'linear');
                        }
                    }
                });
            });
                
            // check the date format is correct
            // check date is valid and in the future
            $("#examDate").keyup(function(){                                        
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>lec/assessments/check_assessment_date",
                    data: "assessmentDate="+$("#examDate").val(),
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateNewExamDate').innerHTML=msg;
                            $('#validateNewExamDate').show('normal', 'linear');  
                        }
                        else
                        {
                            $('#validateNewExamDate').hide('normal', 'linear');
                        }
                    }
                });
            });
                
            //  compares start and end times and checks that they start time is before end time
            $("#examEndTime").change(function(){  
                var examEndTimeValue = $("#examEndTime option:selected").val();
                var examStartTimeValue = $("#examEndTime").siblings("#examStartTime").val();
                    
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>lec/assessments/check_exam_end_time",
                    data: {
                        'examEndTime': examEndTimeValue,
                        'examStartTime': examStartTimeValue
                    },
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateNewExamEndTime').innerHTML=msg;
                            $('#validateNewExamEndTime').show('normal', 'linear');                        
                        }
                        else{
                            $('#validateNewExamEndTime').hide('normal', 'linear');
                        }
                    }
                });           
                    
            });
                
            //  compares start and end times and checks that they start time is before end time
            $("#examStartTime").change(function(){  
                var examStartTimeValue = $("#examStartTime option:selected").val();
                var examEndTimeValue = $("#examStartTime").siblings("#examEndTime").val();
                    
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>lec/assessments/check_exam_end_time",
                    data: {
                        'examEndTime': examEndTimeValue,
                        'examStartTime': examStartTimeValue
                    },
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateNewExamEndTime').innerHTML=msg;
                            $('#validateNewExamEndTime').show('normal', 'linear');                        
                        }
                        else{
                            $('#validateNewExamEndTime').hide('normal', 'linear');
                        }
                    }
                });           
                    
            });
                
            // check desctipion does not exceed 255 characters
            $("#examDescription").keyup(function(){                                        
                if($("#examDescription").val().length >= 2)
                {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>lec/assessments/check_assessment_description",
                        data: "assessmentDescription="+$("#examDescription").val(),
                        success: function(msg){
                            if(msg){
                                document.getElementById('validateNewExamDescription').innerHTML=msg;
                                $('#validateNewExamDescription').show('normal', 'linear');                        
                            }
                            else{
                                $('#validateNewExamDescription').hide('normal', 'linear');
                            }
                        }
                    });
                }
            });
                

            //  compares the assessment weighting to existing weightings to ensure total does not exceed 100%
            $("#examWeighting").keyup(function(){  
                var assessmentWeighting = $("#examWeighting").val();
                var moduleID = <?php echo $module_details['id']; ?>;
                var examID = $("#examWeighting").siblings("#examID").val();
                                                                    
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>lec/assessments/check_assessment_weighting",
                    data: {
                        'assessmentWeighting': assessmentWeighting,
                        'moduleID': moduleID,
                        'examID': examID
                    },
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateNewExamWeighting').innerHTML=msg;
                            $('#validateNewExamWeighting').show('normal', 'linear');                        
                        }
                        else{
                            $('#validateNewExamWeighting').hide('normal', 'linear');
                        }
                    }
                });           
                                                                    
            });

            // This will do final check when "shcedule new exam" button is pressed
            $('#schedule_exam_form').submit(function(event){
                event.preventDefault();
                /* get some values from elements on the page: */

                var $form = $( this ),
                moduleID = $form.find('input[id="moduleID"]').val(),
                assessmentTitle = $form.find('input[id="examTitle"]').val(),
                assessmentDate = $form.find('input[id="examDate"]').val(),
                examStartTime = $form.find("#examStartTime").val(),
                examEndTime = $form.find("#examEndTime").val(),
                assessmentWeighting = $form.find("#examWeighting").val(),
                assessmentDescription = $form.find('textarea[id="examDescription"]').val(),
                url = $form.attr( 'action' );

                var request = $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        'moduleID': moduleID,
                        'assessmentTitle': assessmentTitle,
                        'assessmentDate': assessmentDate,
                        'examStartTime': examStartTime,
                        'examEndTime': examEndTime,
                        'assessmentWeighting' : assessmentWeighting,
                        'assessmentDescription' : assessmentDescription
                    },
                    cache:false,
                    dataType: 'json'
                });
               
                request.always(function(msg) {
                    if(msg.responseText != 'everything is good to go'){
                        document.getElementById('validateNewExamSubmit').innerHTML=msg.responseText;
                        $('#validateNewExamSubmit').show('normal', 'linear');
                        //display login error message 
                    }
                    else
                    {
                        $('#validateNewExamSubmit').hide('normal', 'linear');
                        $('#scheduleExam').hide('normal', 'linear');
                        window.location.reload(true);
                    }

                });
            });    
        });
        
    </script>