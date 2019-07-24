<?php

namespace model;

require_once PATH_APP . "/model/DBMS.php";

class UserMeetingManager extends DBMS {

    public function users_in_meetings($user, $meeting) {
        $sql = "
            SELECT u.username as 'username'
            FROM user_meeting um
            LEFT JOIN user u ON um.username = u.username
            WHERE um.meeting_id = ". $meeting->getId() ." AND 
                  u.username != '". $user->getUsername() ."'
            ORDER BY u.username ASC";

        $rows = parent::query($sql);
        $user_list = array();

        while ($row = mysqli_fetch_assoc($rows)) {
            $user = new User();
            $user->setUsername($row['username']);

            array_push($user_list, $user);
        }

        return $user_list;
    }


    public function add_user_meeting($user, $meeting) {
        $sql = "INSERT INTO user_meeting VALUES ('". $user->getUsername() ."', ". $meeting->getId() .")";
        parent::query($sql);
    }


    public function remove_user_meeting($user, $meeting) {
        $sql = "DELETE FROM user_meeting WHERE username = '". $user->getUsername() ."' AND meeting_id = ". $meeting->getId();
        parent::query($sql);
    }

}