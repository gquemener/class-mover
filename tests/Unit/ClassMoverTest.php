<?php

namespace Phpactor\ClassMover\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\ClassMover\Domain\RefFinder;
use Phpactor\ClassMover\Domain\RefReplacer;
use Phpactor\ClassMover\ClassMover;
use Phpactor\ClassMover\Domain\SourceCode;
use Phpactor\ClassMover\Domain\NamespacedClassReferences;
use Prophecy\Argument;
use Phpactor\ClassMover\Domain\FoundReferences;
use Phpactor\ClassMover\Domain\FullyQualifiedName;

class ClassMoverTest extends TestCase
{
    private $mover;
    private $finder;
    private $replacer;

    public function setUp()
    {
        $this->finder = $this->prophesize(RefFinder::class);
        $this->replacer = $this->prophesize(RefReplacer::class);

        $this->mover = new ClassMover(
            $this->finder->reveal(),
            $this->replacer->reveal()
        );
    }

    /**
     * It should delgate to the finder to find references.
     */
    public function testFindReferences()
    {
        $source = SourceCode::fromString('<?php echo "hello";');
        $fullName = 'Something';
        $refList = NamespacedClassReferences::empty();

        $this->finder->findIn($source)->willReturn($refList);

        $references = $this->mover->findReferences($source, $fullName);

        $this->assertInstanceOf(FoundReferences::class, $references);
        $this->assertEquals($source, (string) $references->source());
        $this->assertEquals($fullName, (string) $references->targetName());
        $this->assertEquals([], iterator_to_array($references->references()));

        return $references;
    }

    /**
     * It should replace references.
     *
     * @depends testFindReferences
     */
    public function testReplaceReferences(FoundReferences $references)
    {
        $newFqn = 'SomethingElse';

        $this->replacer->replaceReferences(
            $references->source(),
            $references->references(),
            $references->targetName(),
            FullyQualifiedName::fromString($newFqn)
        )->shouldBeCalled();

        $this->mover->replaceReferences($references, $newFqn);
    }
}
