<?php

namespace Drupal\forcontu_pec\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;

class ForcontuPecDeleteForm extends ConfirmFormBase {
  protected $database;
  protected $node;

  public function __construct(Connection $database) {
    $this->database = $database;
  }
  public static function create(ContainerInterface $container) {
    return new static($container->get('database'));
  }
  public function getFormId() {
    return 'forcontu_pec_delete';
  }
  public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $node = NULL) {
    $this->node = $node;
    return parent::buildForm($form, $form_state);
  }
  public function getQuestion() {
    return $this->t('Are you sure you want to delete node "%title" (%nid) from <em>forcontu-pec-messages</em> table?',
      array('%title' => $this->node->getTitle(), '%nid' => $this->node->id()));
 }
  public function getConfirmText() {
    return $this->t('Delete');
  }
  public function getCancelText() {
    return $this->t('Don\'t Delete');
  }
  public function getCancelUrl() {
    return new Url('forcontu_pec.messages');
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->database->delete('forcontu_pec_messages')
    ->condition('nid', $this->node->id())
    ->execute();

    drupal_set_message($this->t('The node has been removed.'));

    \Drupal::logger('forcontu_pec')->notice('New Confirm Form entry from node %node deleted: %name.',
      ['%node' => $this->node->id(),
       '%name' => $this->node->label()]);

    $form_state->setRedirectUrl($this->getCancelUrl());
  }
}
