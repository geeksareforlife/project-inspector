<?php

namespace GeeksAreForLife\Inspector;

use GeeksAreForLife\Inspector\License;

class Package
{
    /**
     * Name of package
     * @var string
     */
    private $name;

    /**
     * Where the package is from
     * @var string
     */
    private $source;

    /**
     * Array of licenses that apply to this package
     * @var License[]
     */
    private $licenses;
}