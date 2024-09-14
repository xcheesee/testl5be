<?php
namespace Src\Controllers;

use Src\TableGateways\CommentGateway;
use Src\Models\Comment;

class CommentController {

    private $db;
    private $requestMethod;
    private $filmId;

    private $commentGateway;

    public function __construct($db, $requestMethod, $filmId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->filmId = $filmId;

        $this->commentGateway = new CommentGateway($db);
    }

    public function processRequest()
    {
        $response = null;
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->filmId) {
                    $response = $this->getCommentsByFilmId($this->filmId);
                } else {
                    $response = $this->getAllComments();
                };
                break;
            case 'POST':
                //if(!$this->filmId) return;
                $response = $this->postComment();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public function getAllComments() {
        $result = $this->commentGateway->getAll();
        //var_dump($result);
        $response['status_code_header'] = "HTTP/1.1 200 OK";
        $response['body'] = json_encode($result);
        return $response;
    }

    public function getCommentsByFilmId($film_id) {
        $result = $this->commentGateway->getByFilmId($film_id);
        $response['status_code_header'] = "HTTP/1.1 200 OK";
        $response['body'] = json_encode($result);
        return $response;
    }

    public function postComment() {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        $comment = new Comment($input['comment'], $input['film_id']);
        $this->commentGateway->insert($comment);
        $response['status_code_header'] = "HTTP/1.1 201 CREATED";
        $response['body'] = null;
        return $response;
    }
}
