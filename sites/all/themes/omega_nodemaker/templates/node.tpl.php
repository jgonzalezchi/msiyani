<?php
  //krumo($content);
?>
<article<?php print $attributes; ?>>
  <div class="node-content clearfix">
    <?php print render($title_prefix); ?>
    
    <header>
      <?php if (isset($content['field_nm_attach_gallery'])): ?>
        <?php print render($content['field_nm_attach_gallery']); ?>
        <?php hide($content['field_nm_headline_image']); ?>
      <?php endif; ?>
      
      <?php if (isset($content['field_nm_gallery_images'])): ?>
        <?php print render($content['field_nm_gallery_images']); ?>
        <?php hide($content['field_nm_headline_image']); ?>
      <?php endif; ?>
      
      <?php if(!isset($content['field_nm_attach_gallery']) || !isset($content['field_nm_gallery_images'])): ?>
        <?php print render($content['field_nm_headline_image']); ?>
      <?php endif; ?>
      
      <?php if (!$page && $title): ?>
        <h2<?php print $title_attributes; ?>><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
      <?php endif; ?>
      
      <?php if ($display_submitted): ?>
        <div class="submitted"><?php print $submission_info; ?></div>
      <?php endif; ?>
      
      <div class="node-category node-terms share clearfix">
        <?php if (isset($content['taxonomy_forums'])): ?>
          <div class="category-term"><?php print render($content['taxonomy_forums']); ?></div>
        <?php endif; ?>
        <?php if (isset($content['sharethis'])): ?>
          <div class="share-wrapper"><?php print render($content['sharethis']); ?></div>
        <?php endif; ?>
      </div>
    </header>
    
    <?php print render($title_suffix); ?>
  
    <div<?php print $content_attributes; ?>>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        hide($content['field_nm_tags']);
        hide($content['taxonomy_forums']);
        hide($content['sharethis']);
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
      
      </footer>
      
    </div>
  </div>
  
  <div class="node-comments clearfix">
    <div class="clearfix comment-wrapper">
      <?php print render($content['comments']); ?>
    </div>
  </div>
</article>
