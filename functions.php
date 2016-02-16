<?php
date_default_timezone_set("America/Sao_Paulo");

$TASKS_DIR = 'tasks';
$TASKS = opendir($TASKS_DIR);

//Retorna um JSON array com todas as tarefas salvas
function getAllTasks()
{
    global $TASKS;
    global $TASKS_DIR;

    while (($entry = readdir($TASKS))) {
        if ($entry != "." && $entry != "..") { //Ignora o diretório atual e o anterior (um nivel acima)
            $response[] = json_decode(file_get_contents("$TASKS_DIR/$entry"));
        }
    }

    return json_encode($response, JSON_PRETTY_PRINT);
}

function getTask($id) {
    global $TASKS_DIR;

    $content = file_get_contents("$TASKS_DIR/$id.json");
    if($content) {
        return json_decode($content);
    }
    return false;
}

//Adiciona uma tarefa e retorna o objeto adicionado em caso de sucesso
function addTask($name, $description = "")
{
    global $TASKS_DIR;

    if (!findTask($name)) {
        $id = generateId();
        $date = date("Y-m-d");
        $task = new stdClass();
        $task->id = $id;
        $task->nome = $name;
        $task->descricao = $description;
        $task->concluida = false;
        $task->criacao = $date;
        $task->modificada = $date;
        try {
            writeJson("$TASKS_DIR/$id.json", $task);
        } catch (Exception $e) {
            echo "Erro ao serializar";
            echo $e;
            return false;
        }
        return $task;
    }
    return false;
}

//Salva um arquivo em disco no formato JSON
function writeJson($filename, $obj)
{

    $fh = fopen($filename, "w");
    fwrite($fh, json_encode($obj, JSON_UNESCAPED_UNICODE));
    fclose($fh);
}

function removeTask($id)
{
    global $TASKS_DIR;

    unlink("$TASKS_DIR/$id.json");
    return true;
}

function editTask($taskName, $description = "")
{
    global $TASKS_DIR;

    $task = findTask($taskName);
    if ($task) {
        $task->descricao = $description;
        $task->modificada = date("Y-m-d");
        $filename = $TASKS_DIR . '/' . $task->id . '.json';
        writeJson($filename, $task);
        return $task;
    }
    return false;
}

function findTask($taskName)
{
    global $TASKS_DIR;

    $tasks = json_decode(getAllTasks());
    foreach ($tasks as $k => $v) {
        if ($tasks[$k]->nome == $taskName) {
            return $tasks[$k];
        }
    }
    return false;
}

/**
 * Marca uma tarefa como concluida
 * @param $id Id da tarefa
 * @return mixed A tarefa modificada, ou false em caso de falha
 */
function taskDone($id)
{
    global $TASKS_DIR;

    $filename = "$TASKS_DIR/$id.json";
    $task = getTask($id);
    if($task) {
        $task->concluida = true;
        $task->modificada = date("Y-m-d");
        writeJson($filename, $task);
        return $task;
    }
    return false;
}

//Gera um ID para as tasks
function generateId()
{
    return date("YmdHis");
}

