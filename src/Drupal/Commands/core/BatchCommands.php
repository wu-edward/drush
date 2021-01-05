<?php
namespace Drush\Drupal\Commands\core;

use Consolidation\OutputFormatters\StructuredData\UnstructuredListData;
use Drush\Commands\DrushCommands;

class BatchCommands extends DrushCommands
{

    /**
     * Default value for max number of seconds a batch worker process can take.
     *
     * @var int
     */
    const DEFAULT_BATCH_WORKER_TIME_LIMIT = 28800;

    /**
     * Process operations in the specified batch set.
     *
     * @command batch:process
     * @aliases batch-process
     * @param $batch_id The batch id that will be processed.
     * @option int $time_limit Maximum amount of time the batch worker can take
     *   in seconds.
     * @hidden
     *
     * @return \Consolidation\OutputFormatters\StructuredData\UnstructuredListData
     */
    public function process($batch_id, $options = ['format' => 'json', 'time_limit' => NULL])
    {
        if (!isset($options['time_limit'])) {
            $options['time_limit'] = getenv('DRUSH_BATCH_WORKER_TIME_LIMIT') ?: static::DEFAULT_BATCH_WORKER_TIME_LIMIT;
        }
        $return = drush_batch_command($batch_id, $options['time_limit']);
        return new UnstructuredListData($return);
    }
}
