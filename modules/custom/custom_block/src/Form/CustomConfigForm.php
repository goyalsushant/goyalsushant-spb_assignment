<?php

namespace Drupal\custom_block\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Website configuration form.
 */
class CustomConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_website_config';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['custom_website_config.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->configFactory->get('custom_website_config.settings');

    $form['site_country'] = [
      '#type' => 'textfield',
      '#title' => 'Website: Country',
      '#default_value' => $config->get('cwc.site_country'),
      '#description' => $this->t('The country where website is operated'),
    ];

    $form['site_city'] = [
      '#type' => 'textfield',
      '#title' => 'Website: City',
      '#default_value' => $config->get('cwc.site_city'),
      '#description' => $this->t('The City where website is operated'),
    ];

    $timezone_options = [
      'America/Chicago' => 'Chicago',
      'America/New_York' => 'New York',
      'Asia/Tokyo' => 'Tokyo',
      'Asia/Dubai' => 'Dubai',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Europe/Amsterdam' => 'Amsterdam',
      'Europe/Oslo' => 'Oslo',
      'Europe/London' => 'London',
    ];

    $form['site_timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Choose the Timezone.'),
      '#options' => $timezone_options,
      '#default_value' => $config->get('cwc.site_timezone'),
      '#description' => $this->t('Separate functionality for both our iNAV update functionality choose to activate'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->configFactory->getEditable('custom_website_config.settings');

    $config
      ->set('cwc.site_country', $form_state->getValue('site_country'))
      ->set('cwc.site_city', $form_state->getValue('site_city'))
      ->set('cwc.site_timezone', $form_state->getValue('site_timezone'));
    $config->save();
    parent::submitForm($form, $form_state);
  }

}
