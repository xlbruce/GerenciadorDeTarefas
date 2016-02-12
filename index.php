<html>
<?php
require_once "model/Tarefa.php";

$tasks = scandir('tasks');

foreach ($tasks as $task) {
    if (strpos($task, ".json")) {
        echo $task;
    }


}

?>
</html>