<?php
/*
Plugin Name: DDL Cookie Consent
Version: 2.0.0
Description: Declares a plugin that creates a cookie popup.
Author: Dental Design
Author URI: https://dental-design.marketing/
License: GPL2
*/


/*-----------------------------------------------------------------------------------*/
/* ADD OPTIONS TO ADMIN */
/*-----------------------------------------------------------------------------------*/

/* --------------------- REGISTER OPTIONS --------------------- */

function add_cookie_options_page() {

  $icon = plugin_dir_url( __FILE__ ) . '/assets/img/cookie-icon.svg';

	add_menu_page (
		'Cookie Options',
		'Cookie Consent',
		'manage_options',
		'cookie-options-page',
		'display_cookie_options_page',
    $icon
	);

}

add_action( 'admin_menu', 'add_cookie_options_page' );


/* --------------------- STYLE THE ICON --------------------- */

function admin_cookie_icon_style() {
  echo '<style>
    .toplevel_page_cookie-options-page .wp-menu-image img{
      max-width: 18px;
      max-height: 18px;  
    }
  </style>';
}

add_action('admin_head', 'admin_cookie_icon_style');


/* --------------------- DISPLAY OPTIONS FORM --------------------- */

function display_cookie_options_page() {

	echo '<h1 style="margin: 30px 0 40px;">Cookie Consent Options</h1>';

	echo '<form method="post" action="options.php">';

	do_settings_sections( 'cookie-options-page' );
	settings_fields( 'cookie-options' );

	submit_button();

	echo '</form>';

}


/* --------------------- POP-UP SETTINGS SECTION --------------------- */

function admin_init_cookie_dialog() {

	add_settings_section (
		'cookie-dialog-section',
		'Pop-up Options',
		'cookie_dialog_section_message',
		'cookie-options-page'
	);

  /* --- ADD FIELDS --- */

	add_settings_field ('cookie-message','Pop-up message:','render_cookie_message','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-policy-link','Policy page link URL:','render_cookie_policy_link','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-policy-text','Policy page link text:','render_cookie_policy_text','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-background','Background colour:','render_cookie_background','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-colour','Text colour:','render_cookie_colour','cookie-options-page','cookie-dialog-section');
  
  add_settings_field ('cookie-accept-background','Accept button background colour:','render_cookie_accept_background','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-accept-border','Accept button border colour:','render_cookie_accept_border','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-accept-colour','Accept button text colour:','render_cookie_accept_colour','cookie-options-page','cookie-dialog-section');

  add_settings_field ('cookie-reject-background','Reject button background colour:','render_cookie_reject_background','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-reject-border','Reject button border colour:','render_cookie_reject_border','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-reject-colour','Reject button text colour:','render_cookie_reject_colour','cookie-options-page','cookie-dialog-section');

  add_settings_field ('cookie-reset-text','Reset link text:','render_cookie_reset_text','cookie-options-page','cookie-dialog-section');


  /* --- REGISTER FIELDS --- */

	register_setting ('cookie-options','cookie-message');
  register_setting ('cookie-options','cookie-policy-link');
  register_setting ('cookie-options','cookie-policy-text');
  register_setting ('cookie-options','cookie-background');
  register_setting ('cookie-options','cookie-colour');

  register_setting ('cookie-options','cookie-accept-background');
  register_setting ('cookie-options','cookie-accept-border');
  register_setting ('cookie-options','cookie-accept-colour');

  register_setting ('cookie-options','cookie-reject-background');
  register_setting ('cookie-options','cookie-reject-border');
  register_setting ('cookie-options','cookie-reject-colour');

  register_setting ('cookie-options','cookie-reset-text');

}

add_action( 'admin_init', 'admin_init_cookie_dialog' );


/* --- SECTION MESSAGE --- */

function cookie_dialog_section_message() {
	echo "Use these options to alter the text and styling of the pop-up.";
}


/* --- RENDER FIELDS --- */

