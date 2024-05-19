<?php
/**
 * @file
 * Contains Drupal\realty\Form\RealtyForm.
 */

namespace Drupal\realty\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the realty entity edit forms.
 *
 * @ingroup content_entity_example
 */
class RealtyForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\realty\Entity\Realty */
    $form = parent::buildForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    // Redirect to realty list after save.
    $form_state->setRedirect('entity.realty.collection');
    $entity = $this->getEntity();
    $entity->save();
  }

}