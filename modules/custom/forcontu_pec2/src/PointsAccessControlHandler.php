<?php

namespace Drupal\forcontu_pec2;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Points entity.
 *
 * @see \Drupal\forcontu_pec2\Entity\Points.
 */
class PointsAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\forcontu_pec2\Entity\PointsInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished points entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published points entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit points entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete points entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add points entities');
  }

}
