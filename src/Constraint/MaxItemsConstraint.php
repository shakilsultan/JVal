<?php

namespace JsonSchema\Constraint;

use JsonSchema\Context;
use JsonSchema\Types;
use JsonSchema\Walker;
use stdClass;

class MaxItemsConstraint extends AbstractCountConstraint
{
    public function keywords()
    {
        return ['maxItems'];
    }

    public function supports($type)
    {
        return $type === Types::TYPE_ARRAY;
    }

    public function apply($instance, stdClass $schema, Context $context, Walker $walker)
    {
        if (count($instance) > $schema->maxItems) {
            $context->addViolation(
                'number of items should be lesser than or equal to %s',
                [$schema->maxItems]
            );
        }
    }
}
