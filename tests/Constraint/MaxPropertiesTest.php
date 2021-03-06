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

class MaxPropertiesTest extends ConstraintTestCase
{
    public function testNormalizeThrowsIfMaxPropertiesIsNotAnInteger()
    {
        $this->expectConstraintException('InvalidTypeException', '/maxProperties');
        $schema = $this->loadSchema('invalid/maxProperties-not-integer');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeThrowsIfMaxPropertiesIsNotPositive()
    {
        $this->expectConstraintException('LessThanZeroException', '/maxProperties');
        $schema = $this->loadSchema('invalid/maxProperties-not-positive');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    protected function getConstraint()
    {
        return new MaxPropertiesConstraint();
    }

    protected function getCaseFileNames()
    {
        return ['maxProperties'];
    }
}
