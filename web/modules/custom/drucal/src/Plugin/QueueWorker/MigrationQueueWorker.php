<?php

namespace Drupal\drucal\Plugin\QueueWorker;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\migrate\MigrateExecutable;
use Drupal\migrate\MigrateMessage;
use Drupal\migrate\Plugin\MigrationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Executes interface translation queue tasks.
 *
 * @QueueWorker(
 *   id = "run_migrations",
 *   title = @Translation("Run migrations"),
 *   cron = {"time" = 400}
 * )
 */
class MigrationQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * The migration plugin manager.
   *
   * @var \Drupal\migrate\Plugin\MigrationPluginManagerInterface
   */
  protected $manager;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->manager = $container->get('plugin.manager.migration');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $migration_ids = $data['migration_ids'] ?? [];
    foreach ($migration_ids as $migration_id) {
      $migration = $this->manager->createInstance($migration_id);
      // update existing entity imported.
      $migration->getIdMap()->prepareUpdate();
      $executable = new MigrateExecutable($migration, new MigrateMessage());

      try {
        // Run the migration.
        $executable->import();
      } catch (\Exception $e) {
        $migration->setStatus(MigrationInterface::STATUS_IDLE);
      }
    }
  }
}
