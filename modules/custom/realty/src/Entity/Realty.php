<?php
/**
 * @file
 * Contains \Drupal\realty\Entity\Realty.
 */

namespace Drupal\realty\Entity;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Link;
use Drupal\Core\Render\Markup;

/**
 * Defines the realty entity.
 * 
 * @ingroup realty
 * 
 * @ContentEntityType(
 *  id = "realty",
 *  label = @Translation("Realty"),
 *  base_table = "realty",
 *  data_table = "realty_field_data",
 *  revision_table = "realty_revision",
 *  revision_data_table = "realty_field_revision",
 *  entity_keys = {
 *      "id" = "id",
 *      "uuid" = "uuid",
 *      "label" = "title",
 *      "revision" = "vid",
 *      "status" = "status",
 *      "published" = "status",
 *      "uid" = "uid",
 *      "owner" = "uid",
 *  },
 *  revision_metadata_keys = {
 *      "revision_user" = "revision_uid",
 *      "revision_created" = "revision_timestamp",
 *      "revision_log_message" = "revision_log"
 *  },
 *  handlers = {
 *      "access" = "Drupal\realty\RealtyAccessControlHandler",
 *      "views_data" = "Drupal\realty\RealtyViewsData",
 *      "form" = {
 *          "add" = "Drupal\realty\Form\RealtyForm",
 *          "edit" = "Drupal\realty\Form\RealtyForm",
 *          "delete" = "Drupal\realty\Form\RealtyDeleteForm",
 *      }
 *  },
 *  links = {
 *      "canonical" = "/realtys/{realty}",
 *      "delete-form" = "/realty/{realty}/delete",
 *      "edit-form" = "/realty/{realty}/edit",
 *      "create" = "/realty/create"
 *  },
 *  field_ui_base_route = "entity.realty.settings"
 * )
 */

 class Realty extends EditorialContentEntityBase {

    public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
      $fields = parent::baseFieldDefinitions($entity_type); // provides id and uuid fields
      
      $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
        ->setLabel(t('User'))
        ->setDescription(t('The user that created the realty.'))
        ->setSetting('target_type', 'user')
        ->setSetting('handler', 'default')
        ->setDisplayOptions('view', [
          'label' => 'user',
          'type' => 'author',
          'weight' => 0,
        ])
        ->setDisplayOptions('form', [
          'type' => 'entity_reference_autocomplete',
          'weight' => 5,
          'settings' => [
            'match_operator' => 'CONTAINS',
            'size' => '60',
            'autocomplete_type' => 'tags',
            'placeholder' => '',
          ],
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);
  
      $fields['title'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Title'))
        ->setDescription(t('The title of the realty'))
        ->setSettings([
          'max_length' => 150,
          'text_processing' => 0,
        ])
        ->setDefaultValue('')
        ->setDisplayOptions('view', [
          'label' => 'above',
          'type' => 'string',
          'weight' => -4,
        ])
        ->setDisplayOptions('form', [
          'type' => 'string_textfield',
          'weight' => -4,
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);
  
      $fields['status'] = BaseFieldDefinition::create('boolean')
        ->setLabel(t('Publishing status'))
        ->setDescription(t('A boolean indicating whether the Realty entity is published.'))
        ->setDefaultValue(TRUE);
  
      $fields['created'] = BaseFieldDefinition::create('created')
        ->setLabel(t('Created'))
        ->setDescription(t('The time that the entity was created.'));
  
      $fields['changed'] = BaseFieldDefinition::create('changed')
        ->setLabel(t('Changed'))
        ->setDescription(t('The time that the entity was last edited.'));
      
      return $fields;
    }
  
    /**
     * {@inheritdoc}
     */
    public function getOwner() {
      /* dd($this->get('user_id')->entity); */
      return $this->get('user_id')->entity;
    }
  
    /**
     * {@inheritdoc}
     */
    public function getOwnerId() {
      return $this->get('user_id')->target_id;
    }

    /**
     * Return Promo Text
     */
    public function getPromoText(){
      return 'Be the First';
    }
  
    /**
     * Return a price field
     * @return string the price
     */
    public function getPriceAmount(){
      switch($this->get('field_realty_type')->getString()){
        case 'with_minimum':
          return $this->get('field_price')->getString() . '$';
          break;
        case 'no_minimum':
          return 'Start bidding at 0$';
      }
      return '';
    }
}