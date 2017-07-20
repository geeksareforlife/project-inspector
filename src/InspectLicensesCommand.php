<?php

namespace GeeksAreForLife\Inspector;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InspectLicensesCommand extends Command
{

    protected function configure()
    {
        $this->setName("inspect:licenses")
                ->setDescription("Compiles a list of all licenses used by external code.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('Licenses');

    }

}