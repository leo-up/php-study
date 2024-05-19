<?php
/**
 * see article: https://github.com/leo-up/php-study/blob/master/base/array.php
 */
$arr1 = array(1, 2, 4); //正常形式
$arr2 = ['a'=>1, 2, 4]; //简写形式，一般都用这种
$arr3 = [
    'a' => [1, 6],
    '55',
    '1.2' => 55,//需要用哪个字符串，否则会报 Deprecated 错误
    false => 44,//false自动转为0, 如果数组中已有下标0的，则会被覆盖
    -1 => 3333,
];

$arr1[] = 5;//数字下标的赋值
$arr2['b'] = 5;//字母下标赋值
$arr3[1+2] = 666;//下标可以运算，也可以用函数或方法

//输出数组，带类型
var_dump($arr1);

//输出数组，可读性高，一般用这种
print_r($arr2);

//输出数组，格式化，一般用于写入php文件（第2个参数设为true）
var_export($arr3) . "\n";

var_dump($arr1[0]);
print_r($arr3['a']);

echo "\n\n\n";

foreach (['a'=>1, 'b'=>2, 'c'=>3] as $key=>$value) {
    echo (sprintf("%s: %d\n", $key, $value));
}

$arr4 = ['a', 'd', 'f'];
for ($i=0; $i<count($arr4); $i++) {
    echo (sprintf("%d: %s\n", $i, $arr4[$i]));
}

$arr5 = [
    'a' => 'a1',
    'b' => 'b1',
    'c' => 'c1',
    'd' => 'd1',
];
while (true) {
    $value = current($arr5);
    $key = key($arr5);
    echo (sprintf("%s: %s\n", $key, $value));
    $value = next($arr5);
    $key = key($arr5);
    if ($value === false && $key === null) {
        break;
    }
}

echo "\n\n\n";

class ArrObj1
{
    public function __construct(protected string $a) {}

    public function getA(): string
    {
        return $this->a;
    }
}
$arr6 = [];
$arr6[] = new ArrObj1('a');
$arr6[] = new ArrObj1('b');
$arr6[] = new ArrObj1('c');

//单纯的遍历，如果有额外参数可以用use
array_walk($arr6, function (ArrObj1 $arrObj1, int $key) use ($arr5) {
    echo sprintf("%d: %s\n", $key, $arrObj1->getA());
}, ARRAY_FILTER_USE_BOTH);

//遍历，遍历的返回值会改变数组本身，如果有额外参数可以用use
print_r(array_map(function (ArrObj1 $arrObj1)  use ($arr5) {
    echo sprintf("%s\n", $arrObj1->getA());
    return $arrObj1->getA() . $arrObj1->getA();
}, $arr6));//输出 【’aa‘, 'bb', 'cc'】

//遍历，根据遍历的结果false/true来过滤掉数组内元素，如果有额外参数可以用use
print_r(array_filter($arr6, function (ArrObj1 $arrObj1, int $key)  use ($arr5) {
    echo sprintf("%d: %s\n", $key, $arrObj1->getA());
    return $arrObj1->getA() != 'b';
}, ARRAY_FILTER_USE_BOTH));//输出 [object('a'), object('b')]

echo "\n\n\n";

//基础排序
$arr7 = ['a'=>1, 'b'=>8, 'c'=>5, 'd'=>2];
//按值顺序排序
sort($arr7);
print_r($arr7);//输出 [1, 2, 5, 8]  会丢失key

$arr8 = ['a'=>1, 'b'=>8, 'c'=>5, 'd'=>2];
//按值逆向排序
rsort($arr8);
print_r($arr8);//输出 [8, 5, 2, 1]  会丢失key

$arr9 = ['a'=>1,  'c'=>5, 'd'=>2, 'b'=>8,];
//按值对数组排序, 并保留key
asort($arr9);
print_r($arr9);//输出 ['a'=>1, 'd'=>2, 'c'=>5, 'b'=>8,]

