<div class="row">
    <div class="panel">
        <h5 style="text-align: center">
            <a href="" data-reveal-id="addModule">Add a New Module</a></h5>
    </div>
</div>

<div class="row">
    <?php
    if (empty($all_modules))
    {
        ?>
        <div class="panel">
            <h5>No Modules have been created yet</h5>
        </div>
        <?php
    }
    else
    {
        foreach ($all_modules as $module)
        {
            ?>
            <div class="panel">
        <!--                    <h5>Module ID : <?php echo $module['id']; ?></h5>-->
                <h5>Module Title : <?php echo $module['title']; ?></h5>
                <p><em>Code : </em><?php echo $module['code']; ?></p>
                <?php
                if (!empty($module['description']))
                {
                    ?>
                    <p><em>Description : </em><?php echo $module['description']; ?></p>
                    <?php
                }
                else
                {
                    ?>
                    <p><b>No Description Entered.</b></p>
                    <?php
                }

                if (!empty($module['first_name']))
                {
                    ?>
                    <p><em>Lecturer : </em><?php echo $module['first_name'] . ' ' . $module['last_name']; ?></p>
                    <?php
                }
                else
                {
                    ?>
                    <p><b>No Lecturer Assigned.</b></p>
                    <?php
                }
                ?>
                <p style="text-align: right" >
                    <a href="" class="radius button"  
                       data-reveal-id="editModule-<?php echo $module['id']; ?>"
                       data-animation="fade" data-animationspeed="300" 
                       data-closeonbackgroundclick="true" 
                       data-dismissmodalclass="close-reveal-modal">Edit</a>
                </p>

                <!-- Edit a module --------------------------------------------------------------------------------------->
                <?php $id = $module['id']; ?>
                <div class="reveal-modal" id="editModule-<?php echo $id; ?>">
                    <form id="module_update_form-<?php echo $id; ?>" action="<?php echo base_url() . 'adm/modules/edit_module'; ?>" method="POST">
                        <label for="title">Module Title: </label>
                        <input type="hidden" id="moduleID-<?php echo $id; ?>" name="moduleID" value="<?php echo $id; ?>">         
                        <input type="text" id="moduleTitle-<?php echo $id; ?>" name="moduleTitle" value="<?php echo $module['title']; ?>" />
                        <small id="validateTitle-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <label for="code">Module Code: </label>
                        <input type="text" id="moduleCode-<?php echo $id; ?>" name="moduleCode" class="twelve" value="<?php echo $module['code']; ?>" />
                        <small id="validateCode-<?php echo $id; ?>" class="error" style="display: none"></small>


                        <select id="moduleLecturer-<?php echo $id; ?>" name="moduleLecturer" class="twelve" />
                        <?php
                        if (!empty($module['user_id']))
                        {
                            foreach ($all_lecturers as $lecturer)
                            {
                                if ($lecturer['user_id'] === $module['user_id'])
                                {
                                    ?>
                                    <option value="<?php echo $lecturer['user_id']; ?>" selected><?php echo $lecturer['first_name'] . ' ' . $lecturer['last_name']; ?></option>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <option value="<?php echo $lecturer['user_id']; ?>"><?php echo $lecturer['first_name'] . ' ' . $lecturer['last_name']; ?></option>
                                    <?php
                                }
                            }
                        }
                        else
                        {
                            echo '<option value=' . 0 . ' selected >No Lecturer Assigned</option>';

                            foreach ($all_lecturers as $lecturer)
                            {
                                echo '<option value=' . $lecturer['user_id'] . '>' . $lecturer['first_name'] . ' ' . $lecturer['last_name'] . '</option>';
                            }
                        }
                        ?>
                        </select>
                        <p></p>
                        <small id="validateModuleLecturer-<?php echo $id; ?>" class="error" style="display: none"></small>                        

                        <label for="description">Module Description: </label>
                        <textarea style="max-width: 100%;" id="moduleDescription-<?php echo $id; ?>" name="moduleDescription"><?php echo $module['description']; ?></textarea>
                        <small id="validateDescription-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <small id="validateSubmit-<?php echo $id; ?>"  style="display:none" id="error_msg" class="error"></small>

                        <p style="text-align: right;" >
                            <button type="submit" id="updateButton-<?php echo $id; ?>"  class="radius button">Update <i class="foundicon-edit"></i></button>
                        </p>
                    </form>
                    <a href="" class="close-reveal-modal">&times;</a>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#moduleTitle-<?php echo $id; ?>").keyup(function(){                                        
                        if($("#moduleTitle-<?php echo $id; ?>").val().length >= 2)
                        {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>adm/modules/check_module_title",
                                data: "moduleTitle="+$("#moduleTitle-<?php echo $id; ?>").val(),
                                success: function(msg){
                                    if(msg){
                                        document.getElementById('validateTitle-<?php echo $id; ?>').innerHTML=msg;
                                        $('#validateTitle-<?php echo $id; ?>').show('normal', 'linear');  
                                    }
                                    else
                                    {
                                        $('#validateTitle-<?php echo $id; ?>').hide('normal', 'linear');
                                    }
                                }
                            });
                                                                                                                                                            
                        }
                    });
                                                                                                                                                        
                    $("#moduleCode-<?php echo $id; ?>").keyup(function(){                                        
                        if($("#moduleCode-<?php echo $id; ?>").val().length >= 2)
                        {
                            var moduleID = $(this).parent().find("#moduleID-<?php echo $id; ?>").val();
                            var moduleCode = $(this).parent().find("#moduleCode-<?php echo $id; ?>").val();
                                                                                                                                                         
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>adm/modules/check_module_code",
                                data: {
                                    moduleID : moduleID,
                                    moduleCode : moduleCode
                                },
                                success: function(msg){
                                    if(msg){
                                        document.getElementById('validateCode-<?php echo $id; ?>').innerHTML=msg;
                                        $('#validateCode-<?php echo $id; ?>').show('normal', 'linear');
                                    }
                                    else{
                                        $('#validateCode-<?php echo $id; ?>').hide('normal', 'linear');
                                    }
                                }
                            });
                        }
                    });
                                                                                                                                                        
                    $("#moduleDescription-<?php echo $id; ?>").keyup(function(){                                        
                        if($("#moduleDescription-<?php echo $id; ?>").val().length >= 2)
                        {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>adm/modules/check_module_description",
                                data: "moduleDescription="+$("#moduleDescription-<?php echo $id; ?>").val(),
                                success: function(msg){
                                    if(msg){
                                        document.getElementById('validateDescription-<?php echo $id; ?>').innerHTML=msg;
                                        $('#validateDescription-<?php echo $id; ?>').show('normal', 'linear');                        
                                    }
                                    else{
                                        $('#validateDescription-<?php echo $id; ?>').hide('normal', 'linear');
                                    }
                                }
                            });
                        }
                    });
                                                                                                                                                                
                    $('#module_update_form-<?php echo $id; ?>').submit(function(event){
                        event.preventDefault();
                        /* get some values from elements on the page: */

                        var $form = $( this ),
                        moduleID = $form.find( 'input[id="moduleID-<?php echo $id; ?>"]').val(),
                        moduleTitle = $form.find( 'input[id="moduleTitle-<?php echo $id; ?>"]').val(),
                        moduleCode = $form.find( 'input[id="moduleCode-<?php echo $id; ?>"]').val(),
                        moduleLecturer = $form.find("#moduleLecturer-<?php echo $id; ?>").val(),
                        moduleDescription = $form.find( 'textarea[id="moduleDescription-<?php echo $id; ?>"]').val(),
                        url = $form.attr( 'action' );

                        var request = $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                'moduleID': moduleID,
                                'moduleTitle': moduleTitle,
                                'moduleCode': moduleCode,
                                'moduleLecturer': moduleLecturer,
                                'moduleDescription' : moduleDescription
                            },
                            cache:false,
                            dataType: 'json'
                        });

                        console.log(request);
                                                                                                                                                            
                        request.always(function(msg) {
                            //                console.log(msg);
                            if(msg.responseText == 'All fields are required.'){
                                document.getElementById('validateSubmit-<?php echo $id; ?>').innerHTML=msg.responseText;
                                $('#validateSubmit-<?php echo $id; ?>').show('normal', 'linear');
                            }
                            else
                            {
                                //redirect to 
                                window.location.href = msg.responseText;
                            }
                        });
                    });
                });
            </script>
            <?php
        } //  END OF foreach ($modules as $module)
    }
    ?>
    <!-- Edit Module END --------------------------------------------------------------------------------- -->

    <!-- Edit a module --------------------------------------------------------------------------------------->
    <div class="reveal-modal" id="addModule">
        <form id="module_update_form" action="<?php echo base_url() . 'adm/modules/create_module'; ?>" method="POST">
            <label for="title">Module Title: </label>
            <input type="hidden" id="moduleID" name="moduleID" value="">         
            <input type="text" id="moduleTitle" name="moduleTitle" value="" />
            <small id="validateTitle" class="error" style="display: none"></small>

            <label for="code">Module Code: </label>
            <input type="text" id="moduleCode" name="moduleCode" class="twelve" value="" />
            <small id="validateCode" class="error" style="display: none"></small>


            <select id="moduleLecturer" name="moduleLecturer" class="twelve" />
            <?php
            echo '<option value=' . 0 . ' selected >No Lecturer Assigned</option>';

            foreach ($all_lecturers as $lecturer)
            {
                echo '<option value=' . $lecturer['user_id'] . '>' . $lecturer['first_name'] . ' ' . $lecturer['last_name'] . '</option>';
            }
            ?>
            </select>
            <p></p>
            <small id="validateModuleLecturer" class="error" style="display: none"></small>                        

            <label for="description">Module Description: </label>
            <textarea style="max-width: 100%;" id="moduleDescription" name="moduleDescription" ></textarea>
            <small id="validateDescription" class="error" style="display: none"></small>

            <small id="validateSubmit"  style="display:none" id="error_msg" class="error"></small>

            <p style="text-align: right;" >
                <button type="submit" id="updateButton"  class="radius button">Create Module <i class="foundicon-edit"></i></button>
            </p>
        </form>
        <a href="" class="close-reveal-modal">&times;</a>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#moduleTitle").keyup(function(){                                        
                if($("#moduleTitle").val().length >= 2)
                {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>adm/modules/check_module_title",
                        data: "moduleTitle="+$("#moduleTitle").val(),
                        success: function(msg){
                            if(msg){
                                document.getElementById('validateTitle').innerHTML=msg;
                                $('#validateTitle').show('normal', 'linear');  
                            }
                            else
                            {
                                $('#validateTitle').hide('normal', 'linear');
                            }
                        }
                    });
                                                                                    
                }
            });
                                                                                
            $("#moduleCode").keyup(function(){                                        
                if($("#moduleCode").val().length >= 2)
                {
                    var moduleID = $(this).parent().find("#moduleID").val();
                    var moduleCode = $(this).parent().find("#moduleCode").val();
                                                                                 
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>adm/modules/check_module_code",
                        data: {
                            moduleID : moduleID,
                            moduleCode : moduleCode
                        },
                        success: function(msg){
                            if(msg){
                                document.getElementById('validateCode').innerHTML=msg;
                                $('#validateCode').show('normal', 'linear');
                            }
                            else{
                                $('#validateCode').hide('normal', 'linear');
                            }
                        }
                    });
                }
            });
                                                                                
            $("#moduleDescription").keyup(function(){                                        
                if($("#moduleDescription").val().length >= 2)
                {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>adm/modules/check_module_description",
                        data: "moduleDescription="+$("#moduleDescription").val(),
                        success: function(msg){
                            if(msg){
                                document.getElementById('validateDescription').innerHTML=msg;
                                $('#validateDescription').show('normal', 'linear');                        
                            }
                            else{
                                $('#validateDescription').hide('normal', 'linear');
                            }
                        }
                    });
                }
            });
                                                                                        
            $('#module_update_form').submit(function(event){
                event.preventDefault();
                /* get some values from elements on the page: */

                var $form = $( this ),
                moduleID = $form.find( 'input[id="moduleID"]').val(),
                moduleTitle = $form.find( 'input[id="moduleTitle"]').val(),
                moduleCode = $form.find( 'input[id="moduleCode"]').val(),
                moduleLecturer = $form.find("#moduleLecturer").val(),
                moduleDescription = $form.find( 'textarea[id="moduleDescription"]').val(),
                url = $form.attr( 'action' );

                var request = $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        'moduleID': moduleID,
                        'moduleTitle': moduleTitle,
                        'moduleCode': moduleCode,
                        'moduleLecturer': moduleLecturer,
                        'moduleDescription' : moduleDescription
                    },
                    cache:false,
                    dataType: 'json'
                });

                console.log(request);
                                                                                    
                request.always(function(msg) {
                    //                console.log(msg);
                    if(msg.responseText == 'All fields are required.'){
                        document.getElementById('validateSubmit').innerHTML=msg.responseText;
                        $('#validateSubmit').show('normal', 'linear');
                    }
                    else
                    {
                        //redirect to 
                        window.location.href = msg.responseText;
                        //                                    alert(msg.responseText);
                    }

                });
            });
        });
    </script>
    <!-- Create Module END --------------------------------------------------------------------------------- -->

</div>
<!-- End Grid Section -->