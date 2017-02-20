function drawCircles(data, point){ 
	var airportArray = [];
	airportArray = data.split("\n");
	var count = airportArray.length;
	
	for(var i = 0; i < count; i++){
		var temp = airportArray[i].split(",");
		var latLng = new GLatLng(parseFloat(temp[5]),parseFloat(temp[6])) ;
		var level = temp[7];
		var abbr = temp[1];
		var AP =  new Airport(latLng,level,abbr);
		var m2l = milesToLng(AP.latLng.lat(),bCV[0]);
		
		
		// if an airport is within bigRadius miles in latitude or longitude we show it.
		if(Math.abs(AP.latLng.lat() - point.lat()) <= (bCV[0] * milesToLat) && Math.abs(AP.latLng.lng() - point.lng()) <= m2l){	
			if(AP.level == 1){
				var fillColor = '#BCCAE4';
			}else{
				var fillColor = '#FFB70D';
			}
			
			
	   		
	   			var bigCircle = new CircleOverlay(AP.latLng,bCV[0],bCV[1],bCV[2],bCV[3],fillColor,bCV[5]);
		   		var medCircle = new CircleOverlay(AP.latLng,mCV[0],mCV[1],mCV[2],mCV[3],fillColor,mCV[5]);
		   		var smlCircle = new CircleOverlay(AP.latLng,sCV[0],sCV[1],sCV[2],sCV[3],fillColor,sCV[5]);
		
  			var dst = dstBtwPoints(point,AP.latLng);
  			
  			overlayArray[overlayArray.length] = new Array(bigCircle, medCircle, smlCircle, dst, AP); 
	    	//map.addOverlay(bigCircle);
	    	//map.addOverlay(medCircle);
	    	//map.addOverlay(smlCircle);
	    	
		}
		//alert(overlayArray.length);
		
		
	}
		overlayArray.sort(sortByMinReq);
		for(var x=0; x<3; x++){
			if(x==0){
				var dst = overlayArray[x][3];
				var level = overlayArray[x][4];
				document.getElementById('help').innerHTML = showDstFrom(dst, address, level);
			}
			map.addOverlay(overlayArray[x][0]);
			map.addOverlay(overlayArray[x][1]);
			map.addOverlay(overlayArray[x][2]);
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
    var numPoints = 60;
   
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


function removeCircles(num){
	
	//for(var i in overlayArray)
		//alert(overlayArray[i][3]);
	//alert(dstBtwPoints(map.getCenter(),
	num = parseInt(num);
	//alert(num); 
	//alert(typeof num);
	if(num ==  "NaN"){
		alert(num + " is not a number");
	}else{
	
		for(var i = 0; i< num; i++){
				map.removeOverlay(overlayArray[0][0]);
				map.removeOverlay(overlayArray[0][1]);
				map.removeOverlay(overlayArray[0][2]);
				overlayArray.shift();
		}
	}			
}