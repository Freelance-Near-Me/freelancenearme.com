/*********************************************************************************

	Template Name: Reyes Bootstrap4 Template
	Version: 1.0


**********************************************************************************/

/**************************************************************
	
	MAIN JS INDEXING
	=======================
	
		01. Wow Active 
		02. Radial Progress
		03. Countdown
		04. Team
		05. Testimonial Activation 
		06. Testimonial Carousel Style		
		07. LightBox		
		08. Header Search Style
		09. Search Toggler 02
		10. MagnificPopup Video Popup
		11. Instagram Img Slide
		12. Toggle Ativation
		13. Blog Post Activation
		14. Counter Up
		15. Post Slider Activation
		16. Post Grid Tab
		17. Gallery Mesonry Activation
		18. Thumb Gallery Activation
		19. Twitter Activation
		20. Comtom Carousel  Activation
		21. Testimonial Slider Activation
		22. Post Carousel Activation
		23. Image Justify Activation
		24. Data Table
		25. Slider Height
		26. Cleaning Service Activation
		27. Slider Activation
		28. Mainmenu Activation
		29. Panel Slide Active
		30. Agency Activation
		31. Gallery Mesonry Activation
		32. Brand Activation
		33. Scroll Up Activation
	
	__ END MAIN JS INDEXING

***************************************************************/


