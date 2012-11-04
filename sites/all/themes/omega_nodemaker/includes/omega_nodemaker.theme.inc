<?php

function omega_nodemaker_system_powered_by() {
  $items = array();
  
  // Powered by Drupal
  $items[] = array(
    'data' => l('Drupal', 'http://drupal.org', array('attributes' => array('target' => '_blank','class' => array('powered-link-drupal')))),
    'id' => 'powered-drupal',
    'class' => array('powered-link'),
  );
  
  // Powered by ThemeGeeks
  $items[] = array(
    'data' => l('ThemeGeeks', 'http://themegeeks.com', array('attributes' => array('target' => '_blank','class' => array('powered-link-themegeeks')))),
    'id' => 'powered-themegeeks',
    'class' => array('powered-link'),
  );
  
  // Powered by NodeMaker
  $items[] = array(
    'data' => l('NodeMaker', 'http://drupal.org/project/nodemaker', array('attributes' => array('target' => '_blank','class' => array('powered-link-nodemaker')))),
    'id' => 'powered-nodemaker',
    'class' => array('powered-link'),
  );
  
  // Powered by Omega
  $items[] = array(
    'data' => l('Omega', 'http://drupal.org/project/omega', array('attributes' => array('target' => '_blank','class' => array('powered-link-omega')))),
    'id' => 'powered-omega',
    'class' => array('powered-link'),
  );
  $content = theme('item_list', array('items' => $items, 'title' => t('Powered By: '), 'type' => 'ul', 'attributes' => array()));
  
  return $content;
}

function omega_nodemaker_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary Actions') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul id="primary-tabs" class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary Actions') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul id="secondary-tabs" class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

function omega_nodemaker_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  
  if (!empty($breadcrumb)) {
    
    if (strlen($breadcrumb[0]) == 0) {
      unset($breadcrumb[0]);
      if (count($breadcrumb) == 0) {
        unset ($breadcrumb);
      }
    }
    else {
      // Provide a navigational heading to give context for breadcrumb links to
      // screen-reader users. Make the heading invisible with .element-invisible.
      $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
      $title = array_pop($breadcrumb);
      $breadcrumb[] = '<span class="page-title">' . $title . '</span>';
      $output .= '<div id="breadcrumb" class="breadcrumb clearfix">' . implode('<span class="separator"></span>', $breadcrumb) . '</div>';
      return $output;  
    }
  }
}

function omega_nodemaker_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  /*
  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('«')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('»')), 'element' => $element, 'parameters' => $parameters));
  */
  
  $li_first = theme('pager_first', array('text' => t('«'), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => t('‹'), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => t('›'), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => t('»'), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'), 
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'), 
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      /*
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'), 
          'data' => '…',
        );
      }
      */
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'), 
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current'), 
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'), 
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      /*
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'), 
          'data' => '…',
        );
      }
      */
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'), 
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'), 
        'data' => $li_last,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items, 
      'attributes' => array('class' => array('pager')),
    ));
  }
}

function omega_nodemaker_image_widget($variables) {
  $element = $variables['element'];
  //dsm($element);
  
  if (isset($element['remove_button'])) {
    $element['remove_button']['#attributes'] = array(
      'class' => array('file-remove-button'),
    );
  }
  if (isset($element['alt'])) {
    $element['alt']['#attributes']['placeholder'] = $element['alt']['#title'];
  }
  
  if (isset($element['title'])) {
    $element['title']['#attributes']['placeholder'] = $element['title']['#title'];
  }
  
  
  
  $extra = isset($element['filename']) ? ' has-image' : ' has-no-image';
  
  $output = '';
  $output .= '<div class="image-widget' . $extra . ' form-managed-file clearfix">';

  if (isset($element['preview'])) {
    $element['preview']['#prefix'] = '<div class="thumbnail">';
    $element['preview']['#suffix'] = '</div>';
    $output .= '<div class="image-preview clearfix">';
    $output .= drupal_render($element['preview']);
    $output .= '</div>';
  }

  $output .= '<div class="image-widget-data clearfix">';
  // make sure there IS an image before rendering the "data" section of the image widget  
  if (isset($element['filename'])) {
    $output .= '<div class="image-data">';
    $output .= '<span class="file-name">' . drupal_render($element['filename']) . '</span>';
    
    if ($element['fid']['#value'] != 0) {
      $output .= '<span class="file-size">(' . format_size($element['#file']->filesize) . ')</span> ';
    }
    
    if (isset($element['width']['#value']) && isset($element['height']['#value'])) {
      $output .= '<span class="file-dimensions">' . $element['width']['#value'] . ' x ' . $element['height']['#value'] . '</span>';
    }
    $output .= '<span class="more-details"><a href="#" class="image-widget-toggle show-more">show more</a></div>';
    $output .= '<div class="image-details with-image clearfix">';
    $output .= '<div class="image-meta clearfix">' . drupal_render($element['title']) . drupal_render($element['alt']) . '</div>';
  }
  else {
    $output .= '<div class="image-details without-image clearfix">';
  }
  $output .= '<div class="image-actions clearfix">';
  $output .= drupal_render_children($element);
  $output .= '</div>';
  $output .= '</div>';
  $output .= '</div>';
  $output .= '</div>';

  return $output;
}

