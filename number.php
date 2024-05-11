<?php

/**
 * see article: https://www.leyeah.com/blog/article/update-php-data-types-int-and-float-3924112
 */
class Number
{
    public function getNumberFromNull(null $a): int
    {
        return (int)$a; //需要转换，否则报错
    }

    public function getNumberFromBool(bool $a): int
    {
        return $a;
    }

    public function getIntFromString(string $a): int
    {
        return $a;
    }

    public function getFloatFromString(string $a): float
    {
        return $a;
    }

    public function getNumberFromOthers(array|callable|object $a): int
    {
        //callable和object会报 PHP Warning
        return (int)$a;
    }
}

$number = new Number();
//var_dump($number->getNumberFromNull(null));//报错
var_dump($number->getNumberFromBool(false));//输出 0
var_dump($number->getNumberFromBool(true));//输出 1
var_dump($number->getIntFromString('123'));//输出 123
var_dump($number->getIntFromString(123));//输出 123
var_dump($number->getIntFromString('123.123'));//输出 123.123 (Deprecated 错误)
var_dump($number->getIntFromString(123.34));//输出 123.34 (Deprecated 错误)
//var_dump($number->getIntFromString('12aa'));//Fatal error
var_dump($number->getFloatFromString('123.123'));//输出 123.123
var_dump($number->getFloatFromString(123.34));//输出 123.34
var_dump($number->getNumberFromOthers([]));//输出 0
var_dump($number->getNumberFromOthers([1,2,3]));//输出 1
var_dump($number->getNumberFromOthers(new stdClass()));//输出 1 (PHP Warning)
var_dump($number->getNumberFromOthers(function (){}));//输出 1 (PHP Warning)

//浮点数
var_dump((int)( (0.1+0.7) * 10 ));//输出7，而不是8
var_dump(round(( (0.1+0.7) * 10 )));//输出8
var_dump(0.1+0.2);//输出 0.30000000000000004
var_dump(0.1+0.2 == 0.3);//输出false
var_dump(0.1+0.2 >= 0.3);//输出true

//二进制应用
class ModulePerm
{
    const PERM_JONI         = 1; // 0b00001
    const PERM_CLOSE        = 2; // 0b00010
    const PERM_QUIT         = 4; // 0b00100
    const PERM_SET_ADMIN    = 8; // 0b01001
    const PERM_CAN_ADMIN    = 16; // 0b10000
    //....

    public function getPermission(): int
    {
        $perm = $this->getJoinPerm();
        //$perm += ....
        //....
        return $perm;
    }

    public function hasPermission(int $perm): bool
    {
        return $perm & $this->getPermission();
    }

    protected function getJoinPerm(): int
    {
        //...判断是否有这个权限
        return static::PERM_JONI;
    }

}

//常用函数
var_dump((int)'11a');//输出 11
var_dump(intval('11a'));//输出 11
var_dump((float)'11a');//输出 11
var_dump(floatval('11.87'));//输出 11.87
var_dump((is_numeric('11.345')));//输出 true
var_dump(max(1, 5, 2));//输出 5
var_dump(min(1, 5, 2));//输出 1
var_dump(floor(2.8));//输出 2
var_dump(round(2.5));//输出 3
var_dump(ceil(2.1));//输出 3

