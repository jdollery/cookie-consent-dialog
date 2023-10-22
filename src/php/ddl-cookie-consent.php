<?php
/*
Plugin Name: DDL Cookie Consent
Version: 2.1.0
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

  add_settings_field ('cookie-policy-link','Policy page link URL:','render_cookie_policy_link','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-policy-text','Policy page link text:','render_cookie_policy_text','cookie-options-page','cookie-dialog-section');

  add_settings_field ('cookie-colour-one','Colour one:','render_cookie_colour_one','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-colour-two','Colour two:','render_cookie_colour_two','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-colour-three','Colour three:','render_cookie_colour_three','cookie-options-page','cookie-dialog-section');
  add_settings_field ('cookie-colour-overlay','Overlay colour:','render_cookie_colour_overlay','cookie-options-page','cookie-dialog-section');

  add_settings_field ('cookie-reset-text','Reset option text:','render_cookie_reset_text','cookie-options-page','cookie-dialog-section');


  /* --- REGISTER FIELDS --- */

  register_setting ('cookie-options','cookie-policy-link');
  register_setting ('cookie-options','cookie-policy-text');

  register_setting ('cookie-options','cookie-colour-one');
  register_setting ('cookie-options','cookie-colour-two');
  register_setting ('cookie-options','cookie-colour-three');
  register_setting ('cookie-options','cookie-colour-overlay');

  register_setting ('cookie-options','cookie-reset-text');

}

add_action( 'admin_init', 'admin_init_cookie_dialog' );


/* --- SECTION MESSAGE --- */

function cookie_dialog_section_message() {
	echo "Use these options to alter the text and styling of the pop-up.";
}


/* --- RENDER FIELDS --- */

function render_cookie_policy_link() {

	$input = get_option( 'cookie-policy-link' );
	echo '<input style="width:500px;" type="text" id="cookie-policy-link" name="cookie-policy-link" placeholder="' . site_url() . '/cookie-policy/" value="' . $input . '" />
  <p class="description" id="cookie-policy-link-description">Please enter your own policy URL to override the default cookie policy, which has been added here: <a href="' . site_url() . '/cookie-policy/" target="_blank">' . site_url() . '/cookie-policy/</a>.</p>';
  
}

function render_cookie_policy_text() {

	$input = get_option( 'cookie-policy-text' );
	echo '<input style="width:500px;" type="text" id="cookie-policy-text" name="cookie-policy-text" placeholder="cookie policy" value="' . $input . '" />
  <p class="description" id="cookie-policy-link-description">Please enter your own policy link text to override the default link text (cookie policy).</p>';


}

function render_cookie_colour_one() {

	$input = get_option( 'cookie-colour-one' );
	echo '<input style="width:500px;" type="text" id="cookie-colour-one" name="cookie-colour-one" placeholder="#ffffff" value="' . $input . '" />
  <p class="description" id="cookie-policy-link-description">Enter a new colour (hash or rgb) to override the default (white).</p>';


}

function render_cookie_colour_two() {

	$input = get_option( 'cookie-colour-two' );
	echo '<input style="width:500px;" type="text" id="cookie-colour-two" name="cookie-colour-two" placeholder="#222222" value="' . $input . '" />
  <p class="description" id="cookie-policy-link-description">Enter a new colour (hash or rgb) to override the default (black).</p>';

}

function render_cookie_colour_three() {

	$input = get_option( 'cookie-colour-three' );
	echo '<input style="width:500px;" type="text" id="cookie-colour-three" name="cookie-colour-three" placeholder="#4c4c4c" value="' . $input . '" />
  <p class="description" id="cookie-policy-link-description">Enter a new colour (hash or rgb) to override the default (grey).</p>';


}

function render_cookie_colour_overlay() {

	$input = get_option( 'cookie-colour-overlay' );
	echo '<input style="width:500px;" type="text" id="cookie-colour-overlay" name="cookie-colour-overlay" placeholder="#222222" value="' . $input . '" />
  <p class="description" id="cookie-policy-link-description">Enter a new colour (hash or rgb) to override the default (black).</p>';


}

function render_cookie_reset_text() {

	$input = get_option( 'cookie-reset-text' );
	echo '<input style="width:500px;" type="text" id="cookie-reset-text" name="cookie-reset-text" placeholder="Please click here to reset your cookie preference" value="' . $input . '" />
  <p class="description" id="cookie-policy-link-description">Please use this shotcode to add the reset option: [cookie-reset]</p>';

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

  add_settings_field ('cookie-tag','Google Tag Manager ID:','render_cookie_tag','cookie-options-page','cookie-tracking-section');
  add_settings_field ('cookie-pixel','Facebook Pixel code:','render_cookie_pixel','cookie-options-page','cookie-tracking-section');


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
/* ENQUEUE STYLES & SCRIPTS */
/*-----------------------------------------------------------------------------------*/

function cookie_scripts() {

  wp_enqueue_style( 'cookie-styles', 'https://cdn.jsdelivr.net/gh/dental-design/cookie-consent@main/cookie-styles.css', array(), '', 'all' );
  wp_enqueue_script( 'cookie-script', 'https://cdn.jsdelivr.net/gh/dental-design/cookie-consent@main/cookie-script.js', array(), '', true ); 

}

add_action( 'wp_enqueue_scripts', 'cookie_scripts' );


function add_cookie_control() { 

  $cookieTag = get_option('cookie-tag');
  $cookiePixel = get_option('cookie-pixel');

  $cookieColourOne = get_option('cookie-colour-one');
  $cookieColourTwo = get_option('cookie-colour-two');
  $cookieColourThree = get_option('cookie-colour-three');
  $cookieColourOverlay = get_option('cookie-colour-overlay');

  
  if($cookieTag || $cookiePixel) { ?>

    <?php if( $cookieColourOne || $cookieColourTwo || $cookieColourThree || $cookieColourOverlay ) { ?>
    <style>

      .cookie-dialog__body {
        <?php if( $cookieColourOne ) { ?>--cookie-white: <?php echo $cookieColourOne ?>;<?php } ?>
        <?php if( $cookieColourTwo ) { ?>--cookie-black: <?php echo $cookieColourTwo ?>;<?php } ?>
        <?php if( $cookieColourThree ) { ?>--cookie-grey: <?php echo $cookieColourThree ?>;<?php } ?>
        <?php if( $cookieColourOverlay ) { ?>--cookie-overlay: <?php echo $cookieColourOverlay ?>;<?php } ?>
      }

    </style>
    <?php } ?>

    <script type="text/javascript" defer >

      window.addEventListener('load', function () {
        setCookieConsent({
          policy_url: "https://dental-design.marketing/cookie-policy/", //REMOVE LINE IF NOT NEEDED
          policy_link: "cookie policy", //REMOVE LINE IF NOT NEEDED
          <?php if($cookieTag) {?>tag: "<?php echo $cookieTag; ?>",<?php } ?>
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

    return '<a id="resetCookieConsent" class="cookie-dialog__reset" tabindex="0" type="button" title="Reset and open cookie preferences">' . $cookieResetText . '</a>';

  } else {

    return '<a id="resetCookieConsent" class="cookie-dialog__reset" tabindex="0" type="button" title="Reset and open cookie preferences">Please click here to reset your cookie preference.</a>';

  };

}

add_shortcode('cookie-reset', 'cookie_reset_shortcode');