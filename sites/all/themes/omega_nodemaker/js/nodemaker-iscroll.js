(function ($) {
  
  var myScroll,
  	pullDownEl, pullDownOffset,
  	pullUpEl, pullUpOffset,
  	generatedCount = 0;
  
  function pullDownAction () {
		var el, li, i;
		el = document.getElementById('page');

		$('#page-wrapper').load(document.URL + ' #page', function() {
      Drupal.attachBehaviors('#page');
      myScroll.refresh();		// Remember to refresh when contents are loaded (ie: on ajax completion)
    });
  }
  function reloadiScroll() {
    var myScroll;
    
    if (myScroll) {
      myScroll.refresh();
    }
  }
  
  function loadiScroll() {
  	var notouch = $('html.no-touch').size();
    if (notouch) {
      return false;
    }
    else {
      pullDownEl = document.getElementById('pullDown');
    	pullDownOffset = pullDownEl.offsetHeight;
    	
    	myScroll = new iScroll('wrapper', {
    		useTransition: true,
    		topOffset: pullDownOffset,
    		checkDOMChanges: true,
    		bounce: true,
    		momentum: true,
    		lockDirection: true,
        hScrollbar: false,
        vScrollbar: true,
        zoom: true,
  			zoomMin: 1,
  			zoomMax: 2,
  			doubleTapZoom: 1.5,
    		onBeforeScrollStart: function () {
    		  // this is ONLY here to reset line 130 in iscroll.js
      		// onBeforeScrollStart: function (e) { e.preventDefault(); },

    		},

    		onRefresh: function () {
    			if (pullDownEl.className.match('loading')) {
    				pullDownEl.className = '';
    				pullDownEl.querySelector('.pullDownLabel').innerHTML = 'Pull down to refresh...';
    			} 
    		},
    		
    		onScrollMove: function () {

    			if (this.y > 5 && !pullDownEl.className.match('flip')) {
    				pullDownEl.className = 'flip';
    				pullDownEl.querySelector('.pullDownLabel').innerHTML = 'Release to refresh...';
    				this.minScrollY = 0;
    			} 

    			else if (this.y < 5 && pullDownEl.className.match('flip')) {
    				pullDownEl.className = '';
    				pullDownEl.querySelector('.pullDownLabel').innerHTML = 'Pull down to refresh...';
    				this.minScrollY = -pullDownOffset;
    			} 
    		},
    		
    		onScrollEnd: function () {
    			if (pullDownEl.className.match('flip')) {
    				pullDownEl.className = 'loading';
    				pullDownEl.querySelector('.pullDownLabel').innerHTML = 'Loading...';				
    				pullDownAction();	// Execute custom function (ajax call?)
    			} 
    		}
    	});
    }
  	//setTimeout(function () { document.getElementById('page').style.left = '0'; }, 0);
  }
  
  document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
  window.addEventListener('load', loadiScroll, false);
  window.addEventListener('resize', reloadiScroll, false);
  
})(jQuery);
