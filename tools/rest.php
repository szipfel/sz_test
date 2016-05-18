<?php

/**
 * Class WebServiceSync
 *
 * This Class is for connecting to an available web service (URL set in the sz_test modules /admin/conf/sz_test/settings) to get the
 * JSON, and process it into baznds and songs related to the bands.
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
   * Get the bands from the JSON and return them as an array
   *
   * @return mixed
   */
  public function get_bands() {
    // if we have cached results, let's use them.
    $cache = cache_get('sz_bands_cache');
    if(isset($cache->data)) {
      return $cache->data;
    }

    $bands[0] = t('Choose a band'); // Default select value.
    $data = self::process_json();
    foreach ($data as $key => $value) {
      $bands[$key] = $key;
    }

    cache_set('sz_bands_cache', $bands); // cache the values.
    return $bands;
  }

  /**
   * Get the songs associated with a band and return as array
   *
   * @param $band
   * @return mixed
   */
  public function get_songs($band) {
    // load up the cached versions.
    $cache = cache_get('sz_songs_cache_' . $band);
    if(isset($cache->data)){
      return $cache->data;
    }
    $songs[0] = t('Choose a song');
    $data = self::process_json();
    foreach ($data[$band] as $key => $song) {
      $songs[$song] = $data[$band][$key];
    }
    cache_set('sz_songs_cache_' . $band, $songs); // cache the values.
    return $songs;
  }

  /**
   * Get the available data and parse it into an array for computation
   *
   * @return array|bool
   */
  public function process_json() {
    $file_location = variable_get('sz_test_songs_api_location', NULL); // this is set @ admin/config/sz_test/settings/
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
     * Change the structure to use the band name as the key in order to make it easier to parse the
     * associated songs
     */
    if(!empty($file_data)) {
      foreach ($file_data as $value) {
        $data[$value['name']] = array_change_key_case($value['songs'], CASE_LOWER);
      }
    } else {
      return FALSE;
    }
    cache_set('sz_external_data', $data); // cache the results.
    return $data;
  }





}
