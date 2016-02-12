<?php

$TASKS_DIR = 'tasks';
$TASKS = opendir($TASKS_DIR);

function getAllTasks() {
    global $TASKS;
    global $TASKS_DIR;

    foreach ($TASKS as $task) {
        if (strpos($task, ".json")) {
            $fp = fopen("$TASKS_DIR/$task", "r");

        }

    }
}