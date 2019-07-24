<?php
namespace controller;

use model\Meeting;
use model\User;
use model\UserMeetingManager;

require_once PATH_APP . "/model/UserManager.php";
require_once PATH_APP . "/model/MeetingManager.php";
require_once PATH_APP . "/model/UserMeetingManager.php";

class MeetingController extends ApplicationController {

    private $meetingManager;
    private $usermeetingManager;

    public function __construct() {
        $this->meetingManager = new \model\MeetingManager();
        $this->usermeetingManager = new \model\UserMeetingManager();
    }

    public function home(){
        if (isset($_SESSION['meeting_id'])) {
            $user = new \model\User();
            $user->setUsername($_SESSION['username']);

            $meeting = new \model\Meeting();
            $meeting->setId($_SESSION['meeting_id']);

            $this->usermeetingManager->remove_user_meeting($user, $meeting);
            unset($_SESSION['meeting_id']);
        }

        $meeting_list = $this->meetingManager->get_meeting_list();

        parent::response("home.html.twig", array(
            'meetings' => $meeting_list
        ));
    }

    public function create() {
        $view = "meeting/form.html.twig";
        parent::response($view);
    }

    public function save() {
        $meeting = new \model\Meeting();
        $meeting->setName($_POST['name']);
        $this->meetingManager->create($meeting);

        parent::redirect("/");
    }


}