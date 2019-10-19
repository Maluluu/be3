<?php

namespace Drupal\forcontu_pec2\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\forcontu_plugins\Annotation\GrantPoints;

/**
 * Provides the Grant points plugin manager.
 */
class GrantPointsManager extends DefaultPluginManager {


  /**
   * Constructs a new GrantPointsManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    $subdir = 'Plugin/GrantPoints';
    $plugin_interface = GrantPointsInterface::class;
    $plugin_definition_annotation_name = GrantPoints::class;
    
    parent::__construct('Plugin/GrantPoints', $namespaces, $module_handler, 'Drupal\forcontu_pec2\Plugin\GrantPointsInterface', 'Drupal\forcontu_pec2\Annotation\GrantPoints');

    $this->alterInfo('forcontu_pec2_grant_points_info');
    $this->setCacheBackend($cache_backend, 'forcontu_pec2_grant_points_plugins');
  }

}
