/* ----- GLOBAL VARIABLES ----- */
var deviceWidth = typeof innerWidth === 'undefined' ? document.body.clientWidth : innerWidth, // GET DEVICE WIDTH
isMobile = { // CHECKS IF USER IS ON MOBILE OS
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	iPad: function() {
		return navigator.userAgent.match(/iPad/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
};

( function( $ ) {
	
	/* ----- IOS7 SAFARI VIEWPORT UNIT FIX ----- */
	$(document).ready(function() {
		if(isMobile.iOS()) { // MOBILE SAFARI ONLY
			window.viewportUnitsBuggyfill.init();
		}
	});


	/* ----- MENU FUNCTIONS ----- */
	$(document).ready(function() {
		var mobileMenuButton = $('.menu-btn'),
		mobileMenu = $('nav.main'),
		headerContainer = $('header');
		$('nav.main ul li .drop-down').hide(); // PREVENTS DROP-DOWNS FROM DEFAULTING TO OPEN POSITION ON PAGE LOAD
		if (deviceWidth > 960 && !isMobile.any()) { // DESKTOP FUNCTIONS
			$('nav.main ul li').hover(function() {
				$('.drop-down', this).stop().slideToggle(250);
			}, function(){
				$('.drop-down', this).stop().slideToggle(100);
			});
		}
		else { // MOBILE FUNCTIONS
			if (isMobile.iPad()) { // IPADS ONLY
				$('nav.main ul li').click(function() {
					$('.drop-down').not(this).stop().slideUp(100);
					$('.drop-down', this).stop().slideToggle(250);
				});		
			}
			else { // PHONES AND NON-IPAD TABLETS
				$('nav.main ul li').click(function() {
					$('.drop-down', this).stop().slideToggle(250);
				});
			}
			mobileMenuButton.click(function() {
				if (mobileMenu.hasClass('show-menu')) { // CLOSED MOBILE MENU Z-INDEX FIX
					setTimeout(function() {
						headerContainer.toggleClass('resize');
					}, 250); // LENGTH OF CLOSE MENU TRANSITION
				}
				else {
					headerContainer.toggleClass('resize');
				}
				mobileMenu.toggleClass('show-menu');
				$('body').toggleClass('hide-scroll');
			});
		}
	});


	/* ----- STICKY HEADER ----- */
	$(document).ready(function() {
		if (deviceWidth > 760) { // DESKTOPS AND TABLETS ONLY
			var headerContainer = $('header .middle');
			$(window).scroll(function() {
				if ($(window).scrollTop() > 145) {
					headerContainer.addClass('sticky');
					setTimeout(function() {
						headerContainer.addClass('slide');
					}, 250);
				}
				else {
					headerContainer.removeClass('slide');
					headerContainer.removeClass('sticky');
				}
			});
		}
	});

	/* ----- SEARCH FUNCTIONS ----- */
	$(document).ready(function() {
		var searchLink = $('.search'),
		searchContainer = $('.search-row'),
		searchForm = $('.search .container form'),
		searchButton = $('.search-row .container form input[type="submit"]');
		searchLink.click(function() {
			searchLink.toggleClass('active');
			searchContainer.toggleClass('show-search');
		});
		searchForm.find('input').keypress(function(e) { // ALLOW RETURN OR ENTER TO INITIATE SEARCH
			if (e.which == 10 || e.which == 13) {
				this.form.submit();
			}
		});
		searchButton.hide();
	});

	/* ----- SUBSCRIBE FUNCTIONS ----- */
	$(document).ready(function() {
		var newsletterLink = $('.join-newsletter .join-btn'),
		newsLetterContainer = $('.join-newsletter');
		newsletterLink.click(function() {
			newsletterLink.toggleClass('active');
			newsLetterContainer.toggleClass('show-subscribe');
		});
	});

	/* ----- BACK-TO-TOP FUNCTIONS ----- */
	$(document).ready(function() {
		var topButton = $('#back-to-top-btn');
		if (deviceWidth <= 760) { // PHONES ONLY
			$(window).scroll(function() {
				if ($(this).scrollTop() > 500) {
					topButton.addClass('show-btn');
				}
				else {
					topButton.removeClass('show-btn');
				}
			});
		}
		topButton.click(function() {
			$('body, html').animate({
				scrollTop : 0
			}, 500);
		});
	});

	/* ----- SLIDER MOBILE FUNCTIONS ----- */
	$(document).ready(function() {
		if(isMobile.any()) {
			$('#prev, #next').hide(); // PREVENTS BUTTONS FROM APPEARING ON MOBILE IF SCREEN WIDTH BYPASSES CSS MEDIA QUERIES
		}
		$('#slider li').on('swipeleft', function() {
			$('#next').click();
		});
		$('#slider li').on('swiperight', function() {
			$('#prev').click();
		});
	});

	/* ----- ENTRY FUNCTIONS ----- */
	$(document).ready(function() {
		$('.entry a.read-details').click(function(e) {
			e.preventDefault();
			var theEntry = $(this).parents('.entry');
			$('.details', theEntry).slideToggle();
			$(this).toggleClass('active');
			return false;
		});
		$(window).load(function() { // ADJUST IMAGE CONTAINER HEIGHT TO PARENT CONTAINER HEIGHT IF LARGER THAN MIN-HEIGHT
			function resizeImage() {
				$('.entry-image').each(function() {
					var theParent = $(this).parent();
					$(this).css('height', theParent.innerHeight()+'px');
				});
			}
			resizeImage();
			setTimeout(function() {  // RESET BACKGROUND COVER AFTER ON-LOAD RESIZE CALL
				$('.entry-image .background-cover').backgroundCover();		
			}, 250);
			$(window).resize(function() {
				$('.entry-image').css('height','240px'); // RESET INITIAL HEIGHT ON TABLET ROTATION
				resizeImage();
			});
		});
	});

	/* ----- INPUT PLACEHOLDER FALLBACK ----- */
	$(document).ready(function() {
		if (!('placeholder' in document.createElement('input'))) {
			$('input[placeholder], textarea[placeholder]').each(function() {
				var val = $(this).attr('placeholder');
				if (this.value == '') {
					this.value = val;
				}
				$(this).focus(function() {
					if (this.value == val) {
						this.value = '';
					}
				}).blur(function() {
					if ($.trim(this.value) == '') {
						this.value = val;
					}
				})
			});
			$('form').submit(function() { // CHECK FOR AND REMOVE HTML5 PLACEHOLDER VALUES ON SUBMIT
				$(this).find('input[placeholder], textarea[placeholder]').each(function() {
					if (this.value == $(this).attr('placeholder')) {
						this.value = '';
					}
				});
			});
		}
	});

	/* ----- TOOLTIPSTER INITIALIZE ----- */
	$(document).ready(function() {
		if (!isMobile.any()) { // DESKTOPS ONLY
			$('.tooltip').tooltipster({
			   animation: 'grow',
			   delay: 50,
			   theme: 'tooltipster-default',
			   touchDevices: false,
			   trigger: 'hover',
			   position: 'bottom',
			   offsetY: 2
			});
			$('#map-btn').tooltipster({ // STYLE FOR ONLY MAP BUTTON
			   animation: 'grow',
			   delay: 50,
			   theme: 'tooltipster-default',
			   touchDevices: false,
			   trigger: 'hover',
			   position: 'left',
			   offsetX: 2
			});
		}
	});

	/* ----- CYCLE INITIALIZE ----- */
	$(document).ready(function() {
		$('#slider').cycle({
			speed: 600,
			timeout: 5000,
			prev: '#prev', 
			next: '#next'
		});
	});

	/* ----- BACKGROUND COVER INITIALIZE ----- */
	$(document).ready(function() {
		$('.background-cover').backgroundCover();
		if (isMobile.iOS()) { // IOS7 VIEWPORT UNIT BACKGROUND COVER FIX
			$(window).load(function() {
				$('.background-cover').backgroundCover(); // IOS7 DOM LOADING FIX
			});
			$(window).resize(function() {
				$('.background-cover').css('height','100%'); // RESET CSS HEIGHT
				setTimeout(function() { // RESET BACKGROUND COVER AFTER CSS HEIGHT RESET
					$('.background-cover').backgroundCover();
				}, 250);
			});
		}
	});

	/* ----- MAP FUNCTIONS ----- */
	$(document).ready(function() {
		var markersArray = [],
		mapCanvas = $('#map-canvas'),
		mapButton = $('#map-btn'),
		mapLink = $('.map-link');
		$('#map-btn, #mobile-map-btn').click(function() {
			if (!mapCanvas.hasClass('active')) { // CLEAR MARKERS BEFORE OPENING MAP
				for (var i = 0; i < markersArray.length; ++i) {
					markersArray[i].setMap(null);
				}
			}
			if (mapButton.hasClass('active') && $('nav.main').hasClass('show-menu')) {
				$('.menu-btn').click();
			}
			mapCanvas.toggleClass('active');
			mapButton.toggleClass('active');
		});
		$(document).keyup(function(e) { // ALLOW ESCAPE TO CLOSE MAP
			if (mapCanvas.hasClass('active') && e.keyCode == 27) {
				mapButton.click();
			}
		});
		mapLink.click(function(e) {
			e.preventDefault();
			var coordinates = $(this).attr('href'),
			googleCoordinates = coordinates.split(","), // CONVERT STRING TO CONSTRUCTOR VALUES
			location = new google.maps.LatLng(parseFloat(googleCoordinates[0]), parseFloat(googleCoordinates[1]));
			mapButton.click();
			setTimeout(function() {
				map.panTo(location);
				var marker = new google.maps.Marker({
					position: location,
					map: map,
					animation: google.maps.Animation.DROP,
					icon: 'images/map-marker.svg'
				});
				markersArray.push(marker);
			}, 750);
			return false;
		});
		var map, // GOOGLE MAPS API V3.9
		navyPier = new google.maps.LatLng(41.891642,-87.605519),
		MY_MAPTYPE_ID = 'navy_pier';
		function initialize() {
			var featureOpts = [
				{
				'featureType': 'landscape.man_made',
				'stylers': [
				  { 'visibility': 'off' }
				]
			  },{
				'featureType': 'road',
				'elementType': 'geometry.fill',
				'stylers': [
				  { 'color': '#ffffff' }
				]
			  },{
				'featureType': 'poi',
				'elementType': 'geometry.fill',
				'stylers': [
				  { 'color': '#bed600' }
				]
			  },{
				'featureType': 'water',
				'stylers': [
				  { 'color': '#263f6a' }
				]
			  },{
				'featureType': 'road',
				'elementType': 'geometry.stroke',
				'stylers': [
				  { 'color': '#cccccc' }
				]
			  },{
				'elementType': 'labels.text.fill',
				'stylers': [
				  { 'color': '#221e1f' },
				  { 'visibility': 'on' }
				]
			  },{
				'featureType': 'landscape',
				'stylers': [
				  { 'color': '#eeeeee' }
				]
			  },{
				'featureType': 'transit',
				'elementType': 'labels',
				'stylers': [
				  { 'visibility': 'off' }
				]
			  },{
				'featureType': 'transit',
				'elementType': 'geometry',
				'stylers': [
				  { 'visibility': 'off' }
				]
			  },{
				'elementType': 'labels.text.stroke',
				'stylers': [
				  { 'weight': 4 },
				  { 'color': '#ffffff' }
				]
			  },{
				"featureType": "road.local",
				"elementType": "labels",
				"stylers": [
				  { "visibility": "off" }
				]
			  }
			];
			var mapOptions = {
				zoom: 17,
				center: navyPier,
				panControl: false,
				zoomControl: false,
				mapTypeControl: false,
				scaleControl: false,
				streetViewControl: false,
				overviewMapControl: false,
				mapTypeControlOptions: {
				mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
			},
			mapTypeId: MY_MAPTYPE_ID
			};
			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			var styledMapOptions = {
				name: 'Navy Pier Style'
			};
			var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);
			map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
		}
		google.maps.event.addDomListener(window, 'load', initialize);
		if (deviceWidth <= 960 && deviceWidth > 640) { // ADJUST ZOOM LEVELS FOR SMALLER VIEWPORTS
			$(window).load(function() {
				setTimeout(function() {
					map.setZoom(16);
				}, 1000);
			});
		}
		if (deviceWidth <= 640) {
			$(window).load(function() {
				setTimeout(function() {
					map.setZoom(15);
				}, 1000);
			});
		}
	});
	
} )( jQuery );	