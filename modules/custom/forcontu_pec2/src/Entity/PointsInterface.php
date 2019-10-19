<?php

namespace Drupal\forcontu_pec2\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\node\NodeInterface;

/**
 * Provides an interface for defining Points entities.
 *
 * @ingroup forcontu_pec2
 */
interface PointsInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Points type_entity.
   *
   * @return $node
   *   Type of entity of the Points.
   */
  public function getTypeEntity();

  /**
   * Sets the Points type_entity.
   *
   * @param $node
   *   The Points type Entity.
   *
   * @return \Drupal\forcontu_pec2\Entity\PointsInterface
   *   The called Points entity.
   */
  public function setTypeEntity(NodeInterface $node);

    /**
   * Gets the Points id_entity.
   *
   * @return string
   *   Id of entity of the Points.
   */
  public function getIdEntity();

  /**
   * Sets the Points id_entity.
   *
   * @param string $id
   *   The Points Id Entity.
   *
   * @return \Drupal\forcontu_pec2\Entity\PointsInterface
   *   The called Points entity.
   */
  public function setIdEntity($id);
  
  /**
   * Gets the Points creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Points.
   */
  public function getCreatedTime();

  /**
   * Sets the Points creation timestamp.
   *
   * @param int $timestamp
   *   The Points creation timestamp.
   *
   * @return \Drupal\forcontu_pec2\Entity\PointsInterface
   *   The called Points entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Points creation operation.
   *
   * @return int
   *   Creation operaation of the Points.
   */
  public function getOperation();
  /**
   * Sets the Points creation operation.
   *
   * @param int $op
   *   The Points creation operation.
   *
   * @return \Drupal\forcontu_pec2\Entity\PointsInterface
   *   The called Points entity.
   */
  public function setOperation($op);
  
    /**
   * Gets the Points creation points.
   *
   * @return int
   *   Creation points of the Points.
   */
  public function getPoints();
  /**
   * Sets the Points creation points.
   *
   * @param int $points
   *   The Points creation points.
   *
   * @return \Drupal\forcontu_pec2\Entity\PointsInterface
   *   The called Points entity.
   */
  public function setPoints($points);
  
    /**
   * Returns the Points published status indicator.
   *
   * Unpublished Points are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Points is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Points.
   *
   * @param bool $published
   *   TRUE to set this Points to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\forcontu_pru\Entity\PointsInterface
   *   The called Points entity.
   */
  public function setPublished($published);
}
