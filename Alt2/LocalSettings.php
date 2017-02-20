<?php

# This file was automatically generated by the MediaWiki installer.
# If you make manual changes, please keep track in case you need to
# recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.

# If you customize your file layout, set $IP to the directory that contains
# the other MediaWiki files. It will be used as a base to locate files.
if( defined( 'MW_INSTALL_PATH' ) ) { 
	$IP = MW_INSTALL_PATH;
} else {
	$IP = dirname( __FILE__ );
}

$path = array( $IP, "$IP/includes", "$IP/languages" );
set_include_path( implode( PATH_SEPARATOR, $path ) . PATH_SEPARATOR . get_include_path() );

require_once( "$IP/includes/DefaultSettings.php" );

# If PHP's memory limit is very low, some operations may fail.
# ini_set( 'memory_limit', '20M' );

if ( $wgCommandLineMode ) {
	if ( isset( $_SERVER ) && array_key_exists( 'REQUEST_METHOD', $_SERVER ) ) {
		die( "This script must be run from the command line\n" );
	}
}
## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename         = "wikiCommunity";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.

$wgArticlePath      = "/$1";
$wgScriptPath       = "/Alt2";
$wgScriptExtension  = ".php";
$wgArticlePath = "/us/$1";  # Virtual path (left part of first rewrite rule). MUST be DIFFERENT from the path above!


## For more information on customizing the URLs please see:
## http://www.mediawiki.org/wiki/Manual:Short_URL

$wgEnableEmail      = true;
$wgEnableUserEmail  = true;

$wgEmergencyContact = "chris.andrews.russo@gmail.com";
$wgPasswordSender = "chris.andrews.russo@gmail.com";

## For a detailed description of the following switches see
## http://www.mediawiki.org/wiki/Extension:Email_notification 
## and http://www.mediawiki.org/wiki/Extension:Email_notification
## There are many more options for fine tuning available see
## /includes/DefaultSettings.php
## UPO means: this is also a user preference option
$wgEnotifUserTalk = true; # UPO
$wgEnotifWatchlist = true; # UPO
$wgEmailAuthentication = true;

$wgDBtype           = "mysql";
$wgDBserver         = "mysql.russeme.com";
$wgDBname           = "wikidb";
$wgDBuser           = "wcround1u";
$wgDBpassword       = "wcround1p";

# MySQL specific settings
$wgDBprefix         = "";

# MySQL table options to use during installation or update
$wgDBTableOptions   = "TYPE=InnoDB";

# Experimental charset support for MySQL 4.1/5.0.
$wgDBmysql5 = false;

# Postgres specific settings
$wgDBport           = "5432";
$wgDBmwschema       = "mediawiki";
$wgDBts2schema      = "public";

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = array();

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads       = false;
# $wgUseImageMagick = true;
# $wgImageMagickConvertCommand = "/usr/bin/convert";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
# $wgHashedUploadDirectory = false;

## If you have the appropriate support software installed
## you can enable inline LaTeX equations:
$wgUseTeX           = false;

$wgLocalInterwiki   = $wgSitename;

$wgLanguageCode = "en";

$wgProxyKey = "d7a95f9b8dac7182ccf39c3287b299bc4b7e821dce02053aea0eb7f47b51bdeb";

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'standard', 'nostalgia', 'cologneblue', 'monobook':
$wgDefaultSkin = 'monobook';

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
# $wgEnableCreativeCommonsRdf = true;
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";
# $wgRightsCode = ""; # Not yet used

$wgDiff3 = "/usr/bin/diff3";

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
$configdate = gmdate( 'YmdHis', @filemtime( __FILE__ ) );
$wgCacheEpoch = max( $wgCacheEpoch, $configdate );

$wgShowExceptionDetails = true;

// Everything below here is new.
$wgDefaultSkin = 'wc';

$wgNamespacesWithSubpages[NS_MAIN] = true;
$wgNamespacesWithSubpages[NS_CATEGORY] = true;

$wgEnableUploads       = true;

