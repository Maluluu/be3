<?php

namespace Drupal\forcontu_pec2\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Entity\EntityInterface;

/**
 * Defines an interface for Grant points plugins.
 */
interface GrantPointsInterface extends PluginInspectionInterface {
  // Add get/set methods for your plugin type here.

  public function grant($entityi);

}
