<?php
namespace Tarefas;

date_default_timezone_set("America/Sao_Paulo");
/**
 * User: gilson
 * Date: 2/12/16
 * Time: 6:35 PM
 */
class Tarefa implements \JsonSerializable
{

    private $nome;
    private $descricao;
    private $concluida;
    private $criacao;
    private $modificada;

    function __construct($nome, $descricao = "")
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->concluida = false;
        $this->criacao = date("d/m/Y-H:m");
        $this->modificada = $this->criacao;
    }

    function getCriacao()
    {
        return $this->criacao;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return array("nome" => $this->nome,
                     "descricao" => $this->descricao,
                     "concluida" => $this->concluida,
                     "criacao" => $this->criacao,
                     "modificada" => $this->modificada);
    }
}