<?php
// $Id: copyright.inc 371 2007-10-18 15:47:58Z rfay $

/**
 * @file
 * Support file for COPYRIGHT meta tag.
 */

function nodewords_copyright_prepare($type, $ids, $value, $settings) {
  if ((!isset($value) || $value == '')) {
    $value = $settings['global']['copyright'];
  }
  return $value;
}

function nodewords_copyright_form($type, $value, $settings) {
  return array(
    '#type' => 'textfield',
    '#title' => t('Copyright'),
    '#default_value' => $value,
    '#size' => 60,
    '#maxlength' => $settings['max_size'],
    '#description' => t('Enter a short copyright statement for this page.'),
  );
}
