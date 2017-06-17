<?php

namespace DTL\ClassMover\RefFinder;

use DTL\ClassMover\RefFinder\ClassRef;
use DTL\ClassMover\Finder\FilePath;
use DTL\ClassMover\RefFinder\FullyQualifiedName;

final class NamespacedClassRefList implements \IteratorAggregate
{
    private $classRefs = array();
    private $path;
    private $namespace;

    private function __construct(SourceNamespace $namespace, FilePath $path, array $classRefs)
    {
        $this->namespace = $namespace;
        $this->path = $path;
        foreach ($classRefs as $classRef) {
            $this->add($classRef);
        }
    }

    public static function fromNamespaceAndClassRefs(SourceNamespace $namespace, FilePath $path, array $classRefs)
    {
        return new self($namespace, $path, $classRefs);
    }

    public function filterForName(FullyQualifiedName $name)
    {
        return new self($this->namespace, $this->path, array_filter($this->classRefs, function (ClassRef $classRef) use ($name) {
            return $classRef->fullName()->isEqualTo($name);
        }));
    }

    public function path(): FilePath
    {
        return $this->path;
    }

    public function isEmpty(): bool
    {
        return empty($this->classRefs);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->classRefs);
    }

    public function namespace()
    {
        return $this->namespace;
    }

    private function add(ClassRef $classRef)
    {
        $this->classRefs[] = $classRef;
    }
}