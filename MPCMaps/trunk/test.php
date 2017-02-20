<html>
	<head>
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA5rSiNSxNrO2ZRkz7Kn85chQgPieDRzevs-0NI2utdy8M2R4YMxSGzIvgElD5bCgZcpMdWYjjqrixrA"
	      type="text/javascript"></script>
	    																
	</head>
	<body>
		<h1>MPC Google Map</h1>
		<form method="post" action="nothing" onsubmit="return isValidAdd(document.getElementById('location').value)">
			<input type="text" name="location" id="location" onfocus="this.value = ''" value="enter address here"/>
			<input type="button" onclick="isValidAdd(document.getElementById('location').value)" value="show map" />
		</form>
			<input type="text" name="removeNum" id="removeNum" />
			<input type="button" onclick="removeCircles(document.getElementById('removeNum').value)"  value="remove airports" />
		
			<table border="1" style="border:1px solid black;margin:10px">
			<tr><td colspan="3">Key / Legend</td>
			</tr>
			<tr>
				<td>Fill Color</td>
				<td>Level</td>
				<td>Minimum Purchase <60,<40,<25 (distance in miles)</td>
			</tr>
			<tr>
				<td style="background-color:#BCCAE4"></td>
				<td>Level 1</td>
				<td>8,5,3</td>
			</tr>
			<tr>
				<td style="background-color:#FFB70D"></td>
				<td>Level 2</td>
				<td>8,7,5</td>
			</tr>
			</table>
			<div id="help"></div>
			<div id="gMap" style="width:1000px;height:500px"></div>
		<script type="text/javascript" src="js/MPCMap1.js">
		</script>
		<script type="text/javascript" src="js/config.js">
		</script>
	</body>
	<script type="text/javascript"> load(); </script>
</html>