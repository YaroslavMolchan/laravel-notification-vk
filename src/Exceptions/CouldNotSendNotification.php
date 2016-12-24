<?php

namespace NotificationChannels\Vk\Exceptions;

use GuzzleHttp\Exception\ClientException;

class CouldNotSendNotification extends \Exception
{
    /**
     * Thrown when there's no vk token provided.
     *
     * @param string $message
     *
     * @return static
     */
    public static function vkTokenNotProvided($response)
    {
        return new static($response);
    }

    /**
     * Thrown when there's a bad request and an error is responded.
     *
     * @param array $response
     *
     * @return static
     */
    public static function vkRespondedWithAnError(array $response)
    {
        $statusCode = $response['error']['error_code'];

        $description = 'no description given';

        if (isset($response['error']['error_msg'])) {
            $description = $response['error']['error_msg'];
        }

        return new static("VK responded with an error `{$statusCode} - {$description}`");
    }

    /**
     * Thrown when we're unable to communicate with VK.
     *
     * @return static
     */
    public static function couldNotCommunicateWithVk()
    {
        return new static('The communication with VK failed.');
    }
}
