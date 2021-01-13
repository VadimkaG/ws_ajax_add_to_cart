<?php

namespace Drupal\ws_ajax_add_to_cart\Form;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Path\PathValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AjaxConfigForm.
 */
class AjaxConfigForm extends ConfigFormBase {

  const AJAX_MODAL_INPUT_SIZE = 5;

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Drupal\Core\Path\PathValidator definition.
   *
   * @var \Drupal\Core\Path\PathValidator
   */
  protected $pathValidator;

  /**
   * Constructs a new AjaxConfigForm object.
   */
  public function __construct(
    ConfigFactory $config_factory, PathValidator $path_validator
  ) {
    parent::__construct($config_factory);
    $this->configFactory = $config_factory;
    $this->pathValidator = $path_validator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'), $container->get('path.validator')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ws_ajax_add_to_cart';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config($this->getEditableConfigNames()[0]);
    $form['cart_block_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Настройки блока корзины'),
    ];
    $form['cart_block_settings']['cart_block_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Идентификатор блока корзины'),
      '#default_value' => $config->get('cart_block_id'),
      '#description' => $this->t('Блок будет загружен сервисом "plugin.manager.block"'),
    ];
    $form['cart_block_settings']['cart_block_selector'] = [
      '#type' => 'textfield',
      '#title' => $this->t('HTML selector блока корзины.'),
      '#default_value' => $config->get('cart_block_selector'),
      '#description' => $this->t('Плагин будет заменять html корзины с указанным селектором. Если указывается class должно начинаться с ".". Если id с "#"'),
    ];

    // Настройки fancybox
    $form['ajax_modal_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Настройки fancybox'),
    ];
    $form['ajax_modal_settings']['fancybox_instead_alert'] = [
        '#type' => 'checkbox',
        '#title' => t('Использовать fancybox вместо стандартного alert браузера.'),
        '#states' => [
          'unchecked' => [
            ':input[name="name"]' => ['filled' => TRUE],
                 ],
              ],
        '#default_value' => $config->get('modal_mode') == 1?1:0
     ];
    $form['ajax_modal_settings']['fancybox_selector'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Указатель'),
      '#default_value' => $config->get('selector'),
      '#description' => $this->t('Указатель на HTML элемент страницы. Если указывается class должно начинаться с ".". Если id с "#"'),
    ];


    // настройки active режима
    $form['ajax_active_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Настройки "active" режима'),
    ];
    $form['ajax_active_settings']['active_instead_alert'] = [
        '#type' => 'checkbox',
        '#title' => t('Использовать вместо стандартного alert браузера.'),
        '#states' => [
          'unchecked' => [
            ':input[name="name"]' => ['filled' => TRUE],
                 ],
              ],
        '#default_value' => $config->get('modal_mode') == 2?1:0,
        '#description' => $this->t('При добавлении товара в корзину, указанному HTML объекту будет присвоен класс active')
     ];
    $form['ajax_active_settings']['active_selector'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Указатель'),
      '#default_value' => $config->get('selector'),
      '#description' => $this->t('Если указывается class должно начинаться с ".". Если id с "#"'),
    ];

    // Нат сройки всплывающих окон
    $form['popup_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Настройки всплывающих окон'),
    ];
    $form['popup_settings']['time_ajax_modal'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Время, через которое окно будет автоматически закрыто.'),
      '#default_value' => $config->get('time_ajax_modal'),
      '#description' => $this->t('Время указывается в милисекундах. 2000 = 2 секунды. 0 = не закрывать'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config($this->getEditableConfigNames()[0])
      ->set('cart_block_id', $form_state->getValue('cart_block_id'))
      ->set('cart_block_selector', $form_state->getValue('cart_block_selector'))
      ->set('time_ajax_modal', $form_state->getValue('time_ajax_modal'));

    // fancybox
    if ($form_state->getValue('fancybox_instead_alert')) 
      $config->set("modal_mode",1)
             ->set('selector', $form_state->getValue('fancybox_selector'));

    // active
    elseif ($form_state->getValue('active_instead_alert')) {
      $config->set("modal_mode",2)
             ->set('selector', $form_state->getValue('active_selector'));

    // alert
    } else
      $config->set("modal_mode",0);
    $config->save();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ws_ajax_add_to_cart.ajaxconfig',
    ];
  }

}
