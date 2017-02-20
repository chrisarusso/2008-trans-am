<?php

require_once("State.php");

Class County extends State{
	
	protected $state_id;
	protected $sections = array("Events", "Societies", "Photos", "Dining", "Entertainment");
	
	function __construct($page_id){
			parent::__construct($page_id);
	}
	
	public function loadData($page_id){ //constructor calls this to get city staet name, lat, lon etc.

		
		$dbr =& wfGetDB( DB_SLAVE );
		$fields  = array( 'county.*' , 'state.name sName');
		$from = array("county", "page", "state");
		$where = array("county.page_id = $page_id", 'county.page_id = page.page_id' , "state.state_id = county.state_id");
		$res = $dbr->selectRow($from ,$fields, $where);  
		
		$this->name = $res->name;
		$this->lat = $res->lat;	
		$this->lon = $res->lon;
		$this->id = $res->county_id;
		$this->state_id = $res->state_id;
		
		
	}	
	
	public function getHTML(){
		$ret = "County name = {$this->getName()} <Br>";
		$ret .= "County Lat = {$this->getLat()} <br>";
		$ret .= "County Lon = {$this->getLon()} <br>";
		$ret .= $this->getGMap();
		
	
		foreach($this->getSections() as $val){
			$ret .= $this->getInteriorLink($val, "$val in {$this->getName()} County") . "<br>";
		}
		
		$ret .= "<br> Cities <hr>";
		
		foreach($this->getCities() as $val){
			 
			$ret .= $this->getInteriorLink($val->name) . "<br>	";
		}
		
		return $ret;
	}
	
	public function getCities(){
	$dbr =& wfGetDB( DB_SLAVE );
		$fields  = array( 'city.*');
		$from = array("city", "county");
		$where = array("city.county_id = county.county_id", "county.county_id = {$this->getID()}");
		$res = $dbr->select($from ,$fields, $where);  
		
		while ( $row = $dbr->fetchObject( $res ) ) {
			$cities[] = $row;
		}
		return $cities;
	
	}
	
}


/*
public function getDining(){
	
	
	$ret = "dining in $title is so fun!!!";
		
		return $ret;
	}

	public function getEntertainment(){
		$ret = "ent in $title is so fun!!!";
		
		return $ret;
	}
	
	public function getEvents(){
		$ret = "events in $title is so fun!!!";
		
		return $ret;
	}
	
	public function getFreeForm(){
		$ret = "free form in $title is so fun!!!";
		
		return $ret;
	}
	
	public function getGripeBox(){
		$ret = "gripes in $title is so fun!!!";
		
		return $ret;
	}
	
	public function getLifeIn(){
		$ret = "lives in $title is so fun!!!";
		
		return $ret;
	}
	
	public function getPhotos(){
		$ret = "photos in $title is so fun!!!";
		
		return $ret;
	}
	
	public function getResidents(){
		$ret = "residents in $title is so fun!!!";
		
		return $ret;
	}
	
	public function getSocieties(){
		global $wgUser, $wgScriptPath;
		//lets write all of our scripts in js... and then do an include before or afterthe rendered stuff here if need be.
		$socScript = "<script src='$wgScriptPath/extensions/WCFormatting/societies.js'></script>";
		
		$socHTML = "<div id='left'>
						Join a group 
						<ul>
							<li> Cat 1 </li>
							<li> Cat 2 </li>
							<li> Cat 3 </li>
							<li> Cat n </li>
							<li> Cat this should be category tree tag </li>
						<ul>
					</div>
					<div id='topRight'>
						<td> <a href='javascript:show();' >Create</a> a group<br> 
						<div id='expand' style='height:150px;display:none;'><form action='http://google.com' method=''>
						Name: <input type='text'><br />  
						Creator: <input disabled='true' type='text' value=".$wgUser->getName()."><br />
						Location: <br>
						State : <input disabled='true' type='text' value='CT'><br />
						Ctiy : <input disabled='true' type='text' value='Bristol'><br />
						Contact: <input id='email' disabled='true' type='text' value=".$wgUser->getEmail().">
						<a href='javascript:changeEmail()'>Change</a> (for email distro lists, etc.)<br />
						</form>
						</div>";
		
		return $socScript . $socHTML;
	}
	
	*/