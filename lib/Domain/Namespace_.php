<?php

namespace Phpactor\ClassMover\Domain;

use Phpactor\ClassMover\Domain\FullyQualifiedName;
use Phpactor\ClassMover\Domain\QualifiedName;

class Namespace_ extends QualifiedName
{
    public function qualify(QualifiedName $name): FullyQualifiedName
    {
        return FullyQualifiedName::fromString($this->__toString().'\\'.$name->__toString());
    }
}