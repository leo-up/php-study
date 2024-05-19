<?php
class StringTest
{
    public function getStringFromIntBool(int|bool|null $a): string
    {
        return $a;
    }

    public function getStringFromArray(array $a): string
    {
        return json_encode($a);
        //return serialize($a);
    }
}

$stringTest = new StringTest();
//var_dump($stringTest->getStringFromIntBool(null));//Fatal error
var_dump($stringTest->getStringFromIntBool(0));//输出 “0”
var_dump($stringTest->getStringFromIntBool(1));//输出 “”
var_dump($stringTest->getStringFromIntBool(false));//输出 “”
var_dump($stringTest->getStringFromIntBool(true));//输出 “1”
var_dump($stringTest->getStringFromArray([]));//输出 “[]”
var_dump($stringTest->getStringFromArray([1]));//输出 “[1]”
echo "\n\n\n";

//常用方法
//调试常用，不能数组对象等复杂类型
echo "a","b","c" . "\n";//输出 abc

//调试常用，不能数组对象等复杂类型
print("a") . "\n";//输出 a

//调试常用，可以打印所有类型
var_dump([1, 5, 6]);//输出 [1, 5, 6]

//调试常用
print_r([2,3,4]);//输出 [2,3,4]

//格式化字符串，可用于连接字符串
echo printf("a_%s: %d", 'aaa', 23) . "\n";//输出 a_aaa: 239

//字符串切成数组
print_r(explode(',', 'ab,cd'));//输出 ["ab" "cd"]

//数组合成字符串
var_dump(implode(',', ['a', 'b']));//输出 a,b

//转化html标记
echo htmlspecialchars('<b>bold</b>') . "\n";//输出 &lt;b&gt;bold&lt;/b&gt;

//首字母小写
echo lcfirst('ABCD') . "\n";//输出 aBCD

//首字母大写
echo ucfirst('abcd') . "\n";//输出 Abcd

//从左边过滤字符串，第2个参数不传，默认位空格
echo ltrim(',abcd,', ',') . "\n";//输出 abcd,

//从右边过滤字符串，第2个参数不传，默认位空格
echo rtrim(',abcd,', ',') . "\n";//输出 ,abcd

//过滤字符串，第2个参数不传，默认位空格
echo trim(',abcd,', ',') . "\n";//输出 abcd

//是否包含字串b
var_dump(str_contains('abcd', 'b'));//输出 true

//是否以ab开头
var_dump(str_starts_with('abcd', 'ab'));//输出 true

//是否以cd结尾
var_dump(str_ends_with('abcd', 'cd'));//输出 true

//替换字串
var_dump(strtr('abcdCD', ['a'=>1, 'b'=>2]));//输出 12cdCD

//替换字串
var_dump(str_replace( 'c', 1, 'abcdCD'));//输出 ab1dCD

//替换字串
var_dump(str_replace(['a', 'c'], 1, 'abcdCD'));//输出 1b1dCD

//替换字串
var_dump(str_replace(['a', 'c'], [1, 3], 'abcdCD'));//输出 1b3dCD

//不区分大小写替换字串
var_dump(str_ireplace( 'c', 1, 'abcdCD'));//输出 ab1d1D

//过滤html标记，可以保留某些标记
var_dump(strip_tags('<b>bold</b><img src="/test/sss.jpg">', ['img']));//输出 bold<img src="/test/sss.jpg">

//获取字串
var_dump(substr('abcdef', 1, 3));//输出 bcd

//转成小写
var_dump(strtolower('ABCDEF'));//输出 abcdef

//转成大写
var_dump(strtoupper('abcdef'));//输出 ABCDEF

//取长度
var_dump(strlen('abcdef'));//输出 6

//查找字串位置，结果一定要用 === false 来判断
var_dump(strpos('abcdef', "c"));//输出 2

//还有mb开头系统函数，举一个例子，其他类似
//获取第一个字
var_dump(mb_substr('中国人民', 0, 1));//输出 中

//获取第一个字，因为utf8边吗3位一字
var_dump(substr('中国人民', 0, 3));//输出 中
echo "\n\n\n";

//单引号，双引号的区别
$str = 'TEST';

//取字符串的第一个字符，顺便说下
var_dump($str[0]);//输出 T

//字符串转义用反斜杠\
var_dump('TE\'ST');//输出 TE'ST

//保持原样
var_dump('ab${str}ccc');//输出 ab${str}ccc

//变量/方法 已被解析，养成习惯，加上{}
var_dump("ab{$str}ccc");//输出 abTESTccc
var_dump("ab{$stringTest->getStringFromArray(['1', '2'])}cd");//输出 ab["1","2"]cd
echo "\n\n\n";

//引用大块字符串
$a = <<<EOT
hello world, you're a good "person".
result: {$stringTest->getStringFromArray(['c', 'd'])}
EOT;
var_dump($a); //输出 hello world, you're a good "person".\nresult: ["c","d"]
echo "\n\n\n";

//字符串的连接
$a = 'abc';
$b = 'def';
var_dump($a . ',' . $b);//输出 abc,def
var_dump(sprintf('%s,%s', $a, $b));//输出 abc,def
