/* Google Maps */

function initGmap($mapContainer) {
	var mapC = $mapContainer,
		singleLocation = mapC.parent().find('.et_location'),
		mapZoom = mapC.data('map-zoom'),
		mapStyle = mapC.data('map-style'),
		customMapStyle = mapC.data('custom-map-style'),
		mapType = mapC.data('map-type'),
		panControl = mapC.data('pan-control'),
		zoomControl = mapC.data('zoom-control'),
		mapTypeControl = mapC.data('maptype-control'),
		scaleControl = mapC.data('scale-control'),
		streetViewControl = mapC.data('streetview-control'),
		locations = mapC.find('.et-location-data'),
		isReady,
		// Custom map styles from snazzymaps.com
		customStyles = {
			// ../style/84535/paper-v2
			'paper': [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"visibility":"simplified"},{"hue":"#0066ff"},{"saturation":74},{"lightness":100}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"off"},{"weight":0.6},{"saturation":-85},{"lightness":61}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#eaeaea"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"simplified"},{"color":"#5f94ff"},{"lightness":26},{"gamma":5.86}]}],

			// ../style/29/light-monochrome
			'light': [{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}],

			// ../style/56984/grey-and-black
			'dark': [{"featureType":"all","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"color":"#838383"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#c4c4c4"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#aaaaaa"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21},{"visibility":"on"}]},{"featureType":"poi.business","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#6e6e6e"},{"lightness":"0"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#575757"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.stroke","stylers":[{"color":"#2c2c2c"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#999999"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}],
			
			// ../style/132/light-gray
			'grayscale': [{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#d3d3d3"}]},{"featureType":"transit","stylers":[{"color":"#808080"},{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#b3b3b3"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"weight":1.8}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"color":"#d7d7d7"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#ebebeb"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#a7a7a7"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#efefef"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#696969"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"#737373"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#d6d6d6"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#dadada"}]}],
			
			// ../style/56393/minimal-grey
			'countries': [{"featureType":"all","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType": "water","elementType": "all","stylers":[{"visibility":"on"},{"lightness":-100},{"color":"#454545"}]}]
		};

	// Load custom map style	
	if (customMapStyle.length > 0) {
		mapStyle = customMapStyle;
	} else {
		mapStyle = customStyles[mapStyle];
	}

	var bounds = new google.maps.LatLngBounds();
 
	// Prepare gmap options
	var mapOptions = {
		center: {
			lat: -34.397,
			lng: 150.644
		},
		styles: mapStyle,
		zoom: mapZoom,
		//draggable: !("ontouchend" in document),
		scrollwheel: false,
		panControl: panControl,
		zoomControl: zoomControl,
		mapTypeControl: mapTypeControl,
		scaleControl: scaleControl,
		streetViewControl: streetViewControl,
		fullscreenControl: false,
		mapTypeId: mapType
	};

	// Generate Map
	var map = new google.maps.Map(mapC[0], mapOptions);
	 
	// Add Marker
	function mapAddMarker(i, location) {

	 	var options = location.data('option'),
	 			lat = options.latitude,
	 			long = options.longitude,
	 			latlng = new google.maps.LatLng(lat, long),
	 			marker = options.marker_image,
	 			marker_size = options.marker_size,
	 			retina = options.retina_marker,
	 			title = options.marker_title,
	 			desc = options.marker_description,
	 			loadPinImage = new Image();
	 	
	 	bounds.extend(latlng);
	 	
	 	loadPinImage.src = marker;
	 	
	 	location.data('rendered', true);

	 	jQuery(loadPinImage).on('load', function(){
	 		setMapMarkers(i, map, latlng, marker, marker_size, title, desc, retina);
	 	});	
	 }

	singleLocation.each(function(i) {
		var _this = jQuery(this),
			i = _this.parents('.et_location_outer').index(),
			location = locations.eq(i);
		mapAddMarker(i, location);
	});

	function setMapMarkers(i, map, latlng, marker, marker_size, title, desc, retina) {
		// Information Box 
		var contentString = '' + 
				'<div class="poi-info-window gm-style">' +
				'<div class="title">' + title + '</div>' +
				'<div class="address">' + desc + '</div>' +
				'</div>',
				infowindow = new google.maps.InfoWindow({
					content: contentString
				});
		
		// Marker size
		if ( retina ) {
			marker_size[0] = marker_size[0]/2;
			marker_size[1] = marker_size[1]/2;
		}
		
		function CustomMarker(latlng,  map) {
		  this.latlng = latlng;
		  this.setMap(map);
		}

		CustomMarker.prototype = new google.maps.OverlayView();
		
		// Draw marker on map
		CustomMarker.prototype.draw = function() {
	    var self = this;
	    var div = this.div_;
	    if (!div) {
				div = this.div_ = jQuery('<div class="pin-wrap"><img src="'+marker+'" width="'+marker_size[0]+'" height="'+marker_size[1]+'"/></div>');
				this.div_[0].style.position = 'absolute';
				this.div_[0].style.cursor = 'pointer';
				
				var panes = this.getPanes();
				panes.overlayImage.appendChild(this.div_[0]);
				
				google.maps.event.addDomListener(div[0], "click", function(event) {
					infowindow.setPosition(latlng);
					infowindow.open(map);
				});

	    }

	    // Position marker
	    var point = this.getProjection().fromLatLngToDivPixel(latlng);
	    if (point) {
        this.div_[0].style.left = Math.round(point.x - (marker_size[0]/2) ) + 'px';
        this.div_[0].style.top = (point.y - marker_size[1]) + 'px';
        this.div_[0].style.width = marker_size[0] + 'px';
        this.div_[0].style.height = marker_size[1] + 'px';
	    }

		};

		CustomMarker.prototype.remove = function() {
			if (this.div_) {
				this.div_.parentNode.removeChild(this.div_);
				this.div_ = null;
			}	
		};
		
		CustomMarker.prototype.getPosition = function() {
			return this.latlng;	
		};
		
		var g_marker = new CustomMarker(latlng, map);
	}

	// On map tiles loaded
	google.maps.event.addListenerOnce(map,'tilesloaded', function() {

		// Get location info on click
		singleLocation.on('click', function() {
			var _this = jQuery(this),
					i = _this.parents('.et_location_outer').index(),
					location = locations.eq(i),
					options = location.data('option'),
					lat = options.latitude,
					long = options.longitude,
					latlng = new google.maps.LatLng(lat, long);

			if (!location.data('rendered')) {
				isReady = true;
				mapAddMarker(i, location);
			}
			singleLocation.removeClass('active');
			_this.addClass('active');
	   map.panTo(latlng);
			
		});
		
		setTimeout(function() {
			var loclist = singleLocation.eq(0).parents('.et_location_list');
			if (loclist.hasClass('autoselect_first')) {
				singleLocation.eq(0).trigger('click');	
			}
		}, 100);
		
		// Reposition map 
		if( mapZoom > 0 ) {
			map.setCenter(bounds.getCenter());
			map.setZoom(mapZoom);
		} else {
			map.setCenter(bounds.getCenter());
			map.fitBounds(bounds);
		}
		
	});

	jQuery(window).on('resize', _.debounce(function(){
		map.setCenter(bounds.getCenter());
	 }, 50) );

};

// Init map
jQuery(document).ready(function($) {
	$('.et_map_parent:not(.disabled)').each(function() { initGmap($(this)); });
});
