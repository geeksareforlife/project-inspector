<?php

namespace GeeksAreForLife\Inspector;

interface PackageBridge
{
    /**
     * Returns an array of packages, with license details
     * @return GeeksAreForLife\Inspector\Package[]
     */
    public function getPackages();
}