<?php
  //krumo($content);
?>
<article<?php print $attributes; ?>>
  
  <div class="node-content clearfix">
  
  <?php print render($title_prefix); ?>
  <header>
    <div class="event-summary clearfix">
    <div class="calendar-icon">
      <div class="month"><?php print($calendar['start_month']); ?></div>
      <div class="day"><?php print($calendar['start_day']); ?></div>
    </div>
    
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
    
    <?php print render($content['field_nm_date']); ?>
    </div>
  </header>
  <?php print render($title_suffix); ?>
  
  <?php print render($content['field_nm_headline_image']); ?>
  
  <div<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      hide($content['sharethis']);
      print render($content);
    ?>
  </div>

  <div class="clearfix">
    <?php if (!empty($content['links'])): ?>
      <nav class="links node-links clearfix"><?php print render($content['links']); ?></nav>
    <?php endif; ?>

    <?php print render($content['comments']); ?>
  </div>
  
  </div>
</article>
