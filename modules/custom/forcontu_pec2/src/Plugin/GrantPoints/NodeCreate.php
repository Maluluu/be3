<?php

namespace Drupal\forcontu_pec2\Plugin\GrantPoints;

use Drupal\forcontu_pec2\GrantPointsBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\forcontu_plugins\GrantPointsPluginManager;


/**
* Provides an GrantPoints entity.
*
* @GrantPoints(
* id = "NodeCreate",
* description = @Translation("Forcontu Pec2 Grant Points")
* )
*/
class NodeCreate extends GrantPointsBase {

  public function grant($entity) {
    $points = \Drupal::entityTypeManager()->getStore('forcontu_pec2_points');
    $user = \Drupal::currentUser()->id();
    $points->create( [
      'type_entity' => $entity->id(),
      'id_entity' => $entity->getIdEntity(),
      'operation' => 'create',
      'points' => 5,
      'user_id' => $user,
      'timestamp' => time(),
     ])->save();
    return;
 }
}
