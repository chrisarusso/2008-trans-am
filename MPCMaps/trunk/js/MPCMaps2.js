var d2r = Math.PI / 180; //degrees to radians used in several functions
var milesToLat = 0.014483; // multiple for converting miles into degrees of latitude 

var map = new GMap2(document.getElementById("gMap"));
//converts miles to degrees longitude.  Note, this requires some trig because as lng moves away from equator
//the lines get closer... so it's dependent upon lat
//inputs are degrees lat, and distance in miles and output is degrees in longitude
function milesToLng(lat, mileage){
	var ret =  milesToLat * mileage / Math.cos(d2r*lat);
	return ret;
}



function dstBtwPoints(pointA,pointB){
	//return //diff between two points of latitude and longitutde by 
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
   
function drawCircles(data){ 
	var airportArray = [];
	airportArray = data.split("\n");
	var count = airportArray.length;
	
	for(var i = 0; i < count; i++){
		var temp = airportArray[i].split(",");
		var latLng = new GLatLng(parseFloat(temp[5]),parseFloat(temp[6])) ;
		var level = temp[7];
		var abbr = temp[1];
		var AP =  new Airport(latLng,level,abbr);
		var m2l = milesToLng(AP.latLng.lat(),bigRadius);
		
			
	   		var bigCircle = new CircleOverlay(AP.latLng,bCV[0],bCV[1],bCV[2],bCV[3],bCV[4],bCV[5]);
	   		var medCircle = new CircleOverlay(AP.latLng,mCV[0],mCV[1],mCV[2],mCV[3],mCV[4],mCV[5]);
	   		var smlCircle = new CircleOverlay(AP.latLng,sCV[0],sCV[1],sCV[2],sCV[3],sCV[4],sCV[5]);
	   		GEvent.addListener(smlCircle, "click", function() {
 				alert("You clicked the map.");
			});
	   		//medCircle.setLatLng(new GLatLng(AP.lat,AP.lng));
	   		//smlCircle.setLatLng(new GLatLng(AP.lat,AP.lng));
	   		//unless created new here... there will only be one.
  			//gm.setLatLng(new GLatLng(AP.lat,AP.lng));
	    	map.addOverlay(bigCircle);
	    	map.addOverlay(medCircle);
	    	map.addOverlay(smlCircle);	
		
	}
}

var Airport = function(latLng, level,abbr){
	this.latLng = latLng;
	this.level = level;
	this.abbr = abbr;
}


 // This file adds a new circle overlay to GMaps2
// it is really a many-pointed polygon, but look smooth enough to be a circle.
var CircleOverlay = function(latLng, radius, strokeColor, strokeWidth, strokeOpacity, fillColor, fillOpacity) {
    this.latLng = latLng;
    this.radius = radius;
    this.strokeColor = strokeColor;
    this.strokeWidth = strokeWidth;
    this.strokeOpacity = strokeOpacity;
    this.fillColor = fillColor;
    this.fillOpacity = fillOpacity;
}
// Implements GOverlay interface
CircleOverlay.prototype = GOverlay;

CircleOverlay.prototype.initialize = function(map) {
    this.map = map;
}

CircleOverlay.prototype.clear = function() {
    if(this.polygon != null && this.map != null) {
        this.map.removeOverlay(this.polygon);
    }
}

// Calculate all the points and draw them
CircleOverlay.prototype.redraw = function(force) {
    circleLatLngs = new Array();
    var circleLat = this.radius * milesToLat;  // Convert statute miles into degrees latitude
    var circleLng = circleLat / Math.cos(this.latLng.lat() * d2r);
    var numPoints = 20;
   
    // 2PI = 360 degrees, +1 so that the end points meet
    for (var i = 0; i < numPoints + 1; i++) {
        var theta = Math.PI * (i / (numPoints / 2));
        var vertexLat = this.latLng.lat() + (circleLat * Math.sin(theta));
        var vertexLng = this.latLng.lng() + (circleLng * Math.cos(theta));
        var vertextLatLng = new GLatLng(vertexLat, vertexLng);
        circleLatLngs.push(vertextLatLng);
    }
   
    this.clear();
    this.polygon = new GPolygon(circleLatLngs, this.strokeColor, this.strokeWidth, this.strokeOpacity, this.fillColor, this.fillOpacity);
    this.map.addOverlay(this.polygon);
}

CircleOverlay.prototype.remove = function() {
    this.clear();
}

CircleOverlay.prototype.containsLatLng = function(latLng) {
    // Polygon Point in poly
    if(this.polygon.containsLatLng) {
        return this.polygon.containsLatLng(latLng);
    }
}

CircleOverlay.prototype.setRadius = function(radius) {
    this.radius = radius;
}

CircleOverlay.prototype.setLatLng = function(latLng) {
    this.latLng = latLng;
}

   	load();
   	GDownloadUrl("js/airports2.csv", function(data, responseCode) {
  					drawCircles(data);
	});
  
  