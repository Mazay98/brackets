<?php

namespace App;

use Exception;

class Brackets
{
    private $data;

    public function isValid($data)
    {
        try {
            if (empty($data)) {
                $this->response(400);
                throw new Exception('DataIsEmpty');
            }

            $this->data = htmlspecialchars($data);
            $this->AllowedData();
            echo $this->isEqual();

        } catch (Exception $e) {
            if ($e->getMessage()) {
                echo json_encode(Array('result' => 'error', 'msg' => $e->getMessage()));
            } else {
                echo json_encode(Array('result' => 'error'));
            }
        }
    }

    private function isEqual()
    {
        $openBrackets = $this->howManyOpenBrackets();
        $closeBrackets = $this->howManyCloseBrackets();

        if ($openBrackets > $closeBrackets) {
            $this->response(400);
            throw new Exception('"(" > ")"');
        } elseif ($openBrackets < $closeBrackets) {
            $this->response(400);
            throw new Exception('"(" < ")"');
        } else {
            return $this->response(200, 'ok');
        }

        $this->response(500);
        throw new Exception('ServerError');
    }

    private function AllowedData()
    {
        $array = [
            '(',
            ')',
            ' ',
            '\n',
            '\t',
            '\r',
        ];

        $data = str_replace($array, '', trim($this->data));
        if (!empty($data)) {
            throw new Exception('InvalidArgumentException');
        }
        return true;
    }

    private function howManyOpenBrackets()
    {
        preg_match_all('~\(~', $this->data, $openBrackets);
        return count($openBrackets[0]);
    }

    private function howManyCloseBrackets()
    {
        preg_match_all('~\)~', $this->data, $openBrackets);
        return count($openBrackets[0]);
    }

    protected function response($status = 500, $data = "")
    {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        if (!empty($data)) {
            return json_encode($data);
        }
    }

    private function requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            400 => 'Bad Reques',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }
}