function render_cookie_message() {

	$input = get_option( 'cookie-message' );
	echo '<textarea style="width:500px;" id="cookie-message" name="cookie-message" rows="5" cols="30" spellcheck="false" placeholder="This website uses cookies to provide necessary functionality and improve your experience.">' . $input . '</textarea>
  <p class="description" id="cookie-message-description">Enter your text here to override the default pop-up message. If you override this pop-up message, the cookie policy link below will no longer appear.</p>';

}

function render_cookie_policy_link() {

	$input = get_option( 'cookie-policy-link' );
	echo '<input style="width:500px;" type="text" id="cookie-policy-link" name="cookie-policy-link" value="' . $input . '" />
  <p class="description" id="cookie-policy-link-description">A default cookie policy has been created here: <a href="' . site_url() . '/cookie-policy/" target="_blank">' . site_url() . '/cookie-policy/</a>.</p>
  <p class="description" id="cookie-policy-link-description">Please add this link above to enable the policy link, or enter your own policy URL.</p>';
  
}

function render_cookie_policy_text() {

	$input = get_option( 'cookie-policy-text' );
	echo '<input style="width:500px;" type="text" id="cookie-policy-text" name="cookie-policy-text" placeholder="cookie policy" value="' . $input . '" />';

}

function render_cookie_background() {

	$input = get_option( 'cookie-background' );
	echo '<input style="width:500px;" type="text" id="cookie-background" name="cookie-background" placeholder="#000000" value="' . $input . '" />';

}

function render_cookie_colour() {

	$input = get_option( 'cookie-colour' );
	echo '<input style="width:500px;" type="text" id="cookie-colour" name="cookie-colour" placeholder="#ffffff" value="' . $input . '" />';

}

function render_cookie_accept_background() {

	$input = get_option( 'cookie-accept-background' );
	echo '<input style="width:500px;" type="text" id="cookie-accept-background" name="cookie-accept-background" placeholder="#000000" value="' . $input . '" />';

}

function render_cookie_accept_border() {

	$input = get_option( 'cookie-accept-border' );
	echo '<input style="width:500px;" type="text" id="cookie-accept-border" name="cookie-accept-border" placeholder="#838383" value="' . $input . '" />';

}

function render_cookie_accept_colour() {

	$input = get_option( 'cookie-accept-colour' );
	echo '<input style="width:500px;" type="text" id="cookie-accept-colour" name="cookie-accept-colour" placeholder="#ffffff" value="' . $input . '" />';

}

function render_cookie_reject_background() {

	$input = get_option( 'cookie-reject-background' );
	echo '<input style="width:500px;" type="text" id="cookie-reject-background" name="cookie-reject-background" placeholder="#000000" value="' . $input . '" />';

}

function render_cookie_reject_border() {

	$input = get_option( 'cookie-reject-border' );
	echo '<input style="width:500px;" type="text" id="cookie-reject-border" name="cookie-reject-border" placeholder="#838383" value="' . $input . '" />';

}

function render_cookie_reject_colour() {

	$input = get_option( 'cookie-reject-colour' );
	echo '<input style="width:500px;" type="text" id="cookie-reject-colour" name="cookie-reject-colour" placeholder="#ffffff" value="' . $input . '" />';

}

function render_cookie_reset_text() {

	$input = get_option( 'cookie-reset-text' );
	echo '<input style="width:500px;" type="text" id="cookie-reset-text" name="cookie-reset-text" placeholder="Please click here to reset your cookie preference" value="' . $input . '" />
  <p class="description" id="cookie-policy-link-description">To enable the reset link, please add this shotcode: [cookie-reset]</p>';

}


/* --------------------- TRACKING SETTINGS SECTION --------------------- */

function admin_init_cookie_tracking() {

	add_settings_section (
		'cookie-tracking-section',
		'Tracking Settings',
		'cookie_tracking_section_message',
		'cookie-options-page'
	);

  /* --- ADD FIELDS --- */

  add_settings_field ('cookie-tag','Google Tag Manager tracking ID','render_cookie_tag','cookie-options-page','cookie-tracking-section');
  add_settings_field ('cookie-pixel','Facebook Pixel code','render_cookie_pixel','cookie-options-page','cookie-tracking-section');


  /* --- REGISTER FIELDS --- */

  register_setting ('cookie-options','cookie-tag');
  register_setting ('cookie-options','cookie-pixel');

}

