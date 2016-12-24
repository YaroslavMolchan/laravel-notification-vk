<?php

namespace NotificationChannels\Vk;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use NotificationChannels\Vk\Exceptions\CouldNotSendNotification;

class Vk
{
    /** @var HttpClient HTTP Client */
    protected $http;

    /** @var null|string Telegram Bot API Token. */
    protected $token = null;

    /**
     * @param null            $token
     * @param HttpClient|null $httpClient
     */
    public function __construct($token = null, HttpClient $httpClient = null)
    {
        $this->token = $token;

        $this->http = $httpClient;
    }

    /**
     * Get HttpClient.
     *
     * @return HttpClient
     */
    protected function httpClient()
    {
        return $this->http ?: $this->http = new HttpClient();
    }

    /**
     * Send text message.
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'text'                     => '',
     *   'parse_mode'               => '',
     *   'disable_web_page_preview' => '',
     *   'disable_notification'     => '',
     *   'reply_to_message_id'      => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     *
     * @param array $params
     *
     * @var int|string $params ['chat_id']
     * @var string     $params ['text']
     * @var string     $params ['parse_mode']
     * @var bool       $params ['disable_web_page_preview']
     * @var bool       $params ['disable_notification']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     *
     * @return mixed
     */
    public function sendMessage($params)
    {
        return $this->sendRequest('messages.send', $params);
    }

    /**
     * Send an API request and return response.
     *
     * @param $endpoint
     * @param $params
     *
     * @throws CouldNotSendNotification
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendRequest($endpoint, $params)
    {
        if (empty($this->token)) {
            throw CouldNotSendNotification::vkTokenNotProvided('You must provide your VK token to make any API requests.');
        }

        $endPointUrl = $this->generateUrl($endpoint, $params);

        try {
            $response = $this->httpClient()->get($endPointUrl);
            $response = json_decode($response->getBody(), true);
            if (isset($response['response']) && is_int($response['response'])) {
                return true;
            }
            else {
                throw CouldNotSendNotification::vkRespondedWithAnError($response);
            }
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithVk();
        }
    }

    /**
     * Generate URL
     * @param $endpoint
     * @param $params
     * @return string
     */
    protected function generateUrl($endpoint, $params)
    {
        $default = [
            'v' => '5.37',
            'access_token' => $this->token
        ];
        $params = array_merge($default, $params);

        $endPointUrl = 'https://api.vk.com/method/' . $endpoint . '?' . http_build_query($params);
        return $endPointUrl;
    }
}
