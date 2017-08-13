<?php

namespace Phpactor\ClassMover\Domain;

use Phpactor\ClassMover\Domain\SourceCode;
use Phpactor\ClassMover\Domain\FullyQualifiedName;
use Phpactor\ClassMover\Domain\NamespacedClassReferences;

final class FoundReferences
{
    private $source;
    private $name;
    private $references;

    public function __construct(SourceCode $source, FullyQualifiedName $name, NamespacedClassReferences $list)
    {
        $this->source = $source;
        $this->name = $name;
        $this->references = $list;
    }

    public function source(): SourceCode
    {
        return $this->source;
    }

    public function targetName(): FullyQualifiedName
    {
        return $this->name;
    }

    public function references(): NamespacedClassReferences
    {
        return $this->references;
    }
}
