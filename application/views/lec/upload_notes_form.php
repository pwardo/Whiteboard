<!-- Main Grid Section -->

<div class="row">
    <div class="six columns">
        <div class="panel" style="height: 150px;">
            <h5><?php echo $module_details['title'] ?></h5>
            <h6><?php echo $module_details['code'] ?></h6>
            <p><?php echo $module_details['description'] ?></p>
        </div>
    </div>

    <div class="six columns">
        <div class="panel" style="height: 150px;">
            <h5><?php echo $error; ?></h5>
<!--            <h6><?php echo $module_id; ?></h6>-->
            <p><?php echo form_open_multipart('lec/notes/do_upload/' . $module_id); ?></p>
            <p style="text-align: center">
                <input type="file" class="button expand postfix" name="userfile" size="30"/>
            </p>
            <p style="text-align: right">
                <button type="submit" class="radius button">Upload  <i class="foundicon-add-doc"></i></button>
            </p>
            </form>
        </div>
    </div>
</div>