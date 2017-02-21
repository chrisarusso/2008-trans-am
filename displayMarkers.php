<?php

/*
 * Previous implementation relied on MySQL query
 * We've now flattened things to a CSV file we read from
 */
$csv = array_map('str_getcsv', file('wc-outfile.csv'));


// Output XML that the map JS will read from.
// Perhaps not well formed?

	echo
  '<?xml version="1.0" encoding="ISO-8859-1"?>
    <markers>';
    if(is_array($csv)){
      foreach($csv as $key => $val){
        echo "<marker time=\"{$val[4]}\" lat=\"{$val[1]}\" lon=\"{$val[2]}\" />\n";
      }
    }

  echo "</markers>";
