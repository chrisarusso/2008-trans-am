<?php
$conn = mysql_connect("mysql.wikicommunity.org","root2", 'r00tb33r');
$db = mysql_select_db("track3r");
	
$query =  'select lat ,  lon, time2  from tracking2 where (id % 30 = 0) 
or (id 
= 1) or (id % 5 = 0 and substring(time2,1,5) = (select 
max(substring(time2,1,5)) from 
tracking2) or id = (select max(id) from tracking2))';
$res = mysql_query($query);


		while($row = mysql_fetch_object($res)){
			$arr[] = array($row->lat, $row->lon, $row->time2);
		}
		
		$mostRecent = $arr[count($arr)-1][2];

		
		
		echo '<?xml version="1.0" encoding="ISO-8859-1"?>
				<markers>';

        if(is_array($arr)){
		foreach($arr as $key => $val){
				echo "<marker time=\"{$val[2]}\" lat=\"{$val[0]}\" lon=\"{$val[1]}\" />\n";
			
		}
        }
		
		echo "</markers>";