$arr10 = ['a'=>1,  'c'=>5, 'd'=>2, 'b'=>8,];
//按值对数组排序, 并保留key
arsort($arr10);
print_r($arr10);//输出 ['b'=>8, 'c'=>5, 'd'=>2, 'a'=>1,]

$arr11 = ['a'=>1,  'c'=>5, 'd'=>2, 'b'=>8,];
//按key对数组排序
ksort($arr11);
print_r($arr11);//输出 ['a'=>1, 'b'=>8,  'c'=>5, 'd'=>2,]

echo "\n\n\n";

//自定义排序
$arr12 = ['a'=>1,  'c'=>5, 'd'=>2, 'b'=>8,];
usort($arr12, function (int $v1, int $v2) {
    return intval($v1 > $v2);
});
print_r($arr12);//输出 [1, 2, 5, 8]  会丢失key

$arr13 = ['a'=>1,  'c'=>5, 'd'=>2, 'b'=>8,];
uasort($arr13, function (int $v1, int $v2) {
    return intval($v1 < $v2);
});
print_r($arr13);//输出 [8, 5, 2, 1]  会丢失key

$arr14 = ['a'=>1,  'c'=>5, 'd'=>2, 'b'=>8,];
uksort($arr14, function (string $k1, string $k2) use($arr14) {
    return intval($arr14[$k1] > $arr14[$k2]);
});
print_r($arr14);//输出 ['a'=>1, 'd'=>2, 'c'=>5, 'b'=>8,]

echo "\n\n\n";

//多维数据排序
$arr15 = [
    [
        'a'=>5,
        'b'=>2,
        'c'=>7
    ],
    [
        'a'=>8,
        'b'=>4,
        'c'=>1
    ],
    [
    'a'=>5,
    'b'=>9,
    'c'=>2
    ],
];
//先按字段a排序，之后字段b排序
array_multisort(array_column($arr15, 'a'), SORT_ASC, array_column($arr15, 'b'), SORT_ASC, $arr15);
print_r($arr15); //结果如下：
//Array
//(
//    [0] => Array
//    (
//        [a] => 5
//        [b] => 2
//        [c] => 7
//    )
//
//    [1] => Array
//    (
//        [a] => 5
//        [b] => 9
//        [c] => 2
//    )
//
//    [2] => Array
//    (
//        [a] => 8
//        [b] => 4
//        [c] => 1
//    )
//)


//常用数组函数
$arr16 = [
    [
        'a'=>1,
        'b'=>2,
        'c'=>3
    ],
    [
        'a'=>4,
        'b'=>5,
        'c'=>6
    ]
];
//这个在数据库中读取某一列时很好用
print_r(array_column($arr16, 'a'));//输出 [1, 4]

//key和value对应组合成一个数组
print_r(array_combine(['a', 'b', 'c'], [1, 2, 3]));//输出 ['a'=>1, 'b]=>2, 'c'=>3]

$arr17 = ['a'=>1, 'b'=>2, 'c'=>3];
//交换key和value
print_r(array_flip($arr17));//输出 [1=>'a', 2=>'b', 3=>'c']

$arr18 = ['a'=>1, 'b'=>2, 'c'=>3];
//翻转数组
print_r(array_reverse($arr18));//输出 ['c'=>3, 'b'=>2, 'a'=>1]

//获取数组数量
echo count([1, 8, 4]) . "\n";//输出 3

//判断某个值是否在数组中，区别大小写的，要不区分，需传入第3个参数true
var_dump(in_array('a', ['c', 'b', 'a']));//输出 true

//判断某个key是否在数组中
var_dump(array_key_exists('a', ['c'=>3, 'b'=>2, 'a'=>1]));

//获取数组中的第一个key
var_dump(array_key_first(['c'=>3, 'b'=>2, 'a'=>1]));//输出 c

