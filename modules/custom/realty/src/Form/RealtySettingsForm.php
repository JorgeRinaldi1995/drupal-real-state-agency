<?php
/**
 * @file
 * Contains \Drupal\realty\Form\RealtySettingsForm.
 */

namespace Drupal\realty\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RealtySettingsForm.
 *
 * @package Drupal\realty\Form
 *
 * @ingroup realty
 */
class RealtySettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'realty_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['realty_settings']['#markup'] = 'Settings form for realty. We don\'t need additional entity settings. Manage field settings with the tabs above.';
    return $form;
  }

}