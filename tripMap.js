// Create our "wc" marker icon
var wcIcon = new GIcon();
wcIcon.image = "http://wikicommunity.org/wcFinalSmall.png";
wcIcon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
wcIcon.iconSize = new GSize(60, 60);
wcIcon.shadowSize = new GSize(22, 20);
wcIcon.iconAnchor = new GPoint(6, 20);
wcIcon.infoWindowAnchor = new GPoint(5, 1);
var redIcon = MapIconMaker.createMarkerIcon({width: 32, height: 32, primaryColor: "#ff0000"});
var blueIcon = MapIconMaker.createMarkerIcon({width: 32, height: 32, primaryColor: "#0000ff"});
var yellowIcon = MapIconMaker.createMarkerIcon({width: 50, height: 50, primaryColor: "#ffff00"});
var greenIcon  = MapIconMaker.createMarkerIcon({width: 50, height: 50, primaryColor: "#00ff00"});
// Set up our GMarkerOptions object literal

mostRecentIcon = { icon:wcIcon }
todayIcon = { icon:yellowIcon }
oddIcon = { icon:blueIcon }
evenIcon = { icon:redIcon }
firstIcon = { icon:greenIcon }

var colorsArray = ["#ff0000","#00ff00","#0000ff","#ffff00"];
var map = new GMap2(document.getElementById("map_canvas"));
map.addControl(new GSmallMapControl());
map.addControl(new GMapTypeControl());
map.addControl(new GScaleControl());
var point = new GLatLng(37.493138, -97.459141);
map.setCenter(point, 4);


GDownloadUrl("displayMarkers.php", function(data, responseCode) {
  var xml = GXml.parse(data);
  var markers = xml.documentElement.getElementsByTagName("marker");
  var days = [];
  //var today = markers[markers.length - 1].getAttribute("time").split("/")[1];
  //need to concat month and day
  var polyline = [];
  for (var i = 0; i < markers.length; i++) {
    var day = markers[i].getAttribute("time").split("/")[0] + markers[i].getAttribute("time").split("/")[1];
    var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),parseFloat(markers[i].getAttribute("lon")));
    polyline[i] = point;
    if(day != lastDay){
      days[day] = [];
    }
    var lastDay = day;
    days[day][days[day].length] = point;


    if(i==0){
      map.addOverlay(new GMarker(point, firstIcon));
    }else if(i == (markers.length - 1)){
      map.addOverlay(new GMarker(point, mostRecentIcon));
    }

  }

  for(i in days){
    var dayPath = new GPolyline(days[i], colorsArray[0] ,7,.7);
    var newLast = colorsArray.shift();
    colorsArray[colorsArray.length] = newLast;
    map.addOverlay(dayPath);

  
  }

});
