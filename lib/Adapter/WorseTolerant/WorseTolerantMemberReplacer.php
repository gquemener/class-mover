<?php

namespace Phpactor\ClassMover\Adapter\WorseTolerant;

use Microsoft\PhpParser\TextEdit;

use Phpactor\ClassMover\Domain\ClassReplacer;
use Phpactor\ClassMover\Domain\MemberReplacer;
use Phpactor\ClassMover\Domain\Model\ClassMemberQuery;
use Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor\ClassMover\Domain\Reference\ImportedNameReference;
use Phpactor\ClassMover\Domain\Reference\MemberReferences;
use Phpactor\ClassMover\Domain\Reference\NamespacedClassReferences;
use Phpactor\ClassMover\Domain\SourceCode;
use Phpactor\ClassMover\Domain\Reference\MemberReference;

class WorseTolerantMemberReplacer implements MemberReplacer
{
    public function replaceMembers(SourceCode $source, MemberReferences $references, string $newName): SourceCode
    {
        $edits = [];
        /** @var $reference MemberReference */
        foreach ($references as $reference) {
            $edits[] = new TextEdit($reference->position()->start(), $reference->position()->length(), $newName);
        }

        $source = $source->replaceSource(TextEdit::applyEdits($edits, $source->__toString()));

        return $source;
    }
}

