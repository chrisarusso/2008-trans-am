<?php
/**
 * @version 0.1
 * @version 0.2
 *		added "return true;" at the end of wfCallLoadMessages()
 */
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install Call as a special page, put the following line in LocalSettings.php:
require_once( "$IP/extensions/Call/Call.php" );
EOT;
        exit( 1 );
}

$wgAutoloadClasses['Call'] = dirname(__FILE__) . '/Call_body.php';
$wgSpecialPages['Call'] 	= 'Call';
// obviously LoadAllMessages needs a static function as a callback
$wgHooks['LoadAllMessages'][] 			= 'wfCallLoadMessages';

function wfCallLoadMessages() {
	(Call::loadMessages());
	return true;
}
?>