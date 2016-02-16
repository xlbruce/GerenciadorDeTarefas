<?php
require_once "functions.php";

$ERROR_MESSAGES = [
    "miss_param" => 'O parâmetro "%s" é obrigatório',
    "task_not_found" => 'A tarefa %s não foi encontrada',
    "task_already_exists" => 'Já existe uma tarefa com o nome "%s"'
];

$method = $_SERVER['REQUEST_METHOD'];

//Verifica o tipo de requisição recebida
if ($method == 'POST') { //POST é somente usado para a inserção de tarefas
    if (isset($_POST['nome']) && (!empty($_POST['nome']))) {
        $name = $_POST['nome'];
        $description = (isset($_POST['descricao'])) ? $_POST['descricao'] : "";
        $task = addTask($name, $description);
        if($task) {
            echo json_encode($task, JSON_PRETTY_PRINT);
            return http_response_code($RESPONSE_CODES['ok']);
        } else {
            $responseCode = $RESPONSE_CODES['bad_request'];
            echo json_encode([
                "status" => $responseCode,
                "mensagem" => sprintf($ERROR_MESSAGES['task_already_exists'], $name)
            ]);
            return http_response_code($responseCode);
        }
    } else {
        $responseCode = $RESPONSE_CODES['bad_request'];
        echo json_encode([
            "status" => $responseCode,
            "mensagem" => sprintf($ERROR_MESSAGES['miss_param'], 'nome')
        ]);
        return http_response_code($responseCode); //Bad request
    }
} elseif ($method == 'GET') { //GET apenas lista as tarefas
    $tasks = getAllTasks();
    echo $tasks;
    return http_response_code($RESPONSE_CODES['ok']);
} elseif ($method == 'PUT') { //PUT pode ser usado para editar uma tarefa, ou marcá-la como concluida
    parse_str(file_get_contents('php://input'), $vars); //pega as variáveis via PUT
    if (!empty(($name = $vars['nome']))) { //Edição de uma tarefa
        $description = ($vars['descricao']) ? $vars['descricao'] : "";
        if ($success = editTask($name, $description)) {
            $success->status = 200;
            echo json_encode($success, JSON_PRETTY_PRINT);
            return http_response_code($RESPONSE_CODES['ok']);
        } else {
            $responseCode = $RESPONSE_CODES['bad_request'];
            echo json_encode([
                "status" => $responseCode,
                "mensagem" => sprintf($ERROR_MESSAGES['miss_param'], "nome")
            ]);
            return http_response_code($responseCode);
        }
    } elseif (!empty(($id = $vars['id']))) { //Marcar conclusão de uma tarefa

        $success = taskDone($id);
        if ($success) {
            $success->status = 200;
            echo json_encode($success, JSON_PRETTY_PRINT);
            return http_response_code($RESPONSE_CODES['ok']);
        } else {
            $responseCode = http_response_code(403);
            echo json_encode([
                "status" => $responseCode,
                "mensagem" => sprintf($ERROR_MESSAGES['task_not_found'], $id)
            ]);
            return $responseCode;
        }
    }
}
?>
