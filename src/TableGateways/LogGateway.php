<?php
namespace Src\TableGateways;

use Src\Models\Log;

class LogGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insert(Log $input)
    {
        $statement = "
            INSERT INTO logs 
                (request_type, request_url, requested_at)
            VALUES
                (:request_type, :request_url, :requested_at)
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'request_type' => $input->getReqType(),
                'request_url'  => $input->getReqUrl(),
                'requested_at' => $input->getReqTime()
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}