<?php

namespace Drupal\realty\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\ViewExecutable;
use Drupal\core\Url;

/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("realty_dynamic_operation_links")
 */
class RealtyDynamicOperationLinks extends FieldPluginBase{

  /**
   * The current display.
   *
   * @var string
   *   The current display of the view.
   */
  protected $currentDisplay;

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL){
    parent::init($view, $display, $options);
    $this->currentDisplay = $view->current_display;
  }

  /**
   * {@inheritdoc}
   */
  public function usesGroupBy(){
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query(){
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions(){
    $options = parent::defineOptions();
    $options['hide_alter_empty'] = ['default' => FALSE];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values){
    $entity = $values->_entity;
    $state = $entity->get('moderation_state')->getString();

    switch ($state) {
      case 'draft':
        $operations['publish'] = [
          'title' => $this->t('Publish'),
          'url' => Url::fromRoute('realty.publish', ['realty' => $entity->id()])
        ];
        break;
    }

    $operations['edit'] = [
      'title' => $this->t('Edit'),
      'url' => Url::fromRoute('entity.realty.edit_form', ['realty' => $entity->id()])
    ];

    $operations['delete'] = [
      'title' => $this->t('Delete'),
      'url' => Url::fromRoute('entity.realty.delete_form', ['realty' => $entity->id()])
    ];

    $dropbutton = [
      '#type' => 'dropbutton',
      '#links' => $operations
    ];

    $renderedOutput = \Drupal::service('renderer')->render($dropbutton);
    return $renderedOutput;

  }
}