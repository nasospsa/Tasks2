<?php

class Task {

    static function _getTaskStatusArray() {
        $status = array();
        $status[0] = 'Completed';
        $status[1] = 'In Progress';
        $status[2] = 'Not Started';
        $status[3] = 'Awaiting Confirmation';
        $status['default'] = $status[3];
        return $status;
    }

    static function _getTaskStatus($param) {
        $statusArray = $this->_getStatusArray();
        return $statusArray[$param];
    }

}

?>
