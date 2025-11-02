<?php
class Test2
{
    protected int $num;
    protected string $str;
    protected object $obj;

    public function __construct(int $num, string $str)
    {
        $this->num = $num;
        $this->str = $str;
    }

    public function run(Test3 $test): void
    {
        //will cause PHP Fatal error:  Uncaught Error: Typed property Test2::$obj must not be accessed before initialization  error
        //$this->obj;
        $num = $this->square($test->getNum());
        $str = $this->concat($test->getStr());
        $test->setNum($num);
        $test->setStr($str);
    }

    protected function square(int $num): int
    {
        return $this->num * $num;
    }

    protected function concat(string $str): string
    {
        return sprintf('%s/%s', $this->str, $str);
    }
}

class Test3
{

    public function __construct(protected int $num, protected string $str) {}

    public function getNum(): int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;
        return $this;
    }

    public function getStr(): string
    {
        return $this->str;
    }

    public function setStr(string $str): static
    {
        $this->str = $str;
        return $this;
    }
}

$test2 = new Test2(2, 'test2');
$test3 = new Test3(3, 'test3');
$test2->run($test3);
var_dump($test3->getNum());
var_dump($test3->getStr());

