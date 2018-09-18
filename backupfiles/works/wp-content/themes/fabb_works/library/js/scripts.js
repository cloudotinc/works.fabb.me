/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


// document.domain = "otocoto.jp";

/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *	// update the viewport, in case the window size has changed
 *	viewport = updateViewportDimensions();
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
*/
function loadGravatars() {
  // set the viewport using the function above
  viewport = updateViewportDimensions();
  // if the viewport is tablet or larger, we load in the gravatars
  if (viewport.width >= 768) {
  jQuery('.comment img[data-gravatar]').each(function(){
    jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
  });
	}
} // end function


/*
 * Put all your regular jQuery in here.
*/

/**
 * detect IE
 * returns version of IE or false, if browser is not Internet Explorer
 */
function detectIE() {
    var ua = window.navigator.userAgent;
	// console.log(ua);
    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    // var edge = ua.indexOf('Edge/');
    // if (edge > 0) {
    //     // Edge (IE 12+) => return version number
    //     return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    // }

    // other browser
    return false;
}


// var md = new MobileDetect(window.navigator.userAgent);


function getRootUrl() {
    return window.location.origin?window.location.origin+'/':window.location.protocol+'/'+window.location.host+'/';
}

// Get Query Strings
$.extend({
    getUrlVars: function(){
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    },
    getUrlVar: function(name){
        return $.getUrlVars()[name];
    }
});


/* ページ判定 */
function checkSinglePost() {
	if ($("body").hasClass("single-post")) {
		return true;
	}
	return false;
}
function checkSingleEschannel() {
    if ($("body").hasClass("single-eschannel")) {
        return true;
    }
    return false;
}
function checkSingle() {
    if ($("body").hasClass("single")) {
        return true;
    }
    return false;
}


function isOneColumn() {
    // isMobileWidth()はここではチェックしないため
    // スマートフォン時もtrueになる
	if ($('#main').width() >= $('#inner-content').width()*0.8) {
		return true;
	}
	else {
		return false;
	}
}

function isMobileWidth() {
	if ($('#header').height() < 50) {
		return true;
	}
	else {
		return false;
	}
}

// 481 - 768
function isMobileWidthLarge() {
	if (isMobileWidth() && window.innerWidth > 480) {
		return true;
	}
	else {
		return false;
	}
}

function setContentHeight() {

	var $main = $('#main');
	var $side = $('#sidebar');

	if (!isOneColumn()) {
		$side.height('auto');
		$main.height('auto');

		var mainHeight = $main.height();
		var sideHieght = $side.height();

		if (mainHeight >= sideHieght) {
			$side.height(mainHeight);
		}
		else {
			$main.height(sideHieght);
		}
	}
	else {
		$side.height('auto');
		$main.height('auto');
	}
}


function setFooterPos() {
	var $footer = $(".footer");
	var footerHeight = $footer.outerHeight();
	if (!$footer.hasClass("force_bottom")) footerHeight = 0;
	$('#container').css("minHeight","auto");
	//console.log($("html").height());
	//console.log(footerHeight);
	if ($(window).height() > ($("html").outerHeight() + footerHeight)) {
	    var minHeight = $(window).height();
        if (isMobileWidth()) minHeight = minHeight - $('#header').height();

		$('#container').css("minHeight",minHeight);
		$footer.addClass("force_bottom");
	}
	else {
        $('#container').css("minHeight","auto");
		$footer.removeClass("force_bottom");
	}
}




var headerHeight;
var $header;



function animateScroll(selector, speed, delta) {
    if(typeof delta === 'undefined') delta = 0;

    var target = $(selector);
    var position = target.offset().top - delta;

    var page = $("html, body");
    page.on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function(){
        page.stop();
    });

    page.animate({ scrollTop: position }, speed, "easeOutQuart", function(){
        page.off("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove");
    });
}


function showFixedNav() {
    $('#header-fixed').addClass('show');
}

function hideFixedNav() {
    $('#header-fixed').removeClass('show');
}

function checkFixedNavToShow() {
    if (!isMobileWidth() && $(window).scrollTop() > headerHeight) {
        showFixedNav();
    }
    else {
        hideFixedNav();
    }
}



var wwidth = 0;

