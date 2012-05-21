<?php

class Task {
    
    function action_newTask($taskArray) {
        list ($title, $desc, $priority, $assignedto, $project) = $taskArray;
        $assigned_array = explode(",", $assignedto);
        
        //Check assigned users array!
        //$self_array[] = $this->username;

        $not_eligible_users = $this->array_in_array_mistakes($assigned_array, $this->getUsers_on_Project($project, SERIALIZED_NONCLIENT));
        
    }
    function newtask($title, $desc, $priority, $assignedto, $project) {
        global $database, $form, $mailer;  //The database, form and mailer object

        $assigned_array = explode(",", $assignedto);

        //Check assigned users array!
        //$self_array[] = $this->username;

        $self = "Self (" . $this->username . ")";

        if (in_array($this->username, $assigned_array)) {
            $index = array_search($this->username, $assigned_array);
            array_splice($assigned_array, $index, 1);
            array_splice($assigned_array, 0, 0, $self);
        }

        $not_eligible_users = $this->array_in_array_mistakes($assigned_array, $this->getUsers_on_Project($project, SERIALIZED_NONCLIENT));



        foreach ($this->avail_projects as $avail_project) {
            $projects[] = $avail_project[title];
        }

        //Error checking of task_title
        $field = "task_title_" . $project;
        if (!$title || strlen($title = trim($title)) == 0) {
            $form->setError($field, "Δεν έχει οριστεί τίτλος");
        } else if (strlen($title) < 5) {
            $form->setError($field, "Δώστε όνομα Task πάνω απο 5 χαρακτήρες");
        }
        //greek check for proper format (μαζί με τόνους)
        else if (!preg_match($this->text_pattern, $title)) {
            $form->setError($field, "O τίτλος δεν είναι αλφαριθμητικός");
        }

        //Error checking for assigned users
        $field = "task_assignement" . $project;
        if (!$assignedto || strlen($assignedto = trim($assignedto)) == 0) {
            $form->setError($field, "Ορίστε άτομο/άτομα για ανάθεση του Task");
        } else if ($not_eligible_users > 0) {
            $form->setError($field, "Λάθος στα άτομα προς ανάθεση του Task");
        } else if (!in_array($project, $projects, true)) {
            $form->setError($field, "Σφάλμα στην επιλογή του project!");
        }


        if (in_array($self, $assigned_array)) {
            $index = array_search($self, $assigned_array);
            array_splice($assigned_array, $index, 1);
            array_splice($assigned_array, 0, 0, $this->username);
        }

        if ($form->num_errors > 0) {
            $form->setError("vis_add_task" . $project, "none");
            return 1;  //Errors with form
        } else {
            if ($database->addNewTask($title, $desc, $priority, $project, $this->username, $assigned_array)) {
                $database->activities_AddNewTask($this->username, $project, $title);

                $from_start = TRUE;
                $database->activities_AddAssignTask($this->username, $project, $title, implode(",", $assigned_array), $from_start);

                $mailer->newTaskNotification($title, $project, $this->username, $assigned_array);
                return 0; //Everything went fine!
            }
            else
                return 2; // New Task failed
        }
    }

    static function getTaskStatusArray() {
        $status = array();
        $status[0] = 'Completed';
        $status[1] = 'In Progress';
        $status[2] = 'Not Started';
        $status[3] = 'Awaiting Confirmation';
        $status['default'] = $status[3];
        return $status;
    }

    static function getTaskStatus($param) {
        $statusArray = $this->_getStatusArray();
        return $statusArray[$param];
    }

}

?>
