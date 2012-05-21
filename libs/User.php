<?php

class User
{
    static function getUserLvlArray() {
        $userLevels = array();
        $userLevels[0] = 'Super Admin';
        $userLevels[1] = 'Administrator';
        $userLevels[2] = 'Project Administrator';
        $userLevels[3] = 'Employee';
        $userLevels[7] = 'Client';
        return $userLevels;
    }
    
    static function getUserLvl($lvl) {
        $userLevels = $this->_getUserLvlArray();
        return isset($userLevels[$lvl])?$userLevels[$lvl]:false;
    }




//to use it:  $userLevels = unserialize(USER_LVL);
}
?>
