<?php

namespace JsonSchema\Constraint;

use JsonSchema\Constraint;
use JsonSchema\Context;
use JsonSchema\Exception\ConstraintException;
use JsonSchema\Testing\ConstraintTestCase;

class PropertiesTest extends ConstraintTestCase
{
    /**
     * @dataProvider absentKeywordProvider
     * @param $schemaName
     */
    public function testNormalizeSetsAbsentKeywordsToEmptySchema($schemaName)
    {
        $schema = $this->loadSchema($schemaName);
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
        $this->assertObjectHasAttribute('properties', $schema);
        $this->assertObjectHasAttribute('additionalProperties', $schema);
        $this->assertObjectHasAttribute('patternProperties', $schema);
        $this->assertEquals(new \stdClass(), $schema->properties);
        $this->assertEquals(new \stdClass(), $schema->additionalProperties);
        $this->assertEquals(new \stdClass(), $schema->patternProperties);
    }

    public function testNormalizeSetsAdditionalPropertiesToEmptySchemaIfSetToTrue()
    {
        $schema = $this->loadSchema('valid/additionalProperties-set-to-true');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
        $this->assertEquals(new \stdClass(), $schema->additionalProperties);
    }

    public function testNormalizeThrowsIfPropertiesIsNotAnObject()
    {
        $this->expectException(ConstraintException::PROPERTIES_NOT_OBJECT);
        $schema = $this->loadSchema('invalid/properties-not-object');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeThrowsIfPropertiesPropertyValueIsNotAnObject()
    {
        $this->expectException(ConstraintException::PROPERTY_VALUE_NOT_OBJECT);
        $schema = $this->loadSchema('invalid/properties-property-value-not-object');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeEnsuresPropertiesPropertyIsAValidSchema()
    {
        $schema = $this->loadSchema('valid/properties-not-empty');
        $walker = $this->mockWalker();
        $walker->expects($this->at(0))
            ->method('parseSchema')
            ->with($schema->properties->foo);
        $this->getConstraint()->normalize($schema, new Context(), $walker);
    }

    public function testNormalizeThrowsIfAdditionalPropertiesIsNotBooleanOrObject()
    {
        $this->expectException(ConstraintException::ADDITIONAL_PROPERTIES_INVALID_TYPE);
        $schema = $this->loadSchema('invalid/additionalProperties-not-object-or-boolean');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeEnsuresAdditionalPropertiesAsObjectIsAValidSchema()
    {
        $schema = $this->loadSchema('valid/additionalProperties-as-object');
        $walker = $this->mockWalker();
        $walker->expects($this->at(0))
            ->method('parseSchema')
            ->with($schema->additionalProperties);
        $this->getConstraint()->normalize($schema, new Context(), $walker);
    }

    public function testNormalizeThrowsIfPatternPropertiesIsNotAnObject()
    {
        $this->expectException(ConstraintException::PATTERN_PROPERTIES_NOT_OBJECT);
        $schema = $this->loadSchema('invalid/patternProperties-not-object');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeThrowsIfPatternPropertiesPropertyNameIsNotAValidRegex()
    {
        $this->expectException(ConstraintException::PATTERN_PROPERTIES_INVALID_REGEX);
        $schema = $this->loadSchema('invalid/patternProperties-invalid-regex');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeThrowsIfPatternPropertiesPropertyValueIsNotAnObject()
    {
        $this->expectException(ConstraintException::PATTERN_PROPERTY_NOT_OBJECT);
        $schema = $this->loadSchema('invalid/patternProperties-property-value-not-object');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeEnsuresPatternPropertiesPropertyValueIsAValidSchema()
    {
        $schema = $this->loadSchema('valid/patternProperties-not-empty');
        $walker = $this->mockWalker();
        $walker->expects($this->at(1))
            ->method('parseSchema')
            ->with($schema->patternProperties->regex);
        $this->getConstraint()->normalize($schema, new Context(), $walker);
    }

    protected function getConstraint()
    {
        return new PropertiesConstraint();
    }

    protected function getCaseFileNames()
    {
        return ['properties'];
    }

    public function absentKeywordProvider()
    {
        return [
            ['valid/properties-not-present'],
            ['valid/additionalProperties-not-present'],
            ['valid/patternProperties-not-present']
        ];
    }
}