//获取数组中的最后一个key
var_dump(array_key_last(['c'=>3, 'b'=>2, 'a'=>1]));//输出 a

//获取数组中所有key
print_r(array_keys(['c'=>3, 'b'=>2, 'a'=>1]));//输出 ['c', 'b', 'a']

//获取数组中所有value
print_r(array_values(['c'=>3, 'b'=>2, 'a'=>1]));//输出 [3, 2, 1]

//将数组指针重置到开始
//reset();

//将数组指针移动到结尾
//end();

//获取当前数组的值
//current();

//将数组指针移动到下一个
//next();

//取差集, 在第一个数组中去除在第二个数组存在的相同值
$arr18 = ['a'=>1, 'b'=>3, 'c'=> 6];
$arr19 = ['a'=>1, 't'=>8, 'c'=> 9];
print_r(array_diff($arr18, $arr19));//输出 ['b'=>3, 'c'=>6]

//用key取差集, 在第一个数组中去除在第二个数组存在的相同key的value
$arr20 = ['a'=>1, 'b'=>3, 'c'=> 6];
$arr21 = ['a'=>1, 't'=>8, 'c'=> 9];
print_r(array_diff_key($arr20, $arr21));//输出 ['b'=>3]

//取交集, 在第一个数组中存在并在第二个数组也存在的相同值
$arr22 = ['a'=>1, 'b'=>3, 'c'=> 6];
$arr23 = ['a'=>1, 't'=>8, 'c'=> 9];
print_r(array_intersect($arr22, $arr23));//输出 ['a'=>1]

//用key取交集, 在第一个数组中存在并在第二个数组也存在的相同key的value
$arr24 = ['a'=>1, 'b'=>3, 'c'=> 6];
$arr25 = ['a'=>1, 't'=>8, 'c'=> 9];
print_r(array_intersect_key($arr24, $arr25));//输出 ['a'=>1, 'c'=>6]

//将一个或多个值放入数组尾部
$arr26 = ['a'=>1];
array_push($arr26, 2, 3);
print_r($arr26);//输出 ['a'=>1, 2, 3]

//从数组尾部取出一个值，如果数组为空，返回null
$arr27 = ['a'=>1, 'b'=>2, 'c'=>3];
print_r(array_pop($arr27));//输出 3

//将一个或多个值放入数组头部
$arr28 = ['a'=>1];
array_unshift($arr28, 2, 3);
print_r($arr28);//输出 [2, 3, 'a'=>1]

//从数组头部取出一个值，如果数组为空，返回null
$arr29 = ['a'=>1, 'b'=>2, 'c'=>3];
var_dump(array_shift($arr29));//输出 1

//取出数组中的随机key
$arr30 = ['a'=>1, 'b'=>2, 'c'=>3, 'd'=>4];
var_dump(array_rand($arr30));//输出 a, b, c, d中的随机一个

//将数组随机打乱,注意key会丢失
$arr31 = ['a'=>1, 'b'=>2, 'c'=>3, 'd'=>4];
shuffle($arr31);
print_r($arr31);//输出 打乱后的数组

//将两个或多个数组merge，数字key会被重新编号，一定要注意
$arr32 = ['a'=>1, 1=>1, 2=>2];
$arr33 = ['a'=>2, 3=>3];
print_r(array_merge($arr32, $arr33));//输出 ['a'=>2, 0=>1, 1=>2, 2=>3]

//搜索数组的值，并返回key
var_dump(array_search(2, ['a'=>1,'b'=>2,'c'=>3]));//输出 b

//将数组中的值求和，有字符串将被自动转化
var_dump(array_sum([1,4,5,'6b']));//输出 16

//取出数组中的某一段
print_r(array_slice([1,2,3,4], 0, 2));//输出 [1,2]

//将数组中的值取唯一处理
print_r(array_unique([1, 3, 1, 3]));//输出 [1, 3]