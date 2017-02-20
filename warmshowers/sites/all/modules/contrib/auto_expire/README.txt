// $Id: README.txt,v 1.4 2007/09/03 23:28:31 mariuss Exp $

This module allows site administrators to set expiration times for content types.

End users creating content that has auto expiry set cannot control the expiry time. They
could be allowed to renew the content for one or more cycles.

Before a node is expired a warning message is sent to the user that created that node. If
the user has the proper rights then he can extend the node.

Nodes that have expired for a certain amount of time can be automatically purged.

This module is ideal for content that is allowed only for a limited time, like
classified listings.

Somewhat similar modules are Scheduler and Node Expire. Scheduler allows the user
creating the node to set the expiry time, Auto Expire enforces an expiry time set by
the administrator. Node Expire allows both default settings for each node type and
individual settings for nodes, content is expired based on last update time. Auto
Expire is expiring content based on creation time, and content has to be explicitly
extended (a simple update is not sufficient).
