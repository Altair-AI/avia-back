<?php

namespace App\Components;

class CaseEngine
{
    public static function compareValues($case1Val, $case2Val, $weight, $constraint)
    {
        $res = 0;
        if (Trim($constraint) == '')
            $constraint = 100;
        if (Trim($weight) == '')
            $weight = 1;
        if ((strpos($case1Val,'[') === false) and (strpos($case2Val,'[') === false)) {
            $case1Val = str_replace(',', '.', $case1Val);
            $case2Val = str_replace(',', '.', $case2Val);
            if (is_numeric($case1Val) and is_numeric($case2Val)) {
                $res = abs($case1Val - $case2Val);
                if ($res > ($case1Val * $constraint / 100))
                    $res = 0;
                else
                    if ($res == 0)
                        $res = $weight;
                    else
                        $res = ($case1Val / ($case1Val + $res)) * $weight;
            } else {
                if (is_string($case1Val))
                    if ((trim($case1Val) == trim($case2Val)) and (trim($case1Val) != ''))
                        $res = $weight;
                    else
                        $res = 0;
            }
        }
        return $res;
    }

    public static function compare($case1, $case2)
    {
        $res = 0;
        $i = 0;
        foreach ($case1 as $key => $value) {
            if ($i == 0 and array_key_exists($key, $case2))
                $res += self::compareValues($case1[$key], $case2[$key], 1, 100);
            $i += 1;
        }
        return $res;
    }

    public static function execute($case0, $cases)
    {
        $res = array();
        $res[0] = self::compare($case0, $case0);
        foreach ($cases as $key => $value)
            $res[$key] = (self::compare($case0, $value)) / $res[0];
        array_shift($res);
        arsort($res);
        return $res;
    }
}
