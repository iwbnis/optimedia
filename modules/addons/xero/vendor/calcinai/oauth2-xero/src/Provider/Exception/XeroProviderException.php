<?php

namespace EdgeHosting\Calcinai\OAuth2\Client\Provider\Exception;

use EdgeHosting\League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use EdgeHosting\Psr\Http\Message\ResponseInterface;
class XeroProviderException extends IdentityProviderException
{
    /**
     * @param  ResponseInterface $response
     * @param  string|null $message
     *
     * @throws XeroProviderException
     */
    public static function fromResponse(ResponseInterface $response, $message = null)
    {
        throw new static($message, $response->getStatusCode(), (string) $response->getBody());
    }
}
