<?php

namespace JsonSchema\Constraint;

use JsonSchema\Constraint;
use JsonSchema\Context;
use JsonSchema\Testing\ConstraintTestCase;

class MinItemsConstraintTest extends ConstraintTestCase
{
    public function testNormalizeThrowsIfMinItemsIsNotAnInteger()
    {
        $this->expectConstraintException('InvalidTypeException', '/minItems');
        $schema = $this->loadSchema('invalid/minItems-not-integer');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeThrowsIfMinItemsIsNotPositive()
    {
        $this->expectConstraintException('LessThanZeroException', '/minItems');
        $schema = $this->loadSchema('invalid/minItems-not-positive');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    protected function getConstraint()
    {
        return new MinItemsConstraint();
    }

    protected function getCaseFileNames()
    {
        return ['minItems'];
    }
}
