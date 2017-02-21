

var colorsArray = ["#ff0000","#00ff00","#0000ff","#ffff00"];
var center = {lat: 37.493138, lng: -97.459141};
var map = new google.maps.Map(document.getElementById('map'), {
  zoom: 4,
  center: center
});

// Retrieve markers from XML file
$.get( "marker.xml", function( data, status, xhr ) {
  $xml =  $( $.parseXML( xhr.responseText ) );
  var markers = $xml.find("marker");
  var days = [];

  // Loop through markers and draw path
  for (var i = 0; i < markers.length; i++) {
    // day becomes 5/19 for May 19th
    var day = markers[i].getAttribute("time").split("/")[0] + markers[i].getAttribute("time").split("/")[1];
    var point = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")),parseFloat(markers[i].getAttribute("lon")));

    if (i == 0) {
      var image = {
        url: '/wcFinalSmall_60x54.png'
      };

      var beginning = new google.maps.Marker({
        position: point,
        map: map,
        title: 'Hello World!',
        animation: google.maps.Animation.DROP,
        icon: image,
        title: "The motha-truckin' beginning!"
      });

      var beginningString =
          '<h1 id="firstHeading" class="firstHeading">The beginning!</h1>'+
          '<div id="bodyContent">'+
          'We ate, we pedaled, we conqured: starting in Key West, FL!'+
          '</div>';

      var infowindow = new google.maps.InfoWindow({
        content: beginningString
      });

      beginning.addListener('click', function() {
        infowindow.open(map, beginning);
      });
    }
    else if(i == (markers.length - 1)){

      setTimeout(function() {
        addEndingMarker(point);
      }, 1500);

    }

    if(day != previousPointDay){
      // Add a new day
      days[days.length] = [];
      days[days.length-1][0] = point;
    }
    else {
      days[days.length -1][days[days.length -1].length] = point;
    }

    var previousPointDay = day;

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
  }

});

function addEndingMarker(point){

  var endString =
      '<h1 id="firstHeading" class="firstHeading">The end!</h1>'+
      '<div id="bodyContent">'+
      'Four months and 6,000 miles later we arrived in San Diego.'+
      'The <i>slightly</i> longer 250+ page printed version can be read at the <a href="/blog">blog</a>.'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
    content: endString
  });

  var end = new google.maps.Marker({
    position: point,
    map: map,
    title: 'Hello World!',
    animation: google.maps.Animation.DROP,
    //icon: image,
    title: "The motha-truckin' end!"
  });

  end.addListener('click', function() {
    infowindow.open(map, end);
  });

}