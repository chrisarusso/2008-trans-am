<?php

$wgExtensionCredits['other'][] = array(
  'name' => 'Google Site Search 1.2',
  'author' => 'Ryan Finnie',
  'url' => 'http://www.mediawiki.org/wiki/Extension:GoogleSiteSearch',
  'description' => 'Uses Google to search the wiki, instead of MediaWiki\'s own search function (not affiliated in any way with Google, Inc.)',
);

function wfshowResultsGoogle($term='') {
  $fname = 'SpecialSearch::showResults';
  wfProfileIn( $fname );

  global $wgOut;
  global $wgUser;
  global $wgRequest;
  global $wgGoogleSiteSearchVars;

  # Vars we'll need later
  $skin = $wgUser->getSkin();

  $wgOut->setPageTitle( wfMsg( 'searchresults' ) );
  $subtitlemsg = ( Title::newFromText($term) ? 'searchsubtitle' : 'searchsubtitleinvalid' );
  $wgOut->setSubtitle( $wgOut->parse( wfMsg( $subtitlemsg, wfEscapeWikiText($term) ) ) );
  $wgOut->setArticleRelated( false );
  $wgOut->setRobotpolicy( 'noindex,nofollow' );

  $wgOut->addWikiText( wfMsg( 'searchresulttext' ) );

  if(!$term) {
    $title = SpecialPage::getTitleFor( 'Search' );
    $action = $title->escapeLocalURL();
    $wgOut->setSubtitle( '' );

    $searchText = wfMsg( 'searchfulltext' );
    $searchField = '<input type="text" name="search" value="' .
      htmlspecialchars( $term ) ."\" size=\"16\" />\n";
    $searchButton = '<input type="submit" name="searchx" value="' .
      htmlspecialchars( wfMsg('powersearch') ) . "\" />\n";

    $title = SpecialPage::getTitleFor( 'Search' );
    $action = $title->escapeLocalURL();
    $wgOut->AddHTML("<br /><br />\n<form id=\"powersearch\" method=\"get\" " .
      "action=\"$action\">\n{$searchText}: {$searchField} {$searchButton}\n</form>\n");

    wfProfileOut( $fname );
    return;
  }

  $googlesitesearch_vars = array();
  $googlesitesearch_vars['domains'] = $_SERVER['HTTP_HOST'];
  $googlesitesearch_vars['sitesearch'] = $_SERVER['HTTP_HOST'];
  $googlesitesearch_vars['client'] = 'pub-9372650377977516';
  $googlesitesearch_vars['channel'] = '';
  $googlesitesearch_vars['ie'] = 'ISO-8859-1';
  $googlesitesearch_vars['oe'] = 'ISO-8859-1';
  $googlesitesearch_vars['hl'] = 'en';
  $googlesitesearch_vars['cof'] = 'GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:9';
  $googlesitesearch_vars['sa'] = 'Google Search';
  $googlesitesearch_vars['forid'] = '1'; // Leave at 1, doesn't seem to affect anything.

  # If there are any local overrides, use them here.
  if(is_array($wgGoogleSiteSearchVars)) {
    foreach($wgGoogleSiteSearchVars as $var => $val) {
      $googlesitesearch_vars[$var] = $val;
    }
  }

  $qline = "?q=" . urlencode($term);

  foreach($googlesitesearch_vars as $key => $val) {
    $wgval = $wgRequest->GetVal($key);
    # The value either has to exist, or can be blank
    # (as long as the default is also blank)
    if($wgval || ($wgval == $val)) {
      $qline .= '&' . urlencode($key)."=".urlencode($wgval);
    } else {
      $doredir = 1;
      $qline .= '&' . urlencode($key)."=".urlencode($val);
    }
  }

  $qline = substr($qline, 0, -1);

  # Assemble the output
  $wgOut->AddHTML('
    <!-- Google Search Result Snippet Begins -->
    <div id="googleSearchUnitIframe"></div>
    <script type="text/javascript">
      var googleSearchIframeName = '."'".'googleSearchUnitIframe'."'".';
      var googleSearchFrameWidth = 800; // Numbers smaller than 800 or percentages do not work
      var googleSearchFrameborder = 0 ;
      var googleSearchDomain = '."'".'www.google.com'."'".';
      var googleSearchLocation = '."'".$qline."'".';

// Code taken from http://www.google.com/afsonline/show_afs_search.js
// Downloaded 2007-05-26
// document.location.search changed to googleSearchLocation
// width:d changed to width:"100%"
(function(){var f=null,a=window,j="sitesearch",s=a.googleSearchResizeIframe||a.googleSearchPath&&a.googleSearchPath=="/cse"&&typeof a.googleSearchResizeIframe=="undefined",p,o,k;function t(c,b,l,m){var d={},g=c.split(l);for(var e=0;e<g.length;e++){var h=g[e],n=h.indexOf(b);if(n>0){var i=h.substring(0,n);if(m){i=i.toUpperCase()}else{i=i.toLowerCase()}var w=h.substring(n+1,h.length);d[i]=w}}return d}function x(){var c=googleSearchLocation;if(c.length<1){return""}c=c.substring(1,c.length);var b=
t(c,"=","&",false);if(a.googleSearchQueryString!="q"&&b[a.googleSearchQueryString]){b["q"]=b[a.googleSearchQueryString];delete b[a.googleSearchQueryString]}if(b.cof){var l=t(decodeURIComponent(b.cof),":",";",true),m=l.FORID;if(m){p=parseInt(m,10)}}var d=document.getElementById(a.googleSearchFormName);if(d){if(d["q"]&&b["q"]&&(!b.ie||b.ie.toLowerCase()=="utf-8")){d["q"].value=decodeURIComponent(b["q"].replace(/\+/g," "))}if(d[j]){for(var g=0;g<d[j].length;g++){if(b[j]==f&&d[j][g].value==""){d[j][g].checked=
true}else if(d[j][g].value==b[j]){d[j][g].checked=true}else{d[j][g].checked=false}}}}var e="";for(var h in b){e+="&"+h+"="+b[h]}return e.substring(1,e.length)}function q(c,b){if(b){return"&"+c+"="+encodeURIComponent(b)}else{return""}}function r(c,b){if(c){return Math.max(c,b)}else{return b}}function u(){var c="http://";if(a.googleSearchDomain){c+=a.googleSearchDomain}else{c+="www.google.com"}if(a.googleSearchPath){c+=a.googleSearchPath}else{c+="/custom"}c+="?";if(a.googleSearchQueryString){a.googleSearchQueryString=
a.googleSearchQueryString.toLowerCase()}c+=x();c+=q("ad","w"+o);c+=q("num",k);c+=q("adtest",a.googleAdtest);if(s){var b=a.location.href,l=b.indexOf("#");if(l!=-1){b=b.substring(0,l)}c+=q("rurl",b)}return c}function v(){o=a.googleSearchNumAds;if(!o){o=9}k=a.googleNumSearchResults;if(k){k=Math.min(k,20)}else{k=10}var c={};c[9]=795;c[10]=795;c[11]=500;var b={};b[9]=300+90*k;b[10]=300+50*Math.min(o,4)+90*k;b[11]=300+50*o+90*k;var l=u();if(!a.googleSearchFrameborder){a.googleSearchFrameborder="0"}var m=
document.getElementById(a.googleSearchIframeName);if(m&&c[p]){var d=r(a.googleSearchFrameWidth,c[p]),g=r(a.googleSearchFrameHeight,b[p]),e=document.createElement("iframe"),h={name:"googleSearchFrame",src:l,frameBorder:a.googleSearchFrameborder,width:"100%",height:g,marginWidth:"0",marginHeight:"0",hspace:"0",vspace:"0",allowTransparency:"true",scrolling:"no"};for(var n in h){e.setAttribute(n,h[n])}m.appendChild(e);if(e.attachEvent){e.attachEvent("onload",function(i){window.scrollTo(0,0)})}else{e.addEventListener("load",
function(){window.scrollTo(0,0)},false)}if(s){a.setInterval(function(){if(a.location.hash&&a.location.hash!="#"){var i=a.location.hash.substring(1)+"px";if(e.height!=i&&i!="0px"){e.height=i}}},10)}}a.googleSearchIframeName=f;a.googleSearchFormName=f;a.googleSearchResizeIframe=f;a.googleSearchQueryString=f;a.googleSearchDomain=f;a.googleSearchPath=f;a.googleSearchFrameborder=f;a.googleSearchFrameWidth=f;a.googleSearchFrameHeight=f;a.googleSearchNumAds=f;a.googleNumSearchResults=f;a.googleAdtest=f}
v()})();
    </script>
<!--    <script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script> -->
    <!-- Google Search Result Snippet Ends -->
  ');

  wfProfileOut( $fname );
}
?>
