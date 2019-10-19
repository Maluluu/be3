<?php

namespace Drupal\forcontu_pec2\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Points entities.
 */
class PointsViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
