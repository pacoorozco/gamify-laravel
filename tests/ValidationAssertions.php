<?php

namespace Tests;

use ArrayAccess;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Assert as PHPUnitAssert;
use PHPUnit\Framework\InvalidArgumentException;

trait ValidationAssertions
{
    /**
     * Assert that the provided data passes the provided validation rules.
     *
     * @param array  $actual
     * @param array  $rules
     * @param string $message
     */
    protected function assertValidationPasses(array $actual, array $rules, string $message = '')
    {
        if (! (\is_array($actual) || $actual instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                1,
                'array or ArrayAccess'
            );
        }

        if (! (\is_array($rules) || $rules instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                2,
                'array or ArrayAccess'
            );
        }

        $validator = Validator::make($actual, $rules);
        PHPUnitAssert::assertFalse($validator->fails(), $message);
    }

    /**
     * Assert that the provided data is not passing the provided validation rules.
     *
     * @param array  $actual
     * @param array  $rules
     * @param string $message
     */
    protected function assertValidationFails(array $actual, array $rules, string $message = '')
    {
        if (! (\is_array($actual) || $actual instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                1,
                'array or ArrayAccess'
            );
        }

        if (! (\is_array($rules) || $rules instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                2,
                'array or ArrayAccess'
            );
        }

        $validator = Validator::make($actual, $rules);
        PHPUnitAssert::assertTrue($validator->fails(), $message);
    }

    /**
     * Assert that the provided data is not passing due to the expected provided field error.
     *
     * @param string $expected
     * @param array  $actual
     * @param array  $rules
     * @param string $message
     */
    protected function assertValidationHasError(string $expected, array $actual, array $rules, string $message = '')
    {
        if (! \is_string($expected)) {
            throw InvalidArgumentException::create(
                1,
                'string'
            );
        }

        if (! (\is_array($actual) || $actual instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                2,
                'array or ArrayAccess'
            );
        }

        if (! (\is_array($rules) || $rules instanceof ArrayAccess)) {
            throw InvalidArgumentException::create(
                3,
                'array or ArrayAccess'
            );
        }

        $validator = Validator::make($actual, $rules);
        PHPUnitAssert::assertTrue($validator->errors()->has($expected), $message);
    }
}
