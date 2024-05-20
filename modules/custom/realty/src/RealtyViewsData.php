<?php

namespace Drupal\realty;

use Drupal\views\EntityViewsData;

/**
 * Provides views data for Realty entities.
 *
 */
class RealtyViewsData extends EntityViewsData {

  /**
   * Returns the Views data for the entity.
   */
  public function getViewsData() {
    
    $data = parent::getViewsData();
    
    $data['realty']['realty_entity_moderation_state_views_field'] = [
      'title' => t('Moderation status'),
      'field' => [
        'title' => t('Moderation status'),
        'help' => t('Shows the status of the realty entity'),
        'id' => 'realty_entity_moderation_state_views_field'
      ]
    ];

    $data['realty']['realty_dynamic_operation_links'] = [
      'title' => t('Dynamic operations'),
      'field' => [
        'title' => t('Dynamic operations'),
        'help' => t('Shows a dropbutton with dynamic operations for realtys.'),
        'id' => 'realty_dynamic_operation_links',
      ]
    ];

    return $data;
  }
}