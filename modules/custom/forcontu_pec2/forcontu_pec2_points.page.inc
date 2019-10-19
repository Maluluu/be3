<?php

/**
 * @file
 * Contains forcontu_pec2_points.page.inc.
 *
 * Page callback for Points entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Points templates.
 *
 * Default template: forcontu_pec2_points.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_forcontu_pec2_points(array &$variables) {
  // Fetch Points Entity Object.
  $forcontu_pec2_points = $variables['elements']['#forcontu_pec2_points'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
