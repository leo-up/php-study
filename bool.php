<?php

class BoolTest1
{
    public function getBoolFromNull(null $a): bool
    {
        return (bool)$a;//必须加上强制转换，否则报错
    }

    public function getBoolFromInt(int $a): bool
    {
        return $a;
    }

    public function getBoolFromString(string $a): bool
    {
        return $a;
    }

    public function getBoolFromArray(array $a): bool
    {
        return (bool)$a; //必须加上强制转换，否则报错
    }

    public function getBoolFromObject(object $a): bool
    {
        return (bool)$a; //必须加上强制转换，否则报错
    }

    public function getBoolFromCallable(object $a): bool
    {
        return (bool)$a; //必须加上强制转换，否则报错
    }
}

$boolTest = new BoolTest1();
var_dump($boolTest->getBoolFromNull(null));// 输出 false
var_dump($boolTest->getBoolFromInt(0));// 输出 false
var_dump($boolTest->getBoolFromInt(5));// 输出 true

var_dump($boolTest->getBoolFromString(''));// 输出 false
var_dump($boolTest->getBoolFromString('abc'));// 输出 true

var_dump($boolTest->getBoolFromArray([]));// 输出 false
var_dump($boolTest->getBoolFromArray([1, 2]));// 输出 true

var_dump($boolTest->getBoolFromObject(new stdClass()));// 输出 true

var_dump($boolTest->getBoolFromCallable(function ($b) {return $b;}));// 输出 true

//其他类型转城bool
class BoolTest2
{
    public function getBool(int|float|string $a): bool
    {
        return $a;
    }

    public function getBoolFromOther(array|object|callable $a): bool
    {
        return (bool)$a;
    }
}

$boolTest2 = new BoolTest2();
var_dump($boolTest2->getBool(0));// 输出 false
var_dump($boolTest2->getBool(22));// 输出 true
var_dump($boolTest2->getBool(''));// 输出 false
var_dump($boolTest2->getBool('aaa'));// 输出 true
var_dump($boolTest2->getBoolFromOther([])); // 输出 false
var_dump($boolTest2->getBoolFromOther([1,2])); // 输出 true
var_dump($boolTest2->getBoolFromOther(function (){})); // 输出 true


class BoolTest3
{
    //false单独类型
    public function getFalseOrInt(int|false $a): int|false
    {
        return $a;
    }

    //true单独类型
    public function getTrueOrInt(int|true $a): int|true
    {
        return $a;
    }
}

$boolTest3 = new BoolTest3();
//false单独类型
//var_dump($boolTest3->getFalseOrInt(null)); //报错
var_dump($boolTest3->getFalseOrInt(3)); //输出 3
//var_dump($boolTest->getFalseOrInt('')); //报错
var_dump($boolTest3->getFalseOrInt(true)); //输出 1
var_dump($boolTest3->getFalseOrInt(false)); //输出 false

//true单独类型
var_dump($boolTest3->getTrueOrInt(3)); //输出 3
//var_dump($boolTest->getFalseOrInt('')); //报错
var_dump($boolTest3->getTrueOrInt(true)); //输出 true
var_dump($boolTest3->getTrueOrInt(false)); //输出 0

class BooTest4
{
    protected bool $b;

    public function setB(bool $b): static
    {
        $this->b = $b;
        return $this;
    }

    public function getB(): bool
    {
        return $this->b;
    }
}

$boolTest4 = new BooTest4();
//var_dump($boolTest4->getB()); //报错
$boolTest4->setB(true);
var_dump($boolTest4->getB()); //输出 true

//构造方法初始化
class BooTest5
{
    public function __construct(protected bool $b) {}

    public function getB(): bool
    {
        return $this->b;
    }
}

$boolTest4 = new BooTest5(false);
var_dump($boolTest4->getB()); //输出 false

//boll转换
var_dump((bool)[]); // 输出 false
var_dump((boolval('abc'))); // 输出 true