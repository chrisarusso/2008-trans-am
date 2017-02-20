#!/usr/bin/perl


foreach $module (@ARGV) {
	$cmd="cvs -z7 -d:pserver:anonymous:anonymous\@cvs.drupal.org:/cvs/drupal-contrib checkout -d $module contributions/modules/$module";
	$rv=system($cmd);
	print "cmd=\n\n$cmd\nrv=$rv\n";
}
