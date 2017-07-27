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

    /**
     * Version of this package
     * @var string
     */
    private $version;

    public function __construct($name, $version, $source)
    {
        $this->name = $name;
        $this->version = $version;
        $this->source = $source;
    }

    public function addLicense($license)
    {
        $this->licenses[] = new License($license);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getLicenses()
    {
        return $this->licenses;
    }
}