add_action( 'admin_init', 'admin_init_cookie_tracking' );


/* --- SECTION MESSAGE --- */

function cookie_tracking_section_message() {
	echo "Use these options to add your tracking codes.";
}


/* --- RENDER FIELDS --- */

function render_cookie_tag() {

	$input = get_option( 'cookie-tag' );
	echo '<input style="width:500px;" type="text" id="cookie-tag" name="cookie-tag" value="' . $input . '" /><p class="description" id="cookie-tag-description">
  Add your Google Tag Manager ID (e.g. GTM-XXXXXXX) to enable tracking.</p>';

}

function render_cookie_pixel() {

	$input = get_option( 'cookie-pixel' );
	echo '<input style="width:500px;" type="text" id="cookie-pixel" name="cookie-pixel" value="' . $input . '" /><p class="description" id="cookie-pixel-description">
  Add your Facebook Pixel Code to enable tracking.</p>';

}


/*-----------------------------------------------------------------------------------*/
/* ADD COOKIE PAGE ON INSTALL */
/*-----------------------------------------------------------------------------------*/

/* --------------------- CREATE PAGE ON ACTIVATION --------------------- */

define( 'COOKIE_PLUGIN_FILE', __FILE__ );

register_activation_hook( COOKIE_PLUGIN_FILE, 'cookie_plugin_activation' );

