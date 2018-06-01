/*
 *	Name:		Official | HTML5 Theme
 *	Version:	1.0
 *	Authors:	ThemeTor 
 *	website:	http://Themetor.com
 *	Copyright (c) 2014-2015  ThemeTor
 *	All rights reserved
 */
jQuery(document).ready(function ($) {

	function mycarousel4_initCallback(e){e.buttonNext.hover(function(){e.stopAuto()},function(){e.startAuto()});e.buttonPrev.hover(function(){e.stopAuto()},function(){e.startAuto()});e.clip.hover(function(){e.stopAuto()},function(){e.startAuto()})};
	"use strict";
	jQuery.browser={};(function(){jQuery.browser.msie=false;
	jQuery.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)\./)){
	jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;}})();
	
	$('.sf-menu').find('.current-menu-item,.current-menu-parent,.current-menu-ancestor').addClass('selectedLava');
	
	// Superfish
	if ($(".sf-menu")[0]) {
		$('.sf-menu').superfish({
			delay: 100,
			animation: {
				opacity: 'show', height: 'show'
			},
			speed: 300
		}).lavaLamp({
			fx: "easeOutExpo", 
			speed: 600
		});
	}
	// ExtraInfo
	if ($(".extrabox")[0]) {
		(function($) {
			$.fn.clickToggle = function(func1, func2) {
				var funcs = [func1, func2];
				this.data('toggleclicked', 0);
				this.click(function() {
					var data = $(this).data();
					var tc = data.toggleclicked;
					$.proxy(funcs[tc], this)();
					data.toggleclicked = (tc + 1) % 2;
				});
				return this;
			};
		}(jQuery));

		var DropHeight = jQuery('.extrabox').height();
		jQuery('.extrabox').css("top","-"+DropHeight+"px");
		jQuery('.arrow-down').clickToggle(function() {
			var DropHeight = jQuery('.extrabox').height();
			jQuery(this).addClass('opened');
			jQuery('.extrabox').animate({'top': 0}, {duration: '800', easing: 'easeInOutExpo'});
			jQuery('.arrow-down i').removeClass('icon-angle-down').addClass('icon-angle-up');
			jQuery('.page-content, .sliderr, .headdown, .head, .breadcrumb, footer').animate({'opacity': 0.5}, {duration: '2000', easing: 'easeInOutExpo'});
		}, function() {
			var DropHeight = jQuery('.extrabox').height();
			jQuery(this).removeClass('opened');
			jQuery('.extrabox').animate({'top': -DropHeight}, {duration: '800', easing: 'easeInOutExpo'});
			jQuery('.arrow-down i').addClass('icon-angle-down').removeClass('icon-angle-up');
			jQuery('.page-content, .sliderr, .headdown, .head, .breadcrumb, footer').animate({'opacity': 1}, {duration: '2000', easing: 'easeInOutExpo'});
		});
	}
	
	
	
	// Tipsy
	$('.toptip').tipsy({fade: true,gravity: 's'});
	$('.bottomtip').tipsy({fade: true,gravity: 'n'});
	$('.righttip').tipsy({fade: true,gravity: 'w'});
	$('.lefttip').tipsy({fade: true,gravity: 'e'});
	$('#wrap_flickr img').tipsy({fade: true,gravity: 's'});
	
	// Blog Gallery Slider
	if ($(".projectslider")[0]) {
		jQuery('.projectslider').flexslider({
			animation: "fade",
			direction: "horizontal",
			slideshowSpeed: 8000,
			animationSpeed: 1000,
			directionNav: true,
			controlNav: false,
			pauseOnHover: true,
			initDelay: 0,
			randomize: false,
			smoothHeight: true,
			keyboardNav: false
		});
	}
		
		
	// Tabs
	var tabs = jQuery('ul.tabs');
	tabs.each(function (i) {
		// get tabs
		var tab = jQuery(this).find('> li > a');
		tab.click(function (e) {
			// get tab's location
			var contentLocation = jQuery(this).attr('href');
			// Let go if not a hashed one
			if (contentLocation.charAt(0) === "#") {
				e.preventDefault();
				// add class active
				tab.removeClass('active');
				jQuery(this).addClass('active');
				// show tab content & add active class
				jQuery(contentLocation).fadeIn(500).addClass('active').siblings().hide().removeClass('active');
			}
		});
	});
	
	
	// Accordion
	jQuery("ul.tt-accordion li").each(function () {
		if (jQuery(this).index() > 0) {
			jQuery(this).children(".accordion-content").css('display', 'none');
		} else {
			if ($(".faq")[0]) {
				jQuery(this).addClass('active').find(".accordion-head-sign").append("<i class='icon-ok-sign'></i>");
				jQuery(this).siblings("li").find(".accordion-head-sign").append("<i class='icon-question-sign'></i>");
			} else {
				jQuery(this).addClass('active').find(".accordion-head-sign").append("<i class='icon-minus-sign'></i>");
				jQuery(this).siblings("li").find(".accordion-head-sign").append("<i class='icon-plus-sign'></i>");
			}
		}
		jQuery(this).children(".accordion-head").bind("click", function () {
			jQuery(this).parent().addClass(function () {
				if (jQuery(this).hasClass("active")) {
					return;
				} {
					return "active";
				}
			});
			if ($(".faq")[0]) {
				jQuery(this).siblings(".accordion-content").slideDown();
				jQuery(this).parent().find(".accordion-head-sign i").addClass("icon-ok-sign").removeClass("icon-question-sign");
				jQuery(this).parent().siblings("li").children(".accordion-content").slideUp();
				jQuery(this).parent().siblings("li").removeClass("active");
				jQuery(this).parent().siblings("li").find(".accordion-head-sign i").removeClass("icon-ok-sign").addClass("icon-question-sign");
			} else {
				jQuery(this).siblings(".accordion-content").slideDown();
				jQuery(this).parent().find(".accordion-head-sign i").addClass("icon-minus-sign").removeClass("icon-plus-sign");
				jQuery(this).parent().siblings("li").children(".accordion-content").slideUp();
				jQuery(this).parent().siblings("li").removeClass("active");
				jQuery(this).parent().siblings("li").find(".accordion-head-sign i").removeClass("icon-minus-sign").addClass("icon-plus-sign");
			}
		});
	});
	
	
	// Toggle
	jQuery("ul.tt-toggle li").each(function () {
		jQuery(this).children(".toggle-content:not(.open)").css('display', 'none');
		jQuery(this).find(".toggle-head-sign:not(.open)").html("&#43;");
		jQuery(this).children(".toggle-head").bind("click", function () {
			if (jQuery(this).parent().hasClass("active")) {
				jQuery(this).parent().removeClass("active");
			} else {
				jQuery(this).parent().addClass("active");
			}
			jQuery(this).find(".toggle-head-sign").html(function () {
				if (jQuery(this).parent().parent().hasClass("active")) {
					return "&minus;";
				} else {
					return "&#43;";
				}
			});
			jQuery(this).siblings(".toggle-content").slideToggle();
		});
	});
	
	
	jQuery("ul.tt-toggle").find(".toggle-content.active").siblings(".toggle-head").trigger('click');
	
	
	// 4Mob
	if ($("body.isrtl")[0]) {
		$("#header .sf-menu a.sf-with-ul").before('<div class="subarrow"><i class="icon-angle-left"></i></div>');
		}else{
		$(".sf-menu a.sf-with-ul").before('<div class="subarrow"><i class="icon-angle-right"></i></div>');	
		}
	$('.subarrow').click(function () {
		$(this).parent().toggleClass("xpopdrop");
	});
	$('#mobilepro').click(function () {
		$('#header .sf-menu').slideToggle('slow', 'easeInOutExpo').toggleClass("xactive");
		$("#mobilepro i").toggleClass("icon-reorder");
	});
	$("body").click(function() {
		$('#header .xactive').slideUp('slow', 'easeInOutExpo').removeClass("xactive");
		$("#mobilepro i").addClass("icon-reorder");
	});
	$('#mobilepro, .sf-menu').click(function(e) {
		e.stopPropagation();
	});
	function checkWindowSize() {
		if ($(window).width() >= 760) {
			$('#header .sf-menu').css('display', 'block').removeClass("xactive");
		} else {
			$('#header .sf-menu').css('display', 'none');
		}
	}
	$(window).load(checkWindowSize);
	$(window).resize(checkWindowSize);
	// ToTop
	jQuery('#toTop').click(function () {
		jQuery('body,html').animate({
			scrollTop: 0
		}, 1000);
	});
	jQuery("#toTop").addClass("hidett");
	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() < 400) {
			jQuery("#toTop").addClass("hidett").removeClass("showtt");
		} else {
			jQuery("#toTop").removeClass("hidett").addClass("showtt");
		}
	});
	// Notification
	$(".notification-close").click(function () {
		$(this).parent().slideUp("slow");
		return false;
	});
	

	// quicksand
	if ($(".filter")[0]) {
		var $portfolioClone = $(".portfolio").clone();
		$(".filter a").click(function (e) {
			$(".filter li").removeClass("current");
			var $filterClass = $(this).parent().attr("class");
			if ($filterClass == "all") {
				var $filteredPortfolio = $portfolioClone.find("li");
			} else {
				var $filteredPortfolio = $portfolioClone.find("li[data-type~=" + $filterClass + "]");
			}
				
			// Call quicksand
			$(".portfolio").quicksand($filteredPortfolio, {
				duration: 800,
				useScaling: 'true',
				easing: 'easeInOutCubic',
				adjustHeight: 'dynamic'
			}, function () {
				_lightbox();
				_hoverFX();
				_portfolioHeight();
				if ($(".portfolio.msnry")[0]) {
						var msnry = $(".portfolio.msnry");
						_msnry(msnry);
					}
			});
			$(this).parent().addClass("current");
			e.preventDefault();
		});

	}
	
	
	// T20 Custom
	var isDesktop = (function() {
		return !('ontouchstart' in window) // works on most browsers 
		|| !('onmsgesturechange' in window); // works on ie10
	})();
	window.isDesktop = isDesktop;
	if( isDesktop ){
		if ($(".animated")[0]) {
			jQuery('.animated').css('opacity', '0');
		}
		jQuery('.animt').each(function () {
			var $curr = jQuery(this);
			var $currOffset = $curr.attr('data-gen-offset');
			if ($currOffset === '' || $currOffset === 'undefined' || $currOffset === undefined) {
				$currOffset = 'bottom-in-view';
			}
			$curr.waypoint(function () {
				$curr.trigger('animt');
			}, {
				triggerOnce: true,
				offset: $currOffset
			});
		});
		jQuery('.animated').each(function () {
			var $curr = jQuery(this);
			$curr.bind('animt', function () {
				$curr.css('opacity', '');
				$curr.addClass($curr.data('gen'));
			});
		});
		jQuery('.animated').each(function () {
			var $curr = jQuery(this);
			var $currOffset = $curr.attr('data-gen-offset');
			if ($currOffset === '' || $currOffset === 'undefined' || $currOffset === undefined) {
				$currOffset = 'bottom-in-view';
			}
			$curr.waypoint(function () {
				$curr.trigger('animt');
			}, {
				triggerOnce: true,
				offset: $currOffset
			});
		});
	}
	// Progress Load
	if ($(".progress-bar > span")[0]) {
		$('.progress-bar > span').waypoint(function() {
			$(this).each(function() {
				$(this).animate({
					width: $(this).attr('rel') + "%"
				}, 800);
			});
		}, {
			triggerOnce: true,
			offset: 'bottom-in-view'
		});
	}
	
	
	if( isDesktop ){
		$.stellar({
			horizontalScrolling: false,
			verticalOffset: 0
		});
	}
	
	
	
	// Sticky
	if ($(".my_sticky")[0]){
		$('.my_sticky').before('<div class="Corpse_Sticky"></div>');
		var isAdmin = $('#wpadminbar').height();
		$(window).scroll(function(){
			var offset = $(window).scrollTop();
			var window_width = $(window).width();
			var head_w = $('.my_sticky').height();
			if (window_width >= 959) {
				if(offset < 200){
					if($('.my_sticky').data('sticky') === true){
						$('.my_sticky').data('sticky', false);
						$('.my_sticky').stop(true).animate({opacity : 0}, 300, function(){
							$('.my_sticky').removeClass('sticky').css('padding-top','');
							$('.my_sticky').stop(true).animate({opacity : 1}, 300);
							$('.Corpse_Sticky').css('padding-top', '');
						});
					}
				} else {
					if($('.my_sticky').data('sticky') === false || typeof $('.my_sticky').data('sticky') === 'undefined'){
						$('.my_sticky').data('sticky', true);
						$('.my_sticky').stop(true).animate({opacity : 0},300,function(){
							$('.my_sticky').addClass('sticky').css('padding-top', isAdmin + 'px');
							$('.my_sticky.sticky').stop(true).animate({opacity : 1}, 300);
							$('.Corpse_Sticky').css('padding-top', head_w + 'px');
						});
					}
				}
			}
		});
		
		$(window).resize(function(){
			var window_width = $(window).width();
			if (window_width <= 959) {
				if($('.my_sticky').hasClass('sticky')){
					$('.my_sticky').removeClass('sticky');
					$('.my_sticky').stop(true).animate({opacity : 0}, 300, function(){
						$('.my_sticky').removeClass('sticky');
						$('.my_sticky').stop(true).animate({opacity : 1}, 300);
						$('.Corpse_Sticky').css('padding-top', '');
					});
				}
			}
		});
	}

	//Set Portfolio Height
	try {
		$('ul.portfolio').each(function(){
			var pr = $(this);
			pr.imagesLoaded( function(){

			var mh = 0 ;
			pr.find('li').each(function(){
				var h = jQuery(this).height();
				if (h>=mh){mh=h;}
			});
			pr.not('.msnry').find('li').height(mh);
			});	
        });

	} catch(e){}
	
	
	//Hide empty categories in Portfolio Filtering
	try {
		
		$('ul.filter li').hide();	
		$('ul.filter li.all').show();
		
		$('ul.portfolio li').each(function(){
		  var dt = $(this).attr('data-type');
	
		  $.each(dt.split(" ").slice(0,-1), function(i, j) {
			$('ul.filter li.'+j).show();
		  });
		  
		});
	} catch(e){}
	
	
	//Set shop items Height
	try {
		
		$('ul.products').each(function(){
			var pr = $(this);
			pr.imagesLoaded( function(){
				var mh = 0 ;
				pr.find('li.product').each(function(){
					var h = $(this).height();
					if (h>=mh){mh=h;}
				});
				
				pr.find('li.product').height(mh);
				
			});
		});
	} catch(e){}

	//Set shop items Height
	try {
		$('.owl-carousel').each(function(){
			var owl = $(this);
			owl.imagesLoaded( function(){
				var mh = 0 ;
				owl.find('.uowl').each(function(){;
					var h = $(this).height();
					if (h>=mh){mh=h;}
				});
				owl.find('.uowl').height(mh-5);
			});
		});
	} catch(e){}

	//Set Min-Height for Tour Tabs
	try {
		var th = jQuery('.tt_tour .tt_tabs_nav').height();
		th++;
		jQuery('.tt_tour .tt_tab').each(function(){
			jQuery(this).css('min-height',th);
		});
	} catch(e){}
	

	 _hoverFX();
	
});


