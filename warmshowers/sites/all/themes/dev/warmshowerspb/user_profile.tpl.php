<?php

drupal_set_title(check_plain("$user->fullname"));;
// Basic member info introduction
$mail = theme('email_link',$user);
$provincemap = _user_location_get_provincecode_to_province_map($user->country);
$countrylist = _user_location_supported_countries();
$countryname = $countrylist[$user->country];
$province = $provincemap[$user->province];

// Introduction
$output .= "<fieldset><legend><b>Introduction</b></legend>";

$output .= theme('user_picture', $user);

$output .= "<b>Member:</b>";
$output .= "<dl>";
$nameinfo = $user->fullname;

$output .= _output_with_tag("<dd><b>", $nameinfo, "</b></dd>");
if ($user->isunreachable) { $output .= "<dd><i>This member is considered unreachable. Email has bounced or telephone contact has been unsuccessful.</i></dd>"; }
if ($user->isstale) { $output .= "<dd><i>This member is condered stale, as they have not logged into the system for a long time.</i></dd>"; }
if (!$user->status) { $output .= "<dd><i>This member is blocked</i></dd>"; }

$output .= "<dd>Email: $mail</dd>";
$output .= _output_with_tag("<dd>Username:", $user->name, "</dd>");
$output .= _output_with_tag("<dd>", $user->street, "</dd>");
$output .= _output_with_tag("<dd>", $user->additional, "</dd>");
$output .= _output_with_tag("<dd>","$user->city, $province " . (strtoupper($user->postal_code) != 'NONE' ? $user->postal_code : '') . " $countryname", "</dd>");
$output .= "</dl>";
if ($user->URL) {
	$output .= '<b>Website:</b> <a href="' . check_url($user->URL) . '">' . check_url($user->URL) . "</a><br/>";
}
$output .= _output_with_tag_markup("<dl><dt><b>About this member:</b></dt><dd>", $user->comments, "</dd></dl><br/>");



$output .= "</fieldset>";


// Location section
if (user_access('administer user profiles') || user_is_current($user) || !$user->notcurrentlyavailable) {
	$output .= "<fieldset><legend><b>Location Map</b></legend>";
	$output .= $fields['Location']['map']['value'];
	$output .= "<div class='viewmembers' >View members <a href='/map/" . drupal_urlencode("uid=" . $user->uid) . "'>near this one</a> on the full map</div>";


	$output .= "</fieldset>";
}
unset($fields['Location']);

$output .= _item_output_html(t("History"), $fields[t("History")]);
unset ($fields[t("History")]);


$output .= '<div class="profile">';




$output .= '<fieldset><legend><b>'. t('Member Information') .'</b></legend>';


if ($user->homephone || $user->mobilephone || $user->workphone || $user->fax) {
	$output .= "<b>Phones: </b>" ;
	$output .= _output_with_tag("Home", $user->homephone);
	$output .= " ". _output_with_tag("Work", $user->workphone);
	$output .= " ". _output_with_tag("Mobile", $user->mobilephone);
	$output .= " ". _output_with_tag("Fax", $user->fax_number);
	$output .= "<br/>\n";
}
if ($user->notcurrentlyavailable){
	$output .= "<b><i>This user is set as unavailable, possibly on the road, so much of their information is not shown.</i></b><br/>\n";

} else {
	$output .= "<div><a href='/map/" . drupal_urlencode("uid=" . $user->uid) . "'>View members near this one on the map</a></div>";
	$output .= _output_with_tag("<b>Preferred Notice</b>", $user->preferred_notice, "<br/>");
	$maxcyclists=$user->maxcyclists;
	if ($maxcyclists == '5') {  $maxcyclists = "5 or more"; }
	$output .= _output_with_tag("<b>Maximum Guests</b>", $maxcyclists, "<br/>");
	$output .= _output_with_tag("<b>Nearest hotel/motel/accomodation:</b>", $user->motel, "<br/>");
	$output .= _output_with_tag("<b>Nearest Campground</b>", $user->campground, "<br/>");
	$output .= _output_with_tag("<b>Nearest Bike Shop</b>", $user->bikeshop, "<br/>");
	$output .= _output_with_tag("<b>Languages Spoken</b>", $user->languagesspoken, "<br/>");
}


