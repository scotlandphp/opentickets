<?php

namespace OpenTickets\Tickets\Cli\Command;

use Carnage\Cqrs\MessageBus\MessageBusInterface;
use Carnage\Cqrs\Service\EventCatcher;
use OpenTickets\Tickets\Domain\Command\Ticket\CompletePurchase;
use OpenTickets\Tickets\Domain\Command\Ticket\ReserveTickets;
use OpenTickets\Tickets\Domain\Event\Ticket\TicketPurchaseCreated;
use OpenTickets\Tickets\Domain\Service\Configuration;
use OpenTickets\Tickets\Domain\ValueObject\Delegate;
use OpenTickets\Tickets\Domain\ValueObject\TicketReservationRequest;
use OpenTickets\Tickets\Report\ReportInterface;
use OpenTickets\Tickets\Report\ReportManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReportToCsv extends Command
{
    /**
     * @var ReportManager
     */
    private $reportManager;

    public static function build(ReportManager $reportManager)
    {
        $instance = new self();
        $instance->reportManager = $reportManager;
        return $instance;
    }

    protected function configure()
    {
        $this->setName('opentickets:report-to-csv')
            ->setDescription('Creates a csv export of a report')
            ->setDefinition([
                new InputArgument('report', InputArgument::REQUIRED, 'Report to run'),
                new InputArgument('outputFile', InputArgument::OPTIONAL, 'File to output report to', '/tmp/report.csv')
             ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reportName = $input->getArgument('report');
        if (!$this->reportManager->has($reportName)){
            throw new \Exception('Invalid report name');
        }

        $outputFile = $input->getArgument('outputFile');

        if (file_exists($outputFile)) {
            if (!is_writable($outputFile)) {
                throw new \Exception(sprintf('Cannot write to output file: %s', $outputFile));
            }
        } else {
            if (!is_writable(dirname($outputFile))) {
                throw new \Exception(sprintf('Cannot write to output directory: %s', dirname($outputFile)));
            }
        }

        /** @var ReportInterface $report */
        $report = $this->reportManager->get($reportName);

        $reportData = $report->produceReport();

        $h = fopen($outputFile, 'w+');
        $header = array_keys(current($reportData) ?: []);
        fputcsv($h, $header);

        foreach ($reportData as $datum) {
            fputcsv($h, $datum);
        }

        fclose($h);
    }
}