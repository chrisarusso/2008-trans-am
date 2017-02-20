// $Id: wsmap_clusterer.js 474 2008-04-16 23:55:13Z rfay $
var om=null;
var map=null;
var hosts=[];

var startlat;
var startlon;
var startzoom;
var mapcountry;

var advcycl; // Overlay for advcycling stuff

var mapwidth; // In percent, from html

var debug=false;
//var debug=true;
var	base_path = null;
var lastTime = new Date().getTime();
var disable_zoomend = false;
var clusterer=null;
var redIcon;
var maxvisiblemarkers=50;
var numHostsToDetail=8;
var specificZoomSettings  = {  // Handle countries that don't quite fit the calculation
us: 6, ca: 5, ru:3, cn:4
};
var chunkSize = 5000; /* Max size of a request to the db */
var mapdata_source=null;
var loggedin = false;
var  cookiedays=14;  /* days to save a lat/lon/country cookie */  




$(document).ready( function() {
	if (typeof GBrowserIsCompatible != 'undefined' && GBrowserIsCompatible()) {
		$("body").attr( "onunload", "GUnload();" );  // Recommended by Google
		wsmap_main_load_entry();
	} else {
		alert("You don't seem to be compatible with Google Maps");
		$('#wsmap_map').val("Sorry - Your browser does not seem to be compatible with Google Maps. You might want to try to excellent free <a href='http://getfirefox.com'>Firefox</a> browser.");
		return;
	}
} );

	





/************************************************************\
*
\************************************************************/
function wsmap_main_load_entry()
{

	try {
		$('#edit-city')[0].select();

		mapwidth=parseInt($('#mapwidth').text());
		var rightcol=mapwidth+4;

		$('#nearby-hosts').css('left', ""+rightcol +'%');

		if ($('#wsmap_map').width()  < 500) {
			$('#nearby-hosts').css('position','static');
			$('#mapholder').css('width','100%');
		}
		else {
			$('#nearby-hosts').css('position','absolute');
			$('#mapholder').css('width',''+mapwidth+'%');
		}
		$(window).resize(map_resize);
		map_resize();


		setMapStartPosition();
		editCountryReset();

		mapdata_source = document.getElementById('mapdata_source').innerHTML;
		loggedin = parseInt(document.getElementById('loggedin').innerHTML);


		base_path = document.getElementById('base_path').innerHTML;

		//$('#wsmap_map').css('height',windowheight()*.8);
		redIcon = new GIcon();
		redIcon.image=base_path + '/clusterer/red.PNG';
		redIcon.shadow==base_path + '/clusterer/shadow.PNG';
		redIcon.iconSize=new GSize(20,34);
		redIcon.shadowSize=new GSize(37,34);
		redIcon.iconAnchor=new GPoint(9,34);
		redIcon.infoWindowAnchor=new GPoint(9,2);
		redIcon.infoShadowAnchor=new GPoint(18,25);


		map=new GMap2($('#wsmap_map')[0]);
		map.setCenter(new GLatLng(startlat,startlon), startzoom);
    map.setMapType(G_PHYSICAL_MAP);

		om=new OverlayMessage($('#wsmap_map')[0]);

		map.addControl(new GLargeMapControl());
    map.addControl(new GOverviewMapControl());


		map.addControl(new GMapTypeControl());
		map.addControl(new GScaleControl());
    map.addMapType(G_PHYSICAL_MAP);
		clusterer=new Clusterer(map);

		clusterer.maxVisibleMarkers = maxvisiblemarkers;
		clusterer.icon.image = base_path + '/clusterer/blue_large.PNG';
		clusterer.icon.shadow = base_path + '/clusterer/shadow_large.PNG';
		maxlines = mapwidth > 400 ? 10 : 5 ;
		clusterer.SetMaxLinesPerInfoBox(6);

		replaceAutocompleteHooks();


		if ($('#showuser').length) {
			var user =  $('#showuser');
			$('#edit-country').attr('value',user.attr('country'));
			editCountryReset();
			zoomToUser(user.attr('uid'),user.attr('latitude'), user.attr('longitude'),7);
		}


		// loadMarkers();
		GEvent.addListener(map,'dragstart',dragstart_called);
		GEvent.addListener(map,'dragend',dragend_called);
		GEvent.addListener(map,'zoomend', dragend_called);

		// Handle setting of position cookie whenever map moves
		GEvent.addListener( map, "moveend", function() {
			createCookie("mapLatitude",map.getCenter().lat());
			createCookie("mapLongitude",map.getCenter().lng());
			createCookie("mapZoom", map.getZoom());
			createCookie("mapCountry", $('#edit-country').val());
			mapcountry=$('#edit-country').val();
		} );

		loadMarkers();

	}
	catch(e)
	{
		var msg = Props(e);
		console.log('Main loop:\n'+msg);

	}

}


