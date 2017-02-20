<?php
require_once("County.php");
Class State {
	protected $lat, $lon, $name, $id;
	protected $striz = 'stiz';
	
	
	protected $sections = array("Events", "Societies", "Photos");
	private $abbr;
	
	function __construct($page_id){
		$this->loadData($page_id);
	}
	
	
	
	public function loadData($page_id){ //constructor calls this to get city staet name, lat, lon etc.

		$dbr =& wfGetDB( DB_SLAVE );
		$fields  = array( 'state.*');
		$from = array("state", "page");
		$where = array("state.page_id = $page_id", 'state.page_id = page.page_id');
		$res = $dbr->selectRow($from ,$fields, $where);  
		
		$this->name = $res->name;
		$this->lat = $res->lat;	
		$this->lon = $res->lon;
		$this->abbr = $res->abbr;
		$this->id = $res->state_id;
		
		
	}	
		
	
	
	public function getSocieties(){
		//should have the 3 in here that apply to all... and then the other 2 in county... and then the remainders in city
	}
	
	public function getSections(){
		return $this->sections;
	}
	
	public function getLat(){
		return $this->lat;	
	}
	
	public function getLon(){
		return $this->lon;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getID(){
		return $this->id;
	}
	public function getAbbr(){
		return $this->abbr;	
	}
	public function getInteriorLink($subPage, $linkText = ""){
		global $wgTitle;
		$l = new Linker();
		if($linkText == ""){
			$linkText = $subPage;	
		}
		return $l->makeLinkObj(Title::newFromText($wgTitle . "/$subPage"), $linkText );
	}
	public function getHTML(){
		
		$ret = "State name = {$this->getName()} <Br>";
		$ret .= "State Lat = {$this->getLat()} <br>";
		$ret .= "State Lon = {$this->getLon()} <br>";
		$ret .= "State Abbr = {$this->getAbbr()} <br>";
		$ret .= $this->getGMap();
		
		foreach($this->getSections() as $val){
			$ret .= $this->getInteriorLink($val, "$val in {$this->getName()}" ) ."<br>";
		}
		
		$ret .= "<br> Counties <hr>";
		
		foreach($this->getCounties() as $val){
			$ret .= $this->getInteriorLink($val->name . "-County") . "<br>	";
		}
		
		return $ret;
	}
	
	public function getGMap(){
		$gmapDiv = "<div style='width:40%;height:200px' id='GMap'></div>";	
		
	
	return $gmapDiv . $this->getGMapScript();
	}


	public function getGMapZoom(){
		return 10;
	}
	
	
	public function getGMapScript(){
		
		$ret = ' <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAA5rSiNSxNrO2ZRkz7Kn85chTJPcoKeHLnrBlCzckG1Yz5JcZYbRS231zqK9Mx_1Q4KWw2AyHpcXtMAQ"
	      type="text/javascript"></script>
	       <script type="text/javascript"> 
	              function load() {
	              document.getElementById("GMap").style.display = "block";
	      if (GBrowserIsCompatible()) {
	      	var map2 = new GMap2(document.getElementById("GMap"));
			map2.setCenter(new GLatLng('.$this->getLat().', '.$this->getLon().'), '.$this->getGMapZoom().');
			//map2.setMapType(G_SATELLITE_MAP);
			map2.addMapType(G_PHYSICAL_MAP);
			map2.addControl(new GLargeMapControl());
			map2.addControl(new GScaleControl());
			map2.addControl(new GHierarchicalMapTypeControl());
			map2.addControl(new GOverviewMapControl());
			map2.enableContinuousZoom();
			//map2.enableGoogleBar();
			map2.enableScrollWheelZoom();
	      	}}  load()
	      	</script>
			'; 
			//ret is replaced because it is slow and also needs to be at the bottom of the page
			$ret = '';
		return $ret;
	}
	
	public function getCounties(){
		$dbr =& wfGetDB( DB_SLAVE );
		$fields  = array( 'county.*');
		$from = array("state", "county");
		$where = array("state.state_id = county.state_id", "state.state_id = {$this->getID()}");
		$res = $dbr->select($from ,$fields, $where);  
		
		while ( $row = $dbr->fetchObject( $res ) ) {
			$counties[] = $row;
		}
		return $counties;
	}
	
	
}


		
	
