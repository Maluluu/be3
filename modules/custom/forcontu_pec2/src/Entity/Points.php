<?php

namespace Drupal\forcontu_pec2\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;
use Drupal\node\NodeInterface;

/**
 * Defines the Points entity.
 *
 * @ingroup forcontu_pec2
 *
 * @ContentEntityType(
 *   id = "forcontu_pec2_points",
 *   label = @Translation("Points"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\forcontu_pec2\PointsListBuilder",
 *     "views_data" = "Drupal\forcontu_pec2\Entity\PointsViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\forcontu_pec2\Form\PointsForm",
 *       "add" = "Drupal\forcontu_pec2\Form\PointsForm",
 *       "edit" = "Drupal\forcontu_pec2\Form\PointsForm",
 *       "delete" = "Drupal\forcontu_pec2\Form\PointsDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\forcontu_pec2\PointsHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\forcontu_pec2\PointsAccessControlHandler",
 *   },
 *   base_table = "forcontu_pec2_points",
 *   translatable = FALSE,
 *   admin_permission = "administer points entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "type_entity" = "type_entity",
 *     "id_entity" = "id_entity",
 *     "langcode" = "langcode",
 *     "operation" = "operation", 
 *     "points" = "points",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/forcontu_pec2_points/{forcontu_pec2_points}",
 *     "add-form" = "/admin/structure/forcontu_pec2_points/add",
 *     "edit-form" = "/admin/structure/forcontu_pec2_points/{forcontu_pec2_points}/edit",
 *     "delete-form" = "/admin/structure/forcontu_pec2_points/{forcontu_pec2_points}/delete",
 *     "collection" = "/admin/structure/forcontu_pec2_points",
 *   },
 *   field_ui_base_route = "forcontu_pec2_points.settings"
 * )
 */
class Points extends ContentEntityBase implements PointsInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
 //     'type_entity' => \Drupal::entityTypeManager()->type(),
 //     'id_entity' => \Drupal::entityTypeManager()->getEntityTypeId(),
     ];
  }

  /**
   * {@inheritdoc}
   */
  public function getTypeEntity() {
    return $this->bundle();
  }

  /**
   * {@inheritdoc}
   */
  public function setTypeEntity(NodeInterface $node) { 
    $this->set('type_entity', $node->getEntityType());
    return $this;
  }
  public function getIdEntity(){
    return $this->get('type_entity')->target_id;
  }
  
  public function setIdEntity($id){
    $this->set('id_entity', $id);
    return $this;
  }
  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }
  
   /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  } 
  
  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }
  
  public function getOperation(){
    return $this->get('operation')->value;
  }
  public function setOperation($op){
    $this->set('operation', $op);
    return $this;
  }
    
  public function getPoints(){
    return $this->get('points')->value;
  }
  public function setPoints($points){
    $this->set('points', $points);
    return $this;
  }
  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }
 
  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
   // $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Points entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
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
    
    $fields['type_entity'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Type Entity'))
      ->setDescription(t('The type of entity on which the operation is performed.'))
      ->setRevisionable(TRUE)
      ->setSetting('type_entity', 'node')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDefaultValue('node')
      ->setDisplayOptions('view', [
        'label' => 'Type',
        'type' => 'string',
        'weight' => 0,
        ])
      ->setDisplayOptions('form', [
        'type' => 'string_textField',
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
    
    $fields['id_entity'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('ID Entity'))
      ->setDescription(t('The id of the entity on which the operation is performed.'))
      ->setRevisionable(TRUE)
      ->setSetting('id_entity', 'ID_entity')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'ID',
        'type' => 'ID Entity',
        'weight' => 0,
        ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference',
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
    
    $op_values = ['Create' => 'create (5 points)', 'Update' => 'update (1 point)'];
    $fields['operation'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Operation'))
      ->setDescription(t('The CRUD operation that was done.'))
      ->setRevisionable(FALSE)
      ->setRequired(TRUE)
      ->setSettings([
        'allowed_values' => $op_values,
      ])
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_checkbox',
        'weight' => 5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $points_values = ['5 Points' => '5', '1 Point' => '1'];
    $fields['points'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Points'))
      ->setDescription(t('Points conceiveddone.'))
      ->setRevisionable(FALSE)
      ->setRequired(TRUE)
      ->setSettings([
        'allowed_values' => $points_values,
      ])
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_checkbox',
        'weight' => 5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);    
/*
    $fields['status']->setDescription(t('A boolean indicating whether the Points is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);
 */
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
