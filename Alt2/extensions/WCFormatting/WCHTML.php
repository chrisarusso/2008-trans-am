<?php
require_once("extensions/City/City.php");
Class WCHTML{ 
	
	public $wcArt; //member article
	
	function __construct($article){
		$this->wcArt = $article;
		
	}
		
	public function getDining(){
		$ret = "dining in $title is so fun!!!";
		
		return $ret;
	}
	
	public function getInteriorLink($page, $city){ // STUBBED and probably should be used from elsewhere instead of re writing 
		global $wgScriptPath;
		global $wgTitle;
		return "$wgScriptPath/index.php/Category:$city->state/$city->city/$page";
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
	
	public function getStatePage(){
		
	}
	
	public function getCityPage($row){
		$City = new City();
		$city = substr($row->page_title,3); //getting rid of the stateAbbr and / so CT/Bristol becomes Bristol
		if($row->page_is_new == 1){
$ret = <<<EOD
<span class='founderText'>Congratulations,  $city has yet to be founded.  
<a href='http://somethingelse.com'>Become the founder now</a>!</span>
EOD;
		 }else{  
			
$ret = <<<EOD2
<div id="left">
				<ul>
					<li><a href="{$this->getInteriorLink('Residents', $City)}">Residents</a>: [ {$City->getResidentCount()} ]</li> 
					<li><a href="{$this->getInteriorLink('Societies', $City)}">Societies</a>: [ {$City->getSocietyCount()} ]</li>
					<li><a href=' {$this->getInteriorLink('Events', $City)} '>Events</a>: [  {$City->getEventsCount()} ]</li>
					<li><a href=' {$this->getInteriorLink('Photos', $City)} '>Photos</a>: [  {$City->getPhotosCount()} ]</li>
					<li><a href=' {$this->getInteriorLink('Gripe_Box', $City)} '>Gripe_Box</a>: [  {$City->getGripeCount()} ]</li>
					<li><a href=' {$this->getInteriorLink('Dining', $City)} '>Dining</a>: [  {$City->getDiningCount()} ]</li>
					<li><a href=' {$this->getInteriorLink('Entertainment', $City)} '>Entertainment</a>: [  {$City->getEntCount()} ]</li>
					<li><a href=' {$this->getInteriorLink('Living', $City)} '>Living </a>in  $City->city </li>	
				</ul>
			</div>
				
			<div id='topRight'>  {$this->getGMap()}  </div>
			<div id='bottomRight'> Middle Content like calendar of events </div>
			<div id='bottom'> This shouldn't be bottom but featured photos and crap like that should go somewhere on this page</div>
EOD2;
						
		} 
	
		return $ret;
		
	}
	
	
	public function getInteriorPage(){
		$title = $this->wcArt->mTitle->mTextform;
		$titPieces = explode("/", $title);
		switch($titPieces[2]){
			
			case 'Dining':
				return $this->getDining();
			case 'Entertainment':
				return $this->getEntertainment();
			case 'Events':
				return $this->getEvents();
			case 'Free Form':
				return $this->getFreeForm();
			case 'Gripe Box':
				return $this->getGripeBox();
			case "Life in $title":
				return $this->getLifeIn();
			case 'Photos':
				return $this->getPhotos();
			case 'Residents':
				return $this->getResidents();
			case 'Societies':
				return $this->getSocieties();
			default:
				return '';
			
		}
		
	} 
	
	public function getGMap($params =''){
	$gmapDiv = "<iframe width='420' height='420' frameborder='0' src='http://dev.tech9computers.com/map.html?api_key=sbyh1gvku9qlkdnm745hjzs5ljmgcszj&width=400&height=300'></iframe>";//<div id='GMap' ></div>";	
	$gmapScript = ' <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAA5rSiNSxNrO2ZRkz7Kn85chTJPcoKeHLnrBlCzckG1Yz5JcZYbRS231zqK9Mx_1Q4KWw2AyHpcXtMAQ"
	      type="text/javascript"></script>
	       <script type="text/javascript"> 
	              function load() {
	              document.getElementById("GMap").style.display = "block";
	      if (GBrowserIsCompatible()) {
	      	var map2 = new GMap2(document.getElementById("GMap"));
			map2.setCenter(new GLatLng(41.4411, -115.4444), 6);
			//map2.setMapType(G_SATELLITE_MAP);
			map2.addMapType(G_PHYSICAL_MAP);
			map2.addControl(new GLargeMapControl());
			map2.addControl(new GScaleControl());
			map2.addControl(new GHierarchicalMapTypeControl());
			map2.addControl(new GOverviewMapControl());
			map2.enableContinuousZoom();
			//map2.enableGoogleBar();
			map2.enableScrollWheelZoom();
	      	}}  load()</script>
			'; 
	
	return $gmapDiv . $gmapScript;
	}
		

	
}
?>