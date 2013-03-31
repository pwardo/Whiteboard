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

        <title>Whiteboard | Login</title>

        <!-- Included CSS Files (Uncompressed) -->
        <!-- <link rel="stylesheet" href="stylesheets/foundation.css"> -->
        <!-- Included CSS Files (Compressed) -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/foundation/stylesheets/foundation.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/foundation/stylesheets/app.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/foundation/foundation_icons_general/stylesheets/general_foundicons_ie7.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/foundation/foundation_icons_general/stylesheets/general_foundicons.css">

        <script src="<?php echo base_url(); ?>assets/foundation/javascripts/modernizr.foundation.js"></script>
        <script src="<?php echo base_url(); ?>assets/foundation/javascripts/jquery.js"></script>
    </head>
    <body>
        <!-- Top Bar -->
        <nav class="top-bar">
            <ul>
                <!-- Title Area -->
                <li class="name">
                    <h1>
                        <a href="">
                            Whiteboard e-Learning Platform
                        </a>
                    </h1>
                </li>
                <li class="toggle-topbar"><a href="#"></a></li>
            </ul>
        </nav>
        <!-- End Top Bar -->

        <!-- Main Page Content and Sidebar -->
        <div class="row">
            <!-- Contact Details -->
            <div class="nine columns">
                <h3>Login</h3>
                <p>Please log in to explore the features of the Whiteboard e-Learning Platform built using 
                    the <em>CodeIgniter MVC PHP Framework</em> and <em>Zurb Foundation 3 Front-end Framework</em>.
                </p>
                <dl class="contained tabs">
                </dl>
                <ul class="tabs-content contained">
                    <li id="contactFormTab" class="active">
                        <div class="row collapse">
                            <form id="login_form" action="<?php echo base_url(); ?>login/validate">
                                <div class="two columns">
                                    <label class="inline">User Name</label>
                                </div>
                                <div class="ten columns">
                                    <input type="text" isReq="true" id="yourUsername" placeholder="username" />
                                </div>
                                <div class="row collapse">
                                    <div class="two columns">
                                        <label class="inline">Password</label></div>
                                    <div class="ten columns">
                                        <input type="password" isReq="true" id="yourPassword" placeholder="password" />
                                        <small style="display:none" id="error_msg" class="error"></small>
                                    </div>
                                    <button type="submit" id="loginButton" class="radius button">Login <i class="foundicon-unlock"></i></button>
                                </div>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="result">
            </div>
            <!-- End Contact Details -->

            <!-- Sidebar -->
            <div class="three columns">
                <h3>DIT</h3>
                <p>
                    Dublin Institute of Technology, Aungier Street, Dublin 2
                </p>
                <p style="text-align: center;">
                    </br>
                    </br>
                    <img src="<?php echo base_url() . 'assets/DIT_logocol.jpg'; ?>" alt="DIT Logo"/>  </p>
                <!-- Clicking this placeholder fires the mapModal Reveal modal -->
  <!--               <p>
                    <a href="" data-reveal-id="mapModal">View Map</a>
                </p> -->
            </div>
        </div>
            <!-- End Sidebar -->
        </div>
        <!-- End Main Content and Sidebar -->

        <!-- Footer -->
        <footer class="row">
            <div class="twelve columns">
                <hr />
                <div class="row">
                    <div class="six columns">
                        <p>&copy; Copyright Patrick Ward | D11124386 | <a href="http://www.patrickward.ie" target="_blank"/>www.patrickward.ie</a></p>
                    </div>
                    <div class="six columns">
                        <ul class="link-list right">
                            <li><a href="http://www.dit.ie/" target="_blank">Dublin Institue of Technology</a></li>
 <!--                            <li><a href="#">Link 2</a></li>
                            <li><a href="#">Link 3</a></li>
                            <li><a href="#">Link 4</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->

        <!-- Map Modal -->
        <div class="reveal-modal" id="mapModal">
            <h4>Where We Are</h4>

<a action-type="56" tabindex="0" target="_blank" href="//www.google.com/url?sa=D&oi=plus&q=https://maps.google.ie/maps?ie%3DUTF8%26cid%3D410946615852413344%26q%3DDIT%2BAungier%2BSt%26iwloc%3DA%26gl%3DIE%26hl%3Den">
<img width="456" height="132" src="https://mts0.google.com/vt/data=Son45ACYcDhbdVW3GzUfiGT-4a5VEZcUvBEGQjZZKUsfpwOXtk-Eo6CqAiRVC2KYN6mRdmQa-JnUMxRBkLGlzqESJ6iJjGUtXQwa2P8" alt="Map of the business location">
</a>

<!--          <p><img src="placehold.it/800x600" /></p>-->

            <!-- Any anchor with this class will close the modal. This also inherits certain styles, which can be overriden. -->
            <a href="" class="close-reveal-modal">&times;</a>
        </div>

        <!-- End Modal -->

        <!-- Included JS Files (Uncompressed) -->
        <!--
        
        <script src="javascripts/jquery.js"></script>
        
        <script src="javascripts/jquery.foundation.mediaQueryToggle.js"></script>
        
        <script src="javascripts/jquery.foundation.forms.js"></script>
        
        <script src="javascripts/jquery.foundation.reveal.js"></script>
        
        <script src="javascripts/jquery.foundation.orbit.js"></script>
        
        <script src="javascripts/jquery.foundation.navigation.js"></script>
        
        <script src="javascripts/jquery.foundation.buttons.js"></script>
        
        <script src="javascripts/jquery.foundation.tabs.js"></script>
        
        <script src="javascripts/jquery.foundation.tooltips.js"></script>
        
        <script src="javascripts/jquery.foundation.accordion.js"></script>
        
        <script src="javascripts/jquery.placeholder.js"></script>
        
        <script src="javascripts/jquery.foundation.alerts.js"></script>
        
        <script src="javascripts/jquery.foundation.topbar.js"></script>
        
        <script src="javascripts/jquery.foundation.joyride.js"></script>
        
        <script src="javascripts/jquery.foundation.clearing.js"></script>
        
        <script src="javascripts/jquery.foundation.magellan.js"></script>
        
        -->

        <!-- Included JS Files (Compressed) -->
        <script src="<?php echo base_url(); ?>assets/foundation/javascripts/foundation.min.js"></script>

        <!-- Initialize JS Plugins -->
        <script src="<?php echo base_url(); ?>assets/foundation/javascripts/app.js"></script>
        <script type="text/javascript">
            $('#login_form').submit(function(event){
                event.preventDefault();
                /* get some values from elements on the page: */
                                    
                var $form = $( this ),
                yourUsername = $form.find( 'input[id="yourUsername"]' ).val(),
                yourPassword = $form.find( 'input[id="yourPassword"]' ).val(),
                url = $form.attr( 'action' );
                                    
                var request = $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        'yourUsername':yourUsername,
                        'yourPassword':yourPassword
                    },
                    cache:false,
                    dataType: 'json'
                });
                                    
                //                console.log(request);
                                    
                request.always(function(msg) {
                    //                    console.log(msg);
                    if(msg.responseText == "Valid"){
                        //redirect to dashboard
                        window.location.href = "<?php echo base_url(); ?>login/access_control"
                    }
                    else
                    {
                        document.getElementById("error_msg").innerHTML=msg.responseText;
                        $("#error_msg").show('normal', 'linear');
                        //display login error message  
                    }
                });
            });
        </script>
    </body>
</html>