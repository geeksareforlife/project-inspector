<?php

namespace GeeksAreForLife\Inspector;

use GeeksAreForLife\Inspector\Package;
use GeeksAreForLife\Inspector\PackageBridge;

/**
 * Yarn Package Bridge
 *
 * Extracts information about node pacakges used in the project, using yarn
 *
 * Each package can have one license
 */
class YarnPackageBridge implements PackageBridge
{

    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Returns an array of packages, with license details
     * @return GeeksAreForLife\Inspector\Package[]
     */
    public function getPackages()
    {
        $packages = [];

        if (chdir($this->path)) {
            $lines = "";
            
            exec('yarn licenses ls --json --no-progress 2>/dev/null > temp');
            $lines = file_get_contents('temp');
            unlink('temp');

            $lines = explode("\n", $lines);

            foreach ($lines as $line) {
                if (substr($line, 0, 15) == '{"type":"table"') {
                    $out = json_decode($line, true);
                }
            }

            foreach ($out['data']['body'] as $props) {
                $packages[] = $this->buildPackage($props[0], $props[1], $props[2]);
            }
        }

        return $packages;
    }

    private function buildPackage($name, $version, $license)
    {
        $package = new Package($name, $version, 'Yarn');

        $package->addLicense($license);

        return $package;
    }
}