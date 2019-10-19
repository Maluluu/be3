<?php
/**
* @file
* Contains Drupal\forcontu_pec\Controller\ForcontuPecController.
*/

namespace Drupal\forcontu_pec\Controller;

use Drupal\Core\Controller\ControllerBase;
//use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\DependencyInjection\ContainerInterface;
//use Drupal\user\UserInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Database\Connection;
//use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Render\Renderer;

/**
* Controlador para devolver el contenido de las páginas definidas
*/
class ForcontuPecController extends ControllerBase {
  protected $currentUser;
  protected $dateFormatter;
  protected $database;
  protected $renderer;

  public function __construct(AccountInterface $current_user, DateFormatterInterface $date_formatter, Connection $database, Renderer $renderer)  {
    $this->currentUser = $current_user;
    $this->dateFormatter = $date_formatter;
    $this->database = $database;
    $this->renderer = $renderer;
  }

  public static function create(ContainerInterface $container)  {
    return new static ($container->get('current_user'),
      $container->get('date.formatter'),
      $container->get('database'),
      $container->get('renderer'));
  }

  public function Simple()  {
    $connection = \Drupal::database();
    $query = $connection->select('forcontu_pec_messages', 'f')
      ->fields('f')
      ->orderBy('nid', 'DESC')
      ->execute();

    while ($record = $query->fetchAssoc()) {
      $node = node_load($record['nid']);
      $campo = $node->getTitle();
      $botones = [
        '#type' => 'dropbutton',
        '#links' => [
          'edit' => [
            'title' => $this->t('Edit'),
            'url' => Url::fromRoute('entity.node.edit_form', ['node' => $record['nid']]),
          ],
          'delete' => [
            'title' => $this->t('Delete'),
            'url' => Url::fromRoute('forcontu_pec.delete', ['node' => $record['nid']]),
          ],
        ],
      ];
      $rows[] = [
        $record['nid'],
        $campo,
        $record['checked'],
        $record['message'],
        $this->renderer->render($botones),
      ];
    }
      $build['forcontu_pec_messages'] = array(
        '#type' => 'table',
        '#rows' => $rows,
        '#header' => [
          $this->t('ID'),
          $this->t('Title'),
          $this->t('Active'),
          $this->t('Message'),
          $this->t('Operations'),
        ]
      );
      return $build;

  }
}


