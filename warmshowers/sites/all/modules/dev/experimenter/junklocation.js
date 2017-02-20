// $Id: junklocation.js 405 2007-10-26 18:37:32Z rfay $

var debug = false;
var lastTime = new Date().getTime();
var locmap;

var drupenabled=false;
var gbrowscompat=false;
var jquery=false;
drupstat = Drupal.jsEnabled;
if (Drupal.jsEnabled) {
	drupenabled=true;
} 
if (GBrowserIsCompatible()) {
	gbrowscompat=true;
}
if (typeof(window.jQuery) == 'function') {
	jquery=true;
}
console.log("logging is working");
//alert("Javascript is in fact running; Drupal.jsEnabled="+ drupenabled + " and GBrowserIsCompatible() ="+gbrowscompat + " and jQuery="+jquery);;


$(document).ready( function() {
	var compat = GBrowserIsCompatible();
	console.log("GBrowserIsCompatible reports " + compat);
	//alert("(in document.ready)GBrowserIsCompatible reports" + compat);
	
	if (GBrowserIsCompatible()) {
		
		if (typeof showSingleLocationMap != 'undefined' && document.getElementById('locationmap')){
			showSingleLocationMap();
		}
	} else {
		alert("Your browser doesn't seem to be compatible.");
	}
} );


function showDebug(dbgstring) {
	if (debug) {
		var curTime = new Date().getTime();
		var diff = curTime - lastTime;
		document.getElementById("locationmap_debug").innerHTML += curTime + "(" + diff + ")" + dbgstring + "<br>\n";
		lastTime=curTime;
	}
}


function showSingleLocationMap(lat, lon) {
	if (debug && document.getElementById("locationmap_debug")) {
		document.getElementById("locationmap_debug").style.display = "block";
	}

	if (document.getElementById("locationmap")) {
		var defaultZoom=7;

		lon = document.getElementById("location_lon").innerHTML;
		lat = document.getElementById("location_lat").innerHTML;

		showDebug("Got coords: lat" + lat  + "," + lon);


		locmap = new GMap2(document.getElementById("locationmap"));
		var mypoint = new GLatLng(lat,lon);
		locmap.setCenter(mypoint,defaultZoom);
		var mymarker = new GMarker(mypoint);
		locmap.addOverlay(mymarker);

		GEvent.addListener(mymarker, "click", function() {

//			locmap.setCenter(mypoint);
			mymarker.openInfoWindowHtml(document.getElementById("infowindowhtml").innerHTML);
		});


		locmap.addControl(new GLargeMapControl());
		locmap.addControl(new GMapTypeControl());
	}
}
