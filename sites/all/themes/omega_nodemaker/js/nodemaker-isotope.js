Drupal.nodemaker = Drupal.nodemaker || {};

(function($) {
  
  Drupal.nodemaker.isotopeTest = function (container, item) {
    // bail if we haven't anything to do
    results = $(container).find(item).size();
    //console.log(results);
    if (results == 0) {
      return false;
    }
    else {
      return true;
    }
  }
  
  Drupal.nodemaker.isotopeInvoke = function (container, item, cols, gutter) {
    
    if (!Drupal.nodemaker.isotopeTest(container, item)) {
      return;
    }
    
    
    isotopeContainer = container;
    isotopeItem = item;
    isotopeCols = cols;
    isotopeContainerWidth = isotopeContainer.width();
    isotopeGutterWidth = gutter;
    isotopeAllGutters = isotopeGutterWidth * (isotopeCols - 1)
    isotopeColWidth = (isotopeContainerWidth - isotopeAllGutters) / isotopeCols;
    isotopeActive = false;
    
    /*

    console.log('isotopeContainer: ' + isotopeContainer);
    console.log('isotopeItem: ' + isotopeItem);
    console.log('isotopeCols: ' + isotopeCols);
    console.log('isotopeContainerWidth: ' + isotopeContainerWidth);
    console.log('isotopeGutterWidth: ' + isotopeGutterWidth);
    console.log('isotopeAllGutters: ' + isotopeAllGutters);
    console.log('isotopeColWidth: ' + isotopeColWidth);
    
*/
    
    isotopeContainer.imagesLoaded( function(){          
      // update the width
      isotopeContainer.find(isotopeItem).css('width', isotopeColWidth);
      
      isotopeContainer.isotope({
        itemSelector: isotopeItem,
        
        containerStyle: {
          position: 'relative',
          overflow: 'hidden'
        },
        
        animationEngine: 'best-available',
        animationOptions: {
          duration: 1000,
          easing: 'linear',
          queue: false
        },
        
        layoutMode: 'masonry',
        
        masonry: { 
          columnWidth: isotopeColWidth,
          gutterWidth: isotopeGutterWidth
        },
        
        itemPositionDataEnabled: true,
        isAnimated: true,
        resizable: true
      });
      // let's flag our isotope as enabled
      isotopeActive = true;
    });
  }
  
  Drupal.nodemaker.isotopeResize = function (container, item, cols, gutter) {
    
    if (!Drupal.nodemaker.isotopeTest(container, item)) {
      return;
    }
    
    containerwidth = container.width();
    gutters = gutter * (cols - 1)
    colwidth = (containerwidth - gutters) / cols;
    
    // reset the item width to the new value
    container.find(item).css('width', colwidth);
    
    
    
    if (isotopeActive) {
      container.isotope({
        // update columnWidth to a percentage of container width
        masonry: { 
          columnWidth: colwidth,
          gutterWidth: gutter
        },
      });
    }
    
    else {
      Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
    }
  }
  
  Drupal.nodemaker.isotopeDestroy = function (container, item) {
    if (!Drupal.nodemaker.isotopeTest(container, item)) {
      return;
    }
    
    if (isotopeActive) {
      container.isotope('destroy');
      container.find(item).css('width', 'auto');
      isotopeActive = false;
    }
  }
  
  
  
})(jQuery);


