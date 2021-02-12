<?php
namespace Drupal\ws_ajax_add_to_cart\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\StringTranslation\TranslationInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\commerce_cart\Event\CartEntityAddEvent;

class CartEventSubscriber extends \Drupal\commerce_cart\EventSubscriber\CartEventSubscriber {

	/**
	 * {@inheritdoc}
	 */
	public function displayAddToCartMessage(CartEntityAddEvent $event) {
		/*if (!$this->currentRequest->isXmlHttpRequest())
			parent::displayAddToCartMessage($event);*/
	}

}