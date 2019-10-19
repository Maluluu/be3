<?php

namespace Drupal\forcontu_pec2\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Base class for Grant points plugins.
 */
abstract class GrantPointsBase extends PluginBase implements GrantPointsInterface {
  // Add common methods and abstract methods for your plugin type here.

  public function grant($entity) {
    return $this->pluginDefinition['grant'];
  }
}
