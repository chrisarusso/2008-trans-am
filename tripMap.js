
/*var wcIcon = new GIcon();
wcIcon.image = "http://wikicommunity.org/wcFinalSmall.png";
wcIcon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
wcIcon.iconSize = new GSize(60, 60);
wcIcon.shadowSize = new GSize(22, 20);
wcIcon.iconAnchor = new GPoint(6, 20);
wcIcon.infoWindowAnchor = new GPoint(5, 1);
*/

var redIcon = MapIconMaker.createMarkerIcon({width: 32, height: 32, primaryColor: "#ff0000"});
var blueIcon = MapIconMaker.createMarkerIcon({width: 32, height: 32, primaryColor: "#0000ff"});
var yellowIcon = MapIconMaker.createMarkerIcon({width: 50, height: 50, primaryColor: "#ffff00"});
var greenIcon  = MapIconMaker.createMarkerIcon({width: 50, height: 50, primaryColor: "#00ff00"});
// Set up our GMarkerOptions object literal
  /*
mostRecentIcon = { icon:wcIcon }
todayIcon = { icon:yellowIcon }
oddIcon = { icon:blueIcon }
evenIcon = { icon:redIcon }
firstIcon = { icon:greenIcon }

*/
var colorsArray = ["#ff0000","#00ff00","#0000ff","#ffff00"];
var center = {lat: 37.493138, lng: -97.459141};

var map = new google.maps.Map(document.getElementById('map'), {
  zoom: 4,
  center: center
});


$.get( "displayMarkers.php", function( data ) {
  $xml =  $( $.parseXML( data ) );
  var markers = $xml.find("marker");
  // 4271 alert(markers.length);
  var days = [];
  //var today = markers[markers.length - 1].getAttribute("time").split("/")[1];
  //need to concat month and day


  for (var i = 0; i < markers.length; i++) {
    // day becomes 5/19 for May 19th
    var day = markers[i].getAttribute("time").split("/")[0] + markers[i].getAttribute("time").split("/")[1];
    var point = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")),parseFloat(markers[i].getAttribute("lon")));

    if(day != previousPointDay){
      // Add a new day
      days[days.length] = [];
      days[days.length-1][0] = point;
    }
    else {
      days[days.length -1][days[days.length -1].length] = point;
    }

    var previousPointDay = day;
    //days[day][days[day].length] = point;

    if(i==0){
      //map.addOverlay(new GMarker(point, firstIcon));
    }else if(i == (markers.length - 1)){
      //map.addOverlay(new GMarker(point, mostRecentIcon));
    }

  }


  for(var i = 0;  i < days.length; i++) {
    // Switch color each time
    var newLast = colorsArray.shift();
    colorsArray[colorsArray.length] = newLast;
    var polyline = new google.maps.Polyline({
      strokeColor: newLast,
      strokeOpacity: 1,
      strokeWeight: 2,
      geodesic: true
    });

    var path = polyline.getPath();
    polyline.setMap(map);

    for(var p = 0; p < days[i].length; p++) {
      // Add points!
      path.push(days[i][p]);
    }

    //var dayPath = new GPolyline(days[i], colorsArray[0] ,7,.7);
  }

});
