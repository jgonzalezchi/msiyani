<?php

/**
 * @file
 * This file is empty by default because the base theme chain (Alpha & Omega) provides
 * all the basic functionality. However, in case you wish to customize the output that Drupal
 * generates through Alpha & Omega this file is a good place to do so.
 *
 * Alpha comes with a neat solution for keeping this file as clean as possible while the code
 * for your subtheme grows. Please read the README.txt in the /preprocess and /process subfolders
 * for more information on this topic.
 */

require_once(drupal_get_path('theme', 'omega_nodemaker') . '/includes/omega_nodemaker.theme.inc');

/**
 * Debugging calls to drupal_set_message
 */

function omega_nodemaker_js_alter(&$js) {
  //dsm($js);
  // going to remove the nice_menus defaults and add in our own.
  if (isset($js['sites/all/modules/contrib/nice_menus/nice_menus.js'])) {
    unset($js['sites/all/modules/contrib/nice_menus/nice_menus.js']);
  }
}

function omega_nodemaker_css_alter(&$css) {
  //dsm($css);
  // nicemenu's CSS for dropdowns sucks. buh-bye!
  if (isset($css['sites/all/modules/contrib/nice_menus/nice_menus.css'])) {
    //unset($css['sites/all/modules/contrib/nice_menus/nice_menus.css']);
  }
  if (isset($css['sites/all/modules/contrib/nice_menus/nice_menus_default.css'])) {
    //unset($css['sites/all/modules/contrib/nice_menus/nice_menus_default.css']);
  }
  
  // the field group CSS is stupid.
  if (isset($css['sites/all/modules/contrib/field_group/field_group.css'])) {
    unset($css['sites/all/modules/contrib/field_group/field_group.css']);  
  }
  
}
/**
 * Implements hook_process_zone().
 */
function omega_nodemaker_process_region(&$vars) {
  $theme = alpha_get_theme();
  // add messages to the branding zone.
  
  if ($vars['elements']['#region'] == 'menu') {
    //krumo($vars);
    $vars['messages'] = $theme->page['messages'];
    //krumo($vars);
  }
}

/**
 * Implements TEMPLATE_preprocess_html
 */
