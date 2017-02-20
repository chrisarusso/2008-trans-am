<?php
// $Id: auto_expire.inc 371 2007-10-18 15:47:58Z rfay $

// Content types that auto expire
define('AUTO_EXPIRE_NODE_TYPE', 'auto_expire_');
define('AUTO_EXPIRE_EMAIL', 'auto_expire_email_');

// Permissions
define('ADMINISTER_AUTO_EXPIRE', 'administer auto expire');
define('EXTEND_AUTO_EXPIRE_OWN', 'extend expiring own content');
define('EXTEND_AUTO_EXPIRE_ALL', 'extend expiring all content');

define('AUTO_EXPIRE_DAYS', 30);
define('AUTO_EXPIRE_WARN', 5);
define('AUTO_EXPIRE_PURGE', 60);

?>