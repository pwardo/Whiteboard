<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <h5 style="text-align: center">
                <a href="" data-reveal-id="addLecturer"
                   data-animation="fade" data-animationspeed="300" 
                   data-closeonbackgroundclick="true" 
                   data-dismissmodalclass="close-reveal-modal">Add a New Lecturer</a></h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="twelve columns">
        <?php
        if (empty($all_lecturers))
        {
            ?>
            <div class="panel">
                <h5>No lecturers have been registered on system.</h5>
            </div>
            <?php
        }
        else
        {
            ?>
            <table class="twelve">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>username</th>
                        <th>Email</th>
    <!--                        <th>Continuous Assessment Mark</th>-->
                        <th></th>
                    </tr>
                </thead>

                <?php
                foreach ($all_lecturers as $lecturer)
                {
                    ?>
                    <tr>
                        <?php $id = $lecturer['user_id']; ?>
                        <td><?php echo $lecturer['first_name'] . ' ' . $lecturer['last_name']; ?></td>
                        <td><?php echo $lecturer['dob']; ?></td>
                        <td><?php echo $lecturer['username']; ?></td>
                        <td><?php echo $lecturer['email']; ?></td>
        <!--                        <td><?php echo 'ca_mark'; ?></td>-->
                        <td style="text-align: center;">
                            <a href="" 
                               class="small radius button"
                               data-reveal-id="editLecturer-<?php echo $id; ?>"
                               data-animation="fade" data-animationspeed="300" 
                               data-closeonbackgroundclick="true" 
                               data-dismissmodalclass="close-reveal-modal">Edit</a>
                        </td>

                        <td class="reveal-modal" id="editLecturer-<?php echo $id; ?>">
                            <form id="lecturer_update_form-<?php echo $id; ?>" action="<?php echo base_url() . 'adm/lecturers/edit_lecturer'; ?>" method="POST">
                                <input type="hidden" id="userID-<?php echo $id; ?>" name="userID" value="<?php echo $id; ?>">

                                <label for="title">First Name: </label>
                                <input type="text" id="lecturerFirstName-<?php echo $id; ?>" name="lecturerFirstName" value="<?php echo $lecturer['first_name']; ?>" />
                                <small id="validateLecturerFirstName-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Last Name: </label>
                                <input type="text" id="lecturerLastName-<?php echo $id; ?>" name="lecturerLastName" value="<?php echo $lecturer['last_name']; ?>" />
                                <small id="validateLecturerLastName-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Date of Birth: </label>
                                <input type="text" id="lecturerDoB-<?php echo $id; ?>" name="lecturerDoB" value="<?php echo $lecturer['dob']; ?>" />
                                <small id="validateLecturerDoB-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Username: </label>
                                <input type="text" id="lecturerUsername-<?php echo $id; ?>" name="lecturerUsername" value="<?php echo $lecturer['username']; ?>" />
                                <small id="validateLecturerUsername-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Password: </label>
                                <input type="password" id="lecturerPassword-<?php echo $id; ?>" name="lecturerPassword" value="<?php echo $lecturer['password']; ?>" />
                                <small id="validateLecturerPassword-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <label for="title">Email: </label>
                                <input type="text" id="lecturerEmail-<?php echo $id; ?>" name="lecturerEmail" value="<?php echo $lecturer['email']; ?>" />
                                <small id="validateLecturerEmail-<?php echo $id; ?>" class="error" style="display: none"></small>

                                <small id="validateEditLecturerSubmit-<?php echo $id; ?>"  style="display:none" id="error_msg" class="error"></small>
                                <p style="text-align: right;" >
                                    <button type="submit" id="updateButton-<?php echo $id; ?>" class="radius button">Update <i class="foundicon-edit"></i></button>
                                </p>
                            </form>
                            <a href="" class="close-reveal-modal">&times;</a>
                        </td>

                    <script type="text/javascript">
                        $(document).ready(function(){                     
                            $("#lecturerFirstName-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#lecturerFirstName-<?php echo $id; ?>").val().length >= 2)
                                {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_first_name",
                                        data: "lecturerFirstName="+$("#lecturerFirstName-<?php echo $id; ?>").val(),
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateLecturerFirstName-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateLecturerFirstName-<?php echo $id; ?>').show('normal', 'linear');  
                                            }
                                            else
                                            {
                                                $('#validateLecturerFirstName-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            });
                                                                                        
                            $("#lecturerLastName-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#lecturerLastName-<?php echo $id; ?>").val().length >= 2)
                                {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_last_name",
                                        data: "lecturerLastName="+$("#lecturerLastName-<?php echo $id; ?>").val(),
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateLecturerLastName-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateLecturerLastName-<?php echo $id; ?>').show('normal', 'linear');  
                                            }
                                            else
                                            {
                                                $('#validateLecturerLastName-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            });
                                                                                        
                            $("#lecturerDoB-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#lecturerDoB-<?php echo $id; ?>").val().length >= 2)
                                {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_date_of_birth",
                                        data: "lecturerDoB="+$("#lecturerDoB-<?php echo $id; ?>").val(),
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateLecturerDoB-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateLecturerDoB-<?php echo $id; ?>').show('normal', 'linear');  
                                            }
                                            else
                                            {
                                                $('#validateLecturerDoB-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            });

                            $("#lecturerEmail-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#lecturerEmail-<?php echo $id; ?>").val().length >= 2)
                                {
                                    var userID = $(this).parent().find("#userID-<?php echo $id; ?>").val();
                                    var lecturerEmail = $(this).parent().find("#lecturerEmail-<?php echo $id; ?>").val();
                                                                                                                                                                                         
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_email",
                                        data: {
                                            userID : userID,
                                            lecturerEmail : lecturerEmail
                                        },
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateLecturerEmail-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateLecturerEmail-<?php echo $id; ?>').show('normal', 'linear');
                                            }
                                            else{
                                                $('#validateLecturerEmail-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            });
                                                                                        
                                                                                        
                            $("#lecturerUsername-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#lecturerUsername-<?php echo $id; ?>").val().length >= 2)
                                {
                                    var userID = $(this).parent().find("#userID-<?php echo $id; ?>").val();
                                    var lecturerUsername = $(this).parent().find("#lecturerUsername-<?php echo $id; ?>").val();
                                                                                                                                                                                         
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_username",
                                        data: {
                                            userID : userID,
                                            lecturerUsername : lecturerUsername
                                        },
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateLecturerUsername-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateLecturerUsername-<?php echo $id; ?>').show('normal', 'linear');
                                            }
                                            else{
                                                $('#validateLecturerUsername-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            }); 


                            $("#lecturerPassword-<?php echo $id; ?>").keyup(function(){                                        
                                if($("#lecturerPassword-<?php echo $id; ?>").val().length >= 2)
                                {
                                    var userID = $(this).parent().find("#userID-<?php echo $id; ?>").val();
                                    var lecturerPassword = $(this).parent().find("#lecturerPassword-<?php echo $id; ?>").val();
                                                                                                                                                                                         
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_password",
                                        data: {
                                            userID : userID,
                                            lecturerPassword : lecturerPassword
                                        },
                                        success: function(msg){
                                            if(msg){
                                                document.getElementById('validateLecturerPassword-<?php echo $id; ?>').innerHTML=msg;
                                                $('#validateLecturerPassword-<?php echo $id; ?>').show('normal', 'linear');
                                            }
                                            else{
                                                $('#validateLecturerPassword-<?php echo $id; ?>').hide('normal', 'linear');
                                            }
                                        }
                                    });
                                }
                            }); 


                            $('#lecturer_update_form-<?php echo $id; ?>').submit(function(event){
                                event.preventDefault();
                                /* get some values from elements on the page: */

                                var $form = $(this),
                                userID = $form.find("#userID-<?php echo $id; ?>").val(),
                                lecturerFirstName = $form.find( 'input[id="lecturerFirstName-<?php echo $id; ?>"]').val(),
                                lecturerLastName = $form.find("#lecturerLastName-<?php echo $id; ?>").val(),
                                lecturerDoB = $form.find("#lecturerDoB-<?php echo $id; ?>").val(),
                                lecturerUsername = $form.find("#lecturerUsername-<?php echo $id; ?>").val(),
                                lecturerPassword = $form.find("#lecturerPassword-<?php echo $id; ?>").val(),
                                lecturerEmail = $form.find("#lecturerEmail-<?php echo $id; ?>").val(),
                                url = $form.attr('action');

                                var request = $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: {
                                        'userID': userID,
                                        'lecturerFirstName': lecturerFirstName,
                                        'lecturerLastName': lecturerLastName,
                                        'lecturerDoB': lecturerDoB,
                                        'lecturerUsername': lecturerUsername,
                                        'lecturerPassword': lecturerPassword,
                                        'lecturerEmail': lecturerEmail
                                    },
                                    cache:false,
                                    dataType: 'json'
                                });

                                console.log(request);
                                                                                                                                                                                            
                                request.always(function(msg) {
                                    if(msg.responseText != 'everything is good to go'){
                                        document.getElementById('validateEditLecturerSubmit-<?php echo $id; ?>').innerHTML=msg.responseText;
                                        $('#validateEditLecturerSubmit-<?php echo $id; ?>').show('normal', 'linear');
                                        //display login error message 
                                    }
                                    else
                                    {
                                        $('#validateEditLecturerSubmit-<?php echo $id; ?>').hide('normal', 'linear');
                                        window.location.reload(true);
                                    }
                                });
                            });
                        });
                    </script>
                    <?php
                } // End foreach ($all_lecturers as $lecturer) 
                ?>
            </table>
            <?php
        }
        ?>
    </div>
</div>
<div class="reveal-modal" id="addLecturer">
    <form id="lecturer_update_form" action="<?php echo base_url() . 'adm/lecturers/create_lecturer'; ?>" method="POST">
        
        <label for="title">First Name: </label>
        <input type="text" id="lecturerFirstName" name="lecturerFirstName" value="" />
        <small id="validateLecturerFirstName" class="error" style="display: none"></small>

        <label for="title">Last Name: </label>
        <input type="text" id="lecturerLastName" name="lecturerLastName" value="" />
        <small id="validateLecturerLastName" class="error" style="display: none"></small>

        <label for="title">Date of Birth: </label>
        <input type="text" id="lecturerDoB" name="lecturerDoB" value="YYYY-MM-DD" />
        <small id="validateLecturerDoB" class="error" style="display: none"></small>

        <label for="title">Username: </label>
        <input type="text" id="lecturerUsername" name="lecturerUsername" value="" />
        <small id="validateLecturerUsername" class="error" style="display: none"></small>

        <label for="title">Password: </label>
        <input type="password" id="lecturerPassword" name="lecturerPassword" value="" />
        <small id="validateLecturerPassword" class="error" style="display: none"></small>

        <label for="title">Email: </label>
        <input type="text" id="lecturerEmail" name="lecturerEmail" value="" />
        <small id="validateLecturerEmail" class="error" style="display: none"></small>

        <small id="validateEditLecturerSubmit"  style="display:none" id="error_msg" class="error"></small>

        <p style="text-align: right;" >
            <button type="submit" id="updateButton" class="radius button">Create User <i class="foundicon-edit"></i></button>
        </p>
    </form>
    <a href="" class="close-reveal-modal">&times;</a>
</div>


<script type="text/javascript">                     
    $("#lecturerFirstName").keyup(function(){                                        
        if($("#lecturerFirstName").val().length >= 2)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_first_name",
                data: "lecturerFirstName="+$("#lecturerFirstName").val(),
                success: function(msg){
                    if(msg){
                        document.getElementById('validateLecturerFirstName').innerHTML=msg;
                        $('#validateLecturerFirstName').show('normal', 'linear');  
                    }
                    else
                    {
                        $('#validateLecturerFirstName').hide('normal', 'linear');
                    }
                }
            });
        }
    });
                                                        
    $("#lecturerLastName").keyup(function(){                                        
        if($("#lecturerLastName").val().length >= 2)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_last_name",
                data: "lecturerLastName="+$("#lecturerLastName").val(),
                success: function(msg){
                    if(msg){
                        document.getElementById('validateLecturerLastName').innerHTML=msg;
                        $('#validateLecturerLastName').show('normal', 'linear');  
                    }
                    else
                    {
                        $('#validateLecturerLastName').hide('normal', 'linear');
                    }
                }
            });
        }
    });
                                                        
    $("#lecturerDoB").keyup(function(){                                        
        if($("#lecturerDoB").val().length >= 2)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_date_of_birth",
                data: "lecturerDoB="+$("#lecturerDoB").val(),
                success: function(msg){
                    if(msg){
                        document.getElementById('validateLecturerDoB').innerHTML=msg;
                        $('#validateLecturerDoB').show('normal', 'linear');  
                    }
                    else
                    {
                        $('#validateLecturerDoB').hide('normal', 'linear');
                    }
                }
            });
        }
    });

    $("#lecturerEmail").keyup(function(){                                        
        if($("#lecturerEmail").val().length >= 2)
        {
            var userID = $(this).parent().find("#userID").val();
            var lecturerEmail = $(this).parent().find("#lecturerEmail").val();
                                                                                                                                                         
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_email",
                data: {
                    userID : userID,
                    lecturerEmail : lecturerEmail
                },
                success: function(msg){
                    if(msg){
                        document.getElementById('validateLecturerEmail').innerHTML=msg;
                        $('#validateLecturerEmail').show('normal', 'linear');
                    }
                    else{
                        $('#validateLecturerEmail').hide('normal', 'linear');
                    }
                }
            });
        }
    });
                                                        
                                                        
    $("#lecturerUsername").keyup(function(){                                        
        if($("#lecturerUsername").val().length >= 2)
        {
            var userID = $(this).parent().find("#userID").val();
            var lecturerUsername = $(this).parent().find("#lecturerUsername").val();
                                                                                                                                                         
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_username",
                data: {
                    userID : userID,
                    lecturerUsername : lecturerUsername
                },
                success: function(msg){
                    if(msg){
                        document.getElementById('validateLecturerUsername').innerHTML=msg;
                        $('#validateLecturerUsername').show('normal', 'linear');
                    }
                    else{
                        $('#validateLecturerUsername').hide('normal', 'linear');
                    }
                }
            });
        }
    }); 


    $("#lecturerPassword").keyup(function(){                                        
        if($("#lecturerPassword").val().length >= 2)
        {
            var userID = $(this).parent().find("#userID").val();
            var lecturerPassword = $(this).parent().find("#lecturerPassword").val();
                                                                                                                                                         
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>adm/lecturers/check_lecturer_password",
                data: {
                    userID : userID,
                    lecturerPassword : lecturerPassword
                },
                success: function(msg){
                    if(msg){
                        document.getElementById('validateLecturerPassword').innerHTML=msg;
                        $('#validateLecturerPassword').show('normal', 'linear');
                    }
                    else{
                        $('#validateLecturerPassword').hide('normal', 'linear');
                    }
                }
            });
        }
    }); 


    $('#lecturer_update_form').submit(function(event){
        event.preventDefault();
        /* get some values from elements on the page: */

        var $form = $(this),
        userID = $form.find("#userID").val(),
        lecturerFirstName = $form.find( 'input[id="lecturerFirstName"]').val(),
        lecturerLastName = $form.find("#lecturerLastName").val(),
        lecturerDoB = $form.find("#lecturerDoB").val(),
        lecturerUsername = $form.find("#lecturerUsername").val(),
        lecturerPassword = $form.find("#lecturerPassword").val(),
        lecturerEmail = $form.find("#lecturerEmail").val(),
        url = $form.attr('action');

        var request = $.ajax({
            url: url,
            type: 'POST',
            data: {
                'userID': userID,
                'lecturerFirstName': lecturerFirstName,
                'lecturerLastName': lecturerLastName,
                'lecturerDoB': lecturerDoB,
                'lecturerUsername': lecturerUsername,
                'lecturerPassword': lecturerPassword,
                'lecturerEmail': lecturerEmail
            },
            cache:false,
            dataType: 'json'
        });

        console.log(request);
                                                                                                                                                            
        request.always(function(msg) {
            if(msg.responseText != 'everything is good to go'){
                document.getElementById('validateEditLecturerSubmit').innerHTML=msg.responseText;
                $('#validateEditLecturerSubmit').show('normal', 'linear');
                //display login error message 
            }
            else
            {
                $('#validateEditLecturerSubmit').hide('normal', 'linear');
                window.location.reload(true);
            }
        });
    });
</script>