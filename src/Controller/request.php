<?php

namespace CerfaReceiptsGen\Controller;

class Request {
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    public $params;
    public $method;
    public $content_type;

    public function __construct(array $params = []) {
        $this->params = $params;
        $this->method = trim($_SERVER['REQUEST_METHOD']);
        $this->content_type = !empty($_SERVER['CONTENT_TYPE']) ?
            trim($_SERVER['CONTENT_TYPE']) :
            '';
    }

    public function getBody() {
        if ($this->method !== self::METHOD_POST) {
            return '';
        }

        $body = [];
        foreach ($_POST as $key => $value) {
            $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }

    public function getJSON() {
        if ($this->method !== self::METHOD_POST || strcasecmp($this->content_type, 'application/json') !== 0) {
            return [];
        }

        $content = trim(file_get_contents('php://input'));
        $json = json_decode($content);

        return $json;
    }
}