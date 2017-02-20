<?php

/**
 * This file contains the main include file for the Inputbox extension of 
 * MediaWiki. 
 *
 * Usage: require_once("path/to/inputbox.php"); in LocalSettings.php
 *
 * This extension requires MediaWiki 1.5 or higher.
 *
 * @author Erik Moeller <moeller@scireview.de>
 *  namespaces search improvements partially by
 *  Leonardo Pimenta <leo.lns@gmail.com> 
 * @copyright Public domain
 * @license Public domain
 * @version 0.1.1
 */

// define as a Parser FUNCTION
$wgExtensionFunctions[]        = 'registerInputbox_PF';
$wgHooks['LanguageGetMagic'][] = 'registerInputbox_PF_Magic';

// register as a Parser FUNCTION
function registerInputbox_PF() {
  global $wgParser;
  $wgParser->setFunctionHook( 'inputbox', 'renderInputbox_PF' );
}

// register alias names for Parser FUNCTION
function registerInputbox_PF_Magic( &$magicWords, $langCode ) {
        # The first array element is case sensitivity, in this case it is not case sensitive
        # All remaining elements are synonyms for our parser function
        $magicWords['inputbox'] = array( 0, 'inputbox' );
        return true;
}

// entry point for Parser FUNCTION
function renderInputbox_PF(&$parser, $p1='' ,$p2='' ,$p3='' ,$p4='' ,$p5='' ,$p6='' ,$p7='' ,$p8='' ,$p9='' ,$p10='',
									  $p11='',$p12='',$p13='',$p14='',$p15='',$p16='',$p17='',$p18='',$p19='',$p20='') {
	$params = array();
	$input='';
	if ($p1 != '')	$input .= str_replace("\n",'',$p1) ."\n";
	if ($p2 != '')	$input .= str_replace("\n",'',$p2) ."\n";
	if ($p3 != '')	$input .= str_replace("\n",'',$p3) ."\n";
	if ($p4 != '')	$input .= str_replace("\n",'',$p4) ."\n";
	if ($p5 != '')	$input .= str_replace("\n",'',$p5) ."\n";
	if ($p6 != '')	$input .= str_replace("\n",'',$p6) ."\n";
	if ($p7 != '')	$input .= str_replace("\n",'',$p7) ."\n";
	if ($p8 != '')	$input .= str_replace("\n",'',$p8) ."\n";
	if ($p9 != '')	$input .= str_replace("\n",'',$p9) ."\n";
	if ($p10!= '')	$input .= str_replace("\n",'',$p10)."\n";
	if ($p11!= '')	$input .= str_replace("\n",'',$p11)."\n";
	if ($p12!= '')	$input .= str_replace("\n",'',$p12)."\n";
	if ($p13!= '')	$input .= str_replace("\n",'',$p13)."\n";
	if ($p14!= '')	$input .= str_replace("\n",'',$p14)."\n";
	if ($p15!= '')	$input .= str_replace("\n",'',$p15)."\n";
	if ($p16!= '')	$input .= str_replace("\n",'',$p16)."\n";
	if ($p17!= '')	$input .= str_replace("\n",'',$p17)."\n";
	if ($p18!= '')	$input .= str_replace("\n",'',$p18)."\n";
	if ($p19!= '')	$input .= str_replace("\n",'',$p19)."\n";
	if ($p20!= '')	$input .= str_replace("\n",'',$p20)."\n";

	// we must get the generated HTML through the parser->strip() function
	// is there a better way for this?
	global $wgRawHtml;
	$wgRawHtml = true;
	return '<html>'.renderInputbox( $input, $params, $parser ).'</html>';
}

// define as a Parser EXTENSION (user tag)
$wgExtensionFunctions[] = 'registerInputbox_PE';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Inputbox',
	'author' => 'Erik Moeller',
	'url' => 'http://meta.wikimedia.org/wiki/Help:Inputbox',
	'description' => 'Allow inclusion of predefined HTML forms.',
);

// register as a Parser EXTENSION
function registerInputbox_PE() {
    global $wgParser;
    $wgParser->setHook('inputbox', 'renderInputbox');
}
  
/**
 * Renders an inputbox based on information provided by $input.
 */