function loadMarkers() {

	var bounds = map.getBounds();
	var center = map.getCenter();
	var numpoints = 0;
	i=0;
	var sw = bounds.getSouthWest();
	var ne = bounds.getNorthEast();

	var rqurl = mapdata_source + "?minlat="+ sw.lat() +"&maxlat="+ ne.lat() +
	"&maxlon=" + ne.lng() + "&minlon="+ sw.lng() + "&centerlat=" + center.y 
	+ "&centerlon=" + center.x;
	rqurl += "&limitlow=" + 0 + "&maxresults=" + (0+chunkSize);
	showDebug("Rqurl: " + rqurl);

	om.Set('Loading...');

	showDebug("Calling HttpGet");
	HttpGet(rqurl,RequestChecker);
	
}


/************************************************************\
*
\************************************************************/
function RequestChecker(request)
{
	try
	{
		var xmlDoc=request.responseXML.documentElement;
		var hostElements=xmlDoc.getElementsByTagName('host');
		$('#nearby-hosts-content').html("<h2>Closest Hosts</h2>");
		for(var s=0; s<hostElements.length; ++s)
		{
			var host=new Object();
			var lastlat;
			var lastlon;
			
			host.prov=hostElements[s].getAttribute('p');
			host.city=hostElements[s].getAttribute('c');
			host.lat=parseFloat(hostElements[s].getAttribute('la'));
			host.lng=parseFloat(hostElements[s].getAttribute('ln'));
			host.location=new GLatLng(host.lat,host.lng);
			host.name=hostElements[s].getAttribute('n');
			host.mail=hostElements[s].getAttribute('m');
			host.na=parseInt(hostElements[s].getAttribute('a'));
			host.d=parseFloat(hostElements[s].getAttribute('d'));
			host.country=hostElements[s].getAttribute('cnt');

				
			host.uid=hostElements[s].getAttribute('u');
			
			if (s < numHostsToDetail) {
				var text = 	'<div class="hostdetail" uid="' + host.uid + '" class="markerdesc" >';
				if (loggedin) { text+= '<a href="/user/' + host.uid + '">'	+ host.name + '</a> ' ; }
				text += host.city + ", " + host.prov + ", " + host.country + '</div>';
					
				//if ($('#nearby-hosts').height() < $('#mapholder').height()) {
					$('#nearby-hosts-content').append(text);
				//}
			}

			if (hosts[host.uid] == null) {
				var icon = redIcon;
				if ( host.na ) { icon = grayIcon; }

				var marker=new GMarker(host.location, icon);
				host.marker=marker;
				GEvent.addListener(marker,'click',MakeCaller(PopUp,host.uid));
				var link;
				if (loggedin) {
					link = '<a href="/user/' + host.uid + '">' + host.name + "</a>  (" + host.city + ", " + host.prov  +  ", " + host.country + ")";
				} else {
					link =  host.city + ", " + host.prov +", " + host.country ;
				}

				clusterer.AddMarker(marker,link );
				//map.addOverlay(host.marker);
				hosts[host.uid] = host;
			}
			

		}
		om.Clear();
		showDebug("Completed Load and place");
		
		$('.hostdetail').mouseover( function() {
			var thisuid=$(this).attr('uid');
			PopUpWithoutPan($(this).attr('uid'));
		}
		
		);
		GEvent.trigger(map, 'loadMarkersComplete', hostElements.length);


	}

	catch(e)
	{
		var msg = Props(e);
		console.log('RequestChecker block exception:\n'+msg);

	}
	


}


