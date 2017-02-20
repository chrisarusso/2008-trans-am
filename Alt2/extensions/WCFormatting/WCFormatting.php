<?php
require_once("WCHTML.php");
$wgHooks['ArticlePageDataAfter'][] = 'whichTemplate';

// DONT FORGET TO USE the hook that adds js stuff that we'll need depending on the page.  We can have some logic here and attach it to the 
// beforecontentload hook as a js include.


//Changed from the hook called before so that we don't load the article twice.  We'll let MW do what it normally does, but intercept it here once
//weve loaded the page data... essentially just to see if its new and to present the "BECOME THE VIRTUAL FOUNDER" text
/*
 * Lets determin early on what we are doing with the article.  Different pages like ct/bristol/ will include different stuff in the templates
 * and therefore parsing the title will let us know what to use.	 
 */

function whichTemplate(&$art, &$row) { 	
	/*
	 * As the title is all you need in mediawiki... here wee can decide what needs to go into the template areas.  Ive created wcTemp for
	 * wikicommunity template.  Its a global array that we'll add the stuff that's going to appear on the page.  That data will be pulled here. 
	 * We will need to write more functions to do that on this page.
	 *  
	 * */
	global $wcTemp; // this is where I add a global variable which apparently is frowned upon, but they make like 40 so we should
	// be okay with it.
	$tit = $art->mTitle;
		if($tit->getNamespace() == NS_CATEGORY && $art->exists()){ // else it should be handled differently because it's some non - regular page.
			$titPieces = explode("/",$tit->mUrlform);
			$wcHTML = new WCHTML($art);
			switch(count($titPieces)){
				case 1:
					if( strlen($titPieces[0]) == 2)
					$wcTemp['wCAddIns'] = $wcHTML->getStatePage();				
					break;
				case 2:
					$wcTemp['wCAddIns'] = $wcHTML->getCityPage($row);				
					break;
				case $titPieces > 2 :
					$wcTemp['wCAddIns'] = $wcHTML->getInteriorPage();				
					break;
				default:
			}
		}else{
			// we should be doing something here because these will be the non city pages fror help and such....
		}
	
	
		
	return true;
}

	