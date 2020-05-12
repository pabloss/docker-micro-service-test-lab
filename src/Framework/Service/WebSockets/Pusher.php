<?php
declare(strict_types=1);

namespace App\Framework\Service\WebSockets;

use App\Framework\Service\WebSockets\Context\Wrapper;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

/**
 * Class Pusher
 *
 * @package App\Framework\Service\WebSockets
 * @codeCoverageIgnore
 */
class Pusher implements WampServerInterface {
    /**
     * A lookup of all the topics clients have subscribed to
     */
    protected $subscribedTopics = array();

    public function onSubscribe(ConnectionInterface $conn, $topic) {
        $this->subscribedTopics[$topic->getId()] = $topic;
        \print_r("Subscribed topic: ". $topic->getId(). "\n");
    }

    /**
     * @param string JSON'ified string we'll receive from ZeroMQ
     */
    public function onMsg($entry) {
        $entryData = json_decode($entry, true);

        // If the lookup topic object isn't set there is no one to publish to
        if (!array_key_exists($entryData[Wrapper::TOPIC_ENTRY_DATA_KEY], $this->subscribedTopics)) {
            return;
        }

        $topic = $this->subscribedTopics[$entryData[Wrapper::TOPIC_ENTRY_DATA_KEY]];

        // re-send the data to all the clients subscribed to that category
        $topic->broadcast($entryData);
        \print_r($entryData);
    }

    public function onUnSubscribe(ConnectionInterface $conn, $topic) {
    }
    public function onOpen(ConnectionInterface $conn) {
    }
    public function onClose(ConnectionInterface $conn) {
    }
    public function onCall(ConnectionInterface $conn, $id, $topic, array $params) {
        // In this application if clients send data it's because the user hacked around in console
        $conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }
    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible) {
        // In this application if clients send data it's because the user hacked around in console
        $conn->close();
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}
