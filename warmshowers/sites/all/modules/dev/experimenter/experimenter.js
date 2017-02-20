

/* $Id: experimenter.js 371 2007-10-18 15:47:58Z rfay $ */
function select_textfield() {
	var obj = $('#edit-textfield')[0];
	obj.select();
}


$(document).ready( function() {
	$("#wsmap_map").bind("loadMarkersComplete", 
		function (event, message) {
  			alert(message);
		}
		);
} );
	
