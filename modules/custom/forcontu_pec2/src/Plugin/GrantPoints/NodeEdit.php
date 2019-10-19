<?php

namespace Drupal\forcontu_pec2\Plugin\GrantPoints;

use Drupal\forcontu_pec2\GrantPointsBase;

/**
* Provides an GrantPoints entity.
*
* @GrantPoints(
* id = "NodeEdit",
* description = @Translation("Forcontu Pec2 Grant Points")
* )
*/
class NodeEdit extends GrantPointsBase {
  public function grant($Points) {
    return;
 }
}
