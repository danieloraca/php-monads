<?php

namespace App\Tests;

use App\Result;
use PHPUnit\Framework\TestCase;
use function App\divide; // Import the divide() function

class ResultTest extends TestCase
{
    public function testSuccessResult(): void
    {
        $result = Result::success(10);

        // Assert that the result is successful
        $this->assertTrue($result->isSuccess());

        // Assert that the value is correctly set
        $this->assertEquals(10, $result->getOrElse(0));
    }

    public function testErrorResult(): void
    {
        $result = Result::error("An error occurred");

        // Assert that the result is an error
        $this->assertFalse($result->isSuccess());

        // Assert that the error message is correctly set
        $this->assertEquals("An error occurred", $result->getError());
    }

    public function testMapFunctionOnSuccess(): void
    {
        $result = Result::success(5);

        // Apply map to double the value
        $mappedResult = $result->map(function ($value) {
            return $value * 2;
        });

        // Assert that map applied the transformation correctly
        $this->assertTrue($mappedResult->isSuccess());
        $this->assertEquals(10, $mappedResult->getOrElse(0));
    }

    public function testMapFunctionOnError(): void
    {
        $result = Result::error("An error occurred");

        // Apply map (should not execute the map function)
        $mappedResult = $result->map(function ($value) {
            return $value * 2; // This won't run
        });

        // Assert that the result is still an error and unchanged
        $this->assertFalse($mappedResult->isSuccess());
        $this->assertEquals("An error occurred", $mappedResult->getError());
    }

    public function testGetOrElseFunction(): void
    {
        $result = Result::error("Something went wrong");

        // Assert that it returns the default value on error
        $this->assertEquals(0, $result->getOrElse(0));

        // Assert that it returns the actual value on success
        $resultSuccess = Result::success(10);
        $this->assertEquals(10, $resultSuccess->getOrElse(0));
    }

    public function testDivideFunctionSuccess(): void
    {
        $result = divide(10, 2);

        // Assert that the division is successful
        $this->assertTrue($result->isSuccess());
        $this->assertEquals(5, $result->getOrElse(0));
    }

    public function testDivideFunctionError(): void
    {
        $result = divide(10, 0);

        // Assert that the division returns an error
        $this->assertFalse($result->isSuccess());
        $this->assertEquals("Cannot divide by 0", $result->getError());
    }

    public function testChainedMapAfterError(): void
    {
        $result = divide(10, 0) // division by 0 results in error
        ->map(function ($value) {
            return $value * 2;  // This should not run
        });

        // Assert that the result is still an error
        $this->assertFalse($result->isSuccess());
        $this->assertEquals("Cannot divide by 0", $result->getError());
    }

    public function testChainedMapAfterSuccess(): void
    {
        $result = divide(10, 2) // Successful division
        ->map(function ($value) {
            return $value * 2;  // This should run
        });

        // Assert that the map doubled the result correctly
        $this->assertTrue($result->isSuccess());
        $this->assertEquals(10, $result->getOrElse(0)); // 5 * 2 = 10
    }
}
