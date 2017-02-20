<?PHP
/* $Id: actions.inc,v 1.12.2.4 2007/04/02 13:43:31 jvandyk Exp $ */

/**
 * @file
 * Contains example Drupal actions for use with the actions module.
 */

/**
 * Implementation of a Drupal action.
 * Sets the status of a node to 1, meaning published.
 *
 */
function action_node_publish($op, $edit = array(), &$node) {
  switch($op) {
    case 'do':
      $node->status = '1';
      $node->revision = '0';
      if (!$edit['defer']) {
        node_save($node);
      }
      watchdog('action', t('Set node id %id to Published', array('%id' => intval($node->nid))));
      break;

    case 'metadata':
      return array(
        'description' => t('Publish node'),
        'type' => t('Node'),
        'batchable' => true,
        'configurable' => false,
      );

    // return an HTML config form for the action
    case 'form':
      return '';

    // validate the HTML form
    case 'validate':
      return TRUE;

    // process the HTML form to store configuration
    case 'submit':
      return '';
  }
}

/**
 * Implementation of a Drupal action.
 * Sets the status of a node to 0, meaning unpublished.
 *
 */
function action_node_unpublish($op, $edit = array(), &$node) {
  switch($op) {
    case 'metadata':
      return array(
        'description' => t('Unpublish node'),
        'type' => t('Node'),
        'batchable' => true,
        'configurable' => false,
      );

   case 'do':
    $node->status = '0';
    $node->revision = '0';
    if (!array_key_exists('defer', $edit)) {
      node_save($node);
    }
    watchdog('action', t('Set node id %id to Unpublished', array('%id' => intval($node->nid))));
    break;

    // return an HTML config form for the action
   case 'form':
    return '';

   // validate the HTML form
   case 'validate':
     return TRUE;

   // process the HTML form to store configuration
   case 'submit':
     return '';
  }
}

/**
 * Implementation of a Drupal action.
 * Sets the sticky-at-top-of-list property of a node to 1.
 *
 */
function action_node_sticky($op, $edit = array(), &$node) {
  switch($op) {
    case 'metadata':
      return array(
        'description' => t('Make node sticky'),
        'type' => t('Node'),
        'batchable' => true,
        'configurable' => false,
      );

    case 'do':
      $node->sticky = '1';
      $node->revision = '0';
      if (!$edit['defer']) {
        node_save($node);
      }
      watchdog('action', t('Made node id %id sticky', array('%id' => intval($node->nid))));
      break;

     // process the HTML form to store configuration
    case 'submit':
      return '';
  }
}

/**
 * Implementation of a Drupal action.
 * Sets the sticky-at-top-of-list property of a node to 0.
 *
 */
function action_node_unsticky($op, $edit = array(), &$node) {
  switch($op) {
    case 'metadata':
      return array(
        'description' => t('Make node unsticky'),
        'type' => t('Node'),
        'batchable' => true,
        'configurable' => false,
      );

    case 'do':
      $node->sticky = '0';
      $node->revision = '0';
      if (!$edit['defer']) {
        node_save($node);
      }
      watchdog('action', t('Made node id %id unsticky', array('%id' => intval($node->nid))));
      break;

    // process the HTML form to store configuration
    case 'submit':
      return '';
  }
}

/**
 * Implementation of a Drupal action.
 * Sets the promote property of a node to 1.
 *
 */
function action_node_promote($op, $edit = array(), &$node) {
  switch($op) {
    case 'metadata':
      return array(
        'description' => t('Promote node to front page'),
        'type' => t('Node'),
        'batchable' => true,
        'configurable' => false,
      );

    case 'do':
      $node->promote = '1';
      $node->revision = '0';
      if (!$edit['defer']) {
        node_save($node);
      }
      watchdog('action', t('Promoted node id %id to front page', array('%id' => intval($node->nid))));
      break;

    // process the HTML form to store configuration
    case 'submit':
      return '';
  }
}

/**
 * Implementation of a Drupal action.
 * Sets the promote property of a node to 0.
 *
 */
