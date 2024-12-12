<?php

namespace OpenAI\Exceptions;

use OpenAI\Responses\Meta\MetaInformation;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class APIStatusError extends ErrorException implements OpenAIThrowable
{
    protected int $statusCode;
    protected ?string $requestId;

    public function __construct(
        protected readonly RequestInterface $request,
        protected readonly ResponseInterface $response,
        array $contents
    ) {
        parent::__construct($contents, $response->getStatusCode());

        $this->statusCode = $response->getStatusCode();
        $this->requestId = $response->getHeader('x-request-id')[0] ?? null;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    public function meta(): ?MetaInformation
    {
        if (method_exists($this->response, 'getHeaders')) {
            return MetaInformation::from($this->response->getHeaders());
        }

        return null;
    }
}
