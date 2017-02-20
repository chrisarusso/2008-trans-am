Module: Path Access
Author: Mike Carter <ixis.co.uk/contact>

Description
===========
The path_access module gives site administrators an additional layer of access control
to all pages of a Drupal site.


Benefits
========
Although a lot of the Drupal modules provide some degree of access control permissions it
never covers all possible requirements users have. Path_access provides the means to
restrict pages based on their path alias - meaning you can lock out certain user role
groups from whole sections of a site using wildcards.


Installation
============
Simply copy path_access.module to the modules directory of your Drupal
installation, and enable it in the administration tools.

You will also need to run the accompanying SQL script to create a new
table called 'path_access'.

Note that path_access is an extension to the path module, which must also
be enabled.

The Role_Weights module is also required to help determine the most important access restriction
if your users have multiple roles.


Details
=======
When access is denied to certain users they will see the 403 error 'Access Denied'
page which you have defined in the Drupal core settings. This can be changed at ?q=admin/settings

By default the module will allow both anonymous and authenticated users to access pages as usual.

For users with more than one role, the role weight determines which role is used for access. The
role with the highest weight number is used, other roles are ignored.

Use the LoginToboggan module if you would like to show a log in prompt to users who are
denied access to certain content.


Settings
========
You can configure what pages are visible/not visible to each of your user roles
via the 'urls' tab of the 'access control' section of the Drupal Administration.

Visit ?q=admin/user/pathaccess to edit the settings for each role group.

Page visibility configuration is carried out in exactly the same way as block
visibility in Drupal core.


Credits
=======
This module is the work of Mike Carter <ixis.co.uk/contact>. Please use the Drupal
support forums for queries on usage. http://drupal.org/forum
