<?php
namespace controller;

use model\Meeting;
use model\Message;

require_once PATH_APP . "/model/MeetingManager.php";
require_once PATH_APP . "/model/MessageManager.php";

class MessageController extends ApplicationController {

    private $meetingManager;
    private $messageManager;

    public function __construct() {
        $this->meetingManager = new \model\MeetingManager();
        $this->messageManager = new \model\MessageManager();
    }


    public function home() {
        $meeting = new Meeting();
        $_SESSION['meeting_id'] = $_POST['meeting_id'];
        $meeting->setId($_POST['meeting_id']);

        $meeting = $this->meetingManager->get_meeting($meeting);

        parent::response(
            'chat/home.html.twig', array(
                'meeting' => $meeting
            )
        );
    }


    public function send_message() {
        $message = new \model\Message();
        $message->setMeetingId($_SESSION['meeting_id']);
        $message->setUsername($_SESSION['username']);
        $message->setMessage($_POST['message']);
        $message->setDateTime(date('Y-m-d H:i:s'));

        $this->messageManager->write_message($message);
    }


    public function fetch_messages() {
        $meeting = new \model\Meeting();
        $meeting->setId($_SESSION['meeting_id']);

        $message_list = $this->messageManager->fetch_messages($meeting);

        echo parent::response('chat/chat.html.twig', array(
            'messages' => $message_list
        ));
    }

}