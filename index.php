<!DOCTYPE html>
<html>
<head>
    <title>Tarefas API</title>
    <meta charset="UTF-8"/>
</head>
<body>
<h1>Tarefas API</h1>
<h2>Descrição</h2>
<p>Essa simples API permite que se crie tarefas com uma breve descrição</p>

<h2>Funcionalidades</h2>
<ul>
    <li>Adicionar uma nova tarefa</li>
    <li>Listar todas as tarefas adicionadas</li>
    <li>Editar uma tarefa existente</li>
    <li>Remover uma tarefa existente</li>
    <li>Marcar uma tarefa como concluída</li>
</ul>

<h2>Como utilizar</h2>
<h3>Adicionando uma tarefa</h3>
<p>Envie uma requisição POST em /tarefas.php com os parametros *nome e descrição</p>
<p>A API vai retornar uma representação JSON da tarefa incluindo seu ID</p>
<p>* obrigatório</p>

<h3>Listando todas as tarefas</h3>
<p>Envie uma requisição GET em /tarefas.php</p>

<h3>Editando uma tarefa</h3>
<p>Envie uma requisição PUT em /tarefas.php com os parametros *nome e descrição.
Isso vai editar a descrição da tarefa</p>
<p>* obrigatório</p>

<h3>Removendo uma tarefa</h3>
<p>Envie uma requisição DELETE em /tarefas.php com o parametro *id</p>
<p>* obrigatório</p>

<h3>Marcando uma tarefa como concluida</h3>
<p>Envie uma requisição PUT em /tarefas.php com o parametro *id</p>
<p>* obrigatório</p>
</body>
</html>