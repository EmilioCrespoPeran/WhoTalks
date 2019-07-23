<?php
namespace controller;

use model\Meeting;

require_once PATH_APP . "/model/MeetingManager.php";

class MeetingController extends ApplicationController {

    private $meetingManager;

    public function __construct() {
        $this->meetingManager = new \model\MeetingManager();
    }

    public function home(){
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
        $meeting = new Meeting();
        $meeting->setName($_POST['name']);
        $this->meetingManager->create($meeting);

        parent::redirect("/");
    }


}