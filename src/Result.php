<?php

declare(strict_types=1);

namespace App;

class Result
{
    private mixed $value;
    private mixed $error;

    private function __construct($value = null, $error = null)
    {
        $this->value = $value;
        $this->error = $error;
    }

    public static function success($value): Result
    {
        return new self($value, null); // Ensure error is null
    }

    public static function error($error): Result
    {
        return new self(null, $error); // Ensure value is null
    }

    public function isSuccess(): bool
    {
        return $this->error === null;
    }

    public function map(callable $f): Result
    {
        if (!$this->isSuccess()) {
            return $this;
        }

        return self::success($f($this->value));
    }

    public function getOrElse($default): mixed
    {
        return $this->isSuccess() ? $this->value : $default;
    }

    public function getError()
    {
        return $this->error;
    }
}

// implementation

function divide($numerator, $denominator): Result
{
    if ($denominator == 0) {
        return Result::error("Cannot divide by 0");
    }

    $numerator = (float) $numerator;
    $denominator = (float) $denominator;

    $result = $numerator / $denominator;
    return Result::success($result);
}

$result = divide(10, 0) //error
    ->map(function($result) {
        return (int) $result * 2; // this will not run due to error
    });

if ($result->isSuccess()) {
    echo "Result: " . $result->getOrElse(0); // Shows the result if no error
} else {
    echo "Error: " . $result->getError();
}

// boom, monads!