function omega_nodemaker_preprocess_html(&$vars) {
  /*
drupal_set_message('This is a normal call to <em>drupal_set_message</em>.', 'status');
  drupal_set_message('This is a warning call to <em>drupal_set_message</em>.', 'warning');
  drupal_set_message('This is a error call to <em>drupal_set_message</em>.', 'error');
  drupal_set_message('This is a second normal call to <em>drupal_set_message</em>.', 'status');
*/

  // add in default Google Web Fonts
  drupal_add_css('//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800');
  drupal_add_css('//fonts.googleapis.com/css?family=Neuton:200,300,400,700,800,400italic');
  
  $theme = alpha_get_theme();
  // adds masonry plugin
  if (theme_get_setting('jquery172', $theme->theme)) {
    // add jQuery 1.7.2 using noconflict method
    drupal_add_js(drupal_get_path('theme', 'omega_nodemaker') . '/js/jquery-1.7.2.min.js', 
      array(
        'type' => 'file',
        'group' => JS_LIBRARY,
        'scope' => 'header',
        'every_page' => true,
        'weight' => -5000,
      )
    );
    // add a reference of $jq172
    drupal_add_js('var $jq172 = jQuery.noConflict();', 
      array(
        'type' => 'inline',
        'group' => JS_LIBRARY,
        'scope' => 'header',
        'every_page' => true,
        'weight' => -4999,
      )
    ); 
  }
  if (theme_get_setting('jquery180', $theme->theme)) {
    // add jQuery 1.8.0 using noconflict method
    drupal_add_js(drupal_get_path('theme', 'omega_nodemaker') . '/js/jquery-1.8.0.min.js', 
      array(
        'type' => 'file',
        'group' => JS_LIBRARY,
        'scope' => 'header',
        'every_page' => true,
        'weight' => -5002,
      )
    );
    drupal_add_js('var $jq180 = jQuery.noConflict();', 
      array(
        'type' => 'inline',
        'group' => JS_LIBRARY,
        'scope' => 'header',
        'every_page' => true,
        'weight' => -5001,
      )
    ); 
  }
  // adds <meta content="yes" name="apple-mobile-web-app-capable"> to html source
  if (theme_get_setting('web_app_capable', $theme->theme)) {
    $webapp = array(
      '#tag' => 'meta', // The #tag is the html tag - <link />
      '#attributes' => array( // Set up an array of attributes inside the tag
        'content' => 'yes',
        'name' => 'apple-mobile-web-app-capable',
      ),
    );
    drupal_add_html_head($webapp, 'apple_mobile_web_app_capable');  
    // initialize webapp 
    drupal_add_js(drupal_get_path('theme', 'omega_nodemaker') . '/js/nodemaker-webapp.js', array('weight' => '-10', 'every_page' => TRUE, 'group' => JS_LIBRARY)); 
  }
  
  if (theme_get_setting('add_to_homescreen', $theme->theme)) {
    
    drupal_add_js(drupal_get_path('theme', 'omega_nodemaker') . '/js/nodemaker-addtohome.js'); 
    drupal_add_js(drupal_get_path('theme', 'omega_nodemaker') . '/js/addtohome/addtohome.js'); 
    drupal_add_css(drupal_get_path('theme', 'omega_nodemaker') . '/js/addtohome/addtohome.css');
    
    //drupal_add_js('(function ($) {addToHome.show(true);})(jQuery);', 'inline');
  } 
  
  // adds iscroll functionality for "Pull down to refresh"
  if (theme_get_setting('iscroll', $theme->theme)) {
    // add iscroll js
    drupal_add_js(drupal_get_path('theme', 'omega_nodemaker') . '/js/iscroll/iscroll.js'); 
    // initialize iscroll 
    drupal_add_js(drupal_get_path('theme', 'omega_nodemaker') . '/js/nodemaker-iscroll.js'); 
    drupal_add_js(array('nodemaker' => array('iscroll' => true)), 'setting');
  } 
  
  // adds isotope plugin
  if (theme_get_setting('isotope_toggle', $theme->theme)) {
    drupal_add_js(drupal_get_path('theme', 'omega_nodemaker') . '/js/jquery.isotope.js'); 
    drupal_add_js(drupal_get_path('theme', 'omega_nodemaker') . '/js/nodemaker-isotope.js'); 
    drupal_add_js(array('nodemaker' => array('isotope' => true)), 'setting');
    
    if (theme_get_setting('isotope_home_toggle', $theme->theme)) {
      $columns = array();
      //add the home_page_columns
      $columns['home_columns_gutter'] = theme_get_setting('home_columns_gutter', $theme->theme);
      $columns['home_columns_narrow'] = theme_get_setting('home_columns_narrow', $theme->theme);
      $columns['home_columns_normal'] = theme_get_setting('home_columns_normal', $theme->theme);
      $columns['home_columns_wide'] = theme_get_setting('home_columns_wide', $theme->theme);
      drupal_add_js(array('nodemaker' => array('isotope_home_toggle' => theme_get_setting('isotope_home_toggle', $theme->theme), 'home_columns' => $columns)), 'setting');
    }
    
    if (theme_get_setting('isotope_taxonomy_toggle', $theme->theme)) {
      $columns = array();
      
      $columns['taxonomy_columns_gutter'] = theme_get_setting('taxonomy_columns_gutter', $theme->theme);
      $columns['taxonomy_columns_narrow'] = theme_get_setting('taxonomy_columns_narrow', $theme->theme);
      $columns['taxonomy_columns_normal'] = theme_get_setting('taxonomy_columns_normal', $theme->theme);
      $columns['taxonomy_columns_wide'] = theme_get_setting('taxonomy_columns_wide', $theme->theme);
      drupal_add_js(array('nodemaker' => array('isotope_taxonomy_toggle' => theme_get_setting('isotope_taxonomy_toggle', $theme->theme),'taxonomy_columns' => $columns)), 'setting');
    }
  }  
  
  //dsm($vars);
  // add the ios touch icons
  
  $icon = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array( // Set up an array of attributes inside the tag
      'rel' => 'apple-touch-icon-precomposed',
      'href' => file_create_url(drupal_get_path('theme', 'omega_nodemaker') . '/images/branding/apple-touch-icon-57x57-precomposed.png'),
    ),
  );
  drupal_add_html_head($icon, 'apple-touch-icon-default');
  
  $icon = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array( // Set up an array of attributes inside the tag
      'rel' => 'apple-touch-icon-precomposed',
      'href' => file_create_url(drupal_get_path('theme', 'omega_nodemaker') . '/images/branding/apple-touch-icon-72x72-precomposed.png'),
      'sizes' => '72x72',
    ),
  );
  drupal_add_html_head($icon, 'apple-touch-icon-72');
  
  $icon = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array( // Set up an array of attributes inside the tag
      'rel' => 'apple-touch-icon-precomposed',
      'href' => file_create_url(drupal_get_path('theme', 'omega_nodemaker') . '/images/branding/apple-touch-icon-114x114-precomposed.png'),
      'sizes' => '114x114',
    ),
  );
  drupal_add_html_head($icon, 'apple-touch-icon-114');
  
  $icon = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array( // Set up an array of attributes inside the tag
      'rel' => 'apple-touch-icon-precomposed',
      'href' => file_create_url(drupal_get_path('theme', 'omega_nodemaker') . '/images/branding/apple-touch-icon-144-144-precomposed.png'),
      'sizes' => '144x144',
    ),
  );
  drupal_add_html_head($icon, 'apple-touch-icon-144');
  
  
  /**
  <!-- startup image for web apps - iPad - landscape (748x1024) 
       Note: iPad landscape startup image has to be exactly 748x1024 pixels (portrait, with contents rotated).-->
  <link rel="apple-touch-startup-image" href="img/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)" />
  
  <!-- startup image for web apps - iPad - portrait (768x1004) -->
  <link rel="apple-touch-startup-image" href="img/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)" />
  
  <!-- startup image for web apps (320x460) -->
  <link rel="apple-touch-startup-image" href="img/iphone.png" media="screen and (max-device-width: 320px)" />
  */
  
  // app startup image
  
  
  $appstartup = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array( // Set up an array of attributes inside the tag
      'rel' => 'apple-touch-startup-image',
      'href' => file_create_url(drupal_get_path('theme', 'omega_nodemaker') . '/images/branding/apple-startup-image-iphone.png'),
      'media' => 'screen and (max-device-width: 320px)',
      //'sizes' => '320x460',
    ),
  );
  drupal_add_html_head($appstartup, 'apple-touch-startup-image-iphone');
  
  $appstartup = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array( // Set up an array of attributes inside the tag
      'rel' => 'apple-touch-startup-image',
      'href' => file_create_url(drupal_get_path('theme', 'omega_nodemaker') . '/images/branding/apple-startup-image-iphone-retina.png'),
      'media' => 'screen and (max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)',
    ),
  );
  drupal_add_html_head($appstartup, 'apple-touch-startup-image-iphone-retina');
  
  $appstartup = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array( // Set up an array of attributes inside the tag
      'rel' => 'apple-touch-startup-image',
      'href' => file_create_url(drupal_get_path('theme', 'omega_nodemaker') . '/images/branding/apple-startup-image-ipad-portrait.png'),
      'media' => 'screen and (max-device-width: 1024px) and (orientation:portrait)',
    ),
  );
  drupal_add_html_head($appstartup, 'apple-touch-startup-image-ipad-portrait');
  
  $appstartup = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array( // Set up an array of attributes inside the tag
      'rel' => 'apple-touch-startup-image',
      'href' => file_create_url(drupal_get_path('theme', 'omega_nodemaker') . '/images/branding/apple-startup-image-ipad-landscape.png'),
      'media' => 'screen and (max-device-width: 1024px) and (orientation:landscape)',
    ),
  );
  drupal_add_html_head($appstartup, 'apple-touch-startup-image-ipad-landscape');
}