function action_node_unpromote($op, $edit = array(), &$node) {
  switch($op) {
    case 'metadata':
      return array(
        'description' => t('Remove node from front page'),
        'type' => t('Node'),
        'batchable' => true,
        'configurable' => false,
      );

    case 'do':
      $node->promote = '0';
      $node->revision = '0';
      if (!$edit['defer']) {
        node_save($node);
      }
      watchdog('action', t('Removed node id %id from front page', array('%id' => intval($node->nid))));
      break;

    // process the HTML form to store configuration
    case 'submit':
      return '';
  }
}

/**
 * Implementation of a Drupal action.
 * Assigns ownership of a node to a user.
 *
 */
function action_node_assign_owner($op, $edit = array(), &$node) {
  switch($op) {
    case 'metadata':
      return array(
        'description' => t('Change node author'),
        'type' => t('Node'),
        'batchable' => true,
        'configurable' => true,
      );

    case 'do':
      $uid = db_result(db_query("SELECT uid FROM {users} WHERE name = '%s'", $edit['owner_name']));
      $node->uid = $uid;
      $node->revision = '0';
      if (!$edit['defer']) {
        node_save($node);
      }
      watchdog('action', t('Changed owner of node %id to uid %uid', array('%id' => intval($node->nid), '%uid' => intval($edit['new_uid']))));
      break;

    case 'form':
      $form = array();
      // add form components
      $desc = t('The username of the user to which you would like to assign ownership.');
      $count = db_result(db_query("SELECT COUNT(*) FROM {users}"));
      if (intval($count) < 200) {
        $options = array();
        $result = db_query("SELECT uid, name FROM {users} WHERE uid > 0 ORDER BY name");
        while ($data = db_fetch_object($result)) {
          $options[$data->name] = $data->name;
        }
        $form['owner_name'] = array(
          '#type' => 'select',
          '#title' => t('Username'),
          '#default_value' => $edit['owner_name'],
          '#options' => $options,
          '#description' => $desc,
        );
      }
      else {
        $form['owner_name'] = array(
          '#type' => 'textfield',
          '#title' => t('Username'),
          '#default_value' => $edit['owner_name'],
          '#size' => '6',
          '#maxlength' => '7',
          '#description' => $desc,
        );
      }
      return $form;

    case 'validate':
      $errors = array();

      $count = db_result(db_query("SELECT COUNT(*) FROM {users} WHERE name = '%s'", $edit['owner_name']));
      if (intval($count) != 1) {
        $errors['owner_name'] = t('Please enter a valid username.');
      }
      foreach ($errors as $name => $message) {
        form_set_error($name, $message);
      }

      return count($errors) == 0;

    // process the HTML form to store configuration
    case 'submit':
      /* this doesn't actually work, but would be cool;
      // it would modify the description to something better than the default
      // if the user did not modify the description
      $metadata = action_node_assign_owner('metadata');
      if ($edit['actions_desc'] == $metadata['description']) {
        $edit['actions_desc'] = $metadata['description'] . ' ' . t('to') . ' ' . $edit['owner_name'];
      }
      */
      $params = array('owner_name' => $edit['owner_name']);
      return $params;
  }
}

/**
 * Implementation of a Drupal action.
 * This is an example action. Actions should live in the modules
 * for which the actions apply. For example, node actions should
 * be exposed by node.module.
 *
 */
