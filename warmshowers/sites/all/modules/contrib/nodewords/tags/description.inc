<?php
// $Id: description.inc 371 2007-10-18 15:47:58Z rfay $

/**
 * @file
 * Support file for DESCRIPTION meta tag.
 */

function nodewords_description_prepare($type, $ids, $value, $settings) {
  if ((!isset($value) || empty($value)) && $settings['use_teaser'] && count($ids) == 1) {
    switch ($type) {
      case 'node':
        $node = node_load($ids[0]);
        if ($node && node_access('view', $node)) {
          // HACK: see http://drupal.org/node/79315 (can't use php functions in
          // body of nodes).
          $cachable = filter_format_allowcache($node->format);
          if ($cachable) {
            // HACK: see http://drupal.org/node/89067 (teaser as description with
            // [inline] error).
            if (node_hook($node, 'view')) {
              node_invoke($node, 'view', TRUE);
            }
            else {
              $node = node_prepare($node, TRUE);
            }
            node_invoke_nodeapi($node, 'view', TRUE);
            node_invoke_nodeapi($node, 'alter', TRUE);
            $value = $node->teaser;
          }
        }
        break;

      case 'term':
        // TODO: probably we have to do a db_rewrite_sql() query here so access is restricted
        $term = taxonomy_get_term($ids[0]);
        if ($term) {
          $value = $term->description;
        }
        break;
      case 'vocabulary':
        // TODO: probably we have to do a db_rewrite_sql() query here so access is restricted
        $voc = taxonomy_get_vocabulary($ids[0]);
        if ($voc) {
          $value = $voc->description;
        }
        break;
    }
  }
  return $value;
}

function nodewords_description_form($type, $value, $settings) {
  return array(
    '#type' => 'textarea',
    '#title' => t('Description'),
    '#default_value' => $value,
    '#cols' => 60,
    '#rows' => 6,
    '#description' => t('Enter a description for this page. Limit your description to about 20 words, with a maximum of %count characters. It should not contain any HTML tags or other formatting.', array('%count' => $settings['max_size'])) . ($settings['use_teaser'] ? ' ' . t('When you leave this field empty, the teaser will be used as description.') : ''),
  );
}