function cookie_plugin_activation() {

  $url = get_site_url();
  $parse = parse_url($url);
  $domain = str_replace("www.", "",$parse['host']);
  
  if ( ! current_user_can( 'activate_plugins' ) ) return;
  
  global $wpdb;
  
  if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'cookie-policy'", 'ARRAY_A' ) ) {

    $current_user = wp_get_current_user();

    $policyContent = '<p>This website <strong>' . $domain . '</strong> uses cookies to collect information. This Cookie Policy explains what cookies are and how we use them to provide the best experience for you. By using our website, you agree that we may use cookies according to this policy.</p>

    <h3>What are Cookies?</h3>
    <p>Cookies are text files with a small amount of data placed on your computer browser, to collect standard Internet log information and visitor behaviour information in an anonymous form. Cookies can memorise information about your visit to the website and this is then used on your next visit to make it more relevant and useful for you.</p>

    <p>When you visit our website, we deploy cookies to provide an online service suited to the type of device you are using. They also collect information on your preferences and how you use the site to create statistical analysis.</p>

    <h3>Classification Information</h3>
    <p>Cookies fall into two general categories:</p>

    <p><strong>Technical cookies</strong>: essential for the website to function correctly and for a user to properly navigate it.</p>
    <p><strong>Profiling cookies</strong>: used to track user navigation and create a profile which can be used to send promotional material based on their preferences.</p>

    <p>This website uses technical cookies and in particular the following classifications:</p>

    <p><strong>Session cookies</strong>, which are deleted when a user closes the browser window</p>
    <p><strong>Persistent cookies</strong>, which remain in the browser&rsquo;s memory for a certain amount of time. They typically remember settings and preferences that have previously been saved</p>
    <p><strong>Proprietary cookies</strong>, which are created and managed directly by the operator of the website the user is browsing</p>
    <p><strong>Third-party cookies</strong>, which are created and managed by parties other than the website operator</p>

    <p>Session, persistent and proprietary cookies are needed to navigate the site and create a seamless user experience</p>

    <p>Third-party cookies are used to send information to Google Analytics for statistical analysis on an aggregated, anonymous basis. Use of these cookies allows us to analyse how visitors access and use the website, in purely statistical form. You are able to opt-out and prevent Google from collecting data through cookies by installing a plug-in <a href="https://tools.google.com/dlpage/gaoptout" target="_blank">https://tools.google.com/dlpage/gaoptout</a>.</p> 

    <h3>Specific Categorisation of Cookies Used</h3>

    <p><strong>Necessary cookies</strong><br>These are essential for the site to operate correctly and provide the services you require when visiting the site. They allow the basic features of the site, such as navigation and maintaining security and privacy.</p>

    <p><strong>Preference cookies</strong><br>These enable a website to remember information that changes how a website looks or behaves for a user, such as preferred language or region.</p>

    <p><strong>Performance cookies</strong><br>These collect and report anonymous data to help website operators understand how visitors interact with their site.</p>

    <p><strong>Marketing/Targeting cookies</strong><br>These are used to provide content that best suits an individual user and their interests, making messages and advertisements more relevant and personalised.</p>

    <h3>What types of cookies do we use?</h3>
    <p><strong>Strictly Necessary</strong></p>
    <table class="cookie-dialog__table">
      <thead>
        <tr>
          <th>Cookie name</th>
          <th>Provider</th>
          <th>Type</th>
          <th>Expiry</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>cookieConsent</td>
          <td>' . $domain . '</td>
          <td>Proprietary</td>
          <td>6 months</td>
          <td>This cookie stores the user&rsquo;s cookie consent state for the current domain.</td>
        </tr>
        <tr>
          <td>ARRAffinitySameSite</td>
          <td>azure.microsoft.com</td>
          <td>Third-party</td>
          <td>Session</td>
          <td>When using Microsoft Azure as a hosting platform and enabling load balancing, this cookie ensures that requests from one visitor browsing session are always handled by the same server in the cluster.</td>
        </tr>
      </tbody>
    </table>

    <p><strong>Performance</strong></p>
    <table class="cookie-dialog__table">
      <thead>
        <tr>
          <th>Cookie name</th>
          <th>Provider</th>
          <th>Type</th>
          <th>Expiry</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>_ga</td>
          <td>' . $domain . '</td>
          <td>Third-party</td>
          <td>2 years</td>
          <td>This cookie name is associated with Google Analytics - which is a significant update to Google&rsquo;s more commonly used analytics service. This cookie is used to distinguish unique users by assigning a randomly generated number as a client identifier. It is included in each page request in a site and used to calculate visitor, session and campaign data for the sites analytics reports.</td>
        </tr>
        <tr>
          <td>_gid</td>
          <td>' . $domain . '</td>
          <td>Third-party</td>
          <td>1 day</td>
          <td>This cookie is set by Google Analytics. It stores and update a unique value for each page visited and is used to count and track pageviews.</td>
        </tr>
        <tr>
          <td>_ga_XXXXXXXXXX</td>
          <td>' . $domain . '</td>
          <td>Third-party</td>
          <td>2 years</td>
          <td>This cookie is used by Google Analytics to persist session state.</td>
        </tr>
      </tbody>
    </table>

    <p><strong>Marketing/Targeting</strong></p>
    <table class="cookie-dialog__table">
      <thead>
        <tr>
          <th>Cookie name</th>
          <th>Provider</th>
          <th>Type</th>
          <th>Expiry</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>_p_hfp_client_id</td>
          <td>apps.elfsight.com</td>
          <td>Third-party</td>
          <td>30 seconds</td>
          <td>Used to implement social platforms on the website. Tracks users anonymously and ensure views do not exceeded limit.</td>
        </tr>
        <tr>
          <td>_gcl_au</td>
          <td>' . $domain . '</td>
          <td>Third-party</td>
          <td>3 months</td>
          <td>Used by Google AdSense for experimenting with advertisement efficiency across websites using their services.</td>
        </tr>
        <tr>
          <td>test_cookie</td>
          <td>doubleclick.net</td>
          <td>Third-party</td>
          <td>15 minutes</td>
          <td>This cookie is set by DoubleClick (which is owned by Google) to determine if the website visitor&rsquo; browser supports cookies.</td>
        </tr>
        <tr>
          <td>IDE</td>
          <td>doubleclick.net</td>
          <td>Third-party</td>
          <td>1 year</td>
          <td>This cookie is set by Doubleclick and carries out information about how the end user uses the website and any advertising that the end user may have seen before visiting the said website.</td>
        </tr>
        <tr>
          <td>_fbp</td>
          <td>' . $domain . '</td>
          <td>Proprietary</td>
          <td>3 months</td>
          <td>Used by Meta to deliver a series of advertisement products such as real time bidding from third party advertisers.</td>
        </tr>
        <tr>
          <td>fr</td>
          <td>' . $domain . '</td>
          <td>Proprietary</td>
          <td>3 months</td>
          <td>Used by Facebook to follow your surfing behavior across other websites which have implemented a Facebook pixel or Facebook social plug-in.</td>
        </tr>
      </tbody>
    </table>

    <h3>Removing Cookies</h3>
    <p>The majority of popular web browsers automatically permit websites to use cookies on your device. However, most will allow you to refuse to accept, restrict or delete cookies. Methods of doing so vary from browser to browser.</p>

    <p>Disabling cookies may affect your ability to use the site and make the most of all available services.</p>
    
    [cookie-reset]';
    
    $page = array(
      'post_title'  => __( 'Cookie Policy' ),
      'post_status' => 'publish',
      'post_author' => $current_user->ID,
      'post_type'   => 'page',
      'post_content'  => $policyContent,
    );
    
    wp_insert_post( $page );
  }

}


