<?php
//null 参数
function testNull(null $a)
{
    var_dump($a);
}
testNull(null); //正确
//testNull(0); //报错
//testNull(1.22); //报错
//testNull(''); //报错
//testNull(false); //报错
//testNull([]); //报错
//testNull(new stdClass()); //报错
//testNull(fopen('/Users/leo/code/php/php-study/hello_world.php')); //报错
//testNull(function () {echo '111';});

//null 参数 复合
function test(?int $a, int|float|null $b): int|float
{
    return $a + $b;
}
echo test(null, 2.5) . "\n"; //输出 2.5
echo test(1, 2.5)  . "\n"; //输出 3.5
echo test(1, 4)  . "\n"; //输出 5

//null 比较
var_dump(null === 0); // 输出 false
var_dump(null == 0); // 输出 true
var_dump(null === ''); // 输出 false
var_dump(null == ''); // 输出 true
var_dump(null === 0.0); // 输出 false
var_dump(null == 0.0); // 输出 true
var_dump(null === false); // 输出 false
var_dump(null == false); // 输出 true
var_dump(null === []); // 输出 false
var_dump(null == []); // 输出 true

//null 与 void
function testNullVoid1(int &$a): void
{
    $a = $a * $a;
}
function testNullVoid2(int &$a): void
{
    if (!$a) {
        return;
    }
    $a = $a * $a;
}
//function testNullVoid3(int &$a): void
//{
//    if (!$a) {
//        return null; // 报错
//    }
//    $a = $a * $a;
//}

//null 不区分大小写
var_dump(null); // 输出 NULL
var_dump(NULL); // 输出 NULL
var_dump(Null); // 输出 NULL

//null 判断
var_dump(is_null(null)); // 输出 true
var_dump(is_null(false)); // 输出 false
var_dump(is_null('')); // 输出 false
var_dump(is_null(0)); // 输出 false

//null 置空
$a = 1;
$b = false;
$c = [1, 4];
$d = null;
unset($a, $b, $c, $d);

//null的内置方法 deprecated 问题
var_dump(trim(null)); // deprecated error, 输出 ""
var_dump(ucfirst(null)); // deprecated error, 输出 ""
var_dump(strtolower(null)); // deprecated error, 输出 ""