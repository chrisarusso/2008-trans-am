Signature.module for drupal 5.x

Features
--------
   1. Makes user signatures dynamical, that is, if user change his signature in his profile, after each of his/her posts will be the new signature!
   2. Usability benefits - 'cause each time a comment is posted, user don't have to pull down signature to the end of his/her comment.
   3. Comments can be styled another way than the post itself, and it's customizable from 'administer->settings->signature'.
   4. Shows signatures not only after comments, but also after nodes (the only limitation that some html tags will be stripped out).
   5. Allows define content types (and at once comments for them) where signatures should be seen and where not.
   6. New: If the module is enabled, but signatures are disabled for all content types, signature field isn't displayed at user profile settings (So, if you use comment.module but don't want you users to have a signature in their profiles, you need this module too).

New: No patching is required now!

Actually, this is a kind of a hack of the comment.module, and if you like it, please let us know (here). More people will use it, more possibility that the module will become nice, clean and separate from comment.module.
It's kind of a hack, but perfomance is ok: the module adds only 2 simple queries for pages with comments.

Tested with Drupal 5.0 and 5.1



Installation
------------
Just copy the module into your modules directory.



Configuration
-------------
1. Enable the module.
2. Go to 'administer->settings->signature' and choose node types for which you want to see signatures.



This module is free. But, if you really like it, please do me a favor. Post somewhere (at your site's forum, or blog) a link to my site http://alongtail.com (Please! Find 10 minutes to check it out and post somewhere a link with a description).



Author
------
Dmitry Gukov (ultraBoy at Drupal.org)
Updated by Jonas Wouters (zertox at Drupal.org)