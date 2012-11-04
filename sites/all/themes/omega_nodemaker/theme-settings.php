<?php 
/**
 * @file
 *
 * Adds a fieldset to theme settings form which allows site administrators to
 * specify Apple Touch icons for Drupal websites. The Touch icon settings behave
 * in a similar manner to the Site Logo and Favicon settings provided by Drupal
 * core.
 *
 * Also provides a simple means for theme developers to provide default Touch
 * icons with their theme.
 *
 * @todo implement hook_help().
 * @todo harmonise variable names with D6 version, hook_update() if needs be
 */


/**
 * Implements hook_form_system_theme_settings_alter()
 */
function omega_nodemaker_form_system_theme_settings_alter(&$form, &$form_state) {
  $form['themegeeks'] = array(
    '#type' => 'markup',
    '#weight' => -50,
    '#markup' => l('<img src="/'. drupal_get_path('theme','omega_nodemaker') .'/images/themegeeks.png" />', 'http://themegeeks.com', array('html' => TRUE,'attributes' => array('target' => '_blank', 'style' => 'position:absolute;top:70px;right:0;display:block;','class' => array('clearfix','themegeeks', 'theme-sponsor')))),
  );
  
  $theme = alpha_get_theme();
  //krumo($theme);
  $form['alpha_settings']['isotope'] = array(
    '#type' => 'fieldset',
    '#weight' => -75,
    '#title' => t('jQuery Isotope Settings'),
  );
  
  $form['alpha_settings']['isotope']['isotope'] = array(
    '#type' => 'fieldset',
    '#title' => t('Isotope Settings'),
  );
  
  $form['alpha_settings']['isotope']['isotope']['isotope_toggle'] = array(
    '#type' => 'checkbox',
    '#title' => t('Activate Isotope plugin'),
    '#description' => t('This will enable the Masonry plugin (<a href="http://masonry.desandro.com/">masonry.desandro.com/</a>) to various node views.'),
    '#default_value' => theme_get_setting('isotope_toggle', $theme->theme),
  );
  
  $form['alpha_settings']['isotope']['isotope']['isotope_home_toggle'] = array(
    '#type' => 'checkbox',
    '#title' => t('Activate Isotope for landing pages provided by the NodeMaker Landing Pages app.'),
    '#default_value' => theme_get_setting('isotope_home_toggle', $theme->theme),
    '#states' => array(
      'visible' => array(
        'input[name="isotope_toggle"]' => array('checked' => TRUE),
      ),
    ),
  );

  $form['alpha_settings']['isotope']['isotope']['home'] = array(
    '#type' => 'fieldset',
    '#title' => t('Landing Page Columns'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#states' => array(
      'visible' => array(
        'input[name="isotope_toggle"]' => array('checked' => TRUE),
        'input[name="isotope_home_toggle"]' => array('checked' => TRUE),
      ),
    ),
  );

  //make gutter options
  for ($i=1; $i<=100; $i++) {
    $gutter_options[$i] = $i;
  }

  $form['alpha_settings']['isotope']['isotope']['home']['home_columns_gutter'] = array(
    '#type' => 'select',
    '#title' => t('Pixel spacing between columns'),
    '#description' => t('On the home page, how pixels do you want in between each column?'),
    '#options' => $gutter_options,
    '#default_value' => theme_get_setting('home_columns_gutter', $theme->theme),
  ); 
   
  $form['alpha_settings']['isotope']['isotope']['home']['home_columns_narrow'] = array(
    '#type' => 'select',
    '#title' => t('Number of Home Page Columns - Narrow'),
    '#description' => t('On the home page, how many columns do want for the main content when viewing a "narrow" display?'),
    '#options' => array(
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      '6' => '6',
      '7' => '7',
      '8' => '8',
      '9' => '9',
      '10' => '10',
     ),
    '#default_value' => theme_get_setting('home_columns_narrow', $theme->theme),
  );
  
  $form['alpha_settings']['isotope']['isotope']['home']['home_columns_normal'] = array(
    '#type' => 'select',
    '#title' => t('Number of Home Page Columns - Normal'),
    '#description' => t('On the home page, how many columns do want for the main content when viewing a "normal" display?'),
    '#options' => array(
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      '6' => '6',
      '7' => '7',
      '8' => '8',
      '9' => '9',
      '10' => '10',
     ),
    '#default_value' => theme_get_setting('home_columns_normal', $theme->theme),
  );
  
  $form['alpha_settings']['isotope']['isotope']['home']['home_columns_wide'] = array(
    '#type' => 'select',
    '#title' => t('Number of Home Page Columns - Wide'),
    '#description' => t('On the home page, how many columns do want for the main content when viewing a "wide" display?'),
    '#options' => array(
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      '6' => '6',
      '7' => '7',
      '8' => '8',
      '9' => '9',
      '10' => '10',
     ),
    '#default_value' => theme_get_setting('home_columns_wide', $theme->theme),
  );
  
  $form['alpha_settings']['isotope']['isotope']['isotope_taxonomy_toggle'] = array(
    '#type' => 'checkbox',
    '#title' => t('Activate Isotope for taxonomy pages'),
    '#default_value' => theme_get_setting('isotope_taxonomy_toggle', $theme->theme),
    '#states' => array(
      'visible' => array(
        'input[name="isotope_toggle"]' => array('checked' => TRUE),
      ),
    ),
  );
  
  $form['alpha_settings']['isotope']['isotope']['taxonomy'] = array(
    '#type' => 'fieldset',
    '#title' => t('Taxonomy Page Columns'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#states' => array(
      'visible' => array(
        'input[name="isotope_toggle"]' => array('checked' => TRUE),
        'input[name="isotope_taxonomy_toggle"]' => array('checked' => TRUE),
      ),
    ),
  );
  
  $form['alpha_settings']['isotope']['isotope']['taxonomy']['taxonomy_columns_gutter'] = array(
    '#type' => 'select',
    '#title' => t('Pixel spacing between columns'),
    '#description' => t('On the various taxonomy pages, how pixels do you want in between each column?'),
    '#options' => $gutter_options,
    '#default_value' => theme_get_setting('taxonomy_columns_gutter', $theme->theme),
  ); 
   
  $form['alpha_settings']['isotope']['isotope']['taxonomy']['taxonomy_columns_narrow'] = array(
    '#type' => 'select',
    '#title' => t('Number of Taxonomy Page Columns - Narrow'),
    '#description' => t('On the various taxonomy pages, how many columns do want for the main content when viewing a "narrow" display?'),
    '#options' => array(
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      '6' => '6',
      '7' => '7',
      '8' => '8',
      '9' => '9',
      '10' => '10',
     ),
    '#default_value' => theme_get_setting('taxonomy_columns_narrow', $theme->theme),
  );
  
  $form['alpha_settings']['isotope']['isotope']['taxonomy']['taxonomy_columns_normal'] = array(
    '#type' => 'select',
    '#title' => t('Number of Taxonomy Page Columns - Normal'),
    '#description' => t('On the various taxonomy pages, how many columns do want for the main content when viewing a "normal" display?'),
    '#options' => array(
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      '6' => '6',
      '7' => '7',
      '8' => '8',
      '9' => '9',
      '10' => '10',
     ),
    '#default_value' => theme_get_setting('taxonomy_columns_normal', $theme->theme),
  );
  
  $form['alpha_settings']['isotope']['isotope']['taxonomy']['taxonomy_columns_wide'] = array(
    '#type' => 'select',
    '#title' => t('Number of Taxonomy Page Columns - Wide'),
    '#description' => t('On the various taxonomy pages, how many columns do want for the main content when viewing a "wide" display?'),
    '#options' => array(
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      '6' => '6',
      '7' => '7',
      '8' => '8',
      '9' => '9',
      '10' => '10',
     ),
    '#default_value' => theme_get_setting('taxonomy_columns_wide', $theme->theme),
  );
  
  
  $form['alpha_settings']['jquery'] = array(
    '#type' => 'fieldset',
    '#weight' => -49,
    '#title' => t('jQuery Settings'),
  );
  $form['alpha_settings']['jquery']['jquery172'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable jQuery 1.7.2'),
    '#description' => t('Usage in scripts: $jq172'),
    '#default_value' => theme_get_setting('jquery172', $theme->theme),
  );
  $form['alpha_settings']['jquery']['jquery180'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable jQuery 1.8.0'),
    '#description' => t('Usage in scripts: $jq180'),
    '#default_value' => theme_get_setting('jquery180', $theme->theme),
  );
  
  
  

  $form['alpha_settings']['mobile_settings'] = array(
    '#type' => 'fieldset',
    '#weight' => -50,
    '#title' => t('Mobile Application Settings'),
  );
  
  $form['alpha_settings']['mobile_settings']['ios_settings'] = array(
    '#type' => 'fieldset',
    '#weight' => -50,
    '#collapsible' => true,
    '#title' => t('iOS Specific Settings'),
  );
  
  $form['alpha_settings']['mobile_settings']['ios_settings']['web_app_capable'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Web Application mode in iOS'),
    '#description' => t('Turning this feature on will allow this site to act as a web app on iOS devices. After a user saves a shortcut to the desktop, when launching the site the browser controls are hidden, and your "web app" runs in its own process in iOS.'),
    '#default_value' => theme_get_setting('web_app_capable', $theme->theme),
  );
  $form['alpha_settings']['mobile_settings']['ios_settings']['add_to_homescreen'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable "Add to Homescreen" option for iOS users.'),
    '#description' => t('Adds a popup at the bottom of the screen reminding users they can add the app to their homescreen. Should ONLY be used when "Enable Web Application mode in iOS" is enabled.'),
    '#default_value' => theme_get_setting('add_to_homescreen', $theme->theme),
  );
  
  $form['alpha_settings']['mobile_settings']['general_settings'] = array(
    '#type' => 'fieldset',
    '#weight' => -50,
    '#collapsible' => true,
    '#title' => t('General Settings'),
  );
  $form['alpha_settings']['mobile_settings']['general_settings']['iscroll'] = array(
    '#type' => 'checkbox',
    '#title' => t('Activate iScroll'),
    '#description' => t('Turning on this feature enables the "Pull down to refresh" you are accustomed to seeing on mobile devices.'),
    '#default_value' => theme_get_setting('iscroll', $theme->theme),
  );
  $form['alpha_settings']['mobile_settings']['general_settings']['jumpmenu'] = array(
    '#type' => 'checkbox',
    '#title' => t('Activate mobile jump menu'),
    '#description' => t('This will replace (on mobile layouts) your primary navigation with a "jump menu" which is a form select dropdown. This saves valuable screen space, and provides a much better user interaction on smaller devices.'),
    '#default_value' => theme_get_setting('iscroll', $theme->theme),
  );
  
  #krumo($form);
}