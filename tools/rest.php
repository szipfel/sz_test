<?php

/**
 * Class WebServiceSync
 *
 * This Class is for connecting to an available web service (URL set in the sz_test modules /admin/conf/sz_test/settings) to get the
 * JSON, and process it into events and cities related to the events.
 *
 * Author: Steve Zipfel
 * Email: steve@webrepublic.ca
 */

class WebService {

  /**
   * Consumes JSON
   * @return mixed
   *
   */

  /**
   * Get the events from the JSON and return them as an array
   *
   * @return mixed
   */
  public function get_events() {
    // if we have cached results, let's use them.
    $cache = cache_get('sz_events_cache');
    if(isset($cache->data)) {
      return $cache->data;
    }

    $events[0] = t('Choose an event'); // Default select value.
    $data = self::process_json();
    foreach ($data as $key => $value) {
      $events[$key] = $key;
    }

    cache_set('sz_events_cache', $events); // cache the values.
    return $events;
  }

  /**
   * Get the cities associated with an event and return as array
   *
   * @param $event
   * @return mixed
   */
  public function get_cities($event) {
    // load up the cached versions.
    $cache = cache_get('sz_cities_cache');
    if(isset($cache->data)){
      return $cache->data;
    }
    $cities[0] = t('Choose a city');
    $data = self::process_json();
    foreach ($data[$event] as $key => $city) {
      $cities[$city] = $data[$event][$key];
    }
    cache_set('sz_cities_cache', $cities); // cache the values.
    return $cities;
  }

  /**
   * Get the available data and parse it into an array for computation
   *
   * @return array|bool
   */
  public function process_json() {
    $file_location = variable_get('sz_test_cities_api_location', NULL); // this is set @ admin/config/sz_test/settings/
    // Check to see if this data is already cached. If is it return it.
    $cache = cache_get('sz_external_data');
    if (isset($cache->data)) {
      return $cache->data;
    }

    $file = file_get_contents($file_location);

    if (!$file) {
      drupal_set_message(t('Unable to get remote file. ' . $file_location), 'error');

      watchdog('Steve Zipfel Test Module',
        'Unable to get remote file: @file Check settings at: admin/config/sz_test/settings - date: @then',
        array(
          '@then' => date('c', time()),
          '@file' => $file,
        ),
        WATCHDOG_ERROR);

      return FALSE;
    }

    $data = array();
    $file_data = json_decode($file, true);
    /* covert all keys to be lowercase in case data changes case we don't get anything we don't expect.
     * Change the structure to use the event name as the key in order to make it easier to parse the
     * associated cities
     */
    if(!empty($file_data)) {
      foreach ($file_data as $value) {
        $data[$value['name']] = array_change_key_case($value['cities'], CASE_LOWER);
      }
    } else {
      return FALSE;
    }
    cache_set('sz_external_data', $data); // cache the results.
    return $data;
  }





}
