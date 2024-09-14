<?php
namespace Src\Models;

class Comment {
    private $comment;
    private $film_id;

    public function __construct($comment, $film_id)
    {
        $this->comment = $comment;
        $this->film_id = $film_id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getFilmID()
    {
        return $this->film_id;
    }
}