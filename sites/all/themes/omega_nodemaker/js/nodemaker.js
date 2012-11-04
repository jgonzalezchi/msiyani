Drupal.nodemaker = Drupal.nodemaker || {};



(function($) {
    
  var toolbar;
  var toolbarHeight;
  var menuHeight;
  var combinedHeight;
  var menuOffset;
  
  // replacement function for tabledrag dropped row manipulation
  
  if (Drupal.tableDrag) {
    Drupal.tableDrag.prototype.onDrop = function () {
      // add a class to the row that was dragged around
      $(this.oldRowElement).addClass('row-changed');
    };  
  }
  
  
  Drupal.nodemaker.menuInitHeight = function () {
    
    //console.log('Running: Drupal.nodemaker.menuInitHeight');
        
    toolbar = $('#toolbar').size(); 
    menuHeight = $('#zone-user-wrapper').height();
    toolbarHeight = $('#toolbar').height();
    combinedHeight = toolbarHeight + menuHeight;
    
    $('#toolbar').css('position', 'fixed').css('top', '0');
    $('#zone-user-wrapper').css('position', 'fixed').css('top', toolbarHeight);
    $('#overlay-container').css('top', combinedHeight - 20);
    $('#wrapper').css('top', combinedHeight + 15);
  }
  
  
  
  Drupal.nodemaker.mobileFlyout = function (link) {
    // handle a click function on the arrow(s) (mobile ONLY)
    // grab the submenu associated with the arrow we clicked
    submenu = $(link)
      .parents('li.expanded > a')
      .next('ul');
    
    // if it's already opened
    if (submenu.hasClass('submenu-opened')) {
      // rotate the arrow back to closed
      $(link)
        .parent('.menu-children')
        .removeClass('flip');
      // hide the submenu
      submenu.hide('normal', function(){
        $(this)
          .removeClass('submenu-opened');
      });
      return false;
    }
    
    // if it's currently closed
    else {
      // rotate the arrow
      $(link).parent('.menu-children')
        .addClass('flip');
      // show the submenu
      submenu.show('normal', function(){
        $(this)
          .addClass('submenu-opened');
      });
      return false;
    }
  }
  
  Drupal.nodemaker.nicemenuFlyoutPosition = function (item) {
    parent = $(item);
    itemHeight = parent.outerHeight();
    parent.next('ul').css('top', itemHeight).css('left', -1);
  }
  
})(jQuery);

