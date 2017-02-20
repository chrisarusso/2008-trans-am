var d2r = Math.PI / 180; //degrees to radians used in several functions
var milesToLat = 0.014483; // multiple for converting miles into degrees of latitude 
var overlayArray = [];
var map = new GMap2(document.getElementById("gMap"));
var address;
//converts miles to degrees longitude.  Note, this requires some trig because as lng moves away from equator
//the lines get closer... so it's dependent upon lat
//inputs are degrees lat, and distance in miles and output is degrees in longitude
function milesToLng(lat, mileage){
	var ret =  milesToLat * mileage / Math.cos(d2r*lat);
	return ret;
}
//input equals 2 glatlngs output is distance in miles of geodesic curve
function dstBtwPoints(pointA,pointB){
	return pointA.distanceFrom(pointB) / 1609.344; //distanceFrom is a google function
}

function sortByMinReq(a,b){
	var a = minPurch(a[3],a[4].level);
	var b = minPurch(b[3],b[4].level);
	return a-b;
}


function load() {
	if (GBrowserIsCompatible()) {
		map.setCenter(new GLatLng(39.338431,-101.126041), 4);
		//map.setMapType(G_SATELLITE_MAP);
		map.addMapType(G_PHYSICAL_MAP);
		map.addControl(new GLargeMapControl());
		map.addControl(new GScaleControl());
		map.addControl(new GHierarchicalMapTypeControl());
		map.addControl(new GOverviewMapControl());
		map.enableContinuousZoom();
		//map.enableGoogleBar();
		map.enableScrollWheelZoom();
	}//end if
}// end func

function showDstFrom(dst,add, AP){
	var minPurchase = minPurch(dst, AP.level);
	dst = Math.round(10*dst)/10;
	var retString = "The address " + add + " is " + dst + " miles away from a shipping center<br>" +
	"Since this is a level "+ AP.level +" shipping center , you are required to purchase at least " + minPurchase + " chickens ";
	return retString;
}

function minPurch(dst, level){
	var ret = 8;
	if(level ==1){
		if(dst <= sCV[0]){
			ret = 3;
		}else if(dst <= mCV[0]){
			ret = 5;
		}else if(dst <= bCV[0]){
			ret = 8;
		}else{
		 	//shouldnt happen
		}
	}else if(level == 2){
		if(dst <= sCV[0]){
			ret = 5;
		}else if(dst <= mCV[0]){
			ret = 7;
		}else if(dst <= bCV[0]){
			ret = 8;
		}else{
		 	//shouldnt happen
		}
	}else{
		//shouldn't happen
	}
	
	return ret;	
}

function isValidAdd(add){   
	map.clearOverlays();
	var geocoder = new GClientGeocoder();
	address = add;
  	geocoder.getLatLng(add, 
  		function(point) {
    		if (!point) {
        		alert(add + " not found");
      		} else {
      			map.setCenter(point,7);
      			var marker = new GMarker(point)
      			GEvent.addListener(marker, "click", function() {
 				marker.openInfoWindow(add + "<br>" + marker.getLatLng());
				});
      			map.addOverlay(marker);
				GDownloadUrl("js/airports2.csv", function(data, responseCode) {
  					drawCircles(data, point);
				});
       		}
    	}
  	);
  	return false;	 //the work is already done... this is to suppress form submission
}

function findMinPurch(point){   	


				GDownloadUrl("js/airports2.csv", function(data, responseCode) {
  					drawCircles(data, point);
				});
}
  
function minPurchFromAdd(add){
	var geocoder = new GClientGeocoder();
  	geocoder.getLatLng(add, 
  		function(point) {
    		if (!point) {
        		alert(add + " not found");
      		} else {
      			GDownloadUrl("js/airports2.csv", function(data, responseCode) {
  					drawCircles(data, point);
				});

       		}
    	}
  	);
  	return point;
}
  