<?php

namespace Drupal\forcontu_pec2\Plugin\GrantPoints;

use Drupal\forcontu_pec2\GrantPointsBase;

/**
* Provides an GrantPoints entity.
*
* @GrantPoints(
* id = "NodeDelete",
* description = @Translation("Forcontu Pec2 Grant Points")
* )
*/
class NodeDelete extends GrantPointsBase {
  public function grant($Points) {
    return;
 }
}
