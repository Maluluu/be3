<?php

namespace Drupal\forcontu_pec\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Database\Driver\mysql\Connection;

/**
 * Class ForcontuPecSettingsForm.
 */
class ForcontuPecSettingsForm extends ConfigFormBase {

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * Constructs a new ForcontuPecSettingsForm object.
   */
  public function __construct(ConfigFactoryInterface $config_factory, AccountProxyInterface $current_user, Connection $database) {
    parent::__construct($config_factory);
    $this->currentUser = $current_user;
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('current_user'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'forcontu_pec.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'forcontu.pec.settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('forcontu_pec.settings');
    $form['forcontu_pec_allowed_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Allowed types'),
      '#options' => [
        'article' => $this->t('Article'),
        'page' => $this->t('Page'),
        'report' => $this->t('Report'),
        ],
      '#default_value' => $config->get('forcontu_pec_allowed_types'),
    ];
    $form['forcontu_pec_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Message'),
      '#maxlength' => 100,
      '#minlength' => 50,
      '#size' => 100,
      '#required' => TRUE,
      '#default_value' => $config->get('forcontu_pec_message'),
    ];
    $form['forcontu_pec_num_items'] = [
      '#type' => 'select',
      '#title' => $this->t('Number items'),
      '#options' => ['1' => $this->t('1'), '2' => $this->t('2'), '3' => $this->t('3'), '4' => $this->t('4'), '5' => $this->t('5'), '10' => $this->t('10'), '20' => $this->t('20')],
      '#size' => 3,
      '#default_value' => $config->get('forcontu_pec_num_items'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if(strlen($form_state->getValue('forcontu_pec_message')) > 100 || strlen($form_state->getValue('forcontu_pec_message')) < 50 ){
      $form_state->setErrorByName('forcontu_pec_message', t('The length must be greater than 50 and less than 100'));
    }
  }
  
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('forcontu_pec.settings')
      ->set('forcontu_pec_allowed_types', $form_state->getValue('forcontu_pec_allowed_types'))
      ->set('forcontu_pec_message', $form_state->getValue('forcontu_pec_message'))
      ->set('forcontu_pec_num_items', $form_state->getValue('forcontu_pec_num_items'))
      ->save();
  }
  /*
  public function checkAccess($element) {
    $type_node = $element->getFormObject()->getEntity()->getType();
    $allowed_type = \Drupal::config('forcontu_pec.settings')->get('forcontu_pec_allowed_types');
    dpm($type_node);
    dpm($allowed_type);
  return ((in_array($form_state->getFormObject()->getEntity()->getType(), \Drupal::config('forcontu_pec.settings')->get('forcontu_pec_allowed_types') )) && (\Drupal::currentUser()->hasPermission('forcontu pec nodes')));
  }*/
}
