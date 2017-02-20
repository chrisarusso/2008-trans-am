<?php
/*
 * 
 * 
require_once("$IP/extensions/CityPage/CityPage.php");
$wgHooks['ParserAfterTidy'][] = 'getSocieties';

function getSocieties(&$parser, &$text) {  
	$sp = new SocietiesPage();

	foreach($sp->getBaseFeatures() as $section => $func){	
		$sp->insertSection($section, $text, $sp->$func());
	}

	return true; 
}

Class SocietiesPage extends CityPage{

	private $baseFeatures = array(
	'Society Page' =>  'getSocietiesHTML',
     );
     
	public function getBaseFeatures(){
   		return $this->baseFeatures;
   	}	
   
	
	// get function to pull from db and go two llevels deep.
	// the keys are associeted to a certain top level category
	// and the values are arrays of all subcategories
	// any user-added cats will fall below these subs.
    public $societiesArray = array(
    '0' => array('soccer','football','baseball'),
    '1' => array('apple','orange','pear'),
    '2' => array('tall','average','short'),
    '3' => array('rock','rap','blues'),
    '4' => array('science','math','english'),
    '5' => array('ct','ny','ma'),
    '6' => array('balls','vag','nips')
    );
      
    public function getSocieties(){  //break this into getSocieites html and js...
     	return $this->societiesArray;
    }
    
 	public function getSocietyForm(){
 		global $wgUser;
   		return '<form name="addSoc">
   					<table style="background-color:#c6c6ff;border:1px solid grey;width:500px;"> 
   						<tr><td>Founder</td>
   							<td>'.$wgUser->mName.'</td>
   						</tr>
   						<tr><td>Community</td>
   							<td>'.$wgUser->getCity().'</td>
   						</tr>
   						<tr><td>Name</td>
   							<td><input type="text" name="otherthanname" /></td>
   						</tr>
   						<tr><td>Description</td>
   							<td><textarea style="width:96%" rows="5" cols="30"></textarea></td>
   						</tr>
   						<tr><td>Type</td>
   							<td>'.$this->getSocietyMenuHTML().'</td>
   						</tr>
   						<tr><td>External Contact</td>
   							<td>Someone Else</td>
   						</tr>
   						<tr><td>Societies Email</td>
   							<td><input style="width:76%" id="autoEmail" type="text" value="'.$wgUser->mEmail.'" disabled="true" /> [<a href="javascript:changeEmail()">Change</a>]</td>
   						</tr>
   					</table>
   				</form>';
   	}
   	
   	public function getSocietyMenuHTML($occurence = "nada"){
   			return '<select onchange="buildSubs(this)">
 					<option value="no">Select Cat</option>
 					<option value=0>Sports</option>
 					<option value="1">Fruits</option>
 					<option value="2">Height</option>
 					<option value=3>Music</option>
 					<option value="4">Subject</option>
 					<option value="5">State</option>
 					<option value="6">Body Part</option>
 				</select>	
 				<select  disabled="true" onchange="" name="sub">
 					<option value="nada">Select Sub</option>
 				</select>';
   	}
	
   	public function getSocietyMenuJS(){
   			
 		$ret = '<script type="text/javascript">';
 		$ret .='var Groups = Array();';
 		foreach($this->getSocieties() as $key => $value){
 			$ret .= "\nGroups". "[$key] = Array();\n";
 			$i = 0;
 			foreach($value as $value2){
 				$ret .= 'Groups[' . "$key]" . "[$i] = '$value2'\n";
 				$i++;	
 			}
 		}
 		$ret .= 'function buildSubs(selectElement){
 					if(selectElement.form.name == "addSoc")
 						var selectSub = document.addSoc.sub;
 					else
 						var selectSub = document.selectTest.sub;
 					selectSub.length = 0;
 					if(selectElement.value == "no"){
 						selectSub.disabled = "true";
 					}else{
 						selectSub.disabled = null;
 						for(var i=0; i < Groups[selectElement.value].length; i++){
 							selectSub[i] = new Option(Groups[selectElement.value][i]);
 						}
 					}	  
 				}
 				
 				function addGroupHTML(word){
 					var plusOrMinus = document.getElementById("agLink").childNodes[0];
 					if(plusOrMinus.nodeValue == "+"){
 						plusOrMinus.nodeValue = "-";
 					}
 					else
 						plusOrMinus.nodeValue = "+";
 					var aG = document.getElementById("addGroup");
 					//alert(aG.style.display);
 					if(aG.style.display == "block")
 						aG.style.display = "none";
 					else
 						aG.style.display = "block";
 				
 				}
 				
 				function changeEmail(){
 					document.getElementById("autoEmail").disabled = false;
 				}
 		
 				</script>';
   		return $ret;
   	}
   	
   	
 	public function getSocietiesHTML(){
    	
 		$ret = $this->getSocietyMenuJS();
 		$ret .= 'Add a group <span style="font-size:20px"><a id="agLink" href="javascript:addGroupHTML()">+</a></span><br /><div id="addGroup" style="display:none">'.$this->getSocietyForm().'</div>
 				<hr>Search for societies to join:<br />
 				<form name="selectTest">
 				'. $this->getSocietyMenuHTML().'
 				</form>
 				<ul>
 					<li> Top level Cat 1 </li>
 					<li> Top level Cat 2 </li>
 					<li> Top level Cat 3 </li>
 					<li> Top level Cat 4 </li>
 					<li> Top level Cat 5 </li>
 					<li> Top level Cat 6 </li>
 					<li> Top level Cat 7 </li>
 					<li> Top level Cat 8 </li>
 					<li> Top level Cat 9 </li>
 					<li> Top level Cat 10 </li>
 					<li> Top level Cat 11 </li>
 					<li> Top level Cat 12 </li>
 					<li> Top level Cat 13 </li>
 				</ul>
 					';
 		
 		return $ret; 
		    	
    }
}
?> */