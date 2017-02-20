<?php
/*
 * This is going to be the interface for all the city data in the db.  This will be responsible for the home city page.  e.g. CT/Bristol
 * and will have all of.  This should be the MODEL if you will and just provide WCHTML with the data for it to format.  So the two can be separated.
 * 
 * 
 * 
 */
//$wgHooks['ParserAfterTidy'][] = 'getFrontPage';


class City {
	
	public $state;
	public $city;
	
	function __construct(){ // should probably take aricle as a param and figure out which city it is.  STUBBED FOR NOW
		$this->city = 'Bristol';
		$this->state = 'CT';
		// preload whatever city it is in here with tthe data that city would have so not every method needs a param.
	}
	
	public function getCityUrl(){
		
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