function renderInputbox($input, $params, &$parser)
{
	global $wgContLang;
	
	$inputbox=new Inputbox( $parser );
	getBoxOption($inputbox->type,$input,'type',$parser);
	getBoxOption($inputbox->width,$input,'width',$parser,true);	
	getBoxOption($inputbox->preload,$input,'preload',$parser);
	getBoxOption($inputbox->editintro,$input,'editintro',$parser);
	getBoxOption($inputbox->defaulttext,$input,'default',$parser);	
	getBoxOption($inputbox->titleprefix,$input,'titleprefix',$parser);
	getBoxOption($inputbox->bgcolor,$input,'bgcolor',$parser);
	getBoxOption($inputbox->buttonlabel,$input,'buttonlabel',$parser);	
	getBoxOption($inputbox->searchbuttonlabel,$input,'searchbuttonlabel',$parser);		
	getBoxOption($inputbox->namespaces,$input,'namespaces',$parser);		
	getBoxOption($inputbox->id,$input,'id',$parser);	
	getBoxOption($inputbox->labeltext,$input,'labeltext',$parser);
	getBoxOption($inputbox->br, $input, 'break',$parser);
	getBoxOption($inputbox->hidden, $input, 'hidden',$parser);
	$inputbox->lineBreak();
	$inputbox->checkWidth();
	
	$boxhtml=$inputbox->render();
	# Maybe support other useful magic words here
	$boxhtml=str_replace("{{PAGENAME}}",$parser->getTitle()->getText(),$boxhtml);
	$namespaces=$wgContLang->getNamespaces();
	$boxhtml=str_replace("{{NAMESPACE}}",$namespaces[$parser->getTitle()->getNamespace()],$boxhtml);
	if($boxhtml) {
		return $boxhtml;
	} else {
		return '<div><strong class="error">Input box: type not defined.</strong>('.$input.')</div>';
	}
}

function getBoxOption(&$value, &$input, $name, &$parser, $isNumber=false) {

      if(preg_match("/^\s*$name\s*=\s*(.*)/mi",$input,$matches)) {
		if($isNumber) {
			$value=intval($matches[1]);
		} else {
			$value=htmlspecialchars($matches[1]);
		}
		$value = str_replace("{{PAGENAME}}",$parser->getTitle()->getText(),$value);
	}
}


class Inputbox {
	var $type,$width,$preload,$editintro, $br;
	var $defaulttext,$titleprefix,$bgcolor,$buttonlabel,$searchbuttonlabel;
	var $hidden;
	
	function InputBox( &$parser ) {
		$this->parser =& $parser;
	}
	
	function render() {
		if($this->type=='create' || $this->type=='comment') {
			return $this->getCreateForm();		
		} elseif($this->type=='search') {
			return $this->getSearchForm();
		} elseif($this->type=='search2') {
			return $this->getSearchForm2();
		} else {
			return false;
		}	
	}
	function getSearchForm() {
		global $wgUser, $wgContLang;
		
		$sk=$wgUser->getSkin();
		$searchpath = $sk->escapeSearchLink();		
		if(!$this->buttonlabel) {
			$this->buttonlabel = wfMsgHtml( 'tryexact' );
		}
		if(!$this->searchbuttonlabel) {
			$this->searchbuttonlabel = wfMsgHtml( 'searchfulltext' );
		}


		$type = $this->hidden ? 'hidden' : 'text';
		$searchform=<<<ENDFORM
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
		<td bgcolor="{$this->bgcolor}">
		<form name="searchbox" action="$searchpath" class="searchbox">
		<input class="searchboxInput" name="search" type="{$type}"
		value="{$this->defaulttext}" size="{$this->width}" />{$this->br}
ENDFORM;

		// disabled when namespace filter active
		$gobutton=<<<ENDGO
<input type='submit' name="go" class="searchboxGoButton" value="{$this->buttonlabel}" />&nbsp;
ENDGO;
		// Determine namespace checkboxes
		$namespaces = $wgContLang->getNamespaces();
		$namespacesarray = explode(",",$this->namespaces);

		// Test if namespaces requested by user really exist
		$searchform2 = '';
		if ($this->namespaces) {
			foreach ($namespacesarray as $usernamespace) {
				$checked = '';
				// Namespace needs to be checked if flagged with "**" or if it's the only one
				if (strstr($usernamespace,'**') || count($namespacesarray)==1) {
                                        $usernamespace = str_replace("**","",$usernamespace);
                                        $checked =" checked";
                                }
				foreach ( $namespaces as $i => $name ) {
					if ($i < 0){
						continue;
					}elseif($i==0) {
						$name='Main';
					}
					if ($usernamespace == $name) {
						$searchform2 .= "<input type=\"checkbox\" name=\"ns{$i}\" value=\"1\"{$checked}>{$usernamespace}";
					}
				}
			}
			//Line feed 
			$searchform2 .= $this->br;		
			//If namespaces are defined remove the go button 
			//because go button doesn't accept namespaces parameters 
			$gobutton='';
		} 
		$searchform3=<<<ENDFORM2
		{$gobutton}
		<input type='submit' name="fulltext" class="searchboxSearchButton" value="{$this->searchbuttonlabel}" />
		</form>
		</td>
		</tr>
		</table>
ENDFORM2;
		//Return form values
		return $searchform . $searchform2 . $searchform3;
	}

