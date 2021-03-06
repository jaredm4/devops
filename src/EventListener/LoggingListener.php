<?php

declare(strict_types=1);

namespace Devops\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;

/**
 * Class LoggingListener.
 */
class LoggingListener
{
    private LoggerInterface $logger;
    // don't bother logging these commands
    private array $commandBlackList = ['help', 'list'];

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Used to log the name of the command at the start of execution.
     */
    public function logCommandName(ConsoleCommandEvent $event): void
    {
        $commandName = $event->getCommand()->getName();

        if (in_array($commandName, $this->commandBlackList)) {
            return;
        }

        $this->logger->notice('Beginning command.', [$commandName]);
    }

    /**
     * Log the (non-zero) status code and note that command is finished. This simulates the auto-logging of Symfony 3.3.
     *
     * @see https://symfony.com/doc/3.2/console/logging.html#logging-error-exit-statuses
     */
    public function logCommandStatus(ConsoleTerminateEvent $event)
    {
        $statusCode = $event->getExitCode();
        $commandName = $event->getCommand()->getName();

        if (in_array($commandName, $this->commandBlackList)) {
            return;
        }

        if ($statusCode > 255) {
            $statusCode = 255;
            $event->setExitCode($statusCode);
        }

        if (0 === $statusCode) {
            $this->logger->notice('Finished command.', [$commandName]);
        } else {
            $this->logger->warning('Command exited with a non-zero status code.', [
                $commandName,
                $statusCode,
            ]);
        }
    }
}
