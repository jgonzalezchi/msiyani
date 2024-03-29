<article<?php print $attributes; ?>>
  <header>
    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
      <h3<?php print $title_attributes; ?>><?php print $title ?></h3>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if ($new): ?>
      <em class="new"><?php print $new ?></em>
    <?php endif; ?>
    <?php if (isset($unpublished)): ?>
      <em class="unpublished"><?php print $unpublished; ?></em>
    <?php endif; ?>
  </header>

  <div class="comment-body">

    <div<?php print $content_attributes; ?>>
      <?php
        hide($content['links']);
        print render($content);
      ?>
    </div>
  
    <?php if (!empty($content['links'])): ?>
      <nav class="links comment-links clearfix"><?php print render($content['links']); ?></nav>
    <?php endif; ?>
    
  </div>
  <footer class="submitted comment-submitted"><?php print $submission_info; ?></footer>
</article>