function makePopupHtml(host) {
	var txt;
	var style="";
		if (loggedin) {
			txt='<table style="' + style + '" ><tbody><tr><td><b><a href="/user/'+host.uid+'">'+host.name+'</a>' +  '</b><br/> '+host.city + ", " + host.prov+ ", " + host.country + '</td></tr><tr><td><a href="/user/' +host.uid+'/contact" target="_blank">Click to email</a><td></tr></tbody></table>';
		} else {
			txt='<table style="' + style + '" ><tbody><tr><td>'+host.city + ", " + host.prov+ ", " + host.country +'</td></tr><tr><td><a href="/user/login">Log in</a> or <a href="/user/register">register</a> to get more info.</td></tr></tbody></table>';
		}
	return txt;
	
	
}

/************************************************************\
*
\************************************************************/
function PopUp(s)
{
	try
	{
		var host=hosts[s];
		var style = "";
		var html = makePopupHtml(host);
		var templistener =	GEvent.addListener( map, "moveend", function() {
			
			var opts={ maxWidth:220};
			host.marker.openInfoWindowHtml(html,opts );
			loadMarkers();
			GEvent.removeListener(templistener);
			disable_zoomend = false;
		} );

		var loc = host.location;
		disable_zoomend=true;
		map.panTo(loc);

	}

	catch(e)
	{
		console.log('PopUp:\n'+Props(e));

	}

}


function PopUpWithoutPan(s)
{
	var host=hosts[s];
	var style = "";
	var html = makePopupHtml(host);
	host.marker.openInfoWindowHtml(html,{maxWidth:220});
}


function dragend_called() {
	if (!disable_zoomend) {
		om.Clear();  // In the case where no more markers were drawn.
		loadMarkers();
	}

}

function dragstart_called() {
	map.closeInfoWindow();
}

function showDebug(dbgstring) {
	if (debug) {

		var curTime = new Date().getTime();
		var diff = curTime - lastTime;
		$("#wsmap_debug").append("(From showDebug):" + curTime + "(" + diff + ")" + dbgstring + "<br>\n");
		lastTime=curTime;
		
	}
}


function setMapLocationToCountry(countryCode) {
	getMapLocationForCountry(countryCode, zoomCallback);
 }
 
 function zoomCallback(data) {
	var res = Drupal.parseJson(data);
	var area = parseFloat(res.area)/1000;
	var basecalc = Math.log(area)/Math.log(4);
	mapcountry = res.country_code;
	var zoom = specificZoomSettings[mapcountry];
	
	if (!zoom) { 
		zoom= Math.round(10-basecalc);
	}
	zoomToSpecific(res.country,res.latitude,res.longitude,zoom);
        
 }


 
function getMapLocationForCountry(countryCode, func_to_call) {
	
		    // Ajax GET request for autocompletion
	url = '/location_country_locator_service' + '/' + countryCode;
	$.get(url, "" , func_to_call);

}

function editCountryReset() {
	
	replaceAutocompleteHooks(this);

	// HACK ALERT: Drupal 5.1 http://groups.drupal.org/node/3471.
	// Unless you do this Drupal.autocompleteAutoAttach keeps adding more GETs
	var auto=$('#edit-city-autocomplete');
	var country=$('#edit-country').attr('value');
	auto.attr('value','/location_autocomplete/' + country );
	with (document.getElementById('edit-city')) {
		for (i in events.keyup) delete events.keyup[i];
		for (i in events.blur) delete events.blur[i];
		for (i in events.keydown) delete events.keydown[i];
	}
	Drupal.autocompleteAutoAttach();
	$('#edit-city').attr('value',"");
}


function editCountryOnchange() {
	
	editCountryReset(); 
	mapcountry=$('#edit-country').val();

	if (mapcountry != 'xx' && mapcountry.length) {
		setMapLocationToCountry(mapcountry);
	}

	
}



function zoomToSpecific(placename, latitude, longitude, zoom) {
	map.setZoom(zoom);

	var templistener =	GEvent.addListener( map, "moveend", function() {
		GEvent.removeListener(templistener);
		
		var loadMarkersListener = GEvent.addListener(map,'loadMarkersComplete', function(numLoaded) {
			GEvent.removeListener(loadMarkersListener);

			map.openInfoWindow(map.getCenter(),	document.createTextNode(placename),{maxWidth:220});
			
		} );
		loadMarkers();


	});

	map.panTo(new GLatLng(latitude, longitude));


}


