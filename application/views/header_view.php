<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8" />

        <!-- Set the viewport width to device width for mobile -->
        <meta name="viewport" content="width=device-width" />

        <title>CI e-Learner | <?php echo $title; ?></title>

        <!-- Included CSS Files (Uncompressed) -->
        <!--
        <link rel="stylesheet" href="stylesheets/foundation.css">
        -->

        <!-- Included CSS Files (Compressed) -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/foundation/stylesheets/foundation.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/foundation/stylesheets/app.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/foundation/foundation_icons_general/stylesheets/general_foundicons_ie7.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/foundation/foundation_icons_general/stylesheets/general_foundicons.css">

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/foundation/javascripts/modernizr.foundation.js"></script>
        <script src="<?php echo base_url();?>assets/foundation/javascripts/jquery.js"></script>
<!--            <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>-->

        <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
<!--        <script type="text/javascript" src="<?php echo base_url(); ?>asset/kcfinder/ckfinder.js"></script>    -->

    </head>
    <body>

        <!-- Header and Nav -->

        <nav class="top-bar">
            <ul>
                <!-- Title Area -->
                <li class="name">
                    <h1>
                        <a href="<?php echo $home_link; ?>"> <?php echo $title;?></a>
                    </h1>
                </li>
                <li class="toggle-topbar">
                    <a href="#"></a>
                </li>
            </ul>

            <section>
                <!-- Left Nav Section -->
                <ul class="left">
                    <li class="divider"></li>
<!--                    <li class="has-dropdown">
                        <a class="active" href="#">Main Item 1</a>
                        <ul class="dropdown">
                            <li><label>Section Name</label></li>
                            <li><a href="#" class="">Dropdown Level 1</a></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li class="divider"></li>
                            <li><label>Section Name</label></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li class="divider"></li>
                            <li><a href="#">See all &rarr;</a></li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    <li><a href="#">Main Item 2</a></li>
                    <li class="divider"></li>
                    <li class="has-dropdown">
                        <a href="#">Main Item 3</a>
                        <ul class="dropdown">
                            <li><a href="#">Dropdown Option</a></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li class="divider"></li>
                            <li><a href="#">See all &rarr;</a></li>
                        </ul>
                    </li>
                    <li class="divider"></li>-->
                </ul>

                <!-- Right Nav Section -->
                <ul class="right">
<!--                    <li class="divider"></li>
                    <li class="has-dropdown">
                        <a href="#">Main Item 4</a>
                        <ul class="dropdown">
                            <li><label>Section Name</label></li>
                            <li class="has-dropdown">
                                <a href="#" class="">Has Dropdown, Level 1</a>
                                <ul class="dropdown">
                                    <li><a href="#">Dropdown Options</a></li>
                                    <li><a href="#">Dropdown Options</a></li>
                                    <li class="has-dropdown">
                                        <a href="#">Has Dropdown, Level 2</a>
                                        <ul class="dropdown test">
                                            <li><a href="#">Subdropdown Option</a></li>
                                            <li><a href="#">Subdropdown Option</a></li>
                                            <li><a href="#">Subdropdown Option</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Subdropdown Option</a></li>
                                    <li><a href="#">Subdropdown Option</a></li>
                                    <li><a href="#">Subdropdown Option</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li class="divider"></li>
                            <li><label>Section Name</label></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li><a href="#">Dropdown Option</a></li>
                            <li class="divider"></li>
                            <li><a href="#">See all &rarr;</a></li>
                        </ul>
                    </li>-->
                    <li class="divider"></li>
                    <?php
                    if ($home_link === base_url() . 'stu')
                    {
                        ?>
                        <li><a href="<?php echo base_url().'stu/student/all_modules';?>">Find Modules</a></li>
                        <?php
                    }
                    elseif ($home_link === base_url() . 'adm') 
                    {
                        ?>
                        <li><a href="<?php echo base_url().'adm/modules/index';?>">Modules</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'adm/lecturers/index';?>">Lecturers</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'adm/students/index';?>">Students</a></li>
                        <?php
                    }
                    else
                    {
                        ?>
<!--                        <li><a href="#">Menu Item 5</a></li>-->
                        <?php
                    }
                    ?>
                    <li class="divider"></li>
                    <li class="has-dropdown">
                        <a href="#"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></a>
                        <ul class="dropdown">
               <!--              <li><a href="#">Edit Profile</a></li>
                            <li><a href="#">Account</a></li> -->
                            <li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
        </nav>
        <!-- End Header and Nav -->