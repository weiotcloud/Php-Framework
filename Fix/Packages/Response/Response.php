<?php


namespace FixInternal\Response;


class Response {

    protected $STATUS;
    protected $CODE;

    protected $TITLE      = "";
    protected $MESSAGE    = "";
    protected $DATA       = [];

    /**
     * @param String|null $Title
     * @param String|null $Message
     */
    public function __construct(String $Title = Null, String $Message = Null, $Data = []) {

        $this->TITLE    = $Title;
        $this->MESSAGE  = $Message;
        $this->DATA     = $Data;

    }

    /**
     * @param String|null $Title
     * @param String|null $Message
     */
    public static function make(String $Title = Null, String $Message = Null,$Data = []): Response {
        return new self($Title,$Message,$Data);
    }

    /**
     * @return Response
     */
    public function info(): Response {
        $this->STATUS   = "info";
        $this->CODE     = 200;
        $this->show();
    }

    /**
     * @return Response
     */
    public function success(): Response {
        $this->STATUS   = "success";
        $this->CODE     = 200;
        $this->show();
    }

    /**
     * @return Response
     */
    public function error(): Response {
        $this->STATUS   = "error";
        $this->CODE     = 200;
        $this->show();
    }

    /**
     * @return Response
     */
    public function notFound(): Response {
        $this->STATUS   = "error";
        $this->CODE     = 404;
        $this->show();
    }

    /**
     * @return Response
     */
    public function warning(): Response {
        $this->STATUS   = "warning";
        $this->CODE     = 500;
        $this->show();
    }

    /**
     * @return Response
     */
    protected function show(): Response {

        $buildResponse = [
            "status"        => $this->STATUS,
            "code"          => $this->CODE,
            "title"         => $this->TITLE,
            "message"       => $this->MESSAGE,
            "result"        => $this->DATA,
        ];

        header('Content-Type: application/json; charset=utf-8');

        http_response_code($this->CODE);

        die(exit(json_encode($buildResponse)));
    }


}