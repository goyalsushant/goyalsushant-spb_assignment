<?php

namespace Drupal\custom_block;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class TimeService.
 *
 * Create a service to get Time.
 */
class TimeService {

  /**
   * @param Drupal\Core\Config\ConfigFactoryInterface $config_factory
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Function getTime().
   */
  public function getTime() {
    $website_config = $this->configFactory->get('custom_website_config.settings');
    $website_timezone = empty($website_config->get('cwc.site_timezone')) ? '' : $website_config->get('cwc.site_timezone');
    if (empty($website_timezone)) {
      return;
    }
    else {
      $date = new \DateTime("now", new \DateTimeZone($website_timezone));
      $formatted_date = $date->format('dS M Y - H:i a');

      return $formatted_date;
    }
  }

}
