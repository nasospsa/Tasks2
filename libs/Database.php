<?php

class Database
{	
    const server = 'localhost';
    const db = 'ganwebg1_tasksDB2';
    const user = 'ganwebg1_user';
    const pass = '@oQxERR{=f+P';

    function Database()
    {
	mysql_connect(self::connection,self::db,self::user,self::pass);
		
    }
}