/**
 * Implements TEMPLATE_preprocess_page
 */
function omega_nodemaker_preprocess_page(&$vars) {
  // turn off that mother fucking default content block
  if($vars['is_front']) {
    //dsm($vars);
    //dsm($vars['page']['content']['content']['content']['system_main']);
  }
  
  // move the user bar out of the standard flow for better page structure
  if (isset($vars['page']['header']['user'])) {
    $vars['userbar'] = $vars['page']['header']['user'];
    unset($vars['page']['header']['user']);
  }
  
  if (arg(0) == 'node' && (arg(2) == 'edit' || arg(2) == 'revisions')) {
    //dsm('node edit page bitches!');
    
    unset($vars['page']['content']['content']['sidebar_first']);
    unset($vars['page']['sidebar_first']);
    //unset($vars['page']['content']['content']['sidebar_second']);
    
    //dsm($vars);
  }
  //krumo($vars);
}

/**
 * Implements TEMPLATE_preprocess_node
 */
function omega_nodemaker_preprocess_node(&$vars) {
  $node = $vars['node'];
  $type = $vars['type'];
  $user = $vars['user'];
  $lang = $vars['language'];
  // add in template suggestion for node--NODE_TYPE--VIEW_MODE.tp.php
  $view_mode = isset($vars['view_mode']) ? $vars['view_mode'] : FALSE;
  
  if ($view_mode) {
    $suggestions = $vars['theme_hook_suggestions'];
    
    $vars['theme_hook_suggestions'] = array();
    unset($suggestions['0']);
    $new_suggestions = array(
      'node__' . $type,
      'node__' . $type . '__' . $view_mode,
    );

    $vars['theme_hook_suggestions'] = array_merge_recursive($new_suggestions, $suggestions);
    //krumo($vars);
    $vars['attributes_array']['class'][] = $view_mode . '-theme-view';
  }
  
  
  if (isset($vars['content']['links']['comment']['#links']['comment_forbidden'])) {
    //krumo($vars['content']['links']);  
    unset($vars['content']['links']['comment']['#links']['comment_forbidden']);
  }
  // check for the sharethis module
  //krumo($vars['content']);
  if (isset($vars['content']['sharethis'])) {
    
  }
  
  // Change default behavior of the submitted by content
  $vars['submission_info'] = t('Posted by <strong>' . $vars['name'] . '</strong> on ' . format_date($node->created, 'nodemaker_date_friendly'));
  //krumo($vars['node']);
  
  // operate on specific node types
  switch ($type) {
    case 'forum':
      //dsm($vars);
    break;
    case 'nm_blog':
      //krumo($vars['content']);
    break;
    
    case 'nm_event':
      
      $start_date = isset($vars['field_nm_date'][0]['value']) ? $vars['field_nm_date'][0]['value'] : FALSE;
      $end_date = isset($vars['field_nm_date'][0]['value2']) ? $vars['field_nm_date'][0]['value2'] : FALSE;
      
      $vars['calendar'] = array();
      
      if ($start_date) {
        $vars['calendar']['start_month'] = format_date($start_date, 'custom', 'M');
        $vars['calendar']['start_day'] = format_date($start_date, 'custom', 'd');
      }
      if ($end_date) {
        $vars['calendar']['end_month'] = format_date($end_date, 'custom', 'M');
        $vars['calendar']['end_day'] = format_date($end_date, 'custom', 'd');
      }

      $vars['event_dates'] = array();
      
      $vars['event_dates']['start'] = format_date($start_date, 'custom', 'l, F jS g:i a');
      
      $vars['event_dates']['end'] = format_date($end_date, 'custom', 'l, F jS g:i a');
      $vars['event_map'] = addressfield_staticmap_block_view('addressfield_staticmap');
      $vars['event_map'] = isset($vars['event_map']['content']) ? $vars['event_map']['content'] : FALSE;
      
      
      //$vars['content']['field_nm_tags']['#title'] = t('Tagged with');
      //$vars['content']['field_nm_event_category']['#title'] = t('Posted in');
      //krumo($vars['content']);
      
      
    break;
    
    case 'nm_gallery':
      //krumo($vars['content']);
      $vars['photo_count'] = isset($vars['field_nm_gallery_images'][$lang]) ? count($vars['field_nm_gallery_images'][$lang]) . ' ' . t('Photos') : '';
    break;
  }
}



