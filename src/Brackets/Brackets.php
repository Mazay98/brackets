<?php

namespace App;

class Brackets
{
    private $data;

    public function isValid($data)
    {
        if (empty($data)) {
            return('DataIsEmpty');
        }

        $this->data = htmlspecialchars($data);

        $this->AllowedData();

        return $this->isEqual();

    }

    private function isEqual()
    {
        $openBrackets = $this->howManyOpenBrackets();
        $closeBrackets = $this->howManyCloseBrackets();

        if ($openBrackets > $closeBrackets){
            return '"(" > ")"';
        } elseif ($openBrackets < $closeBrackets) {
            return '"(" < ")"';
        } else {
            return 'good!';
        }

        return('ERORR equil');

    }

    private  function AllowedData()
    {
        $array = [
            '(',
            ')',
            ' ',
            '\n',
            '\t',
            '\r',
        ];

        $data = str_replace($array,'',trim($this->data));
        if (!empty($data)) {
            return('InvalidArgumentException');
        }
        return true;
    }

    private function howManyOpenBrackets ()
    {
        preg_match_all('~\(~',$this->data,$openBrackets);
        return count($openBrackets[0]);
    }
    private function howManyCloseBrackets ()
    {
        preg_match_all('~\)~',$this->data,$openBrackets);
        return count($openBrackets[0]);
    }
}