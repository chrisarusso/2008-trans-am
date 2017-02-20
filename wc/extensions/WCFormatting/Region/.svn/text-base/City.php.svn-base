<?php

require_once("County.php");

class City extends County{
	
	protected $county_id;
	protected $sections = array("Events", "Societies", "Photos", "Free Form", "Living", "Dining", "Entertainment", "Gripe Box", "Residents");
	
	function __construct($page_id){
			parent::__construct($page_id);
	}
	
	public function loadData($page_id){ //constructor calls this to get city staet name, lat, lon etc.
	
		$dbr =& wfGetDB( DB_SLAVE );
		$fields  = array( 'city.*');
		$from = array("city", "page", "county");
		$where = array("city.page_id = $page_id", 'city.county_id = county.county_id');
		$res = $dbr->selectRow($from ,$fields, $where);  
		
		$this->name = $res->name;
		$this->lat = $res->lat;	
		$this->lon = $res->lon;
		$this->id = $res->city_id;
		$this->county_id = $res->county_id;
		
	}
	
	public function getNickNames(){
		$dbr =& wfGetDB( DB_SLAVE );
		$fields  = array( 'distinct zip.name');
		$from = array("zip");
		$where = array("zip.city_id = {$this->getID()}", "cityType = 'A'");
		$opt = array('ORDER BY' => "name");
		$res = $dbr->select($from ,$fields, $where, "", $opt);  
		while ( $row = $dbr->fetchObject( $res ) ) {
			
			$zips[] = $row->name;
		}
		return $zips;
	}
	public function getHTML(){
		$ret = "City name = {$this->getName()} <Br>";
		foreach($this->getNickNames() as $val){
			$ret .= $val . "<br>";
		}
		$ret .= "City Lat = {$this->getLat()} <br>";
		$ret .= "City Lon = {$this->getLon()} <br>";
		$ret .= $this->getGMap();
		
		foreach($this->getSections() as $val){
			$ret .= $this->getInteriorLink($val, "$val in {$this->getName()}") . "<br>";
		}
		
		$ret .= "<br> Zips <hr>";
		
		foreach($this->getZips() as $val){
			$ret .= $this->getInteriorLink($val->name, $val->zip) . "<br>";
		}
		
		return $ret;
	}
	
	public function getZips(){
	$dbr =& wfGetDB( DB_SLAVE );
		$fields  = array( 'zip.*');
		$from = array("city", "zip");
		$where = array("city.city_id = zip.city_id", "city.city_id = {$this->getID()}");
		$res = $dbr->select($from ,$fields, $where);  
		
		while ( $row = $dbr->fetchObject( $res ) ) {
			$zips[] = $row;
		}
		return $zips;
	
	
	}
	public function getSocietyCount(){
		return '12';
	}
	
	public function getSocietyTease(){
		return array("teaser text 1", "teaser text2", "teaser text3");
	}
	public function getEventsCount(){
		return '50';
	}
	
	public function getEventsTease(){
		return array("teaser text 1", "teaser text2", "teaser text3");
	}
	
	public function getResidentCount(){
		return '40';
	}
	
	public function getResTease(){
		return array("teaser text 1", "teaser text2", "teaser text3");		
	}
	
	public function getDiningCount(){
		return '2';
	}
	
	public function getDiningTease(){
		return array("teaser text 1", "teaser text2", "teaser text3");
			
	}
	
	public function getEntCount(){
		return '4';
	}
	
	public function getEntTease(){
		return array("teaser text 1", "teaser text2", "teaser text3");
			
	}
	
	public function getGripeCount(){
		return '8';
	}
	
	public function getGripeTease(){
		return array("teaser text 1", "teaser text2", "teaser text3");
			
	}
	
	public function getPhotosCount(){
		return '9';
	}
	
	public function getPhotosTease(){
		return array("teaser text 1", "teaser text2", "teaser text3");
		
	}

	public function getCoords(){
			
	}
	
	public function getNames(){
		
	}
}
?>