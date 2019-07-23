<?php

namespace model;

require_once PATH_APP . "/model/DBMS.php";

class MessageManager extends DBMS {


    public function fetch_messages($meeting) {
        $result = parent::query("SELECT * FROM message WHERE meeting_id = ". $meeting->getId() ." ORDER BY date_time ASC");

        if ($result != null) {
            $message_list = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $message = new Message();
                $message->setId($row['id']);
                $message->setMeetingId($row['meeting_id']);
                $message->setUsername($row['username']);
                $message->setMessage($row['message']);

                $date = date_create($row['date_time']);
                $message->setDateTime(date_format($date, 'H:i'));

                array_push($message_list, $message);
            }

            $result = $message_list;
        }

        return $result;
    }


    public function write_message($message) {
        parent::query("INSERT INTO message (meeting_id, username, message, date_time) VALUES (" .
            $message->getMeetingId() .",'". $message->getUsername() ."', '". $message->getMessage() ."', '". $message->getDateTime() ."')");
    }

}

class Message {

    private $id;
    private $meeting_id;
    private $username;
    private $message;
    private $date_time;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMeetingId() {
        return $this->meeting_id;
    }

    /**
     * @param mixed $meeting_id
     */
    public function setMeetingId($meeting_id) {
        $this->meeting_id = $meeting_id;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getDateTime() {
        return $this->date_time;
    }

    /**
     * @param mixed $date_time
     */
    public function setDateTime($date_time) {
        $this->date_time = $date_time;
    }


}