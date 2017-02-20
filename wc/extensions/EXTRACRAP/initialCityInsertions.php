<?php

/*
This is the script that inupts all of our cities and whatnot into the db.  As it stands all cities are in  3-28-08 with their interioir pages as well
I am giving more thought as to how each cities layout will be so as to not be automatically making too many pages each night.  No categories have
been set yet.
 */
$wgHooks['ArticleFromTitle'][] = 'writeTrial';


Class LoadDB{
	
	function __construct(){
		
	}
	
	public function loadStates(){
		
	}
}

function writeTrial(&$tit, &$art){
	
	ini_set("max_execution_time", 500000);
	ini_set("memory_limit","12000M");
	
/*	$loadEm = false	;
		
		$citySections = array('Societies', 'Events', 'Gripe Box', 'Dining', 'Entertainment', 'Photos', 'Free Form', 'Residents', 'Living'); //forgot life in
		$countySections = array('Societies', 'Events', 'Photos', 'Dining', 'Entertainment');
		$stateSections = array('Societies', 'Events', 'Photos');	
		
		foreach($citySections as $val){
			$art3 = new Article(Title::newFromText("District of Columbia/District of Columbia-County/Washington Navy Yard"));
			if($art3->exists()){
				
				echo 'it sure does';
				$art3->doDelete("Washington D.C. is a state county and city so we're just using city");
			}
		}
	if($loadEm){
		
			Proper query before translating to mw
		 * 
		 	select  stateAbbr, county, city, m.cityType
			from mayZips m, citySort c
			where m.cityType = c.cityType
			and
			order by zip, c.Val
		
		$dbr =& wfGetDB( DB_SLAVE );
		//$dbw = wfGetDB(DB_MASTER);
		//$dbChecker = wfGetDB( DB_SLAVE);
		$fields  = array( 'stateAbbr','county','city', 'mayZips.cityType');
		$from = array("mayZips", "citySort");
		$where = array('mayZips.cityType = citySort.cityType', 'mayZips.zip > 56670');
		//$dbCheckerSelect = array('page_namespace', 'page_title');
		$opt = array ('ORDER BY' => 'zip, citySort.Val');
		//$dbCheckerWhere = array("page_title" => '');
		$res = $dbr->select($from ,$fields, $where,'',$opt);  
		
		
		while ( $row = $dbr->fetchObject( $res ) ) { //each row in the zips table
												
			$title = $row->stateAbbr; // CT
			//$dbCheckerWhere['page_title'] = str_replace(" ","_",$title);					
			//if($dbChecker->numRows($dbChecker->select("page", $dbCheckerSelect, $dbCheckerWhere)) < 1){ // if state doesn't exist put it in
				
			$art = new Article(Title::newFromText("$title"));
			if(!$art->exists()){
				$art->doEdit("","", EDIT_NEW);
				foreach($stateSections as $val){
					$art = new Article(Title::newFromText("$title/$val"));
					$art->doEdit("", "", EDIT_NEW);
				}
			} 
			
			

			$title .=  "/" .$row->county . "-County"; // CT/Hartford-County
		//	$dbCheckerWhere['page_title'] = str_replace(" ","_",$title);					
			//if($dbChecker->numRows($dbChecker->select("page", $dbCheckerSelect, $dbCheckerWhere)) < 1){  // if stateAbbr/county-Counyty doesn't exist
				
			$art = new Article(Title::newFromText("$title"));
			if(!$art->exists()){
				$art->doEdit("","", EDIT_NEW);		
				foreach($countySections as $val){
					$art = new Article(Title::newFromText("$title/$val"));
					$art->doEdit("", "", EDIT_NEW);
				}			
				
			} // city management
			
			$title .= "/" .$row->city; // CT/Hartford-County/Bristol  ... append /cityName to previous
			//$dbCheckerWhere['page_title'] = str_replace(" ","_",$title);					
			//if($dbChecker->numRows($dbChecker->select("page", $dbCheckerSelect, $dbCheckerWhere)) < 1){ // if city doesn't exist  
				 //two options... make redirect or make regular page with 9 subcats.
			$art = new Article(Title::newFromText("$title"));
			if(!$art->exists()){
				if($row->cityType == 'D'){
					$temp = $title;  // used to write the proper title for a redirect in cityType = 'A'
					$art->doEdit('',"", EDIT_NEW ); //EDIT_UPDATE		
					
					foreach($citySections as $val){
						$art2 = new Article(Title::newFromText("$title/$val"));
						$art2->doEdit('',"", EDIT_NEW ); //EDIT_UPDATE
					}
				}else if($row->cityType == 'A'){
					$art3 = new Article(Title::newFromText("$title"));
					$art3->doEdit("#redirect [[$temp]]","", EDIT_NEW); 
				} //since we are sorting $temp should be left over previous Default name and is the proper redirect.
			}
			
		}


	
	$dbr->freeResult( $res );
	}
	
			*/	
	
		return true;
}
