<?php
namespace Src\TableGateways;

use Src\Models\Comment;

class CommentGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll() {
        $statement = "SELECT comment FROM comments;";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function get($id) {
        $statement = "SELECT comment FROM comments WHERE id = ?;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getByFilmId($film_id) {
        $statement = "SELECT comment FROM comments WHERE film_id = ?;";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($film_id));
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Comment $input)
    {
        $statement = "
            INSERT INTO comments 
                (comment, film_id)
            VALUES
                (:comment, :film_id);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array( 
                'comment' => $input->getComment(),
                'film_id' => $input->getFilmId()
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}