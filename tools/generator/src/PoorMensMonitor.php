<?php

namespace Kambo\Tabular\Tools\Generator;

use function array_key_exists;
use function memory_get_usage;
use function memory_get_peak_usage;
use function microtime;
use function round;

final class PoorMensMonitor
{
    private array $collectMemoryBucket = [];
    private array $collectTimeBucket = [];
    private array $collectStartTimeBucket = [];

    public function __construct(
        private bool $enabled = false,
        private bool $collectTime = false,
        private bool $collectMemory = false
    ) {
    }

    public static function createFromConfig(array $config): self
    {
        $enabled = false;
        if (array_key_exists('monitor', $config)) {
            $enabled = $config['monitor'];
        }

        $collectTime = false;
        if (array_key_exists('collectTime', $config)) {
            $collectTime = $config['collectTime'];
        }

        $collectMemory = false;
        if (array_key_exists('collectMemory', $config)) {
            $collectMemory = $config['collectMemory'];
        }

        return new self($enabled, $collectTime, $collectMemory);
    }

    public function collectMemory($name)
    {
        if ($this->shouldCollectMemory()) {
            $this->collectMemoryBucket[$name] = [memory_get_usage(), memory_get_usage(true)];
        }
    }

    public function collectPeakMemory()
    {
        if ($this->shouldCollectMemory()) {
            $this->collectMemoryBucket['peakUsage'] = [memory_get_peak_usage(), memory_get_peak_usage(true)];
        }
    }

    public function startTime($name)
    {
        if ($this->shouldCollectTime()) {
            $this->collectStartTimeBucket[$name] = microtime(true);
            ;
        }
    }

    public function collectTime($name, bool $storeForEval = false)
    {
        if ($this->shouldCollectTime()) {
            $time     = $this->collectStartTimeBucket[$name];
            $resolved = (microtime(true) - $time);

            if ($storeForEval) {
                if (!array_key_exists($name, $this->collectTimeBucket)) {
                    $this->collectTimeBucket[$name] = 0;
                }

                $this->collectTimeBucket[$name] += $resolved;
            } else {
                $this->collectTimeBucket[$name] = $resolved;
            }
        }
    }

    public function __toString(): string
    {
        // $time_elapsed_secs = sprintf('%.9f', (microtime(true) - $start));
        if ($this->shouldCollectTime() || $this->shouldCollectMemory()) {
            $string = "\n";
            foreach ($this->collectTimeBucket as $name => $time) {
                $string .= 'time ' . $name . ': ' . round($time, 5) . "\n";
            }

            foreach ($this->collectMemoryBucket as $name => $time) {
                $string .= 'memory ' . $name . ': ' . round($time[0] / 1024 / 1024, 2) . "Mb\n";
            }
        } else {
            return '';
        }

        return $string;
    }

    public function shouldCollectTime(): bool
    {
        return $this->collectTime;
    }

    public function shouldCollectMemory(): bool
    {
        return $this->collectMemory;
    }
}
