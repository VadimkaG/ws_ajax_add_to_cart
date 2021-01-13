<?php

namespace Drupal\ws_ajax_add_to_cart\Ajax;

use Drupal\Core\Ajax\CommandInterface;

/**
 * Class ReloadCommand.
 *
 * @package Drupal\ws_ajax_add_to_cart\Ajax
 */
class FancyBoxCommand implements CommandInterface {

  /**
   * Return an array to be run through json_encode and sent to the client.
   */
  public function render() {
    return [
      'command' => 'showfancy',
    ];
  }

}
