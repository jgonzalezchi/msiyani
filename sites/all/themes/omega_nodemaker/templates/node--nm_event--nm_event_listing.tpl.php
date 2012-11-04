<?php
  //krumo($content);
?>
<article<?php print $attributes; ?>>
  <div class="event-summary clearfix">
    <div class="calendar-icon">
      <div class="month"><?php print($calendar['start_month']); ?></div>
      <div class="day"><?php print($calendar['start_day']); ?></div>
    </div>
    
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
    
    <?php print render($content['field_nm_date']); ?>
    </div>
</article>
