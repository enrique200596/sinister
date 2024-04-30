<?php
require_once 'notification.php';

class NotificationController
{
    private array $notifications;

    public function __construct()
    {
        $this->notifications = [];
        $this->loadNotifications();
    }

    public function addNotification(Notification $n)
    {
        $this->notifications[$n->getName()] = $n;
    }

    public function saveNotificationsOnSession()
    {
        $session = new Session();
        $session->addData('notifications', $this->getNotifications());
    }

    public function loadNotifications()
    {
        $session = new Session();
        $this->setNotifications($session->getData['notifications']);
    }
}
