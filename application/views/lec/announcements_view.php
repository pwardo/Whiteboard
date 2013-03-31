<!-- Main Grid Section -->
<div class="row">
    <div class="twelve columns">
        <div class="panel">
            <h5><?php echo $module_details['title'] ?>, <?php echo $module_details['code']; ?></h5>
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
            <h5 style="text-align: center;"><a href="" data-reveal-id="makeAnnouncement">Make an Announcement</a></h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="twelve columns">
        <?php
        if (!$module_announcements)
        {
            ?>
            <div class="panel">
                <h5>You have not made any announcements for this module.</h5>
            </div>
            <?php
        }
        else
        {
            foreach ($module_announcements as $module_announcement)
            {
                ?>
                <div class="panel">
                    <h5><?php echo $module_announcement['title']; ?></h5>
                    <p><b>Content: </b><br/><?php echo $module_announcement['content']; ?></p>
                    <p style="text-align: center;" >
                        <a href="" class="radius button"  data-reveal-id="editAnnouncement-<?php echo $module_announcement['id']; ?>">Edit</a>
                    </p>
                </div>        
                <!-- End Grid Section ----------------------------------------------------------------------------------->


                <!-- Edit an announcement --------------------------------------------------------------------------------------->
                <?php $id = $module_announcement['id']; ?>
                <div class="reveal-modal" id="editAnnouncement-<?php echo $id; ?>">
                    <form id="announcement_update_form-<?php echo $id; ?>" action="<?php echo base_url() . 'lec/announcements/edit_announcement'; ?>" method="POST">

                        <label for="announcementTitle">Announcement Title: (i.e. class announcement, final announcement)</label>
                        <input type="hidden" id="announcementID-<?php echo $id; ?>" name="announcementID" value="<?php echo $module_announcement['id']; ?>"/>         
                        <input type="text" id="announcementTitle-<?php echo $id; ?>" name="announcementTitle" value="<?php echo $module_announcement['title']; ?>" />
                        <small id="validateAnnouncementTitle-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <label for="announcementContent-<?php echo $id; ?>">Announcement Content: </label>
                        <textarea style="max-width: 100%;" id="announcementContent-<?php echo $id; ?>" name="announcementContent" ><?php
        if ($module_announcement['content'])
        {

            echo $module_announcement['content'];
        }
        else
        {
            echo '(Optional)';
        }
                ?></textarea>
                        <small id="validateAnnouncementContent-<?php echo $id; ?>" class="error" style="display: none"></small>

                        <small id="validateAnnouncementSubmit-<?php echo $id; ?>" style="display:none" id="error_msg" class="error"></small>

                        <p style="text-align: right;" >
                            <button type="submit" id="updateButton-<?php echo $id; ?>" class="radius button">Update <i class="foundicon-edit"></i></button>
                        </p>
                    </form>
                    <a href="" class="close-reveal-modal">&times;</a>
                </div>

                <script type="text/javascript">
                    $("#announcementTitle-<?php echo $id; ?>").keyup(function(){                                        
                        if($("#announcementTitle-<?php echo $id; ?>").val().length >= 4)
                        {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>lec/announcements/check_announcement_title",
                                data: "announcementTitle="+$("#announcementTitle-<?php echo $id; ?>").val(),
                                success: function(msg){
                                    if(msg){
                                        document.getElementById('validateAnnouncementTitle-<?php echo $id; ?>').innerHTML=msg;
                                        $('#validateAnnouncementTitle-<?php echo $id; ?>').show('normal', 'linear');  
                                    }
                                    else
                                    {
                                        $('#validateAnnouncementTitle-<?php echo $id; ?>').hide('normal', 'linear');
                                    }
                                }
                            });
                        }
                    });
                                                                  
                    // check content does not exceed 500 characters
                    $("#announcementContent-<?php echo $id; ?>").keyup(function(){                                        
                        if($("#announcementContent-<?php echo $id; ?>").val().length >= 2)
                        {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>lec/announcements/check_announcement_content",
                                data: "announcementContent="+$("#announcementContent-<?php echo $id; ?>").val(),
                                success: function(msg){
                                    if(msg){
                                        document.getElementById('validateAnnouncementContent-<?php echo $id; ?>').innerHTML=msg;
                                        $('#validateAnnouncementContent-<?php echo $id; ?>').show('normal', 'linear');                        
                                    }
                                    else{
                                        $('#validateAnnouncementContent-<?php echo $id; ?>').hide('normal', 'linear');
                                    }
                                }
                            });
                        }
                    });
                                                                            
                    $('#announcement_update_form-<?php echo $id; ?>').submit(function(event){
                        event.preventDefault();
                        /* get some values from elements on the page: */

                        var $form = $( this ),
                        announcementID = $form.find('input[id="announcementID-<?php echo $id; ?>"]').val(),
                        moduleID = <?php echo $module_details['id']; ?>,
                        announcementTitle = $form.find('input[id="announcementTitle-<?php echo $id; ?>"]').val(),
                        announcementContent = $form.find('textarea[id="announcementContent-<?php echo $id; ?>"]').val(),
                        url = $form.attr( 'action' );

                        var request = $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                'announcementID': announcementID,
                                'moduleID': moduleID,
                                'announcementTitle': announcementTitle,
                                'announcementContent' : announcementContent
                            },
                            cache:false,
                            dataType: 'json'
                        });
                                                                                                                                                       
                        request.always(function(msg) {
                            if(msg.responseText != 'everything is good to go'){
                                document.getElementById('validateAnnouncementSubmit-<?php echo $id; ?>').innerHTML=msg.responseText;
                                $('#validateAnnouncementSubmit-<?php echo $id; ?>').show('normal', 'linear');
                                //display login error message 
                            }
                            else
                            {
                                $('#validateAnnouncementSubmit-<?php echo $id; ?>').hide('normal', 'linear');
                                $('#makeAnnouncement-<?php echo $id; ?>').hide('normal', 'linear');
                                window.location.reload(true);
                            }
                        });
                    });                     
                </script>
                <?php
            } // End of foreach ($module_announcements as $module_announcement)
        }
        ?>
    </div>
    <!-- Edit an announcement END --------------------------------------------------------------------------------- -->

    <!-- Make an Announcement ------------------------------------------------------------------------------ -->
    <div class="reveal-modal" id="makeAnnouncement">
        <form id="make_announcement_form" action="<?php echo base_url() . 'lec/announcements/add_announcement'; ?>" method="POST">
            <label for="announcementTitle">Announcement Title:</label>
            <input type="hidden" id="moduleID" name="moduleID" value="<?php echo $module_details['id']; ?>"/>         
            <input type="text" id="announcementTitle" name="announcementTitle" value="" />
            <small id="validateNewAnnouncementTitle" class="error" style="display: none"></small>

            <label for="announcementContent">Announcement Content: </label>
            <textarea style="max-width: 100%;" id="announcementContent" name="announcementContent" ></textarea>
            <small id="validateNewAnnouncementContent" class="error" style="display: none"></small>

            <small id="validateNewAnnouncementSubmit" style="display:none" id="error_msg" class="error"></small>

            <p style="text-align: right;" >
                <button type="submit" id="updateButton" class="radius button">Make Announcement <i class="foundicon-edit"></i></button>
            </p>
        </form>
        <a href="" class="close-reveal-modal">&times;</a>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            // function for make new announcement form ------------
            // this will check announcement title while user is typing
            $("#announcementTitle").keyup(function(){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>lec/announcements/check_announcement_title",
                    data: "announcementTitle="+$("#announcementTitle").val(),
                    success: function(msg){
                        if(msg){
                            document.getElementById('validateNewAnnouncementTitle').innerHTML=msg;
                            $('#validateNewAnnouncementTitle').show('normal', 'linear');  
                        }
                        else
                        {
                            $('#validateNewAnnouncementTitle').hide('normal', 'linear');
                        }
                    }
                });
            });
                
            // check content does not exceed 500 characters
            $("#announcementContent").keyup(function(){                                        
                if($("#announcementContent").val().length >= 2)
                {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>lec/announcements/check_announcement_content",
                        data: "announcementContent="+$("#announcementContent").val(),
                        success: function(msg){
                            if(msg){
                                document.getElementById('validateNewAnnouncementContent').innerHTML=msg;
                                $('#validateNewAnnouncementContent').show('normal', 'linear');                        
                            }
                            else{
                                $('#validateNewAnnouncementContent').hide('normal', 'linear');
                            }
                        }
                    });
                }
            });

            // This will do final check when "make new announcement" button is pressed
            $('#make_announcement_form').submit(function(event){
                event.preventDefault();
                /* get some values from elements on the page: */

                var $form = $( this ),
                moduleID = $form.find('input[id="moduleID"]').val(),
                announcementTitle = $form.find('input[id="announcementTitle"]').val(),
                announcementContent = $form.find('textarea[id="announcementContent"]').val(),
                url = $form.attr( 'action' );

                var request = $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        'moduleID': moduleID,
                        'announcementTitle': announcementTitle,
                        'announcementContent' : announcementContent
                    },
                    cache:false,
                    dataType: 'json'
                });
               
                request.always(function(msg) {
                    if(msg.responseText != 'everything is good to go'){
                        document.getElementById('validateNewAnnouncementSubmit').innerHTML=msg.responseText;
                        $('#validateNewAnnouncementSubmit').show('normal', 'linear');
                        //display login error message 
                    }
                    else
                    {
                        $('#validateNewAnnouncementSubmit').hide('normal', 'linear');
                        $('#makeAnnouncement').hide('normal', 'linear');
                        window.location.reload(true);
                    }

                });
            });    
        });
    </script>