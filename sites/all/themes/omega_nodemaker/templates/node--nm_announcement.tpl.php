<?php
  //krumo($content);
?>
<article<?php print $attributes; ?>>
  <div class="node-content clearfix">
    
    <header>
      <?php print render($content['field_nm_headline_image']); ?>
      <div class="node-category node-terms share clearfix">
        <?php if (isset($content['field_nm_announcement_category'])): ?>
          <div class="category-term"><?php print render($content['field_nm_announcement_category']); ?></div>
        <?php endif; ?>
        <?php if (isset($content['sharethis'])): ?>
          <div class="share-wrapper"><?php print render($content['sharethis']); ?></div>
        <?php endif; ?>
      </div>
    </header>
  
    <div<?php print $content_attributes; ?>>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        hide($content['field_nm_tags']);
        print render($content);
      ?>
      <?php if (!empty($content['links'])): ?>
        <nav class="links node-links clearfix"><?php print render($content['links']); ?></nav>
      <?php endif; ?>
      
      <div class="node-category node-terms share clearfix">
        <?php if (isset($content['field_nm_tags'])): ?>
          <div class="category-term tags"><?php print render($content['field_nm_tags']); ?></div>
        <?php endif; ?>
        <?php if (isset($content['sharethis'])): ?>
          <div class="share-wrapper"><?php print render($content['sharethis']); ?></div>
        <?php endif; ?>
      </div>
      
      <footer> 
        <?php if ($display_submitted): ?>
          <span class="submitted"><?php print $submission_info; ?></span>
        <?php endif; ?>
      </footer>
      
    </div>
  </div>
  
  <div class="node-comments clearfix">
    <div class="clearfix comment-wrapper">
      <?php print render($content['comments']); ?>
    </div>
  </div>
</article>