jQuery(document).ready(function($) {

  /*
   * Let's fire off the gravatar function
   * You can remove this if you don't need it
  */
  // loadGravatars();

    // if (detectIE() != false) {
    //     var yu_array = ["游ゴシック", "Yu Gothic", "游ゴシック体", "YuGothic"];
    //     var fontused = $(".menu-interview .menu-text").detectFont();
    //     // console.log("usedfont:" + fontused);
    //     if (yu_array.indexOf(fontused) !== -1) {
    //         $("body").addClass("ie-yu");
    //     }
    // }

    // $('.postlist .postimage').imgLiquid();
    $('.liquidimg').imgLiquid();


    var parser = document.createElement('a');
    var imgurl = $('#logo img').attr('src');
    parser.href = imgurl;
    var imgpath = parser.protocol + "//" + parser.hostname + '/wp-content/themes/fabb_works/library/images/';

    //$('.header_info .cover_title_text').kerning();

	wwidth = $(window).width();

	// side menu
	var pos = 0;
	var fixedPosArray = new Array();
	var fixedElmArray = new Array();

	var isAdminbar = false;
	if ($('body').hasClass('admin-bar')) {
		isAdminbar = true;
	}

	$('.content_fixed').each(function() {
		var cssPos = parseInt($(this).css('top'), 10);
		if (isAdminbar) {
			cssPos += $('#wpadminbar').height();
			$(this).css('top',cssPos + 'px');
		}
		fixedPosArray.push(cssPos);
		fixedElmArray.push($(this));
	});


    // var snsCode = (function() {/*
    //  <ul class="snslinks cf">
    //  <li class="snslink_item snsbtn_fb">
    //  <a href="https://www.facebook.com/jibunchukai/" target="_blank">
    //  <span class="icon icon-facebook"></span>
    //  </a>
    //  </li>
    //  <li class="snslink_item snsbtn_tw">
    //  <a href="https://twitter.com/jibunchukai" target="_blank">
    //  <span class="icon icon-twitter"></span>
    //  </a>
    //  </li>
    //  <li class="snslink_item snsbtn_rss">
    //  <a href="http://www.jibun-chukai.jp/journal/feed/" target="_blank">
    //  <span class="icon icon-rss"></span>
    //  </a>
    //  </li>
    //  </ul>
    //  */}).toString().match(/\/\*([^]*)\*\//)[1];

	var logofile = "logo.svg";
	var homeurl = getRootUrl();


	jQuery("#sidemenu").mmenu({
		panelNodetype: "ul, ol",
		offCanvas: {
			position  : "left",
			zposition : "front"
		},
        navbar: {
            title: '<img class="logo" src="' + imgpath + logofile + '" />'
        },
        navbars: [
            {
                content: '<a class="closemenu" href="">CLOSE</a>',
                position: 'bottom'
            }
        ]
	});

    // デフォルトではclickイベントのため手動で開く
    var mmAPI = $("#sidemenu").data( "mmenu" );
    var openEvt = 'click';
    if (Modernizr.touch) {
        openEvt = 'touchstart';
    }
    $(".togglebutton").on(openEvt, function (e) {
        e.preventDefault();
        e.stopPropagation();

        mmAPI.open();
    });
    $('.closemenu').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        mmAPI.close();
    });
    $('#sidemenu .logo').click(function() {
        window.location.href = homeurl;
    });


	$(".postlist-item").biggerlink({otherstriggermaster:false});
	$(".std_biggerlink").biggerlink({otherstriggermaster:false});


	// 読み込み完了できなかったときのガード処理
	setTimeout(function() {
		$('#loading').fadeOut(1200, function() {
			//$(this).remove(); //webfontでエラーになるため削除
		});
	}, 1000);

	imagesLoaded( document.querySelector('#container'), function( instance ) {
		$('#loading').fadeOut(1200, function () {
			//$(this).remove();
		});
	});



	jQuery('.pgscrl').click(function(){
		var speed = 800;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		//$("html, body").animate({scrollTop:position}, speed, "easeOutExpo");

		var page = $("html, body");
		page.on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function(){
			page.stop();
		});

		page.animate({ scrollTop: position }, speed, "easeOutQuart", function(){
			page.off("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove");
		});

		return false;
	});




    // scroll event
    $header = $("#header");
    headerHeight = $header.outerHeight();

    $(window).scroll(function(event) {
        waitForFinalEvent(function () {

            if (isMobileWidth()) {
            }
            else {
                checkFixedNavToShow();
            }

        }, timeToWaitForLast, "scroll_event");
    });



	jQuery("#headermenu .menulist > li").hover(function(){
			jQuery("ul:not(:animated)",this).slideDown(600, "easeOutQuart");
		},
		function(){
			jQuery("ul", this).slideUp(600, "easeOutQuart");
		});



    /* searchbutton */
    $(document).on("click", ".searchbutton", function(e) {
        if (isMobileWidth()) {
            e.preventDefault();
            if($(this).hasClass('open')) {
                $('.header-search-mobile').removeClass('open');
                $(this).removeClass('open');
            }
            else {
                $('.header-search-mobile').addClass('open');
                $(this).addClass('open');
            }

            return false;
        }
    });


	$(document).on("click",'.snsbtn_item a', function(event) {
		var w  = 575;
		var h = 400;
		var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

		var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
		var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

		var left = ((width / 2) - (w / 2)) + dualScreenLeft;
		var top = ((height / 2) - (h / 2)) + dualScreenTop;
		var url    = this.href;

		var opts   = 'status=1' +
			',width='  + w  +
			',height=' + h +
			',top='    + top +
			',left='   + left;

		window.open(url, 'Share', opts);

		return false;
	});

}); /* end of as page load scripts */



jQuery(window).load(function() {

	var mobileMode = isMobileWidth();

	jQuery(window).resize(function() {
		// setFooterPos();
        headerHeight = $header.outerHeight();
		var currentMobileMode = isMobileWidth();
		if (mobileMode != currentMobileMode) {

            if (!mobileMode) {
                checkFixedNavToShow();
            }
            else {
                hideFixedNav();
            }
			mobileMode = currentMobileMode;
		}
		else {

		}

	});
});