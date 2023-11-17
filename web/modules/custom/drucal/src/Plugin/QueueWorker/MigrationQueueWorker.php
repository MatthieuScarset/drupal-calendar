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
   * The logger channel.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

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
    $instance->logger = $container->get('logger.channel.drucal');
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
      // force stop migration.
      $migration->setStatus(MigrationInterface::STATUS_IDLE);
      $executable = new MigrateExecutable($migration, new MigrateMessage());
      $this->logger->notice('Running migration: ' . $migration_id);
      try {
        // Run the migration.
        $executable->import();
        $this->logger->notice('Finished migration: ' . $migration_id);
      } catch (\Exception $e) {
        // Log the exception.
        $this->logger->error($e->getMessage());
      }
    }
  }
}