(function ($) {
	'use strict';


	// Code Goes Here


	/*======================= 
		01. Wow Active 
	======================*/

	new WOW().init();



	/*============================== 
		02. Radial Progress
	===============================*/

	$('.radial-progress').waypoint(function () {
		$('.radial-progress').easyPieChart({
			lineWidth: 10,
			trackColor: false,
			scaleLength: 0,
			rotate: -45,
			barColor: '#1cb9da',
			trackColor: '#dcd9d9',
			lineCap: 'square',
			size: 130
		});

	}, {
		triggerOnce: true,
		offset: 'bottom-in-view'
	});



	/* Radial Progress 02 */
	$('.radial-progress-2').waypoint(function () {
		$('.radial-progress-2').easyPieChart({
			lineWidth: 10,
			trackColor: false,
			scaleLength: 0,
			rotate: -45,
			barColor: '#f10',
			trackColor: false,
			lineCap: 'square',
			size: 130
		});

	}, {
		triggerOnce: true,
		offset: 'bottom-in-view'
	});


	/* Radial Progress 03 */
	$('.radial-progress-3').waypoint(function () {
		$('.radial-progress-3').easyPieChart({
			lineWidth: 35,
			trackColor: false,
			scaleLength: 0,
			rotate: 0,
			barColor: '#f10',
			trackColor: false,
			lineCap: 'square',
			size: 150


		});

	}, {
		triggerOnce: true,
		offset: 'bottom-in-view'
	});

	$('.radial-progress-charity').waypoint(function () {
		$('.radial-progress-charity').easyPieChart({
			lineWidth: 5,
			trackColor: false,
			scaleLength: 0,
			rotate: -45,
			barColor: '#1cb9da',
			trackColor: '#dcd9d9',
			lineCap: 'square',
			size: 70
		});

	}, {
		triggerOnce: true,
		offset: 'bottom-in-view'
	});



	/*============================== 
		03. Countdown
	===============================*/


	$('[data-countdown]').each(function () {
		var $this = $(this),
			finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function (event) {
			$this.html(event.strftime('<span class="ht-count days"><span class="count-inner"><span class="time-count">%-D</span> <p>Days</p></span></span> <span class="ht-count hour"><span class="count-inner"><span class="time-count">%-H</span> <p>Hours</p></span></span> <span class="ht-count minutes"><span class="count-inner"><span class="time-count">%M</span> <p>Minutes</p></span></span> <span class="ht-count second"><span class="count-inner"><span class="time-count">%S</span> <p>Seconds</p></span></span>'));
		});
	});


	/*============================== 
		04. Team
	===============================*/

	var teamPlus = $('.plus_click');
	teamPlus.on('click', function (e) {
		e.preventDefault();
		$(this).parent('.team-click-action').toggleClass('visible');

		$(this).toggleClass('team-minus');
	});




	/*============================== ====
		05. Testimonial Activation 
	=====================================*/

	/* Testimonial Slider Active 1 */
	$('.testimonial-activation').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		centerMode: true,
		centerPadding: '0',
	});

	/* Testimonial Slider Active 2 */
	$('.testimonial-activation-2').slick({
		dots: true,
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		arrows: false,
		autoplay: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		responsive: [{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});


	/* testimonial activation 3 */

	$('.testimonial-activation-4').slick({
		slidesToShow: 1,
		autoplay: false,
		autoplaySpeed: 5000,
		arrows: false,
		easing: 'ease-in-out',
		dots: true,
		dotsClass: 'testi-pagination-dots',
		appendDots: $('.testimonial-pagination')
	});


	/* testimonial activation 4 */

	$('.testimonial-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '.testimonal-nav'
	});

	$('.testimonal-nav').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.testimonial-for',
		dots: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		arrows: false,

		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 769,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 575,
				settings: {
					slidesToShow: 1
				}
			}
		]

	});

	/* Testimonial Slider Active 5 */

	$('.testimonial-activation-6').slick({
		slidesToShow: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		easing: 'ease-in-out',
		dots: false,
		arrows: true,
		prevArrow: '<button class="testimonial-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="fa fa-angle-right"></i></button>',
	});


	/* Testimonial Slider Active 6 */

	$('.testimonial-activation-7').slick({
		slidesToShow: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		easing: 'ease-in-out',
		dots: false,
		arrows: true,
		prevArrow: '<button class="testimonial-arrow-prev"><i class="ion ion-md-arrow-back"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="ion ion-md-arrow-forward"></i></button>',
	});


	/* Testimonial Slider Active 7 */

	$('.testimonial-activation-8').slick({
		slidesToShow: 1,
		autoplay: false,
		autoplaySpeed: 5000,
		easing: 'ease-in-out',
		dots: false,
		arrows: true,
		prevArrow: '<button class="testimonial-arrow-prev"><i class="ion ion-md-arrow-back"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="ion ion-md-arrow-forward"></i></button>',
	});


	/*==================================
		06. Testimonial Carousel Style
	=====================================*/

	/* Testimonial Carousel 1*/

	$('.testimonial-carousel-1').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		prevArrow: '<button class="testimonial-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="fa fa-angle-right"></i></button>',
		autoplay: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',

		responsive: [{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});

	/*Testimonial Carousel 2*/

	$('.testimonial-carousel-2').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		prevArrow: '<button class="testimonial-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="fa fa-angle-right"></i></button>',
		autoplay: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',

		responsive: [{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});

	/* Testimonial Carousel 3*/

	$('.testimonial-carousel-3').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 2,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
		autoplay: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',

		responsive: [{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});



	/* Testimonial Carousel 4*/

	$('.testimonial-carousel-4').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		arrows: false,
		autoplay: true,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		responsive: [{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});


	/* Testimonial Carousel 5*/

	$('.testimonial-carousel-5').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		prevArrow: '<button class="testimonial-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="fa fa-angle-right"></i></button>',
		autoplay: false,

		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		responsive: [{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});




	/*==================================
		07. LightBox
	=====================================*/

	$('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
		},

		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			/*titleSrc: function(item) {
				return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
			  }*/
		},

		callbacks: {
			elementParse: function (item) {
				// the class name
				if (item.el[0].className == 'play__btn') {
					item.type = 'iframe';
				} else {
					item.type = 'image';
				}
			}
		},


	});

	$('.image-popup-vertical-fit').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-img-mobile',
		image: {
			verticalFit: true
		}

	});


	/*==================================
		08. Header Search Style
	=====================================*/

	$('.search-button').click(function () {
		$(this).parent().toggleClass('open');
	});



	/*==================================
		09. Search Toggler 02
	===================================*/

	function searchToggler() {
		var trigger = $('.search-trigger'),
			container = $('.search_active');


		trigger.on('click', function (e) {
			e.preventDefault();
			container.toggleClass('is-visible');
		});

		$('.close__wrap').on('click', function () {
			container.removeClass('is-visible');
		});

	}
	searchToggler();



	/*==================================
		10. MagnificPopup Video Popup 
	===================================*/

	$('.magnify-video-active').magnificPopup({
		type: 'iframe'
	});



	/*==================================
		11. Instagram Img Slide
	===================================*/

	$('.instagram-activation').slick({
		dots: false,
		arrows: true,
		prevArrow: '<button class="instagram-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="instagram-next"><i class="fa fa-angle-right"></i></button>',
		speed: 500,
		slidesToShow: 8,
		slidesToScroll: 1,
		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 5,
				}
			},

			{
				breakpoint: 481,
				settings: {
					slidesToShow: 3,
				}
			},

			{
				breakpoint: 577,
				settings: {
					slidesToShow: 4,
				}
			},

		]
	});


	/*==================================
		12. Toggle Ativation
	===================================*/

	function itemToggler() {
		$(".toggle-item-active").slice(0, 8).show();
		$(".item-wrapper").find(".loadMore").on('click', function (e) {
			e.preventDefault();
			$(this).parents(".item-wrapper").find(".toggle-item-active:hidden").slice(0, 4).slideDown();
			if ($(".toggle-item-active:hidden").length == 0) {
				$(this).parent('.toggle-btn').fadeOut('slow');
			}
		});
	}
	itemToggler();


	function textToggler() {
		$('.single-text-toggle').slice(0, 1).show();
		$(".text-wrapper").find(".loadMore").on('click', function (e) {
			e.preventDefault();
			$(this).parents(".text-wrapper").find(".single-text-toggle:hidden").slice(0, 1).slideDown();
			if ($(".single-text-toggle:hidden").length == 0) {
				$(this).parent('.toggle-btn').fadeOut('slow');
			}
		});
	}
	textToggler();



	function serviceToggler() {
		$('.single-service-toggle').slice(0, 7).show();
		$(".service-toggle").find(".loadMore").on('click', function (e) {
			e.preventDefault();

			$(this).parents(".service-toggle").find(".single-service-toggle:hidden").slice(0, 2).slideDown();
			if ($(".single-service-toggle:hidden").length == 0) {
				$(this).parent('.toggle-btn').fadeOut('slow');
			}
		});
	}
	serviceToggler();


	/*==================================
		13. Blog Post Activation
	===================================*/

	$('.post_activation').slick({
		slidesToShow: 1,
		autoplay: false,
		autoplaySpeed: 5000,
		easing: 'ease-in-out',
		dots: false,
		arrows: true,
		prevArrow: '<button class="post-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="post-arrow-next"><i class="fa fa-angle-right"></i></button>',
	});



	/*==================================
		14. Counter Up
	===================================*/

	$('.count').counterUp({
		delay: 10,
		time: 1000
	});

	/*==================================
		15. Post Slider Activation
	===================================*/

	$('.new-slider-active').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: false,
		autoplaySpeed: 5000,
		arrows: false,
		dots: true,
		infinite: false,
		focusOnSelect: true,
		centerMode: true,
		centerPadding: 0,
		adaptiveHeight: true,
		speed: 500,
		fade: true,
		cssEase: 'linear'
	});


	function postMenu() {
		$('.new-slider-active ul.slick-dots li').empty();
		var titleArr = [];

		$('.new-slider-trigger li').each(function (index) {
			var titlelist = $(this).html();
			titleArr.push(titlelist);
		});

		$('.new-slider-active ul.slick-dots li').each(function (index) {
			$(this).html(titleArr[index]);
		});

		$('.new-slider-trigger').empty();
	}
	postMenu();


	$('.post-slide-active').slick({
		slidesToShow: 1,
		autoplay: false,
		autoplaySpeed: 5000,
		easing: 'ease-in-out',
		dots: false,
		arrows: true,
		prevArrow: '<button class="postslide-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="postslide-next"><i class="fa fa-angle-right"></i></button>',
	});


	/*==================================
		16. Post Grid Tab
	===================================*/

	function slideToggler() {
		$('.post-grid').each(function () {
			$(this).on('click', function (e) {
				e.preventDefault();

				$(this).next('.post-content').slideToggle().siblings('.post-content').slideUp();
				$(this).next('.post-content').toggleClass('is-visible').siblings('.post-content').removeClass('is-visible');
			});
		});

		$('.close__wrap').on('click', function () {
			$(this).parent('.post-content').slideUp();
			$(this).parent('.post-content').removeClass('is-visible');
		});
	}
	slideToggler();


	/*==================================
		17. Gallery Mesonry Activation
	===================================*/

	$('.masonry-activation').imagesLoaded(function () {
		// init Isotope
		var $grid = $('.masonry-wrap').isotope({
			itemSelector: '.masonary-item',
			percentPosition: true,
			transitionDuration: '0.7s',
			masonry: {
				// use outer width of grid-sizer for columnWidth
				columnWidth: '.masonary-item',
			}
		});


	});



	/*======================================
		18. Thumb Gallery Activation
	=======================================*/

	$('.thumb-gallery-active').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		fade: true,
		infinite: true,
		focusOnSelect: true,
		centerMode: true,
		centerPadding: '0',
		adaptiveHeight: true,
		prevArrow: '<button class="thumb-gallery-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="thumb-gallery-next"><i class="fa fa-angle-right"></i></button>',
		asNavFor: '.thumb-gallery-nav',
	});


	$('.thumb-gallery-nav').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.thumb-gallery-active',
		dots: false,
		centerMode: true,
		centerPadding: '0',
		infinite: true,
		focusOnSelect: true,
		vertical: true,
		arrows: false,
		draggable: true,
		verticalSwiping: true,

		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 2,
				vertical: false,
				verticalSwiping: false,
			}
		}
	]

	});


	/* Thumb Gallery 2 */

	$('.thumb-gallery-active-2').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		fade: true,
		infinite: true,
		focusOnSelect: true,
		centerMode: true,
		centerPadding: '0',
		adaptiveHeight: true,
		prevArrow: '<button class="thumb-gallery-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="thumb-gallery-next"><i class="fa fa-angle-right"></i></button>',
		asNavFor: '.thumb-gallery-nav-2',
	});

	$('.thumb-gallery-nav-2').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		asNavFor: '.thumb-gallery-active-2',
		dots: false,
		centerMode: true,
		centerPadding: '0',
		infinite: true,
		focusOnSelect: true,
		arrows: false,
		draggable: true,
		verticalSwiping: true,




	});


	/*======================================
		19. Twitter Activation
	=======================================*/

	/* Twitter Style 1 */

	$('.twitter-activation-1').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		prevArrow: '<button class="twitter-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="twitter-arrow-next"><i class="fa fa-angle-right"></i></button>',
		autoplay: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		responsive: [{
				breakpoint: 993,
				settings: {
					slidesToShow: 2,
				}
			},

			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 577,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});

	/* Twitter Style 2 */

	$('.twitter-activation-2').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 2,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		prevArrow: '<button class="twitter-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="twitter-arrow-next"><i class="fa fa-angle-right"></i></button>',
		autoplay: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 577,
				settings: {
					slidesToShow: 1
				}
			}
		]

	});

	/* Twitter Style 3 */

	$('.twitter-activation-3').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
		autoplay: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 577,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});

	/* Twitter Style 4 */

	$('.twitter-activation-4').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		autoplay: false,
		prevArrow: '<button class="twitter-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="twitter-arrow-next"><i class="fa fa-angle-right"></i></button>',
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 577,
				settings: {
					slidesToShow: 1
				}
			}
		]

	});



	/*======================================
		20. Comtom Carousel  Activation
	=======================================*/

	/* Comtom Carousel 1*/

	var screenshotCenterActive = $('.custom-carousel-active');
	screenshotCenterActive.slick({
		arrows: false,
		autoplay: false,
		dots: true,
		autoplaySpeed: 800,
		infinite: true,
		centerMode: true,
		centerPadding: '230px',
		slidesToShow: 3,
		focusOnSelect: true,
		responsive: [{
				breakpoint: 769,
				settings: {
					centerPadding: '100px',
				}
			},

			{
				breakpoint: 577,
				settings: {
					centerPadding: '50px',
				}
			},
			{
				breakpoint: 321,
				settings: {
					centerPadding: '30px',
					slidesToShow: 1
				}
			}
		]
	});

	/* Comtom Carousel 2 */

	var screenshotCenterActive2 = $('.custom-carousel-active-2');
	screenshotCenterActive2.slick({
		arrows: true,
		autoplay: false,
		dots: false,
		autoplaySpeed: 800,
		infinite: true,
		centerMode: true,
		centerPadding: '130px',
		slidesToShow: 3,
		prevArrow: '<button class="custom-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="custom-arrow-next"><i class="fa fa-angle-right"></i></button>',
		focusOnSelect: true,

		responsive: [{
				breakpoint: 991,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 768,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
					slidesToShow: 3
				}
			},

			{
				breakpoint: 481,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '0px',
					slidesToShow: 2
				}
			},
			{
				breakpoint: 321,
				settings: {
					slidesToShow: 1,
					centerPadding: '0px',
				}
			}
		]
	});

	/* Comtom Carousel 3 */


	$('.custom-carousel-active-3').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		autoplay: false,
		prevArrow: '<button class="custom-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="custom-arrow-next"><i class="fa fa-angle-right"></i></button>',
		centerMode: false,
		focusOnSelect: true,
		responsive: [{
				breakpoint: 577,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 481,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});

	/* Comtom Carousel 4 */

	$('.custom-carousel-active-4').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 2,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		autoplay: false,
		prevArrow: '<button class="custom-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="custom-arrow-next"><i class="fa fa-angle-right"></i></button>',
		centerMode: false,
		focusOnSelect: true,

		responsive: [{
			breakpoint: 576,
			settings: {
				slidesToShow: 1
			}
		}]

	});

	/* Custom carousel active 5 */

	$('.custom-carousel-active-5').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
		autoplay: false,
		centerMode: false,
		focusOnSelect: false,
		draggable: false,
		responsive: [{
			breakpoint: 576,
			settings: {
				slidesToShow: 1,
				draggable: true,
				dots: false,
			}
		}]

	});

	/* Custom carousel active 6 */

	$('.custom-carousel-active-6').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		autoplay: false,
		prevArrow: '<button class="custom-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="custom-arrow-next"><i class="fa fa-angle-right"></i></button>',
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0px',
		asNavFor: '.custum-carousel-navigation'
	});


	$('.custum-carousel-navigation').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		asNavFor: '.custom-carousel-active-6',
		dots: true,
		centerMode: true,
		focusOnSelect: true,

		responsive: [{
			breakpoint: 577,
			settings: {
				centerPadding: '0px',
			}
		}]
	});

	/* Custom carousel active 7 */
	$('.custom-carousel-active-7').slick({
		infinite: true,
		speed: 500,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		autoplay: false,
		prevArrow: '<button class="custom-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="custom-arrow-next"><i class="fa fa-angle-right"></i></button>',
		centerMode: false,
		focusOnSelect: true,

	});

	/* Comtom Carousel 8*/

	var screenshotCenterActive = $('.software-activation');
	screenshotCenterActive.slick({
		arrows: false,
		autoplay: false,
		dots: false,
		autoplaySpeed: 800,
		infinite: true,
		centerMode: true,
		centerPadding: '200px',
		slidesToShow: 1,
		focusOnSelect: true,
		responsive: [{
				breakpoint: 769,
				settings: {
					centerPadding: '100px',
				}
			},

			{
				breakpoint: 577,
				settings: {
					centerPadding: '50px',
				}
			},
			{
				breakpoint: 321,
				settings: {
					centerPadding: '30px',
					slidesToShow: 1
				}
			}
		]
	});



	/*==========================================
		21. Testimonial Slider Activation
	==============================================*/

	$('.testimonial-slide-active').slick({
		slidesToShow: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		easing: 'ease-in-out',
		dots: false,
		arrows: true,
		prevArrow: '<button class="testimonial-arrow-prev"><i class="fa fa-arrow-left"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="fa fa-arrow-right"></i></button>',
	});

	$('.testimonial-slide-active-3').slick({
		dots: false,
		infinite: true,
		speed: 500,
		slidesToShow: 1,
		centerMode: true,
		arrows: true,
		centerPadding: '0px',
		prevArrow: '<button class="testimonial-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="fa fa-angle-right"></i></button>',
		responsive: [{
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
					centerPadding: '0px',
				}
			}

		]
	});

	$('.testimonial-slide-active-4').slick({
		dots: true,
		infinite: true,
		speed: 500,
		slidesToShow: 1,
		centerMode: true,
		arrows: true,
		prevArrow: '<button class="testimonial-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="fa fa-angle-right"></i></button>',
		centerPadding: '0',
	});

	$('.testimonal-nav5').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		asNavFor: '.testimonial-for5',
		dots: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		arrows: false,

		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 577,
				settings: {
					slidesToShow: 1
				}
			},

		]



	});

	$('.testimonial-for5').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '.testimonal-nav5'
	});


	/*==========================================
		22. Post Carousel Activation
	==============================================*/

	$('.post-carousel-active').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		centerMode: false,
		arrows: true,
		prevArrow: '<button class="post-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="post-next"><i class="fa fa-angle-right"></i></button>',
		responsive: [{
				breakpoint: 1193,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 766,
				settings: {
					slidesToShow: 1
				}
			},

		]
	});

	$('.post-carousel-activ-2').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		centerMode: false,
		arrows: false,

		responsive: [{
				breakpoint: 992,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 681,
				settings: {
					slidesToShow: 1
				}
			},

		]

	});

	$('.post-carousel-active-3').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		centerMode: false,
		arrows: true,
		prevArrow: '<button class="post-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="post-next"><i class="fa fa-angle-right"></i></button>',
		responsive: [{
				breakpoint: 1193,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 766,
				settings: {
					slidesToShow: 1
				}
			},

		]
	});

	$('.post-carousel-active-4').slick({
		slidesToShow: 2,
		slidesToScroll: 1,
		centerMode: false,
		dots: true,
		arrows: true,
		prevArrow: '<button class="post-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="post-next"><i class="fa fa-angle-right"></i></button>',

		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 1
				}
			}


		]

	});

	$('.post-carousel-active-5').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		centerMode: false,
		dots: false,
		arrows: true,
		prevArrow: '<button class="post-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="post-next"><i class="fa fa-angle-right"></i></button>',
		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 770,
				settings: {
					slidesToShow: 3
				}
			},

			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			},
		]

	});

	/*=====================================
		23. Image Justify Activation
	=========================================*/

	$('#npgallery').justifiedGallery({
		rowHeight: 300,
		maxRowHeight: null,
		margins: 20,
		border: 0,
		rel: 'npgallery',
		lastRow: 'nojustify',
		captions: true,
		randomize: false,
		sizeRangeSuffixes: {
			lt100: '_t',
			lt240: '_m',
			lt320: '_n',
			lt500: '',
			lt640: '_z',
			lt1024: '_b'
		}
	}).on('jg.complete', function () {
		$(this).find('a').colorbox({
			maxWidth: '80%',
			maxHeight: '80%',
			opacity: 0.8,
			transition: 'elastic',
			current: ''
		});
	});


	$('#npgallery2').justifiedGallery({
		rowHeight: 350,
		maxRowHeight: null,
		margins: 0,
		border: 0,
		rel: 'npgallery2',
		lastRow: 'nojustify',
		captions: true,
		randomize: false,
		sizeRangeSuffixes: {
			lt100: '_t',
			lt240: '_m',
			lt320: '_n',
			lt500: '',
			lt640: '_z',
			lt1024: '_b'
		}
	}).on('jg.complete', function () {
		$(this).find('a').colorbox({
			maxWidth: '80%',
			maxHeight: '80%',
			opacity: 0.8,
			transition: 'elastic',
			current: ''
		});
	});



	$('#npgallery3').justifiedGallery({
		rowHeight: 390,
		maxRowHeight: null,
		margins: 0,
		border: 0,
		rel: 'npgallery3',
		lastRow: 'nojustify',
		captions: true,
		randomize: false,
		sizeRangeSuffixes: {
			lt100: '_t',
			lt240: '_m',
			lt320: '_n',
			lt500: '',
			lt640: '_z',
			lt1024: '_b'
		}
	}).on('jg.complete', function () {
		$(this).find('a').colorbox({
			maxWidth: '80%',
			maxHeight: '80%',
			opacity: 0.8,
			transition: 'elastic',
			current: ''
		});
	});


	$('#npgallery4').justifiedGallery({
		rowHeight: 470,
		maxRowHeight: null,
		margins: 20,
		border: 0,
		rel: 'npgallery3',
		lastRow: 'nojustify',
		captions: true,
		randomize: false,
		sizeRangeSuffixes: {
			lt100: '_t',
			lt240: '_m',
			lt320: '_n',
			lt500: '',
			lt640: '_z',
			lt1024: '_b'
		}
	}).on('jg.complete', function () {
		$(this).find('a').colorbox({
			maxWidth: '80%',
			maxHeight: '80%',
			opacity: 0.8,
			transition: 'elastic',
			current: ''
		});
	});


	$('#npgallery5').justifiedGallery({
		rowHeight: 260,
		maxRowHeight: null,
		margins: 50,
		border: 0,
		rel: 'npgallery5',
		lastRow: 'nojustify',
		captions: true,
		randomize: false,
		sizeRangeSuffixes: {
			lt100: '_t',
			lt240: '_m',
			lt320: '_n',
			lt500: '',
			lt640: '_z',
			lt1024: '_b'
		}
	}).on('jg.complete', function () {
		$(this).find('a').colorbox({
			maxWidth: '80%',
			maxHeight: '80%',
			opacity: 0.8,
			transition: 'elastic',
			current: ''
		});
	});



	/*=====================================
		24. Data Table
	=========================================*/

	$('#example').DataTable();

	/*=====================================
		25. Slider Height
	=========================================*/

	function heroSliderMargin() {
		if ($('.header--transparant').length) {
			$('.ht-mega-slider .ht-slide').css({
				'min-height': '100vh'
			});
		} else {
			var headerHeight = $('.header').height();
			$('.ht-mega-slider .ht-slide').css({
				'min-height': 'calc(100vh - ' + headerHeight + 'px)'
			});
		}
	}
	heroSliderMargin();




	/*=====================================
		26. Cleaning Service Activation
	=========================================*/

	$('.cln-service-activation').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		centerMode: false,
		dots: false,
		arrows: true,
		focusOnSelect: true,
		prevArrow: '<button class="clnService-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="clnService-next"><i class="fa fa-angle-right"></i></button>',

		responsive: [

			{
				breakpoint: 769,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 770,
				settings: {
					slidesToShow: 3
				}
			},

			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			},
		]

	});



	/*=====================================
		27. Slider Activation
	=========================================*/


	$('.ht-mega-slider-activation').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		centerMode: false,
		dots: true,
		arrows: false,
		focusOnSelect: true,
	});




	/*=====================================
		28. Mainmenu Activation
	=========================================*/


	$('nav.mobilemenu__nav').meanmenu({
		meanMenuClose: 'X',
		meanMenuCloseSize: '18px',
		meanScreenWidth: '991',
		meanExpandableChildren: true,
		meanMenuContainer: '.mobile-menu',
		onePage: true
	});


	/*=====================================
		29. Panel Slide Active
	======================================*/


	$('.panel-slide-active').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		centerMode: true,
		arrows: true,
		prevArrow: '<button class="panel-slide-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="panel-slide-next"><i class="fa fa-angle-right"></i></button>',
		centerPadding: '0',
		responsive: [{
				breakpoint: 577,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 481,
				settings: {
					slidesToShow: 1
				}
			},
		]

	});



	$('.panel-slide-active-2').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		centerMode: false,
		arrows: true,
		prevArrow: '<button class="panel-slide-prev"><i class="fa fa-arrow-left"></i></button>',
		nextArrow: '<button class="panel-slide-next"><i class="fa fa-arrow-right"></i></button>',
		centerPadding: '0px',
		responsive: [{
				breakpoint: 577,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 481,
				settings: {
					slidesToShow: 1
				}
			},
		]
	});


	$('.panel-slide-active-3').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		centerMode: false,
		arrows: false,
		centerPadding: '0',
		focusOnSelect: false,
		responsive: [{
				breakpoint: 577,
				settings: {
					slidesToShow: 2,
					focusOnSelect: true,
				}
			},
			{
				breakpoint: 481,
				settings: {
					slidesToShow: 1,
					focusOnSelect: true,
				}
			},
		]
	});


	$('.panel-slide-active-4').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		centerMode: true,
		arrows: true,
		prevArrow: '<button class="panel-slide-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="panel-slide-next"><i class="fa fa-angle-right"></i></button>',
		centerPadding: '0',
		responsive: [{
				breakpoint: 577,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 481,
				settings: {
					slidesToShow: 1
				}
			},
		]
	});





	/*=====================================
		30. Agency Activation
	======================================*/


	$('.agency-brand-active').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		centerMode: false,
		arrows: false,
		centerPadding: '0',
		responsive: [{
				breakpoint: 577,
				settings: {
					slidesToShow: 4
				}
			},

			{
				breakpoint: 481,
				settings: {
					slidesToShow: 3
				}
			},

			{
				breakpoint: 381,
				settings: {
					slidesToShow: 2
				}
			},
		]
	});



	/*=====================================
		31. Gallery Mesonry Activation
	======================================*/


	$('.consmasonry-active').imagesLoaded(function () {

		// filter items on button click
		$('.gallery__menu').on('click', 'button', function () {
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({
				filter: filterValue
			});
		});

		// change is-checked class on buttons
		$('.gallery__menu button').on('click', function () {
			$('.gallery__menu button').removeClass('is-checked');
			$(this).addClass('is-checked');
			var selector = $(this).attr('data-filter');
			$containerpage.isotope({
				filter: selector
			});
			return false;
		});

		// init Isotope
		var $grid = $('.masonry-wrap-2').isotope({
			itemSelector: '.masonary-item',
			percentPosition: true,
			transitionDuration: '0.7s',
			masonry: {
				// use outer width of grid-sizer for columnWidth
				columnWidth: 1,
			}
		});

	});



	/*================================
		32. Brand Activation
	==================================*/

	$('.brand-style-3').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		centerMode: false,
		arrows: false,
		dots: false,
		arrows: false,

		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 3
				}
			},

			{
				breakpoint: 481,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 321,
				settings: {
					slidesToShow: 1
				}
			},
		]

	});


	$('.brand-style-6').slick({
		slidesToShow: 6,
		slidesToScroll: 1,
		centerMode: false,
		arrows: false,
		dots: false,
		arrows: false,

		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 3
				}
			},

			{
				breakpoint: 481,
				settings: {
					slidesToShow: 2
				}
			},

			{
				breakpoint: 321,
				settings: {
					slidesToShow: 1
				}
			},
		]

	});


	/*===========================
		33. Scroll Up Activation 
	==============================*/
	$.scrollUp({
		scrollText: '<i class="fa fa-angle-up"></i>',
		easingType: 'linear',
		scrollSpeed: 900,
		animation: 'slide'
	});



})(jQuery);