/*-----------------------------------------------------------------------------------*/
/* ADD DIALOG */
/*-----------------------------------------------------------------------------------*/

function add_cookie_dialog() {

  $cookieMessage = get_option('cookie-message');
  $cookiePrivacyLink = get_option('cookie-policy-link');
  $cookiePrivacyText = get_option('cookie-policy-text');

  $cookieTag = get_option('cookie-tag');
  $cookiePixel = get_option('cookie-pixel');

  if($cookieTag || $cookiePixel) {

  ?>

  <div id="cookieConsent" class="cookie-dialog">

    <div id="cookieDialog" class="cookie-dialog__body" >
      
      <div class="cookie-dialog__header">
        <?php if( $cookieMessage) {

          echo $cookieMessage; 

        } else {

          echo 'This website uses cookies to provide necessary functionality and improve your experience';

          if($cookiePrivacyLink == true && $cookiePrivacyText == false) {
          
            echo '. If you would like to learn more about cookies or reset your preference, please visit our <a href=' . $cookiePrivacyLink . ' tabindex="_blank" >cookie policy</a>';
          
          } elseif($cookiePrivacyLink == true && $cookiePrivacyText == true) {
          
            echo '. If you would like to learn more about cookies or reset your preference, please visit our <a href=' . $cookiePrivacyLink . ' tabindex="_blank" >' . $cookiePrivacyText . '</a>';
          
          };

          echo '.';

        } ?>

      </div>

      <div class="cookie-dialog__control">
        <button id="allowCookies" class="cookie-dialog__allow" type="button">Allow all cookies</button>
        <button id="declineCookies" class="cookie-dialog__reject" type="button">Reject non-essential cookies</button>
      </div>

    </div>

  </div>

  <?php 

  }

}

add_action('wp_footer', 'add_cookie_dialog');


/*-----------------------------------------------------------------------------------*/
/* ENQUEUE STYLES & SCRIPTS */
/*-----------------------------------------------------------------------------------*/

function cookie_scripts() {

  wp_enqueue_style( 'cookie-styles', plugins_url('/assets/css/cookie-styles.css', __FILE__), array(), '', 'all' );
  wp_enqueue_script( 'cookie-script', plugins_url('/assets/js/cookie-script.js', __FILE__), array(), '', true ); 

}

add_action( 'wp_enqueue_scripts', 'cookie_scripts' );


