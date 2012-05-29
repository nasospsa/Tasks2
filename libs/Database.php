<?php

class Database {
    const server = 'localhost';
    const db = 'ganwebg1_tasksDB2';
    const user = 'ganwebg1_user';
    const pass = '@oQxERR{=f+P';

    protected $_connection;

    function Database() {
        $this->_connection = mysql_connect(self::server, self::user, self::pass) or die(mysql_error());
        mysql_select_db(self::db, $this->_connection) or die(mysql_error());
        mysql_set_charset('utf8');
        date_default_timezone_set('Europe/Athens');
    }

}