	function getSearchForm2() {
		global $wgUser;
		
		$sk=$wgUser->getSkin();
		$searchpath = $sk->escapeSearchLink();		
		if(!$this->buttonlabel) {
			$this->buttonlabel = wfMsgHtml( 'tryexact' );
		}

		$output = $this->parser->parse( $this->labeltext,
			$this->parser->getTitle(), $this->parser->getOptions(), false, false );
		$this->labeltext = $output->getText();
		$this->labeltext = str_replace('<p>', '', $this->labeltext);
		$this->labeltext = str_replace('</p>', '', $this->labeltext);
		
		$type = $this->hidden ? 'hidden' : 'text';
		$searchform=<<<ENDFORM
<form action="$searchpath" class="bodySearch" id="bodySearch{$this->id}"><div class="bodySearchWrap"><label for="bodySearchIput{$this->id}">{$this->labeltext}</label><input type="{$type}" name="search" size="{$this->width}" class="bodySearchIput" id="bodySearchIput{$this->id}" /><input type="submit" name="go" value="{$this->buttonlabel}" class="bodySearchBtnGo" />
ENDFORM;

		if ( !empty( $this->fulltextbtn ) ) // this is wrong...
			$searchform .= '<input type="submit" name="fulltext" class="bodySearchBtnSearch" value="{$this->searchbuttonlabel}" />';

		$searchform .= '</div></form>';

		return $searchform;
	}

	
	function getCreateForm() {
		global $wgScript;	
		
		$action = htmlspecialchars( $wgScript );		
		if($this->type=="comment") {
			$comment='<input type="hidden" name="section" value="new" />';
			if(!$this->buttonlabel) {
				$this->buttonlabel = wfMsgHtml( "postcomment" );
			}
		} else {
			$comment='';
			if(!$this->buttonlabel) {			
				$this->buttonlabel = wfMsgHtml( "createarticle" );
			}
		}		
		$type = $this->hidden ? 'hidden' : 'text';
		$createform=<<<ENDFORM
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td bgcolor="{$this->bgcolor}">
<form name="createbox" action="$action" method="get" class="createbox" 
	onsubmit="document.createbox.title.value = document.createbox.titleprefix.value + document.createbox.title.value;">
	<input type='hidden' name="action" value="edit" />
	<input type="hidden" name="preload" value="{$this->preload}" />
	<input type="hidden" name="editintro" value="{$this->editintro}" />
	<input type='hidden' name="titleprefix" value="{$this->titleprefix}" />
	{$comment}
	<input class="createboxInput" name="title" type="{$type}"
	value="{$this->defaulttext}" size="{$this->width}" />{$this->br}
	<input type='submit' name="create" class="createboxButton"
	value="{$this->buttonlabel}" />
</form>
</td>
</tr>
</table>
ENDFORM;
		return $createform;
	}

	function lineBreak() {
		# Should we be inserting a <br /> tag?
		$cond = ( strtolower( $this->br ) == "no" );
		$this->br = $cond ? '' : '<br />';
	}

	/**
	 * If the width is not supplied, set it to 50
	 */
	function checkWidth() {
		if( !$this->width || trim( $this->width ) == '' )
			$this->width = 50;
	}	
}
?>
