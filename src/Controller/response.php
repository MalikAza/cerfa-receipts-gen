<?php

namespace CerfaReceiptsGen\Controller;

class Response {
    const STATUS_OK = 200;

    private $status = self::STATUS_OK;

    public function status(int $status) {
        $this->status = $status;

        return $this;
    }

    public function toJSON(array $data = []) {
        http_response_code($this->status);
        header('Content-Type: application/json');

        echo json_encode($data);
    }
}