function action_send_email($op, $edit = array(), $node) {
  switch($op) {
    case 'metadata':
      return array(
        'description' => t('Send Email'),
        'type' => t('Email'),
        'batchable' => false,
        'configurable' => true,
      );

    case 'do':
      // note this is the user who owns the node, not global $user
      $user = user_load(array('uid' => $node->uid));
      $site_name = variable_get('site_name', 'Drupal');
      $from = variable_get('site_mail', ini_get('sendmail_from'));
      $subject = $edit['subject'];
      $message = $edit['message'];
      if ($edit['recipient'] == t('%author')) {
        $recipient = $user->mail;
      } else {
        $recipient = $edit['recipient'];
      }
      if (isset($node) && is_object($node)) {
        $variables = array(
          '%site_name' => $site_name,
          '%username' => $user->name,
          '%uid' => $node->uid,
          '%node_url' => url('node/' . $node->nid, NULL, NULL, TRUE),
          '%node_type' => $node->type,
          '%title' => $node->title,
          '%teaser' => strip_tags($node->teaser),
          '%body' => strip_tags($node->body)
           );

        $subject = strtr($subject, $variables);
        $subject = str_replace(array("\r", "\n"), '', $subject);
        $message = strtr($message, $variables);
      }
      if (drupal_mail('action_send_email', $recipient, $subject, $message, $from)) {
        watchdog('action', t('Sent email to %recipient', array('%recipient' => $recipient)));
      }
      else {
        watchdog('error', t('Unable to send email to %recipient', array('%recipient' => $recipient)));
      }
      break;

    // return an HTML config form for the action
    case 'form':
      // default values for form
      if (!isset($edit['recipient'])) $edit['recipient'] = '';
      if (!isset($edit['subject'])) $edit['subject'] = '';
      if (!isset($edit['message'])) $edit['message'] = '';
      $form = array();

      // add form components
      $form['recipient'] = array(
        '#type' => 'textfield',
        '#title' => t('Recipient'),
        '#default_value' => $edit['recipient'],
        '#size' => '20',
        '#maxlength' => '254',
        '#description' => t('The email address to which the message should be sent OR enter %author if you would like to send an e-mail to the original author of the post.', array('%author' => theme('placeholder', t('%author')))),
      );
      $form['subject'] = array(
        '#type' => 'textfield',
        '#title' => t('Subject'),
        '#default_value' => $edit['subject'],
        '#size' => '20',
        '#maxlength' => '254',
        '#description' => t('The subject of the message.'),
      );
      $form['message'] = array(
        '#type' => 'textarea',
        '#title' => t('Message'),
        '#default_value' => $edit['message'],
        '#cols' => '80',
        '#rows' => '20',
        '#description' => t('The message that should be sent.  You may include the following variables: %site_name, %username, %node_url, %node_type, %title, %teaser, %body'),
      );
      return $form;

     // validate the HTML form
    case 'validate':
      $errors = array();

      if (!valid_email_address($edit['recipient']) && $edit['recipient'] != t('%author')) {
        $errors['recipient'] = t('Please enter a valid email address or %author.', array('%author' => theme('placeholder', t('%author'))));
      }
      foreach ($errors as $name => $message) {
        form_set_error($name, $message);
      }

      return count($errors) == 0;

    // process the HTML form to store configuration
    case 'submit':
      $params = array(
        'recipient' => $edit['recipient'],
        'subject'   => $edit['subject'],
        'message'   => $edit['message']);
      return $params;
  }
}

/**
 * Implementation of a Drupal action.
 * 
 * Sends a configurable message to the current user's screen.
 */
function action_set_message($op, $edit = array(), &$node) {
  switch($op) {
    case 'do':
      global $user;
      $variables = array(
        '%site_name' => variable_get('site_name', 'drupal'),
        '%username' => $user->name ? $user->name : variable_get('anonymous', 'Anonymous'),
      );
      
      if (isset($node) && is_object($node)) {
        $variables += array(
          '%uid' => $node->uid,
          '%node_url' => url('node/' . $node->nid, NULL, NULL, TRUE),
          '%node_type' => $node->type,
          '%title' => strip_tags($node->title),
          '%teaser' => strip_tags($node->teaser),
          '%body' => strip_tags($node->body),
        );
      }
      $edit['message'] = strtr($edit['message'], $variables);
      drupal_set_message($edit['message']);
      break;

    case 'metadata':
      return array(
        'description' => t('Display message to current user'),
        'type' => t('Message'),
        'batchable' => TRUE,
        'configurable' => TRUE,
      );

    // return an HTML config form for the action
    case 'form':
      $form['message'] = array(
        '#type' => 'textarea',
        '#title' => t('Message'),
        '#default_value' => isset($edit['message']) ? $edit['message'] : '',
        '#required' => TRUE,
        '#rows' => '8',
        '#description' => t('The message to be displayed to the current user.  You may include the following variables: %site_name, %username, %node_url, %node_type, %title, %teaser, %body.'),
      );
      return $form;

    // validate the HTML form
    case 'validate':
      return TRUE;

    // process the HTML form to store configuration
    case 'submit':
      return array('message' => $edit['message']);
  }
}