/**
 * Returns HTML for a group of file upload widgets.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: A render element representing the widgets.
 *
 * @ingroup themeable
 */
function omega_nodemaker_file_widget_multiple($variables) {
  
  $element = $variables['element'];
  // Special ID and classes for draggable tables.
  $weight_class = $element['#id'] . '-weight';
  $table_id = $element['#id'] . '-table';

  // Build up a table of applicable fields.
  $headers = array();
  $headers[] = t('File information');
  if ($element['#display_field']) {
    $headers[] = array(
      'data' => t('Display'),
      'class' => array('checkbox'),
    );
  }
  $headers[] = t('Weight');
  //$headers[] = t('Operations');

  // Get our list of widgets in order (needed when the form comes back after
  // preview or failed validation).
  $widgets = array();
  foreach (element_children($element) as $key) {
    $widgets[] = &$element[$key];
  }
  usort($widgets, '_field_sort_items_value_helper');

  $rows = array();
  foreach ($widgets as $key => &$widget) {
    // Save the uploading row for last.
    if ($widget['#file'] == FALSE) {
      $widget['#title'] = $element['#file_upload_title'];
      $widget['#description'] = $element['#file_upload_description'];
      continue;
    }

    // Delay rendering of the buttons, so that they can be rendered later in the
    // "operations" column.
    $operations_elements = array();

    // Delay rendering of the "Display" option and the weight selector, so that
    // each can be rendered later in its own column.
    if ($element['#display_field']) {
      hide($widget['display']);
    }
    hide($widget['_weight']);

    // Render everything else together in a column, without the normal wrappers.
    $widget['#theme_wrappers'] = array();

    foreach (element_children($widget) as $sub_key) {
      if (isset($widget[$sub_key]['#type']) && $widget[$sub_key]['#type'] == 'submit') {
        if ($widget[$sub_key]['#value'] == 'Remove') {
          $widget[$sub_key]['#attributes'] = array(
            'class' => array('file-remove-button'),
          );
        }
      }
    }
    
    $display = '';
    
    
    $information = drupal_render($widget);
    
    
    if ($element['#display_field']) {
      unset($widget['display']['#title']);
      $display = array(
        'data' => render($widget['display']),
        'class' => array('checkbox'),
      );
    }
    $widget['_weight']['#attributes']['class'] = array($weight_class);
    $weight = render($widget['_weight']);
    
    // Arrange the row with all of the rendered columns.
    $row = array();
    $row[] = '<div class="table-cell-wrapper">' . $information . '</div>';
    if ($element['#display_field']) {
      $row[] = $display;
    }
    $row[] = $weight;
    //$row[] = $operations;
    //dsm($row);
    $rows[] = array(
      'data' => $row,
      'class' => isset($widget['#attributes']['class']) ? array_merge($widget['#attributes']['class'], array('draggable')) : array('draggable'),
    );
  }

  drupal_add_tabledrag($table_id, 'order', 'sibling', $weight_class);
  //dsm($rows);
  $output = '';
  $output = empty($rows) ? '' : theme('table', array('header' => $headers, 'rows' => $rows, 'attributes' => array('id' => $table_id)));
  
  
  $output .= drupal_render_children($element);
  
  return $output;
}

/**
 * Theme Plupload items within widget.
 */
function omega_nodemaker_plup_items($vars) {
  //dsm($vars);
  $element = &$vars['element'];
  if (isset($element['#default_value']) && !empty($element['#default_value'])) {
    $items = &$element['#default_value'];
  } else {
    return '';
  }

  $output = '';
  foreach ($items AS $delta => $item) {
    // If user deleted all items I'll get array('fid' => 0)
    if ($item['fid'] > 0) {
      $name = $element['#name'] .'['. $delta .']';
      $output .= '<li class="ui-state-default">';
      $output .= '<div class="plup-thumb-wrapper">'. theme('image_style', array('style_name' => $element['#plup']['image_style'], 'path' => $item['uri'])) .'</div>';
      $output .= '<a class="plup-remove-item"></a>';
      if (isset($element['#plup_override']['title_field']) && $element['#plup_override']['title_field'] == 1) {
        $output .= '<input title="'. t('Title') .'" type="text" class="form-text" name="'. $name .'[title]" value="'. $item['title'] .'" />';
      }
      if (isset($element['#plup_override']['alt_field']) && $element['#plup_override']['alt_field'] == 1) {
        $output .= '<input title="'. t('Alternative text') .'" type="text" class="form-text" name="'. $name .'[alt]" value="'. $item['alt'] .'" />';
      }
      $output .= '<input type="hidden" name="'. $name .'[fid]" value="'. $item['fid'] .'" />';
      $output .= '<input type="hidden" name="'. $name .'[weight]" value="'. $delta .'" />';
      if (isset($item['rename'])) {
        $output .= '<input type="hidden" name="'. $name .'[rename]" value="'. $item['rename'] .'" />';
      }
      $output .= '</li>';
    }
  }
  return $output;
}