function zoomToUser(uid, latitude, longitude, zoom) {
	map.setZoom(zoom);
	
	var templistener =	GEvent.addListener( map, "moveend", function() {
		GEvent.removeListener(templistener);
	
		var loadMarkersListener = GEvent.addListener(map,"loadMarkersComplete", function(numLoaded) {
			GEvent.removeListener(loadMarkersListener);
			var host = hosts[uid];
			
			if (!host) { 
				map.openInfoWindowHtml(
					map.getCenter(),
					"User's general location<br/>(Not currently available to host)",{maxWidth:220});
				return;
			}

			txt = makePopupHtml(host);
			host.marker.openInfoWindowHtml(txt,{maxWidth:220});
		} );
			
		loadMarkers();
	});
	map.panTo(new GLatLng(latitude,longitude));

}

function replaceAutocompleteHooks() {
		Drupal.jsAC.prototype.hidePopup = function (keycode) {
		var loc=null;
		// Select item if the right key or mousebutton was pressed
		if (this.selected && ((keycode && keycode != 46 && keycode != 8 && keycode != 27) || !keycode)) {
			this.input.value = this.selected.autocompleteValue;  // Use the data value to fill
			// Do the map call with autocompleteValue
			loc = this.selected.autocompleteData.split('|');
	       	
 		}
		// Hide popup
		var popup = this.popup;
		if (popup) {
			this.popup = null;
			$(popup).fadeOut('fast', function() { $(popup).remove(); });
		}
		this.selected = false;
		var zoom = 6; // Arbitrary experiment
		if (loc) {   // If we had a selected value above
			zoomToSpecific(this.input.value,loc[0],loc[1], zoom);
			$('#edit-city')[0].select();  // So they can enter the next thing
		}

	};
	
	/**
	* Fills the suggestion popup with any matches received
	*/
	Drupal.jsAC.prototype.found = function (matches) {

		// If no value in the textfield, do not show the popup.
		if (!this.input.value.length) {
			return false;
		}

		// Prepare matches
		var ul = document.createElement('ul');
		var ac = this;
		for (key in matches) {
			var li = document.createElement('li');
			$(li)
			.html('<div>'+ key +'</div>')  // rfay: Use key instead of value
			.mousedown(function () { ac.select(this); })
			.mouseover(function () { ac.highlight(this); })
			.mouseout(function () { ac.unhighlight(this); });
			li.autocompleteValue = key;
			li.autocompleteData = matches[key];
			$(ul).append(li);
		}
		// Show popup with matches, if any
		if (this.popup) {
			if (ul.childNodes.length > 0) {
				$(this.popup).empty().append(ul).show();
			}
			else {
				$(this.popup).css({visibility: 'hidden'});
				this.hidePopup();
			}
		}
	}


}

function windowheight() {
	var browserHeight;
	if( typeof( window.innerHeight ) == 'number' ) {
		browserHeight = window.innerHeight;
	} else {
		browserHeight = document.documentElement.clientHeight;
	}
	return browserHeight;
}

function setMapStartPosition() {
	var success=false;
	var lat=readCookie("mapLatitude");
	var lon=readCookie("mapLongitude");
	var zoom=readCookie("mapZoom");
	var country=readCookie("mapCountry");
	if (lat && lon && zoom && country) {
		startlat = parseFloat(lat);
		startlon = parseFloat(lon);
		startzoom = parseInt(zoom);
		mapcountry = country;
		$('#edit-country').attr('value',mapcountry);
		return;
	} 
	
	startlat = parseFloat($('#browser_lat').text());
	startlon = parseFloat($('#browser_lon').text());
	mapcountry=$('#browser_country').text();
	$('#edit-country').attr('value',mapcountry);

	startzoom=specificZoomSettings[mapcountry];
	if (!startzoom) { 
		startzoom = parseInt($('#browser_default_zoom').text()); 
	}
	
	return;

}


function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

function map_resize() {
	bigsize = ($('#wsmap_map').width() > 500);
	if (bigsize) {
		$('#nearby-hosts').css('position','absolute');
		$('#mapholder').css('width',''+mapwidth+'%');
	} else {
		$('#nearby-hosts').css('position','static');
		$('#mapholder').css('width','100%');
	}
}

function loadAdvCycling(kmzfile) {
  advcycl =  new GGeoXml(kmzfile);
  map.addOverlay(advcycl);
}
function unloadAdvCycling() {
  map.removeOverlay(advcycl);
}
      

