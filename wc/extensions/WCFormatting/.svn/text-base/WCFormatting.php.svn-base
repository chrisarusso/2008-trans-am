<?php
$wgHooks['ArticlePageDataAfter'][] = 'whichTemplate';
// this is meant to intercept the article through the title and decide how to handle it.
// it basically just sticks in html to an additional global variable to the skin.
// shold we do it another way?  It is done after article is loaded so that we can get the id
// from the db so we can match it to our state, county, or city.

function whichTemplate(&$art, &$row) { 
$subSections = array("Events", "Societies", "Photos", "Free Form", "Living", "Dining", "Entertainment", "Gripe Box", "Residents");
	global $wcTemp; 
	
	$tit = $art->mTitle;
		if($art->exists()){ // else it should be handled differently because it's some non - regular page.
			$titPieces = explode("/",$tit->mUrlform);
			if(in_array($titPieces[count($titPieces) - 1], $subSections)){//its a subpage 
				switch(count($titPieces)){
					case 2: //state sub
						break;
					case 3: //county sub
						break;
					case 4: //city sub
						break;
					default://error
						break;
				}
			}else{
				switch(count($titPieces)){
					case 1: //state home
						require_once("Region/State.php");
						if($art->mTitle != "Main Page"){
							$state = new State($art->getID());
							$wcTemp['wCAddIns'] = $state->getHTML();	
						}
						break;			
					case 2: //county home
						require_once("Region/County.php");
						$county = new County($art->getID());
						$wcTemp['wCAddIns'] = $county->getHTML();			
						break;
					case 3: //city home
						require_once("Region/City.php");
						$city = new City($art->getID());
						$wcTemp['wCAddIns'] = $city->getHTML();			
						break;
					default://error
						break;
				}
			}
	
			
			
		}else{
			// we should be doing something here because these will be the non city pages fror help and such....
		}
	
	
	return true;
}

/*
 * just saving heredoc syntax... might be nice for long html	
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
		
*/
 

	