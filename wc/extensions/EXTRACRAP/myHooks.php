<?php

// Stuff needs to be rewritten, and cleaned up.
function unprotect2(&$article, &$user, &$text, &$summary, $minor, $watch, $sectionanchor, &$flags) { 
	$article->unprotect();
	return true;	
	
}

function makeMayor(){
	global $wgUser;
	$_SESSION['mayor'] = $wgUser;
	return true;
}

function getAllStates(){
	mysql_connect('localhost', 'root', 'root');
	mysql_select_db('wikidb');
	$sql = 'select distinct state from zips_test order by state';
	$queryResult = mysql_query($sql);
		$ret = '<option selected> Select your state </option>';
	while($row = mysql_fetch_object($queryResult)){
		$ret .= "<option> $row->state </option>";
	}
	return $ret;
}

function getAllCities($state){
	mysql_connect('localhost', 'root', 'root');
	mysql_select_db('wikidb');
	$sql = "select city from zips_test where
			state = '$state'";
	$queryResult = mysql_query($sql);
	$ret = '<option selected> Select your city </option>';
	while($row = mysql_fetch_object($queryResult)){
		$ret .= "<option> $row->city </option>";
	}
	return $ret;
}

?>