<?php
namespace model;

require_once PATH_APP . "/model/DBMS.php";

class MeetingManager extends DBMS {

    public function get_meeting($meeting) {
        $result = parent::query("SELECT * FROM meeting WHERE id = " . $meeting->getId());

        if ($result != null) {
            $row = mysqli_fetch_assoc($result);
            $meeting->setName($row['name']);
        }

        return $meeting;
    }


    public function get_meeting_list() {
        $result = parent::query("SELECT * FROM meeting ORDER BY name ASC");

        if ($result != null) {
            $meeting_list = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $meeting = new Meeting();
                $meeting->setId($row['id']);
                $meeting->setName($row['name']);

                array_push($meeting_list, $meeting);
            }

            $result = $meeting_list;
        }

        return $result;
    }

    /**
     * @param $meeting Meeting
     */
    public function create($meeting) {
        parent::query("INSERT INTO meeting (name) VALUES ('".$meeting->getName()."')");
    }

}

class Meeting {

    private $id;
    private $name;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

}