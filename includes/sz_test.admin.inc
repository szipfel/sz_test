<?PHP
/**
 *  Admin tools for Steve Zipfel's Test module settings
 */

function sz_test_admin_form($form, &$form_state) {

  $form['songs_api_location'] = array(
    '#type' => 'textfield',
    '#title' => t('Songs API URL'),
    '#description' => t('The URL for the songs rest API'),
    '#default_value' => variable_get('sz_test_songs_api_location', 'http://webrepublic.ca/songlist.json'),
    '#required' => TRUE,
  );

  $form['test_mode'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable test mode'),
    '#description' => t('Enabling test mode will not check IP address from $_SERVER variable. -- NOT finished.'),
    '#default_value' => (variable_get('sz_test_test_mode')) ? variable_get('sz_test_test_mode') : TRUE,
  );

  $form['save'] = array(
    '#type' => 'submit',
    '#value' => t('Save configuration')
  );

  return $form;

}

/**
 * Submit the settings form
 *
 * @param $form
 * @param $form_state
 */
function sz_test_admin_form_submit($form, &$form_state) {

  // make sure it's a valid URL:
  if (!filter_var( $form_state['values']['songs_api_location'], FILTER_VALIDATE_URL) === false) {
    variable_set('sz_test_songs_api_location', $form_state['values']['songs_api_location']);
  } else {
    drupal_set_message(t('Not a valid URL'), 'error');
  }

  variable_set('sz_test_test_mode', $form_state['values']['test_mode']);

  drupal_set_message(t('Your configuration has been saved.'));

}



?>
