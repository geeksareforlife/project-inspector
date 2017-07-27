<?php

namespace GeeksAreForLife\Inspector;

class LicenseInspector
{
    /**
     * Path to the project
     * @var string
     */
    private $path;

    private $output;

    public function setProjectPath($path)
    {
        // check the path exists
        // at some point, we should check if this is a valid project
        if (is_dir($path)) {
            $this->path = rtrim($path, '/');
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets all package dependencies
     * @param  Symfony\Component\Console\Output\OutputInterface $output Output object
     * @return GeeksAreForLife\Inspector\Package[]         Array of packages
     */
    public function inspect($output)
    {
        $this->output = $output;

        $bridges = $this->getBridges();

        $packages = [];

        foreach ($bridges as $bridge) {
            $packages = array_merge($packages, $bridge->getPackages());
        }

        return $packages;
    }

    private function output($msg, $level)
    {
        $this->output->writeln($msg);
    }

    private function getBridges()
    {
        $bridges = [];

        // check to see if we are using composer/yarn on this project
        if (file_exists($this->path . '/composer.json')) {
            $this->output('Composer found.', 'info');
            $bridges[] = new ComposerPackageBridge($this->path);
        }

        return $bridges;
    }

}