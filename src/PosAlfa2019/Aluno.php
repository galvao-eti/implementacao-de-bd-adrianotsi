<?php

declare(strict_types=1);
require 'Abstraction/BancoDeDados.php';
class Aluno implements PosAlfa\Abstraction\BancoDeDados
{
    // Conexão com o banco
    const DSN = 'mysql:host=localhost;dbname=db_poo';
    const USER = 'root';
    const PASS = '';

    // Parametros
    public $id;
    public $ra;
    public $nome;

    // Getters e Setters
    public function getID()
    {
        return $this->id;
    }

    public function setID($id)
    {
        $this->id = $id;
    }

    public function getRA()
    {
        return $this->RA;
    }

    public function setRA($ra)
    {
        $this->ra = $ra;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    // PDO
    public function connect(string $dsn, string $user, string $pass): \PDO
    {
        $conn = new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE  => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_CASE     => \PDO::CASE_LOWER
        ]);
        return $conn;
    }
    public function prepare(\PDO $pdo, string $sql): \PDOStatement
    {
        return $pdo->prepare($sql);
    }

    // Faz o select na tabela de alunos
    public function select()
    {
        try {
            $pdo = $this->connect(self::DSN, self::USER, self::PASS);
            $sql = $this->prepare($pdo, 'SELECT * FROM aluno');
            $sql->execute();
            while ($dados = $sql->fetch(PDO::FETCH_OBJ)) {
                $id = $dados->id;
                $ra = $dados->ra;
                $nome = $dados->nome;
                echo "<table>
                <tr>
                  <th>ID</th>
                  <th>RA</th>
                  <th>Nome</th>
                </tr>
                <tr>
                  <td>$id</td>
                  <td>$ra</td>
                  <td>$nome</td>
                </tr>
              </table>";
            }
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}
