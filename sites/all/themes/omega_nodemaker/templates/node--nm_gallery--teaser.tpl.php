<?php
  //krumo($content);
?>
<article<?php print $attributes; ?>>
  <div class="node-content clearfix">
    <?php print render($title_prefix); ?>
    <?php if (!$page && $title): ?>
    <header>
      <?php print render($content['field_nm_headline_image']); ?>
      <h2<?php print $title_attributes; ?>><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
    </header>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    
    <div<?php print $content_attributes; ?>>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        hide($content['sharethis']);
        print render($content);
      ?>
      <div class="photo-count">
        <?php print $photo_count; ?>
      </div>
    </div>
  </div>
</article>