function omega_nodemaker_preprocess_comment(&$vars) {
  $comment = $vars['comment'];
  // add a specific class to comment titles
  $vars['title_attributes_array']['class'] = array('comment-title');
  
  // Change default behavior of the submitted by content
  $vars['submission_info'] = t('Posted by <strong>' . $vars['author'] . '</strong> on ' . format_date($comment->created, 'nodemaker_date_friendly'));
  
}

/**
 * Implements TEMPLATE_preprocess_block
 */
function omega_nodemaker_preprocess_block(&$vars) {
  $block = $vars['block'];
  //krumo($block);
  switch ($block->bid) {
    case 'system-user-menu':
      //krumo($vars);
    break;
    case 'system-powered-by':
      //krumo($vars);
    break;
  }
}

function omega_nodemaker_page_alter(&$page) {
  // on taxonomy term pags make a wrapper around the nodes that is logical. #wtf
  //dsm($page);
  // page rendered for /node default drupal river of news
  if (arg(0) == 'node' && !arg(1)) {
    $page['content']['content']['content']['system_main']['content']['nodes']['#prefix'] = '<div class="clearfix node-river">';
    $page['content']['content']['content']['system_main']['content']['nodes']['#suffix'] = '</div>';
  }
  
  if (arg(0) == 'taxonomy' & arg(1) == 'term') {
    // for some stupid @#@#$@#$ reason, the list of nodes on a taxonomy page is in a
    // differen portion of the array depending on if a user is logged in or now... #wtf
    
    if (isset($page['content']['content']['content']['system_main']['content']['nodes'])) {
      $page['content']['content']['content']['system_main']['content']['nodes']['#prefix'] = '<div class="term-nodes">';
      $page['content']['content']['content']['system_main']['content']['nodes']['#suffix'] = '</div>';
    }
    elseif (isset($page['content']['content']['content']['system_main']['nodes'])) {
      $page['content']['content']['content']['system_main']['nodes']['#prefix'] = '<div class="term-nodes">';
      $page['content']['content']['content']['system_main']['nodes']['#suffix'] = '</div>';
    }
  }
  
  
}

