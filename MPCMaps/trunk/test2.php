<html>
	<head>
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA5rSiNSxNrO2ZRkz7Kn85chQgPieDRzevs-0NI2utdy8M2R4YMxSGzIvgElD5bCgZcpMdWYjjqrixrA"
	      type="text/javascript"></script>
	    																
	</head>
	<body>
		<label>Enter Address to determine minimum chickens you must purchase to ensure their survival!</label>
		<input type="text" name="location" id="location" onfocus="this.value = ''" value="enter address here"/>
		<input type="button" onclick="minPurchFromAdd(document.getElementById('location').value)" value="show" />
		<br>Minimum purchase requirement for (<span id='add'></span>): 
		<span style="font-size:1.1em;font-weight:bold" id="result"></span>
		<br><br><div style="width:1000px;height:500px" id="gMap"></div>
		<script type="text/javascript" src="js/circle.js">
		</script>
		<script type="text/javascript" src="js/distance.js">
		</script>
		<script type="text/javascript" src="js/config.js">
		</script>
	</body>
</html>	