require_once( "$IP/extensions/Variables/Variables.php" );
require_once ("$IP/extensions/StringFunctions/StringFunctions.php");
require_once( "$IP/extensions/Call/Call.php" );
require_once( "$IP/extensions/DynamicPageList/DynamicPageList2.php" );
require_once( "$IP/extensions/Inputbox/inputbox.php" );
require_once( "$IP/extensions/ParserFunctions/ParserFunctions.php" );
require_once( "$IP/extensions/SocietiesPage/SocietiesPage.php" ); // my mod YEAH!!!
require_once( "$IP/extensions/WCFormatting/WCFormatting.php"); //my mod YEAH!!
require_once( "$IP/extensions/CategoryTree/CategoryTree.php" );
require_once( "$IP/extensions/EXTRACRAP/initialCityInsertions.php" );
// 872 get internal url might be something to look at.  we need to strip
$wgCategoryTreeOmitNamespace =true	;
$wgCategoryTreeDefaultMode = CT_MODE_ALL;

$wgAjaxSearch = true; // pretty nifty but may be too expensive
$wgGroupPermissions['*'    ]['edit']            = false;



$wgFavicon =  "/Alt2/images/smileyFav.png";
$wgLogo = "/Alt2/images/wcFinalSmall.png";
//$wgFavicon = "/Alt2/images/firstTry2FI.gif";

$wgNamespacesToBeSearchedDefault[NS_CATEGORY] = true;


//Ideas

/**
 * require_once( "$IP/extensions/CityPage/CityPage.php" ); // my mod YEAH!!!
 * 
 * $wgExtraNamespaces = array(100 => "BEFFSDEE");
$wgContentNamespaces[] = 100;
 * 
 * //require_once("$IP/myHooks.php");
//$wgHooks['ArticleSave'][] = 'unprotect2';
$wgHooks['AlternateEdit'][] = 'makeMayor';
 * Array of disabled article actions, e.g. view, edit, dublincore, delete, etc.
 
//$wgDisabledActions = array();
//$wgContentNamespaces = array( NS_MAIN );
*/

//$wgAllowPageInfo = true;
/*
 * $wgDebugDumpSql         = false; // can see what the queries are.
 * start with line 883 in default settings.
 * $wgContentNamespaces 
 * $wgAllowDisplayTitle = true;
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
require_once("extensions/GoogleSiteSearch/GoogleSiteSearch.php");

$wgGoogleSiteSearchVars = array();
 
  # Unless you have an odd MediaWiki setup, the same host as the search
  # should be fine.
  $wgGoogleSiteSearchVars['domains'] = $_SERVER['HTTP_HOST'];
 
  # Ditto.
  $wgGoogleSiteSearchVars['sitesearch'] = $_SERVER['HTTP_HOST'];
 
  # A valid Google AdSense or CoOp account.  If this is not set, it defaults
  # to the author's AdSense account, so hey, no rush.
  $wgGoogleSiteSearchVars['client'] = 'pub-9372650377977516';
 
  # If a Google AdSense account is specified, this can be set to a specific
  # channel.
  $wgGoogleSiteSearchVars['channel'] = '';
 
  # Can probably be changed to UTF-8, but hasn't been tested yet.
  $wgGoogleSiteSearchVars['ie'] = 'ISO-8859-1';
 
  # Can probably be changed to UTF-8, but hasn't been tested yet.
  $wgGoogleSiteSearchVars['oe'] = 'ISO-8859-1';
 
  # The language to be displayed.
  $wgGoogleSiteSearchVars['hl'] = 'en';
 
  # The default color scheme compliments MediaWiki well, but can be
  # customized here.
  $wgGoogleSiteSearchVars['cof'] = 'GALT:#008000;GL:1;DIV:#336699;VLC:663399;'
    . 'AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;'
    . 'GFNT:0000FF;GIMP:0000FF;FORID:9';
 
  # Do not change.
  $wgGoogleSiteSearchVars['sa'] = 'Google Search';
 
  # Do not change.
  $wgGoogleSiteSearchVars['forid'] = '1';

*/
	