$fieldlist = wsuser_fieldlist();
foreach (explode(" ", "bed food laundry lawnspace sag shower storage kitchenuse") as $item) {
	if ($user->$item) {
		$services .= "<li>".$fieldlist[$item]['title']."</li>";
	}
}
if (!$user->notcurrentlyavailable) {
	if ($services) {
		$output .= "<b>Services this host may offer:</b>";
		$output .= "<ul>";
		$output .= $services;
		$output .= "</ul>";
	}
}
$output .= "</fieldset>";

unset($fields['Member Information']);



  $output .= '<fieldset><legend><b>'. t('Members I Recommend and Who Recommend Me') .'</b></legend>';

// Note: To get the body alone into a view I used the hack on teaser
// reported at http://drupal.org/node/160641#comment-583207

// Show trusted users
   global $current_view;
   $current_view->args[0]=$user->uid;

   $view = views_get_view('user_referrals_by_referrer');

   $output .= views_build_view('embed', $view, $current_view->args, false, false); 
// Show users I trust
   // $current_view->args[0]=$user->uid;

   $view = views_get_view('user_referrals_by_referee');

   $output .= views_build_view('embed', $view, $current_view->args, false, false); 

  if ($GLOBALS['user']->uid != $user->uid) {
    $output .= "<br/>Do you recommend this member? <a href=\"/node/add/trust_referral?edit[field_member_i_trust][0][user_name]=". $user->name . "\">Click here to add a recommendation</a>";
  }

  $output .= "</fieldset>";

// Now do any remaining sections
// This is commented out for 2 reasons: 1) It shows newsletter, which we don't want to show
// 2) It doesn't work right - it should show HTML and it does a check_plain() on it.
// 3) When done right, the "Blog" section of "HIstory" should get fixed also.

//foreach ($fields as $category => $items) {
//	$output .= _item_output($category,$items);
//}
$output .= '</div>';

print $output;

function _output_with_tag($tag, $item, $closing="") {
	$output = "";
	if ($item) {
		$output .= "$tag ". check_plain($item);
		$output .= $closing;
	}
	return $output;
}
function _output_with_tag_markup($tag, $item, $closing="") {
	$output = "";
	if ($item) {
		$output .= "$tag ". check_markup($item,FILTER_FORMAT_DEFAULT,false);
		$output .= $closing;
	}
	return $output;
}


function _item_output($category, $items) {
	if (strlen($category) > 0) {
			$output .= "<fieldset><legend><b>$category</b></legend>";
	}
	if ($items) {
		foreach ($items as $item) {
			if (isset($item['title'])) {
				$output .= '<b>'. $item['title'] .'</b>:';
			}
			if ($item['value_type'] == 'html') {
				$output .= $item['value'];
			} else {
				$output .= check_plain( $item['value']);
			}
		$output .= "<br/>";
		}
	}
	$output .= "</fieldset>";
	return $output;
}
function _item_output_html($category, $items) {
	if (strlen($category) > 0) {
			$output .= "<fieldset><legend><b>$category</b></legend>";
	}
	if ($items) {
		foreach ($items as $item) {
			if (isset($item['title'])) {
				$output .= '<b>'. $item['title'] .'</b>:';
			}
			if ($item['value_type'] == 'html') {
				$output .= $item['value'];
			} else {
				$output .= check_markup( $item['value']);
			}
		$output .= "<br/>";
		}
	}
	$output .= "</fieldset>";
	return $output;
}
function _output_wsuser_data($title, $user, $fields) {

	$output .= '<h2 class="title">'. check_plain("Host Information") .'</h2>';


	$output .= _output_if_set($user->fullname) . "<br/>";
	$output .= _output_if_set($user->street) . "<br/>";

	return $output;


}

function _output_if_set($str) {
	if ($str) {
		return check_plain($str);
	}
}

function user_is_current($named_user) {
	global $user;
	return ($user->uid == $named_user->uid);
}
