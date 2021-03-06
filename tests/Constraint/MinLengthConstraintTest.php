<?php

/*
 * This file is part of the JVal package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JVal\Constraint;

use JVal\Context;
use JVal\Testing\ConstraintTestCase;

class MinLengthConstraintTest extends ConstraintTestCase
{
    public function testNormalizeThrowsIfMinLengthIsNotAnInteger()
    {
        $this->expectConstraintException('InvalidTypeException', '/minLength');
        $schema = $this->loadSchema('invalid/minLength-not-integer');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeThrowsIfMinLengthIsNotPositive()
    {
        $this->expectConstraintException('LessThanZeroException', '/minLength');
        $schema = $this->loadSchema('invalid/minLength-not-positive');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    protected function getConstraint()
    {
        return new MinLengthConstraint();
    }

    protected function getCaseFileNames()
    {
        return ['minLength'];
    }
}
