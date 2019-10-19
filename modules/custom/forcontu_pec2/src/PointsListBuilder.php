<?php

namespace Drupal\forcontu_pec2;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
// use Drupal\Core\Link;
use Drupal\Core\Datetime\DateFormatterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityStorageInterface;


/**
 * Defines a class to build a listing of Points entities.
 *
 * @ingroup forcontu_pec2
 */
class PointsListBuilder extends EntityListBuilder {
  protected $dateFormatter;

  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, DateFormatterInterface $date_formatter) {
    parent::__construct($entity_type, $storage);
    $this->dateFormatter = $date_formatter;
  }
  
  /**
  * {@inheritdoc}
  */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static($entity_type, 
        $container->get('entity_type.manager')->getStorage($entity_type->id()), 
        $container->get('date.formatter')
        );
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['user_id'] = $this->t('User ID');
    $header['type_entity'] = $this->t('Type Entity');
    $header['id_entity'] = $this->t('ID Entity');
    $header['operation'] = $this->t('Operation');
    $header['created'] = $this->t('Created');
    $header['points'] = $this->t('Points');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\forcontu_pec2\Entity\Points $entity */
    $row['user_id'] = $entity->getOwnerId();
   // $row['name'] = Link::createFromRoute($entity->label(), 'entity.forcontu_pec2_points.edit_form', ['forcontu_pec2_points' => $entity->id()]);
    $row['type_entity'] = $entity->getTypeEntity();
    $row['id_entity'] = $entity->getIdEntity();
    $row['operation'] =  $entity->getOperation();
    $row['created'] = $this->dateFormatter->format($entity->getCreatedTime(), 'short');
    $row['points'] =  $entity->getPoints();
    return $row + parent::buildRow($entity);
  }

}
