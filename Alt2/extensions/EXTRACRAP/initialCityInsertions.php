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
	
	ini_set("max_execution_time", 50000);
	ini_set("memory_limit","1200M");
	
	$loadEm = false	;
	if($loadEm){
	
		$dbr =& wfGetDB( DB_SLAVE );
		$dbw = wfGetDB(DB_MASTER);
		$dbChecker = wfGetDB( DB_SLAVE);
		$select  = array( 'stateAbbr','county','city', 'cityType');
		$dbCheckerSelect = array('page_namespace', 'page_title');
		$opt = array ('GROUP BY' => 'stateAbbr,county,city',  'ORDER BY' => 'stateAbbr, county, city');
		$dbCheckerWhere = array("page_title" => '', 'page_namespace' => 14);
		$res = $dbr->select("zips_final_final",$select, '','',$opt);  
		
		$sections = array('Societies', 'Events', 'Gripe Box', 'Dining', 'Entertainment', 'Photos', 'Free Form', 'Residents', 'Living'); //forgot life in
			
		while ( $row = $dbr->fetchObject( $res ) ) { //each row in the zips table
				/*								
			$title = $row->stateAbbr; // CT
			$dbCheckerWhere['page_title'] = str_replace(" ","_",$title);					
			if($dbChecker->numRows($dbChecker->select("page", $dbCheckerSelect, $dbCheckerWhere)) < 1){ // if state doesn't exist put it in
				
				$art = new Article(Title::newFromText("Category:$title"));
				$art->doEdit("","", EDIT_NEW);
			} 
			
			$art2 = new Article(Title::newFromText("Category:dddummydata"));
					echo $art2->getID() . ' article id 1st round is that';
					$art2->doEdit("dummy text",'debugging');
					echo "\n Next time... do ew have it yet?" . $art2->getID();
					break;
		

			$title = $row->stateAbbr . "/County:" .$row->county; // CT/Bristol
			$dbCheckerWhere['page_title'] = str_replace(" ","_",$title);					
			if($dbChecker->numRows($dbChecker->select("page", $dbCheckerSelect, $dbCheckerWhere)) < 1){  // if state/county doesn't exist
				
				$art = new Article(Title::newFromText("Category:$title"));
				$art->doEdit("","", EDIT_NEW);					
				
			} // city management
			
			$title = $row->stateAbbr . "/" .$row->city; // CT/Bristol
			$dbCheckerWhere['page_title'] = str_replace(" ","_",$title);					
			if($dbChecker->numRows($dbChecker->select("page", $dbCheckerSelect, $dbCheckerWhere)) < 1){ // if city doesn't exist  
				 //do redirect page
			
				 
						
			*/
			if($row->cityType == 'D'){
				$title = $row->stateAbbr . "/" .$row->city; // CT/Bristol
				foreach($sections as $val){
					$art2 = new Article(Title::newFromText("Category:$title/$val"));
					if(!$art2->exists())
					$art2->doEdit('',"", EDIT_NEW ); //EDIT_UPDATE
				}
			}
			//}
			
			
		}
	$dbr->freeResult( $res );
	}
	
				
	
		return true;
}
?>