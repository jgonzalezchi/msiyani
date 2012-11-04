<?php
/**
 * @file
 * Alpha's theme implementation to display a single Drupal page.
 */
?>

<?php if (isset($userbar)) : ?>
  <?php print render($userbar); ?>
<?php endif; ?>

<div id="wrapper" class="clearfix">
<div id="scroller" class="clearfix">
  <div id="pullDown">
		<span class="pullDownIcon"></span><span class="pullDownLabel">Pull down to refresh...</span>
	</div>
  <div id="page-wrapper">
  <div<?php print $attributes; ?>>
  
    <?php if (isset($page['header'])) : ?>
      <?php print render($page['header']); ?>
    <?php endif; ?>
      
    <?php if (isset($page['content'])) : ?>
      <?php print render($page['content']); ?>
    <?php endif; ?>
    
    <?php if (isset($page['footer'])) : ?>
      <?php print render($page['footer']); ?>
    <?php endif; ?>
    
  </div>
  </div>
</div>
</div>