<?php

namespace GeeksAreForLife\Inspector;

interface PackageBridge
{
    /**
     * @param string $path The path to the project
     */
    public function __construct($path);
    /**
     * Returns an array of packages, with license details
     * @return GeeksAreForLife\Inspector\Package[]
     */
    public function getPackages();
}