function _hoverFX(){
	jQuery('.hover-fx').each(function() {
		var u = jQuery(this);
		u.hover(
			function() {
				var w = u.width();
				var h = u.height();
				u.children('.fLeft').css('top', (h/2-20) + 'px').css('left',(w/2-37) + 'px');
				u.children('.fLeft.cntr').css('left',(w/2-20) + 'px');
				u.children('.fRight').css('bottom', (h/2-20) + 'px').css('left',(w/2-3) +'px');
			}, function() {
				u.children('.fLeft').css('top','').css('left','');
				u.children('.fRight').css('bottom','').css('left','');
			}
		);
    });
	
}

function _portfolioHeight(){
	jQuery('ul.portfolio').each(function(){
		var pr = jQuery(this);
		var mh = 0 ;
		pr.find('li').each(function(){
			var h = jQuery(this).height();
			if (h>=mh){mh=h;}
		});
		pr.not('.msnry').find('li').height(mh);
	});
}
	
/* jPlayer */
function js_audioPlayer(l,f) {
	jQuery("#"+l).jPlayer({
		ready: function () {
			jQuery(this).jPlayer("setMedia", {
				mp3:f
			});
		},
		swfPath: "js",
		supplied: "mp3",
		wmode: "window",
		smoothPlayBar: true,
		cssSelectorAncestor:"#int"+l,
		keyEnabled: true
	});
return;
}

	
/* Ajax */		
jQuery(function($){
    
    if (!$(".ajax-loader")[0]) {
        var str = '<img class="ajax-loader hide" src="images/ajax-loader.gif" alt="Sending ..." /><div class="message hide"></div>';
        if ($("#contactform")[0]) {$('#contactform').append(str);}
        if ($("#quickcontact")[0]) {$('#quickcontact').append(str);}
        if ($("#faqform")[0]) {$('#faqform').append(str);}
        if ($("#freeform")[0]) {$('#freeform').append(str);}
        
        }
    
    // Ajax Contact Form in contact.html and contact2.html
    $('#contactform').submit(function(){
        var action = $(this).attr('action');
        $('#contactform #submit').attr('disabled','disabled');
        $('#contactform .ajax-loader').show();
        
            $.post(action, {
                yourname: $('#contactform #your-name').val(),
                youremail: $('#contactform #your-email').val(),
                yoursubject: $('#contactform #your-subject').val(),
                yourmessage: $('#contactform #your-message').val()
            },
            function(data){
                $('#contactform .message').html(data).show();
                $('#contactform .ajax-loader').fadeOut(300);
                $('#contactform #submit').removeAttr('disabled');
                if(data.match('success') != null) {$('#contactform').trigger("reset").find('p').slideUp();};
            });
            
        return false;
    });
    
    
    

    
});
	

