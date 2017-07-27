<?php

namespace GeeksAreForLife\Inspector;

use GeeksAreForLife\Inspector\Package;
use GeeksAreForLife\Inspector\PackageBridge;

class ComposerPackageBridge implements PackageBridge
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

        $out = json_decode(shell_exec('composer licenses -d ' . $this->path . ' -f json'), true);
        
        foreach ($out['dependencies'] as $name => $props) {
            $packages[] = $this->buildPackage($name, $props['version'], $props['license']);
        }

        return $packages;
    }

    private function buildPackage($name, $version, $licenses)
    {
        $package = new Package($name, $version, 'Composer');

        foreach ($licenses as $code) {
            $package->addLicense($code);
        }

        return $package;
    }
}