(function ($) {
  
 
  
  // add jquery isotope/masonry to various elements
  Drupal.behaviors.nodemakerIsotope = {
    attach: function(context, settings) {  
      
           
      $('body').one('responsivelayout', function(e, d) {  
        // default columns
        
        container = $('#block-views-nm-blog-recent .view-nm-blog .view-content, #block-system-main .view-nm-blog .view-content, #block-system-main .view-nm-blog-by-user .view-content, #block-system-main .view-nm-announcements .view-content');
        item = '.views-row';
        gutter = 20;
        cols = 2;        
        
        // override the width and number of columns for the narrow layout
        if (d.to == 'narrow') {
          cols = 1;
          gutter = 0;
        }
        //console.log(d.to);
        // don't invoke if we are loading up on mobile mode
        // it causes suckage. We'll only invoke it once we are above handheld "stacked" mode.
        if (d.to != 'mobile') {
          //console.log('running Drupal.nodemaker.isotopeInvoke()');
          Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
        }
      });
      
      
      // handle resize of isotope plugin
      $(window).resize(function() {
  		  $('body').one('responsivelayout', function(e, d) {  		  
  		    if(d.from != d.to) {
    		    
    		    container = $('#block-views-nm-blog-recent .view-nm-blog .view-content, #block-system-main .view-nm-blog .view-content, #block-system-main .view-nm-blog-by-user .view-content, #block-system-main .view-nm-announcements .view-content');
            item = '.views-row';
            gutter = 20;
            cols = 2;
            
            // override the width and number of columns for narrow
            if (d.to == 'narrow') {
              cols = 1;
            }
            
            // we came from mobile where isotope is not invoked, we should call it now
            if (d.from == 'mobile') {
              Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
            }
            
            // we are going TO a mobile device, get rid of isotope
            if (d.to == 'mobile') {
              Drupal.nodemaker.isotopeDestroy(container, item);
            }
            else {
              Drupal.nodemaker.isotopeResize(container, item, cols, gutter);  
            }
  		    }
  		  });
  	  });    
    }
  };
  
  
  
  
  
  
  
  
  
  
  
  
  
  // add jquery isotope/masonry to various elements
  Drupal.behaviors.nodemakerGalleryIsotope = {
    attach: function(context, settings) {  
                 
      $('body').one('responsivelayout', function(e, d) {  
        // default columns
        
        container = $('#block-system-main .view-display-id-galleries .view-content');
        item = '.views-row';
        gutter = 20;
        cols = 2;
        
        // override the width and number of columns for the narrow layout
        if (d.to == 'normal') {
          cols = 2;
        }
        // override the width and number of columns for the narrow layout
        if (d.to == 'narrow') {
          cols = 1;
        }
        
        // don't invoke if we are loading up on mobile mode
        // it causes suckage. We'll only invoke it once we are above handheld "stacked" mode.
        if (d.to != 'mobile') {
          Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
          isotopeInvoked = true;
        }
      });
      
      
      // handle resize of isotope plugin
      $(window).resize(function() {
  		  $('body').one('responsivelayout', function(e, d) {  		  
  		    if(d.from != d.to) {
    		    
    		    container = $('#block-system-main .view-display-id-galleries .view-content');
            item = '.views-row';
            gutter = 20;
            cols = 2;
            
            // override the width and number of columns for the narrow layout
            if (d.to == 'normal') {
              cols = 2;
            }
            // override the width and number of columns for the narrow layout
            if (d.to == 'narrow') {
              cols = 1;
            }
            
            
            // we came from mobile where isotope is not invoked, we should call it now
            if (d.from == 'mobile') {
              Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
            }
            
            // we are going TO a mobile device, get rid of isotope
            if (d.to == 'mobile') {
              Drupal.nodemaker.isotopeDestroy(container, item);
            }
            else {
              Drupal.nodemaker.isotopeResize(container, item, cols, gutter);  
            }
  		    }
  		  });
  	  });    
    }
  };
  

  // add jquery isotope/masonry to various elements
  Drupal.behaviors.nodemakerGalleryThumbsIsotope = {
    attach: function(context, settings) {  
                 
      $('body').one('responsivelayout', function(e, d) {  
        // default columns
        
        container = $('#block-system-main .view-display-id-thumb_page .view-content');
        item = '.views-row';
        gutter = 5;
        cols = 1;
        
        // override the width and number of columns for the wide layout
        if (d.to == 'wide') {
          cols = 6;
        }
        // override the width and number of columns for the normal layout
        if (d.to == 'normal') {
          cols = 4;
        }
        // override the width and number of columns for the narrow layout
        if (d.to == 'narrow') {
          cols = 2;
        }
        
        // don't invoke if we are loading up on mobile mode
        // it causes suckage. We'll only invoke it once we are above handheld "stacked" mode.
        if (d.to != 'mobile') {
          Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
          isotopeInvoked = true;
        }
      });
      
      
      // handle resize of isotope plugin
      $(window).resize(function() {
  		  $('body').one('responsivelayout', function(e, d) {  		  
  		    if(d.from != d.to) {
    		    
    		    container = $('#block-system-main .view-display-id-thumb_page .view-content');
            item = '.views-row';
            gutter = 5;
            cols = 1;
            
            // override the width and number of columns for the wide layout
            if (d.to == 'wide') {
              cols = 6;
            }
            // override the width and number of columns for the normal layout
            if (d.to == 'normal') {
              cols = 4;
            }
            // override the width and number of columns for the narrow layout
            if (d.to == 'narrow') {
              cols = 2;
            }
            
            
            // we came from mobile where isotope is not invoked, we should call it now
            if (d.from == 'mobile') {
              Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
            }
            
            // we are going TO a mobile device, get rid of isotope
            if (d.to == 'mobile') {
              Drupal.nodemaker.isotopeDestroy(container, item);
            }
            else {
              Drupal.nodemaker.isotopeResize(container, item, cols, gutter);  
            }
  		    }
  		  });
  	  });    
    }
  };
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  Drupal.behaviors.nodemakerLandingPageIsotope = {
    attach: function(context, settings) { 
      if (Drupal.settings.nodemaker.isotope_home_toggle) {
        container = $('.page-landing .view-nm-landing .view-content');
        item = '.views-row';
        gutter = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_gutter);
        cols = Drupal.settings.currentIsotopeCols;
        
        $('.view-nm-landing').ajaxSuccess(function(){
          //console.log('content updated');
          Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
          //console.log(settings);
        });
      }
    }
  };

  // add jquery isotope/masonry to landing pages
  Drupal.behaviors.nodemakerLandingPages = {
    attach: function(context, settings) {  
                       
      $('.page-landing').bind('responsivelayout', function(e, d) {  
        // default columns
        
        
        if (Drupal.settings.nodemaker.isotope_home_toggle) {
          container = $('.page-landing .view-nm-landing .view-content');
          item = '.views-row';
          gutter = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_gutter);
          cols = 1;
             
          // override the width and number of columns for the wide layout
          if (d.to == 'wide') {
            cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_wide);
          }
          
          // override the width and number of columns for the normal layout
          if (d.to == 'normal') {
            cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_normal);
          }
          
          // override the width and number of columns for the narrow layout
          if (d.to == 'narrow') {
            cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_narrow);
          }
          
          // don't invoke if we are loading up on mobile mode
          // it causes suckage. We'll only invoke it once we are above handheld "stacked" mode.
          if (d.to != 'mobile') {
            Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
            Drupal.settings.currentIsotopeCols = cols;
            isotopeInvoked = true;
          }
        }
      });
       
      // handle resize of isotope plugin
      $(window).resize(function() {
  		  $('.page-landing').one('responsivelayout', function(e, d) {  		  
  		    if(d.from != d.to && Drupal.settings.nodemaker.isotope_home_toggle) {
    		    
    		    container = $('.page-landing .view-nm-landing .view-content');
            item = '.views-row';
            gutter = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_gutter);
            cols = 1;
            
            // override the width and number of columns for the wide layout
            if (d.to == 'wide') {
              cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_wide);
            }
            
            // override the width and number of columns for the normal layout
            if (d.to == 'normal') {
              cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_normal);
            }
            
            // override the width and number of columns for the narrow layout
            if (d.to == 'narrow') {
              cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_narrow);
            }
            
            // we came from mobile where isotope is not invoked, we should call it now
            if (d.from == 'mobile') {
              Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
              isotopeInvoked = true;
            }

            // we are going TO a mobile device, get rid of isotope
            if (d.to == 'mobile') {
              Drupal.nodemaker.isotopeDestroy(container, item);
            }
            else {
              Drupal.nodemaker.isotopeResize(container, item, cols, gutter);  
            }
  		    }
  		  });
  	  });    
    }
  };

  // add jquery isotope/masonry to default /node page
  Drupal.behaviors.nodemakerDrupalFrontpage = {
    attach: function(context, settings) {  
      $('body').bind('responsivelayout', function(e, d) {  
        if (Drupal.settings.nodemaker.isotope_home_toggle) {
          container = $('body .node-river');
          item = 'article';
          gutter = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_gutter);
          cols = 1;
             
          // override the width and number of columns for the wide layout
          if (d.to == 'wide') {
            cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_wide);
          }
          
          // override the width and number of columns for the normal layout
          if (d.to == 'normal') {
            cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_normal);
          }
          
          // override the width and number of columns for the narrow layout
          if (d.to == 'narrow') {
            cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_narrow);
          }
          
          // don't invoke if we are loading up on mobile mode
          // it causes suckage. We'll only invoke it once we are above handheld "stacked" mode.
          if (d.to != 'mobile') {
            Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
            Drupal.settings.currentIsotopeCols = cols;
            isotopeInvoked = true;
          }
        }
      });
      
      // handle resize of isotope plugin
      $(window).resize(function() {
  		  $('.page-landing').one('responsivelayout', function(e, d) {  		  
  		    if(d.from != d.to && Drupal.settings.nodemaker.isotope_home_toggle) {
    		    
    		    container = $('body .node-river');
            item = 'article';
            gutter = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_gutter);
            cols = 1;
            
            // override the width and number of columns for the wide layout
            if (d.to == 'wide') {
              cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_wide);
            }
            
            // override the width and number of columns for the normal layout
            if (d.to == 'normal') {
              cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_normal);
            }
            
            // override the width and number of columns for the narrow layout
            if (d.to == 'narrow') {
              cols = parseInt(Drupal.settings.nodemaker.home_columns.home_columns_narrow);
            }
            
            // we came from mobile where isotope is not invoked, we should call it now
            if (d.from == 'mobile') {
              Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
              isotopeInvoked = true;
            }

            // we are going TO a mobile device, get rid of isotope
            if (d.to == 'mobile') {
              Drupal.nodemaker.isotopeDestroy(container, item);
            }
            else {
              Drupal.nodemaker.isotopeResize(container, item, cols, gutter);  
            }
  		    }
  		  });
  	  });    
    }
  };

  
  // add jquery isotope/masonry to various taxonomy page elements
  Drupal.behaviors.nodemakerTaxonomyIsotope = {
    attach: function(context, settings) {  
                 
      $('body').one('responsivelayout', function(e, d) {  
        // default columns
        
        container = $('body.page-taxonomy-term #block-system-main .block-inner .term-nodes');
        item = 'article';
        gutter = parseInt(Drupal.settings.nodemaker.taxonomy_columns.taxonomy_columns_gutter);;
        cols = 1;
        
        // override the width and number of columns for the wide layout
        if (d.to == 'wide') {
          cols = parseInt(Drupal.settings.nodemaker.taxonomy_columns.taxonomy_columns_wide);
        }
        
        // override the width and number of columns for the normal layout
        if (d.to == 'normal') {
          cols = parseInt(Drupal.settings.nodemaker.taxonomy_columns.taxonomy_columns_normal);
        }
        
        // override the width and number of columns for the narrow layout
        if (d.to == 'narrow') {
          cols = parseInt(Drupal.settings.nodemaker.taxonomy_columns.taxonomy_columns_narrow);
        }
        
        
        // don't invoke if we are loading up on mobile mode
        // it causes suckage. We'll only invoke it once we are above handheld "stacked" mode.
        if (d.to != 'mobile') {
          Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
          Drupal.settings.currentIsotopeCols = cols;
          isotopeInvoked = true;
        }
      });
      
      
      // handle resize of isotope plugin
      $(window).resize(function() {
  		  $('body').one('responsivelayout', function(e, d) {  		  
  		    if(d.from != d.to) {
    		    
    		    gutter = parseInt(Drupal.settings.nodemaker.taxonomy_columns.taxonomy_columns_gutter);;
            cols = 1;
            
            // override the width and number of columns for the wide layout
            if (d.to == 'wide') {
              cols = parseInt(Drupal.settings.nodemaker.taxonomy_columns.taxonomy_columns_wide);
            }
            
            // override the width and number of columns for the normal layout
            if (d.to == 'normal') {
              cols = parseInt(Drupal.settings.nodemaker.taxonomy_columns.taxonomy_columns_normal);
            }
            
            // override the width and number of columns for the narrow layout
            if (d.to == 'narrow') {
              cols = parseInt(Drupal.settings.nodemaker.taxonomy_columns.taxonomy_columns_narrow);
            }
            
            // we came from mobile where isotope is not invoked, we should call it now
            if (d.from == 'mobile') {
              Drupal.nodemaker.isotopeInvoke(container, item, cols, gutter);
              isotopeInvoked = true;
            }
            
            // we are going TO a mobile device, get rid of isotope
            if (d.to == 'mobile') {
              Drupal.nodemaker.isotopeDestroy(container, item);
            }
            else {
              Drupal.nodemaker.isotopeResize(container, item, cols, gutter);  
            }
  		    }
  		  });
  	  });    
    }
  };
  
  // modified Isotope methods for gutters in masonry
  $.Isotope.prototype._getMasonryGutterColumns = function() {
    var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
        containerWidth = this.element.width();
  
    this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
                  // or use the size of the first item
                  this.$filteredAtoms.outerWidth(true) ||
                  // if there's no items, use size of container
                  containerWidth;

    this.masonry.columnWidth += gutter;

    this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
    this.masonry.cols = Math.max( this.masonry.cols, 1 );
  };

  $.Isotope.prototype._masonryReset = function() {
    // layout-specific props
    this.masonry = {};
    // FIXME shouldn't have to call this again
    this._getMasonryGutterColumns();
    var i = this.masonry.cols;
    this.masonry.colYs = [];
    while (i--) {
      this.masonry.colYs.push( 0 );
    }
  };

  $.Isotope.prototype._masonryResizeChanged = function() {
    var prevSegments = this.masonry.cols;
    // update cols/rows
    this._getMasonryGutterColumns();
    // return if updated cols/rows is not equal to previous
    return ( this.masonry.cols !== prevSegments );
  };

  
  
  
  
})(jQuery);