/**
 * Implements hook_form_alter
 */
function omega_nodemaker_form_alter(&$form, &$form_state, $form_id) {
  //dsm($form_id);
  switch ($form_id) {
    case 'user_login_block':
      $form['name']['#weight'] = -10;
      $form['name']['#attributes']['placeholder'] = $form['name']['#title'];
      $form['pass']['#weight'] = -9;
      $form['pass']['#attributes']['placeholder'] = $form['pass']['#title'];
      $form['actions']['#weight'] = -8;
      
      $items = array();
      if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
        $items[] = l(t('Register'), 'user/register', array('attributes' => array('title' => t('Create a new user account.'))));
      }
      $items[] = l(t('Forgot Password?'), 'user/password', array('attributes' => array('title' => t('Request new password via e-mail.'))));
      $form['links'] = array('#markup' => theme('item_list', array('items' => $items)));
    break;
    case 'search_block_form': 
      //krumo($form);
      $site_name = variable_get('site_name');
      $form['search_block_form']['#attributes']['placeholder'] = t('Search ') . $site_name . '...';
      //$form['advanced']['#access'] = FALSE;
    break;
    
  }
  
  $node_form = substr($form_id, -10, 10);
  //dsm($node_form);
  if ($node_form == '_node_form') {
    //dsm($form['field_nm_gallery_images']);
  }
}

