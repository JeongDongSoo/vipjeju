	function geoLocation()
	{
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition,showError);
		}
		else{
			alert("Geolocation is not supported by this browser.");
		}
	}
	
	//위치 추적 Success
	function showPosition(position)
	{
		var latitude = position.coords.latitude;
		var longitude = position.coords.longitude;
		
		var mapOptions = {
			zoom : 16,
			center : new google.maps.LatLng(latitude,longitude),
			scrollwheel : true,
			mapTypeControl : true,
			disableDefaultUI : true, //기본 UI 사용 여부
			disableDoubleClickZoom : true, //더블클릭 중심으로 확대 사용 여부
			draggable : true, //지도 드래그 이동 사용 여부
			maxZoom : 18, //최대 줌
			minZoom : 1, //최소 줌
			scaleControl : true //맵 축적도 사용
		};
	
		var map = new google.maps.Map(document.getElementById('google_map'), mapOptions);
		var image = '/site/www/images/main/mobile_maker.png';
		var marker = new google.maps.Marker({
			map : map,
			position : map.getCenter(),
			icon : image,
			title : "내위치"
		});

		google.maps.event.addDomListener(window, "resize", function(){
			var center = map.getCenter();
			google.maps.event.trigger(map, "resize");
			map.setCenter(center);
		});
		
		//현재 위치 주소 가져오기
		var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
		var geocoder = new google.maps.Geocoder;
		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					var address = results[1].formatted_address.replace("대한민국 ", "")+" 주변";
					$("#map_adres").html(address);
				}
			}
		});
	}

	function showError(error)
	{
		switch (error.code)
		{
			case error.PERMISSION_DENIED:
				alert("User denied the request for Geolocation.");
			break;
			case error.POSITION_UNAVAILABLE:
				alert("Location information is unavailable.");
			break;
			case error.TIMEOUT:
				alert("The request to get user location timed out.");
			break;
			case error.UNKNOWN_ERROR:
				alert("An unknown error occurred.");
			break;
		}
	}