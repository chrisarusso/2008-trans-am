var bigRadius = 50;
var smlRadius = 25;
var d2r = Math.PI / 180; //degrees to radians used in several functions
var milesToLat = 0.014483;
var map = new GMap2(document.getElementById("gMap"));

function dstBtwPoints(pointA,pointB){
	return pointA.distanceFrom(pointB) / 1609.344; //distanceFrom is a google function
}

var Address = function(string, latLng){
	this.string = string;
	this.latLng = latLng;
}

function minPurchFromAdd(add){
	var geocoder = new GClientGeocoder();
  	geocoder.getLatLng(add, 
  		function(point) {
    		if (!point) {
        		alert(add + " not found");
        		document.getElementById('result').innerHTML = "";
        		document.getElementById('add').innerHTML = "";
      		} else {
      			load(point);
      			
      			
      			
      			GDownloadUrl("js/airports2.csv", function(data, responseCode) {
      				var Add = new Address(add,point);
  					document.getElementById('result').innerHTML = showMinPurch(data, Add);
  					document.getElementById('add').innerHTML = add;
				});
				

       		}
    	}
  	);
  	
}
  
function milesToLng(lat, mileage){
	var ret =  milesToLat * mileage / Math.cos(d2r*lat);
	return ret;
}

function showMinPurch(data, Add){
	var airportArray = [];
	airportArray = data.split("\n");
	var count = airportArray.length;
	for(var i = 0; i < count; i++){
		var temp = airportArray[i].split(",");
		var latLng = new GLatLng(parseFloat(temp[5]),parseFloat(temp[6])) ;
		var level = temp[7];
		var abbr = temp[1];
		var AP =  new Airport(latLng,level,abbr);
		var m2l = milesToLng(AP.latLng.lat(),50);
		
		var dst = dstBtwPoints(Add.latLng,AP.latLng);
		airportArray[i] = new Array(AP, dst);
		
	}
		airportArray.sort(sortByMinReq); //sort by closest minimum purchase airport
		
		//if its an 8er let's just go to the closest airport distance-wise
		var minP = minPurch(airportArray[0][1],airportArray[0][0].level);
		if(minP == 8){	
			airportArray.sort(sortByDst);	
		}
		
		var fillColor = '#BCCAE4';
	
  		var bigCircle = new CircleOverlay(airportArray[0][0].latLng,bCV[0],bCV[1],bCV[2],bCV[3],fillColor,bCV[5]);
   		var medCircle = new CircleOverlay(airportArray[0][0].latLng,mCV[0],mCV[1],mCV[2],mCV[3],fillColor,mCV[5]);
   		var smlCircle = new CircleOverlay(airportArray[0][0].latLng,sCV[0],sCV[1],sCV[2],sCV[3],fillColor,sCV[5]);
		   		
		//plot closest airport   		
		map.addOverlay(bigCircle);
		map.addOverlay(medCircle);
		map.addOverlay(smlCircle);
		
		var gi = new GIcon(G_DEFAULT_ICON);
      	gi.image = "http://www.mypetchicken.com/images/chickenPix/cheggenSM.jpg";
     	gi.iconSize = new GSize(32, 47);
		markerOptions = { icon:gi };
     	var marker = new GMarker(Add.latLng, markerOptions);
    	var markerText = "The minimum purchase for the address " +
    	"of " + Add.string +  " is: " + minP +" <br> <a href='javascript:map.panTo(new GLatLng"
    	+ airportArray[0][0].latLng +")'>Click here to go to closest shipping center</a><br>Note: " +
    	"Minimum purchases tend to be less when shipped closer to shipping centers.  If you would " +
    	"like to purchase fewer chickens try a friend's or relative's address who lives closer to a " +
    	"shipping center or, find all shipping centers within x miles (could have a quick script that " +
    	"lets them enter a number in miles and pops up all shipping centers)<br><br><br>";
     	
     	     	iWOpt = {maxContent :markerText};
     	
      	map.addOverlay(marker);
      	marker.openInfoWindow(markerText, iWOpt);
		var iW = map.getInfoWindow();
		iW.maximize();      			
		return minP;	
}

function minPurch(dst, level){
	var ret = 8;
	
	if(level == 1){
		if(dst <= smlRadius){
			ret = 3;
		}else if(dst <= bigRadius){
			ret = 5;
		}
	}else if(level == 2){
		if(dst <= smlRadius){
			ret = 5;
		}
	}
	
	return ret;	
}
function sortByMinReq(a,b){
	var a = minPurch(a[1],a[0].level);
	var b = minPurch(b[1],b[0].level);
	return a-b;
}
		
function sortByDst(a,b){
	var a = a[1];
	var b = b[1];
	return a-b;
}

function load(point) {
	if (GBrowserIsCompatible()) {
		map.setCenter(point, 7);
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
		