function add_cookie_control() { 

  $cookieTag = get_option('cookie-tag');
  $cookiePixel = get_option('cookie-pixel');

  $cookieBackground = get_option('cookie-background');
  $cookieColour = get_option('cookie-colour');

  $cookieAcceptBackground = get_option('cookie-accept-background');
  $cookieAcceptBorder = get_option('cookie-accept-border');
  $cookieAcceptColour = get_option('cookie-accept-colour');

  $cookieRejectBackground = get_option('cookie-reject-background');
  $cookieRejectBorder = get_option('cookie-reject-border');
  $cookieRejectColour = get_option('cookie-reject-colour');
  
  if($cookieTag || $cookiePixel) { ?>

    <?php if( $cookieBackground || $cookieColour || $cookieAcceptColour || $cookieAcceptBackground || $cookieAcceptBorder || $cookieRejectColour || $cookieRejectBackground || $cookieRejectBorder) { ?>
    <style>

      <?php if($cookieBackground) { ?>
      .cookie-dialog__body {
        background-color: <?php echo $cookieBackground ?> !important;
      }
      <?php } ?>

      <?php if($cookieColour) { ?>
      .cookie-dialog__header {
        color: <?php echo $cookieColour ?> !important;
      }
      <?php } ?>

      <?php if($cookieAcceptColour || $cookieAcceptBackground || $cookieAcceptBorder) { ?>
      .cookie-dialog__allow {
        <?php if($cookieAcceptColour) { ?>color: <?php echo $cookieAcceptColour ?> !important;<?php } ?>
        <?php if($cookieAcceptBackground) { ?>background: <?php echo $cookieAcceptBackground ?> !important;<?php } ?>
        <?php if($cookieAcceptBorder) { ?>border-color: <?php echo $cookieAcceptBorder ?> !important;<?php } ?>
      }
      <?php } ?>

      <?php if($cookieRejectColour || $cookieRejectBackground || $cookieRejectBorder) { ?>
      .cookie-dialog__reject {
        <?php if($cookieRejectColour) { ?>color: <?php echo $cookieRejectColour ?> !important;<?php } ?>
        <?php if($cookieRejectBackground) { ?>background: <?php echo $cookieRejectBackground ?> !important;<?php } ?>
        <?php if($cookieRejectBorder) { ?>border-color: <?php echo $cookieRejectBorder ?> !important;<?php } ?>
      }
      <?php } ?>

    </style>
    <?php } ?>

    <script type="text/javascript" async >

      document.addEventListener("DOMContentLoaded", function(event) { 
        setCookies({
          tag: "<?php echo $cookieTag; ?>",
          <?php if($cookiePixel) {?>pixel: "<?php echo $cookiePixel; ?>",<?php } ?>
        });
      });

    </script>

    <?php

  }

}

add_action( 'wp_head', 'add_cookie_control', 999);


function add_cookie_iframe() { 

  $cookieTag = get_option('cookie-tag'); ?>

  <?php if($cookieTag) { ?>

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $cookieTag; ?>"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

  <?php } 

}

add_action( 'wp_footer', 'add_cookie_iframe');


function add_pixel_iframe() { 

  $cookiePixel = get_option('cookie-pixel'); ?>

  <?php if($cookiePixel) { ?>

    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $cookiePixel; ?>&ev=PageView&noscript=1" /></noscript>

  <?php } 

}

add_action( 'wp_footer', 'add_pixel_iframe');


/*-----------------------------------------------------------------------------------*/
/* RESET DIALOG SHORTCODE */
/*-----------------------------------------------------------------------------------*/

function cookie_reset_shortcode() {

  $cookieResetText = get_option('cookie-reset-text');

  if( $cookieResetText ) { 

    return '<a id="resetCookies" class="cookie-dialog__reset" tabindex="0" type="button" title="Reset and open cookie preferences">' . $cookieResetText . '</a>';

  } else {

    return '<a id="resetCookies" class="cookie-dialog__reset" tabindex="0" type="button" title="Reset and open cookie preferences">Please click here to reset your cookie preference.</a>';

  };

}

add_shortcode('cookie-reset', 'cookie_reset_shortcode');