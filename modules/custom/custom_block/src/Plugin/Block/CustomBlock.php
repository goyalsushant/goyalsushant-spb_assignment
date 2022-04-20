<?php

namespace Drupal\custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\custom_block\TimeService;

/**
 * Provides a block with a website information.
 *
 * @Block(
 *   id = "website_information",
 *   admin_label = @Translation("Website Information Block"),
 * )
 */
class CustomBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param Drupal\Core\Config\ConfigFactoryInterface $config_factory
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, TimeService $time_service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->timeService = $time_service;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('custom_block.get_time')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $website_config = $this->configFactory->get('custom_website_config.settings');
    $website_country = empty($website_config->get('cwc.site_country')) ? '' : $website_config->get('cwc.site_country');
    $website_city = empty($website_config->get('cwc.site_city')) ? '' : $website_config->get('cwc.site_city');
    $formatted_date = $this->timeService->getTime();
    return [
      '#theme' => 'custom_block',
      '#block_content' => [$website_country, $website_city, $formatted_date],
      '#cache' => [
        'max-age' => 3600,
      ],
    ];
  }

}
