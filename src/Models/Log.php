<?php
namespace Src\Models;

class Log {
    private $request_type;
    private $request_url;
    private $requested_at;

    public function __construct($request_type, $request_url)
    {
        $this->request_type = $request_type;
        $this->request_url = $request_url;
        $this->requested_at = date('Y-m-d H-i-s');
    }

    public function getReqType()
    {
        return $this->request_type;
    }

    public function getReqUrl()
    {
        return $this->request_url;
    }

    public function getReqTime()
    {
        return $this->requested_at;
    }
}