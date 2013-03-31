<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <h5 style="text-align: center">
                <a href="" data-reveal-id="addStudent">Add a New Student</a></h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="twelve columns">
        <?php
        if (empty($all_students))
        {
            ?>
            <div class="panel">
                <h5>No students have been registered on system.</h5>
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
                        <th>username</th>
                        <th>Email</th>
    <!--                        <th>Continuous Assessment Mark</th>-->
                        <th></th>
                    </tr>
                </thead>

                <?php
                foreach ($all_students as $student)
                {
                    ?>
                    <tr>
                        <?php $id = $student['user_id']; ?>
                        <td><?php echo $student['student_number']; ?></td>
                        <td><?php echo $student['first_name'] . ' ' . $student['last_name']; ?></td>
                        <td><?php echo $student['dob']; ?></td>
                        <td><?php echo $student['username']; ?></td>
                        <td><?php echo $student['email']; ?></td>
        <!--                        <td><?php echo 'ca_mark'; ?></td>-->
                        <td style="text-align: center;">
                            <a href="" 
                               class="small radius button"
                               data-reveal-id="editStudent-<?php echo $id; ?>"
                               data-animation="fade" data-animationspeed="300" 
                               data-closeonbackgroundclick="true" 
                               data-dismissmodalclass="close-reveal-modal">Edit</a>
                        </td>

                        <td class="reveal-modal" id="editStudent-<?php echo $id; ?>">
                            <form id="student_update_form-<?php echo $id; ?>" action="<?php echo base_url() . 'adm/students/edit_student'; ?>" method="POST">
                                <input type="hidden" id="userID-<?php echo $id; ?>" name="userID" value="<?php echo $id; ?>">

                                <label for="title">Student Number: </label>
                                <input type="text" id="studentNumber-<?php echo $id; ?>" name="studentNumber" value="<?php echo $student['student_number']; ?>" />
                                <small id="validateStudentNumber-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">First Name: </label>
                                <input type="text" id="studentFirstName-<?php echo $id; ?>" name="studentFirstName" value="<?php echo $student['first_name']; ?>"/>
                                <small id="validateStudentFirstName-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Last Name: </label>
                                <input type="text" id="studentLastName-<?php echo $id; ?>" name="studentLastName" value="<?php echo $student['last_name']; ?>"/>
                                <small id="validateStudentLastName-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Date of Birth: </label>
                                <input type="text" id="studentDoB-<?php echo $id; ?>" name="studentDoB" value="<?php echo $student['dob']; ?>" />
                                <small id="validateStudentDoB-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Username: </label>
                                <input type="text" id="studentUsername-<?php echo $id; ?>" name="studentUsername" value="<?php echo $student['username']; ?>"/>
                                <small id="validateStudentUsername-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Password: </label>
                                <input type="password" id="studentPassword-<?php echo $id; ?>" name="studentPassword" value="<?php echo $student['password']; ?>"/>
                                <small id="validateStudentPassword-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Email: </label>
                                <input type="text" id="studentEmail-<?php echo $id; ?>" name="studentEmail" value="<?php echo $student['email']; ?>" />
                                <small id="validateStudentEmail-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <small id="validateEditStudentSubmit-<?php echo $id; ?>"  style="display:none" id="error_msg" class="error"></small>
                                <p style="text-align: right;" >
                                    <button type="submit" id="updateButton-<?php echo $id; ?>" class="radius button">Update <i class="foundicon-edit"></i></button>
                                </p>
                            </form>
                            <a href="" class="close-reveal-modal">&times;</a>
                        </td>

                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#studentNumber-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#studentNumber-<?php echo $id; ?>").val().length >= 2)
                                {
                                    var userID = $(this).parent().find("#userID-<?php echo $id; ?>").val();
                                    var studentNumber = $(this).parent().find("#studentNumber-<?php echo $id; ?>").val();
                                                                                                                                                                                 
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/students/check_student_number",
                                        data: {
                                            userID : userID,
                                            studentNumber : studentNumber
                                        },
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateStudentNumber-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateStudentNumber-<?php echo $id; ?>').show('normal', 'linear');
                                            }
                                            else{
                                                $('#validateStudentNumber-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            });                       
                                                                                
                            $("#studentFirstName-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#studentFirstName-<?php echo $id; ?>").val().length >= 2)
                                {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/students/check_student_first_name",
                                        data: "studentFirstName="+$("#studentFirstName-<?php echo $id; ?>").val(),
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateStudentFirstName-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateStudentFirstName-<?php echo $id; ?>').show('normal', 'linear');  
                                            }
                                            else
                                            {
                                                $('#validateStudentFirstName-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            });
                                                                                
                            $("#studentLastName-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#studentLastName-<?php echo $id; ?>").val().length >= 2)
                                {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/students/check_student_last_name",
                                        data: "studentLastName="+$("#studentLastName-<?php echo $id; ?>").val(),
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateStudentLastName-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateStudentLastName-<?php echo $id; ?>').show('normal', 'linear');  
                                            }
                                            else
                                            {
                                                $('#validateStudentLastName-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            });
                                                                                
                            $("#studentDoB-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#studentDoB-<?php echo $id; ?>").val().length >= 2)
                                {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/students/check_student_date_of_birth",
                                        data: "studentDoB="+$("#studentDoB-<?php echo $id; ?>").val(),
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateStudentDoB-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateStudentDoB-<?php echo $id; ?>').show('normal', 'linear');  
                                            }
                                            else
                                            {
                                                $('#validateStudentDoB-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            });

                            $("#studentEmail-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#studentEmail-<?php echo $id; ?>").val().length >= 2)
                                {
                                    var userID = $(this).parent().find("#userID-<?php echo $id; ?>").val();
                                    var studentEmail = $(this).parent().find("#studentEmail-<?php echo $id; ?>").val();
                                                                                                                                                                                 
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/students/check_student_email",
                                        data: {
                                            userID : userID,
                                            studentEmail : studentEmail
                                        },
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateStudentEmail-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateStudentEmail-<?php echo $id; ?>').show('normal', 'linear');
                                            }
                                            else{
                                                $('#validateStudentEmail-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            });
                                                                                
                                                                                
                            $("#studentUsername-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#studentUsername-<?php echo $id; ?>").val().length >= 2)
                                {
                                    var userID = $(this).parent().find("#userID-<?php echo $id; ?>").val();
                                    var studentUsername = $(this).parent().find("#studentUsername-<?php echo $id; ?>").val();
                                                                                                                                                                                 
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/students/check_student_username",
                                        data: {
                                            userID : userID,
                                            studentUsername : studentUsername
                                        },
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateStudentUsername-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateStudentUsername-<?php echo $id; ?>').show('normal', 'linear');
                                            }
                                            else{
                                                $('#validateStudentUsername-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            }); 


                            $("#studentPassword-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#studentPassword-<?php echo $id; ?>").val().length >= 2)
                                {
                                    var userID = $(this).parent().find("#userID-<?php echo $id; ?>").val();
                                    var studentPassword = $(this).parent().find("#studentPassword-<?php echo $id; ?>").val();
                                                                                                                                                                                 
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/students/check_student_password",
                                        data: {
                                            userID : userID,
                                            studentPassword : studentPassword
                                        },
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateStudentPassword-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateStudentPassword-<?php echo $id; ?>').show('normal', 'linear');
                                            }
                                            else{
                                                $('#validateStudentPassword-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            }); 


                            $('#student_update_form-<?php echo $id; ?>').submit(function(event){
                                event.preventDefault();
                                /* get some values from elements on the page: */

                                var $form = $(this),
                                userID = $form.find("#userID-<?php echo $id; ?>").val(),
                                studentNumber = $form.find( 'input[id="studentNumber-<?php echo $id; ?>"]').val(),
                                studentFirstName = $form.find( 'input[id="studentFirstName-<?php echo $id; ?>"]').val(),
                                studentLastName = $form.find("#studentLastName-<?php echo $id; ?>").val(),
                                studentDoB = $form.find("#studentDoB-<?php echo $id; ?>").val(),
                                studentUsername = $form.find("#studentUsername-<?php echo $id; ?>").val(),
                                studentPassword = $form.find("#studentPassword-<?php echo $id; ?>").val(),
                                studentEmail = $form.find("#studentEmail-<?php echo $id; ?>").val(),
                                url = $form.attr('action');

                                var request = $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: {
                                        'userID': userID,
                                        'studentNumber': studentNumber,
                                        'studentFirstName': studentFirstName,
                                        'studentLastName': studentLastName,
                                        'studentDoB': studentDoB,
                                        'studentUsername': studentUsername,
                                        'studentPassword': studentPassword,
                                        'studentEmail': studentEmail
                                    },
                                    cache:false,
                                    dataType: 'json'
                                });

                                console.log(request);
                                                                                                                                                                                    
                                request.always(function(msg) {
                                    if(msg.responseText != 'everything is good to go'){
                                        document.getElementById('validateEditStudentSubmit-<?php echo $id; ?>').innerHTML=msg.responseText;
                                        $('#validateEditStudentSubmit-<?php echo $id; ?>').show('normal', 'linear');
                                        //display login error message 
                                    }
                                    else
                                    {
                                        $('#validateEditStudentSubmit-<?php echo $id; ?>').hide('normal', 'linear');
                                        window.location.reload(true);
                                    }
                                });
                            });
                        });
                    </script>
                    <?php
                } // End foreach ($all_students as $student) 
                ?>
            </table>
            <?php
        }
        ?>
    </div>
</div>
<div class="reveal-modal" id="addStudent">
    <form id="student_update_form" action="<?php echo base_url() . 'adm/students/create_student'; ?>" method="POST">

        <label for="title">Student Number: </label>
        <input type="text" id="studentNumber" name="studentNumber" value="" />
        <small id="validateStudentNumber" class="error" style="display: none"></small>

        <label for="title">First Name: </label>
        <input type="text" id="studentFirstName" name="studentFirstName" value="" />
        <small id="validateStudentFirstName" class="error" style="display: none"></small>

        <label for="title">Last Name: </label>
        <input type="text" id="studentLastName" name="studentLastName" value="" />
        <small id="validateStudentLastName" class="error" style="display: none"></small>

        <label for="title">Date of Birth: </label>
        <input type="text" id="studentDoB" name="studentDoB" value="YYYY-MM-DD" />
        <small id="validateStudentDoB" class="error" style="display: none"></small>

        <label for="title">Username: </label>
        <input type="text" id="studentUsername" name="studentUsername" value="" />
        <small id="validateStudentUsername" class="error" style="display: none"></small>

        <label for="title">Password: </label>
        <input type="password" id="studentPassword" name="studentPassword" value="" />
        <small id="validateStudentPassword" class="error" style="display: none"></small>

        <label for="title">Email: </label>
        <input type="text" id="studentEmail" name="studentEmail" value="" />
        <small id="validateStudentEmail" class="error" style="display: none"></small>

        <small id="validateEditStudentSubmit"  style="display:none" id="error_msg" class="error"></small>

        <p style="text-align: right;" >
            <button type="submit" id="updateButton" class="radius button">Create User <i class="foundicon-edit"></i></button>
        </p>
    </form>
    <a href="" class="close-reveal-modal">&times;</a>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $("#studentNumber").keyup(function(){                                        
            if($("#studentNumber").val().length >= 2)
            {
                var userID = $(this).parent().find("#userID").val();
                var studentNumber = $(this).parent().find("#studentNumber").val();
                                                                                                                                                         
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>adm/students/check_student_number",
                    data: {
                        userID : userID,
                        studentNumber : studentNumber
                    },
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateStudentNumber').innerHTML=msg;
                            $('#validateStudentNumber').show('normal', 'linear');
                        }
                        else{
                            $('#validateStudentNumber').hide('normal', 'linear');
                        }
                    }
                });
            }
        });                       
                                                        
        $("#studentFirstName").keyup(function(){                                        
            if($("#studentFirstName").val().length >= 2)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>adm/students/check_student_first_name",
                    data: "studentFirstName="+$("#studentFirstName").val(),
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateStudentFirstName').innerHTML=msg;
                            $('#validateStudentFirstName').show('normal', 'linear');  
                        }
                        else
                        {
                            $('#validateStudentFirstName').hide('normal', 'linear');
                        }
                    }
                });
            }
        });
                                                        
        $("#studentLastName").keyup(function(){                                        
            if($("#studentLastName").val().length >= 2)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>adm/students/check_student_last_name",
                    data: "studentLastName="+$("#studentLastName").val(),
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateStudentLastName').innerHTML=msg;
                            $('#validateStudentLastName').show('normal', 'linear');  
                        }
                        else
                        {
                            $('#validateStudentLastName').hide('normal', 'linear');
                        }
                    }
                });
            }
        });
                                                        
        $("#studentDoB").keyup(function(){                                        
            if($("#studentDoB").val().length >= 2)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>adm/students/check_student_date_of_birth",
                    data: "studentDoB="+$("#studentDoB").val(),
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateStudentDoB').innerHTML=msg;
                            $('#validateStudentDoB').show('normal', 'linear');  
                        }
                        else
                        {
                            $('#validateStudentDoB').hide('normal', 'linear');
                        }
                    }
                });
            }
        });

        $("#studentEmail").keyup(function(){                                        
            if($("#studentEmail").val().length >= 2)
            {
                var userID = $(this).parent().find("#userID").val();
                var studentEmail = $(this).parent().find("#studentEmail").val();
                                                                                                                                                         
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>adm/students/check_student_email",
                    data: {
                        userID : userID,
                        studentEmail : studentEmail
                    },
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateStudentEmail').innerHTML=msg;
                            $('#validateStudentEmail').show('normal', 'linear');
                        }
                        else{
                            $('#validateStudentEmail').hide('normal', 'linear');
                        }
                    }
                });
            }
        });
                                                        
                                                        
        $("#studentUsername").keyup(function(){                                        
            if($("#studentUsername").val().length >= 2)
            {
                var userID = $(this).parent().find("#userID").val();
                var studentUsername = $(this).parent().find("#studentUsername").val();
                                                                                                                                                         
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>adm/students/check_student_username",
                    data: {
                        userID : userID,
                        studentUsername : studentUsername
                    },
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateStudentUsername').innerHTML=msg;
                            $('#validateStudentUsername').show('normal', 'linear');
                        }
                        else{
                            $('#validateStudentUsername').hide('normal', 'linear');
                        }
                    }
                });
            }
        }); 


        $("#studentPassword").keyup(function(){                                        
            if($("#studentPassword").val().length >= 2)
            {
                var userID = $(this).parent().find("#userID").val();
                var studentPassword = $(this).parent().find("#studentPassword").val();
                                                                                                                                                         
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>adm/students/check_student_password",
                    data: {
                        userID : userID,
                        studentPassword : studentPassword
                    },
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateStudentPassword').innerHTML=msg;
                            $('#validateStudentPassword').show('normal', 'linear');
                        }
                        else{
                            $('#validateStudentPassword').hide('normal', 'linear');
                        }
                    }
                });
            }
        }); 


        $('#student_update_form').submit(function(event){
            event.preventDefault();
            /* get some values from elements on the page: */

            var $form = $(this),
            userID = $form.find("#userID").val(),
            studentNumber = $form.find( 'input[id="studentNumber"]').val(),
            studentFirstName = $form.find( 'input[id="studentFirstName"]').val(),
            studentLastName = $form.find("#studentLastName").val(),
            studentDoB = $form.find("#studentDoB").val(),
            studentUsername = $form.find("#studentUsername").val(),
            studentPassword = $form.find("#studentPassword").val(),
            studentEmail = $form.find("#studentEmail").val(),
            url = $form.attr('action');

            var request = $.ajax({
                url: url,
                type: 'POST',
                data: {
                    'userID': userID,
                    'studentNumber': studentNumber,
                    'studentFirstName': studentFirstName,
                    'studentLastName': studentLastName,
                    'studentDoB': studentDoB,
                    'studentUsername': studentUsername,
                    'studentPassword': studentPassword,
                    'studentEmail': studentEmail
                },
                cache:false,
                dataType: 'json'
            });

            console.log(request);
                                                                                                                                                            
            request.always(function(msg) {
                if(msg.responseText != 'everything is good to go'){
                    document.getElementById('validateEditStudentSubmit').innerHTML=msg.responseText;
                    $('#validateEditStudentSubmit').show('normal', 'linear');
                    //display login error message 
                }
                else
                {
                    $('#validateEditStudentSubmit').hide('normal', 'linear');
                    window.location.reload(true);
                }
            });
        });
    });
</script>