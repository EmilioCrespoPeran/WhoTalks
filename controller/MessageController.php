<?php
namespace controller;

use model\Meeting;
use model\Message;
use model\User;

require_once PATH_APP . "/model/UserManager.php";
require_once PATH_APP . "/model/MeetingManager.php";
require_once PATH_APP . "/model/MessageManager.php";
require_once PATH_APP . "/model/UserMeetingManager.php";

class MessageController extends ApplicationController {

    private $meetingManager;
    private $messageManager;
    private $usermeetingManager;

    public function __construct() {
        $this->meetingManager = new \model\MeetingManager();
        $this->messageManager = new \model\MessageManager();
        $this->usermeetingManager = new \model\UserMeetingManager();
    }


    public function home() {
        $_SESSION['meeting_id'] = $_POST['meeting_id'];

        $user = new \model\User();
        $user->setUsername($_SESSION['username']);

        $meeting = new \model\Meeting();
        $meeting->setId($_POST['meeting_id']);

        $meeting = $this->meetingManager->get_meeting($meeting);
        $this->usermeetingManager->add_user_meeting($user, $meeting);
        $user_list = $this->usermeetingManager->users_in_meetings($user, $meeting);

        $section = "Reunión ". $meeting->getName();

        parent::response(
            'chat/home.html.twig', array(
                'meeting' => $meeting,
                'users' => $user_list,
                'section' => $section
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


    public function fetch_users() {
        $user = new \model\User();
        $user->setUsername($_SESSION['username']);

        $meeting = new \model\Meeting();
        $meeting->setId($_SESSION['meeting_id']);

        $user_list = $this->usermeetingManager->users_in_meetings($user, $meeting);
        parent::response('chat/active_users.html.twig', array(
            'users' => $user_list
        ));
    }
}