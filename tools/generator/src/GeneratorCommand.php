<?php

namespace Kambo\Tabular\Tools\Generator;

use Faker\Factory;
use Kambo\Tabular\XLSX\XLSX;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use function json_decode;
use function file_get_contents;
use function array_key_exists;

class GeneratorCommand extends Command
{
    protected static $defaultName = 'generator';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument('config', InputArgument::OPTIONAL, 'Path to config, eg.: foo/config.json');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = json_decode(file_get_contents('config.json'), true);

        $faker = Factory::create();

        if (array_key_exists('seed', $config)) {
            $faker->seed($config['seed']);
        }

        $rows = 10;
        if (array_key_exists('rows', $config)) {
            $rows = $config['rows'];
        }

        $columns = 5;
        if (array_key_exists('columns', $config)) {
            $columns = $config['columns'];
        }

        $monitor = PoorMensMonitor::createFromConfig($config);
        $monitor->collectMemory('start');
        $monitor->startTime('object-creation');
        $xlsx = XLSX::createFromFileObject(new SplFileInfo('basicfile.xlsx'));
        $monitor->collectTime('object-creation');
        $monitor->collectMemory('object-creation');

        $progressBar = new ProgressBar($output, $rows);
        $progressBar->setFormat(
            ' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%'
        );
        $progressBar->start();

        for ($row = 1; $row <= $rows; $row++) {
            $monitor->startTime('generate-data');
            $rowInner = [];
            for ($column = 0; $column < $columns; $column++) {
                $type = $this->getColumnType($config, $column);
                if ($type === 'id') {
                    $rowInner[] = $faker->numberBetween(1, $rows);
                } else {
                    $rowInner[] = $faker->$type();
                }
            }

            $monitor->collectTime('generate-data', true);
            $monitor->collectMemory('fake-data-creation');
            $monitor->startTime('save-data');

            $xlsx->addRow($rowInner);

            $monitor->collectTime('save-data', true);
            $monitor->collectMemory('add-data-to-file');

            $progressBar->advance();
        }

        $monitor->collectMemory('before-save');
        $monitor->startTime('finalize-data');
        $xlsx->save();
        $monitor->collectTime('finalize-data');
        $monitor->collectMemory('after-save');

        $monitor->collectPeakMemory();

        echo $monitor;

        return Command::SUCCESS;
    }

    private function getColumnType(array $config, int $position)
    {
        $type = $config['types'][$position] ?? null;

        if ($type === null) {
            return 'text';
        }

        return $type;
    }
}
