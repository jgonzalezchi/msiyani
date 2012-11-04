<?php

/**
  * Content for app page for NodeMaker profile.
  */
function omega_nodemaker_help_details() {
  $items = array();
  $items[] = '<strong>' . t('.') . '</strong>  ' . t('..');
  $items[] = '<strong>' . t('Issues?') . '</strong>  ' . t('Have a support question?  Find a bug?  !issue!', array('!issue' => '<a href="http://drupal.org/project/issues/omega_nodemaker" title="Omega NodeMaker Issue Queue" target="_blank">Please use the issue queue</a>'));
  return $items;
}