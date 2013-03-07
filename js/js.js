$(document).ready(function(){
    
	var map;
    var geocoder;
	var markerList = Array();
	
	function bind_clicks(){
	 $('#venue a').click(function(e) {
		e.preventDefault();
		jQuery.facebox({ ajax: $(this).attr("href")});
	 });
	}

    function updateCurrentLocation(curLoc){
        $('#loader').fadeIn();
        $.ajax({
          url: 'meh.php',
          dataType: 'json',
          type: 'post',
          data: { curlocation:curLoc },
          success: function(data) {
		    if(data.error){
			 $('#venue').html(data.error);
			 return;
			}
			make_clean();
			set_location(curLoc)
			$.each(data,function(id,v){
				if(v.type == "tram"){ icon = "gfx/tram.png"; }
				if(v.type == "bus"){ icon = "gfx/bus.png"; }
				if(v.type == "metro"){ icon = "gfx/subway.png"; }
				if(v.type == "bus-trolley"){ icon = "gfx/bus-trolley.png"; }
				//$('#venue').append(v.href);
				
				add_venue(v.id,v.lat,v.lon,v.title,icon,id);
			})
			//bind_clicks();
            $('#loader').fadeOut();
          }
        });
    }
    
	function make_clean(){
	 $('#venue').html("");
	 $('#location').html("");
	 while(markerList[0]){
      markerList.pop().setMap(null);
     }
   }
   
   function get_location(callback){
    if(navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(function(position) {
	  callback(new google.maps.LatLng(position.coords.latitude,position.coords.longitude),16);
      return true;
     })
    } else {
	 	callback(new google.maps.LatLng(44.427344,26.087294),15);
        return true;
	}
   }

   function set_location(curLoc){
    if (geocoder) {
		geocoder.geocode({'latLng': curLoc}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var fadr = results[0].formatted_address.split(",");
				$('#location').html("<span>You are around:</span>" + fadr[0] + "," + fadr[1]).show();
				return;
			}
	    });
	}
   }
   
   function add_venue(id,lat,lng,name,type,z){
      var myLatLng = new google.maps.LatLng(lat, lng);
      var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: type,
        title: name,
		zIndex: z,
      });
	 
	 google.maps.event.addListener(marker, 'click', function() {
		var target = $("#venue > #checkout_"+id);
		var infowindow = new google.maps.InfoWindow({
        content: data.body,
        });
		infowindow.open(map,marker);
		//$(target.find("a")[0]).click();
      });
	  google.maps.event.addListener(marker, 'mouseout', function() {
        var target = $("#venue > #checkout_"+id);
		target.removeClass('highlight');
      });
	  google.maps.event.addListener(marker, 'mouseover', function() {
        var target = $("#venue > #checkout_"+id);
		target.addClass('highlight');
      });
	  markerList.push(marker);
	}
	
    function createMap(origine,z) {
        var myOptions = {
            zoom: z,
            center: origine,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            navigationControl: true,
			streetViewControl: false,
            navigationControlOptions: {
                style: google.maps.NavigationControlStyle.DEFAULT
            },
            mapTypeControl: false
        }
		
        geocoder = new google.maps.Geocoder();
        map = new google.maps.Map(document.getElementById("mainmap"), myOptions);
		
		var image = 'gfx/marker.png';
		var point_marker = new google.maps.Marker({
			position: origine,
			map: map,
			icon: image,
			draggable: true,
			zIndex:10000,
		});
	
		google.maps.event.addListener(map, 'click', function(e){
		  point_marker.setPosition(e.latLng);
		  updateCurrentLocation(e.latLng);
		  map.panTo(e.latLng);
		});
	     
        google.maps.event.addListener(point_marker, 'dragend', function() {
            var new_pos = point_marker.getPosition();
			updateCurrentLocation(new_pos);
			map.panTo(new_pos);
        });
		
        updateCurrentLocation(map.getCenter());
		
    }
    
	get_location(function(point,z){
	     createMap(point,z);     //run it
	});


});