<?php

declare(strict_types=1);

namespace OpenAI\Exceptions;

use JsonException;

final class UnserializableResponse extends OpenAiException
{
    /**
     * Creates a new Exception instance.
     */
    public function __construct(JsonException $exception)
    {
        parent::__construct($exception->getMessage(), 0, $exception);
    }
}
