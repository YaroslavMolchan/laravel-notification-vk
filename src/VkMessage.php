<?php

namespace NotificationChannels\Vk;

class VkMessage
{
    /**
     * @var array Params payload.
     */
    public $payload = [];

    /**
     * @param string $content
     *
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * Message constructor.
     *
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content($content);
    }

    /**
     * Recipient's User ID.
     *
     * @param $userId
     *
     * @return $this
     */
    public function to($userId)
    {
        $this->payload['user_id'] = $userId;

        return $this;
    }

    /**
     * Notification message.
     *
     * @param $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->payload['message'] = $content;

        return $this;
    }

    /**
     * Determine if user id is not given.
     *
     * @return bool
     */
    public function toNotGiven()
    {
        return !isset($this->payload['user_id']);
    }

    /**
     * Returns params payload.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->payload;
    }
}
