<?php

/**
 * @file
 * Contains \Drupal\Menu_api\Controller\MenuAPIController.
 */

namespace Drupal\Menu_api\Controller;

use Drupal\Core\Controller\ControllerBase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller routines for Menu_api routes.
 */
class MenuAPIController extends ControllerBase {

  /**
   * Callback for `/api/menus/{menu_name}` API method.
   */
  public function get_menus( Request $request, $menu_name ) {
    $menu_parameters = \Drupal::menuTree()->getCurrentRouteMenuTreeParameters($menu_name);
    $tree = \Drupal::menuTree()->load($menu_name, $menu_parameters);
    $result = array();

    foreach ($tree as $element) {
      $link = $element->link;

      array_push($result, array(
          'title' => $link->getTitle(),
          'url' => $link->getUrlObject()->getUri(),
          'weight' => $link->getWeight()
        )
      );
    }

    return new JsonResponse( $result );
  }
}