(function ($) {
  // function to make image widgets much nicer.
  Drupal.behaviors.nodemakerBetterFileMgmt = {
    attach: function(context, settings) {
      $('.image-widget-toggle').click(function(event){
        event.stopImmediatePropagation();
        if ($(this).hasClass('show-more')) {
          $(this).removeClass('show-more').text('show less');
          $(this).parents('.image-widget-data').children('.image-details').slideDown('fast');
        }
        else {
          $(this).addClass('show-more').text('show more');
          $(this).parents('.image-widget-data').children('.image-details').slideUp('fast');
        }
        return false;
      });
    }
  };
  
  // add a mobile friendly menu
  Drupal.behaviors.nodemakerMobileMenu = {
    attach: function(context, settings) {            
      //$('#region-user-first .region-inner').before('');
      //$('.navigation .primary-menu h2, .navigation .second-menu h2').removeClass('element-invisible');
      
      // wait till the page is fully loaded
      $(window).load(function(){
        
        
        
        
        
        
        
        
        var menuToggleItem;
        var menuOpened;
        var referencedBlock;
        // handle the menu open/close stuff
        $('a.mobile-menu-toggle').click(function(){
          
          menuToggleItem = $(this).attr('href').substr(1);
          
          referencedBlock = $(this).attr('rel');
          //console.log(referencedBlock);
          
          if (menuOpened = $(this).hasClass('mobile-menu-opened')) {
            $(this).removeClass('mobile-menu-opened').removeClass('active');
            $(referencedBlock).removeClass('mobile-block-opened').slideToggle('fast', function(){
              Drupal.nodemaker.menuInitHeight();  
            });
            
          }
          else {            
            
            $(this).addClass('mobile-menu-opened').addClass('active');
            $(referencedBlock).addClass('mobile-block-opened').slideToggle('fast', function(){
              Drupal.nodemaker.menuInitHeight();                
              $('#wrapper, #scroller').animate({
                  scrollTop: 0
              }, 500);
            });
            
            
            
            
            
          }
          return false;          
        });
      });
    }
  };
  
  // fix drupal toolbar menu for logged in users on mobile
  
  Drupal.behaviors.nodemakerMobile = {
    attach: function(context, settings) {            
      
      Drupal.nodemaker.menuInitHeight();
      
      $(window).resize(function(){  
        Drupal.nodemaker.menuInitHeight();
      });
      
      $('a.toggle').click(function(){  
        Drupal.nodemaker.menuInitHeight();
      });
      
      $(window).scroll(function(){  
        
      });
    }
  };
  
  /**
   * This is here to make nice_menus suck a LOT less...
   * Integrates a mobile layout, only invokes nice_menus on a non-mobile version of the browser as well.
   */
  Drupal.behaviors.nodemakerMenus = {
    attach: function(context, settings) {
      // add an open close toggle link to any menuparents
      // this is for opening/closing sub-menus on a touch device
      $('#block-menu-block-nm-core-mobile-menu li.expanded > a')
        .append('<span class="menu-children"><a class="children-toggle" href="#"></a></span>');
      
      
      // bind events to the mobile menu "toggle" link for sub-items
      $('#block-menu-block-nm-core-mobile-menu a.children-toggle').bind({
        click: function() {
          Drupal.nodemaker.mobileFlyout(this);
          return false;
        },
      });
      
      // create nicemenu for primary nav on large screen, non-touch devices.
      // the dropdowns/flyouts are disabled on touch devices, because well... it just 
      // doesn't work right. 
      $('.no-touch ul.nice-menu').superfish({
        // Apply a generic hover class.
        hoverClass: 'over',
        // Disable generation of arrow mark-up.
        autoArrows: false,
        // Disable drop shadows.
        dropShadows: false,
        // Mouse delay.
        delay: Drupal.settings.nice_menus_options.delay,
        // Animation speed.
        speed: Drupal.settings.nice_menus_options.speed
      // Add in Brandon Aaron’s bgIframe plugin for IE select issues.
      // http://plugins.jquery.com/node/46/release
      }).find('ul').bgIframe({opacity:false});
      $('ul.nice-menu ul').css('display', 'none');
      
      $(window).load(function(){
      
        // position the submenus but wait till page is fully loaded
        // so that font sizes don't distrupt the positioning.
        $('.no-touch ul.nice-menu > li.menuparent > a').each(function() {
          Drupal.nodemaker.nicemenuFlyoutPosition(this);
        });
      
      });
      
      
      
      
      // load up the superfish if we are in normal or wide mode when we first load the page
      $('.no-touch body').one('responsivelayout', function(e, d) {  
        // only load up the superfish dropdowns in the normal or wide mode
        // this will NOT load if you first load your browser in a mobile
        // or tablet sized window, even after scaling out to wide.
        
      });
      
      // now we have to handle resize events and enable/destroy superfish as needed
      $(window).resize(function() {
  		  $('.no-touch body').one('responsivelayout', function(e, d) {  		  
  		    if(d.from != d.to) {
            
            if (d.to == 'mobile' || d.to == 'narrow') {

            }
            
		        if (d.to == 'normal' || d.to == 'wide') {
  		        // position the submenus
              $('.no-touch ul.nice-menu > li.menuparent > a').each(function() {
                Drupal.nodemaker.nicemenuFlyoutPosition(this);
              });  		        
		        }
  		    }
  		  });
  	  }); 
    }
  };  // end Drupal.behaviors.nodemakerNiceMenus
  
  
})(jQuery);