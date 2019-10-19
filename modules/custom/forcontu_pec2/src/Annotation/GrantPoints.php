<?php

namespace Drupal\forcontu_pec2\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Grant points item annotation object.
 *
 * @see \Drupal\forcontu_pec2\Plugin\GrantPointsManager
 * @see plugin_api
 *
 * @Annotation
 */
class GrantPoints extends Plugin {


  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

}
