<?php

namespace NotificationChannels\Vk;

use Illuminate\Notifications\Notification;

class VkChannel
{
    /**
     * @var Vk
     */
    protected $vk;

    /**
     * Channel constructor.
     *
     * @param Vk $vk
     */
    public function __construct(Vk $vk)
    {
        $this->vk = $vk;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toVk($notifiable);

        if (is_string($message)) {
            $message = VkMessage::create($message);
        }

        if ($message->toNotGiven()) {
            if (!$to = $notifiable->routeNotificationFor('vk')) {
                return;
            }

            $message->to($to);
        }

        $params = $message->toArray();

        $this->vk->sendMessage($params);
    }
}
