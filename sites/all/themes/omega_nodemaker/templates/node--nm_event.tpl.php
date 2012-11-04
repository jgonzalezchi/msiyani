<?php
  //krumo($content);
?>
<article<?php print $attributes; ?>>
  <div class="node-content clearfix">
    <header>
      <?php if (isset($content['field_nm_attach_gallery'])): ?>
        <?php print render($content['field_nm_attach_gallery']); ?>
        <?php hide($content['field_nm_headline_image']); ?>
      <?php else: ?>
        <?php print render($content['field_nm_headline_image']); ?>
      <?php endif; ?>
      
      <?php if ($display_submitted): ?>
        <div class="submitted"><?php print $submission_info; ?></div>
      <?php endif; ?>
      
      <div class="event-date clearfix">
        <?php if ($event_dates['start']): ?>
        <div class="event-start">
          <h5><?php print t('Event Starts');?></h5>        
          <span><?php print $event_dates['start']; ?></span>
        </div>
        <?php endif; ?>
        
        <?php if ($event_dates['end']): ?>
        <div class="event-end">
          <h5><?php print t('Event Ends');?></h5>        
          <span><?php print $event_dates['end']; ?></span>
        </div>
        <?php endif; ?>
      </div>
      
      <div class="node-category node-terms share clearfix">
        <?php if (isset($content['field_nm_event_category'])): ?>
          <div class="category-term"><?php print render($content['field_nm_event_category']); ?></div>
        <?php endif; ?>
        <?php if (isset($content['sharethis'])): ?>
          <div class="share-wrapper"><?php print render($content['sharethis']); ?></div>
        <?php endif; ?>
      </div>
    </header>  
    <div<?php print $content_attributes; ?>>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['field_nm_tags']);
        hide($content['field_nm_date']);
        hide($content['field_nm_address']);
        hide($content['field_nm_event_link']);
        hide($content['field_nm_registration_info']);
        hide($content['comments']);
        hide($content['links']);
        
        print render($content);
        
        
      ?>
      
      <div class="event-info clearfix">
        <div class="event-map">
          <?php print $event_map; ?>
        </div>
        <div class="event-details">
          <div class="event-address">
            <?php print render($content['field_nm_address']); ?>
          </div>
          <div class="event-link">
            <?php print render($content['field_nm_event_link']); ?>
          </div>
          <div class="event-registration">
            <?php print render($content['field_nm_registration_info']); ?>
          </div>
        </div>
      </div>
            
      <footer>
        <div class="node-category node-terms share clearfix">
          <?php if (isset($content['field_nm_tags'])): ?>
            <div class="category-term tags"><?php print render($content['field_nm_tags']); ?></div>
          <?php endif; ?>
          <?php if (isset($content['sharethis'])): ?>
            <div class="share-wrapper"><?php print render($content['sharethis']); ?></div>
          <?php endif; ?>
        </div> 
        
        <?php if (!empty($content['links'])): ?>
          <nav class="links node-links clearfix"><?php print render($content['links']); ?></nav>
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
