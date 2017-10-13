<?php

namespace GeeksAreForLife\Inspector;

use Symfony\Component\Console\Command\Command;
use GeeksAreForLife\Inspector\LicenseInspector;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Inspect Licenses Command Class
 *
 * Adds the inspect:licenses command to the console
 */
class InspectLicensesCommand extends Command
{

    protected function configure()
    {
        $this->setName("inspect:licenses")
                ->setDescription("Compiles a list of all licenses used by external code.")
                ->addArgument('project', InputArgument::REQUIRED, 'The path to the project you want to inspect')
                ->addOption('output', 'o', InputOption::VALUE_REQUIRED, "Choose output location, either 'file' or 'screen'", 'screen');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $inspector = new LicenseInspector();
        $inspector->setProjectPath($input->getArgument('project'));

        $packages = $inspector->inspect($output);

        $outputType = $input->getOption('output');

        if ($outputType == 'screen') {
            $this->outputTable($packages, $output);
        } elseif ($outputType == 'file') {
            if ($this->outputFile($packages, $input->getArgument('project'))) {
                $output->writeln("File written");
            } else {
                $output->writeln("Failed to write file");
            }
        }

    }

    private function outputTable($packages, $output)
    {
        $colPadding = "  ";

        $table = $this->getTable($packages);

        $columns = $this->getColumnWidths($table);

        // header
        $output->writeln("");
        $firstLine = true;
        foreach ($table as $row) {
            $line = "";

            if ($firstLine) {
                $line .= '<info>';
            }

            for ($i = 0; $i < count($row); $i++) {
                $line .= str_pad($row[$i], $columns[$i]);
                $line .= $colPadding;
            }

            if ($firstLine) {
                $line .= '</info>';
            }

            $output->writeln($line);
            $firstLine = false;
        }
    }

    private function outputFile($packages, $path)
    {
        $table = $this->getTable($packages);

        $file = "";

        $firstLine = true;
        foreach ($table as $row) {
            if ($firstLine) {
                $columns = [];
            }

            for ($i = 0; $i < count($row); $i++) {
                $file .= $row[$i];

                if ($i < (count($row)-1)) {
                    $file .= '|';
                }

                if ($firstLine) {
                    $columns[] = str_pad("", strlen($row[$i]), "-");
                }
            }

            $file .= "\n";

            if ($firstLine) {
                $file .= implode('|', $columns) . "\n";
            }

            $firstLine = false;
        }

        return file_put_contents($path . 'PACKAGES.MD', $file);
    }

    private function getTable($packages)
    {
        $table = [
            ['Source', 'Name', 'Version', 'License']
        ];

        foreach ($packages as $package) {
            $name = $package->getName();
            $version = $package->getVersion();
            $source = $package->getSource();

            foreach ($package->getLicenses() as $license) {
                $table[] = [
                    $source,
                    $name,
                    $version,
                    $license->getCode(),
                ];

                // make sure only first entry per package has name, etc
                $name = "";
                $version = "";
                $source = "";
            }
        }

        return $table;
    }

    private function getColumnWidths($table)
    {
        $widths = array_fill(0, count($table[0]), 0);

        foreach ($table as $row) {
            for ($i = 0; $i < count($row); $i++) {
                if (strlen($row[$i]) > $widths[$i]) {
                    $widths[$i] = strlen($row[$i]);
                }
            }
        }

        return $widths;
    }

}