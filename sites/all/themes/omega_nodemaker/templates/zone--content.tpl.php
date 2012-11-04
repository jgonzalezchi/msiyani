<?php if ($wrapper): ?><div<?php print $attributes; ?>><?php endif; ?>
  <div<?php print $content_attributes; ?>>
    <?php if ($breadcrumb): ?>
      <div id="breadcrumb-wrapper" class="clearfix grid-<?php print $columns; ?>">
        <?php print $breadcrumb; ?>
      </div>
    <?php endif; ?>
    <?php print $content; ?>
  </div>
<?php if ($wrapper): ?></div><?php endif; ?>
