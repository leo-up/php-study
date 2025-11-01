<?php
/**
 * see article: https://www.leyeah.com/blog/leo/article-callable-php-data-types-4046392
 */

function testCallable($a)
{
    return $a * $a;
}
print_r(array_map('testCallable', [2,3,5]));

print_r(array_map('pow', [2,3,5],[2,2,2]));

$testArrow = fn($x) => $x * $x;
print_r(array_map($testArrow, [2,3,5]));

print_r(array_map(function ($x) {
    return $x * $x;
}, [2,3,5]));

//class
class CallableTest
{
    public static function squareStatic(int $a): int
    {
        return $a * $a;
    }

    public function square(int $a): int
    {
        return $a * $a;
    }
}

print_r(array_map([new CallableTest(), 'square'], [2,3,5]));
print_r(array_map('CallableTest::squareStatic', [2,3,5]));

//First class callable
class CallableTest2
{
    public function getPrivateMethod(): callable
    {
        return $this->square(...);
        //return Closure::fromCallable([$this, 'square']); //same with above
    }

    private function square(int $x): int
    {
        return $x * $x;
    }
}

$caTest = new CallableTest2;
print_r(array_map($caTest->getPrivateMethod(), [2,3,5]));

//__invoke
class CallableInvoke
{
    public function __invoke($x)
    {
        return $x * $x;
    }
}

print_r(array_map(new CallableInvoke(), [2,3,5]));


var_dump(is_callable('pow')); // return true
var_dump(is_callable(new CallableInvoke())); // return true
var_dump(is_callable([new CallableTest(), 'square'])); // return true
var_dump(is_callable('CallableTest::squareStatic')); // return true
var_dump(is_callable('str_test_abc')); // return false


#use Symfony\Component\EventDispatcher\EventSubscriberInterface;
#use Symfony\Component\HttpKernel\Event\TerminateEvent;
#use Symfony\Component\HttpKernel\KernelEvents;

class AsyncRunSubscriber //implements EventSubscriberInterface
{
    public function __construct(protected AsyncRunData $asyncRunData){}

    public static function getSubscribedEvents(): array{
        return [
            KernelEvents::TERMINATE  => 'onTerminate',
        ];
    }

    public function onTerminate(TerminateEvent $event): void{
        if (!$data = $this->asyncRunData->getData()) {
            return;
        }
        array_walk($data, function (array $item){
            if (is_callable($funcName = $item[0] ?? '')) {
                $funcName(...array_slice($item, 1));
            }
        });
        $this->asyncRunData->clearData();
    }
}
class AsyncRunService
{
    public function __construct(protected AsyncRunData $asyncRunData) {}
    
    public function addCallable(callable $callable)
    {
        $this->asyncRunData->addCallable(...func_get_args());
        return $this;
    }
}
//可以用这个server加入
//$asyncRunService->addCallable('CallableTest::squareStatic', 5);


//function cache
class FunctionCache
{
    public function __construct(protected $cache){}

    /**
     *
     * @param callable $callable  [classInstance, 'method'] | 'class::method'
     * @return mixed
     */
    public function call(callable $callable, array $args = [], int $expire = 0, string &$key = ''): mixed
    {
        $key = $key ?: $this->getFunctionKey($callable, $args);
        $result = $this->getCache()->get($key);
        if ($result === false) {
            $result = $callable(...$args);
            $this->getCache()->set($key, $result, $expire);
        }
        return $result;
    }

    public function remove(callable $callable, array $args = []): bool
    {
        $key = $this->getFunctionKey($callable, $args);
        return $this->removeByKey($key);
    }

    public function removeByKey(string $key): bool
    {
        return $this->getCache()->delete($key);
    }

    /**
     * @return Memcache
     */
    public function getCache(): Memcache
    {
        return $this->cache;
    }

    protected function getFunctionKey(callable $callable, array $args): string
    {
        $arrKey = [];
        if (is_array($callable)) {
            if (is_object($callable[0])) {
                $arrKey[] = str_replace('\\', '_', get_class($callable[0]));
            } else {
                $arrKey[] = $callable[0];
            }
            if (isset($callable[1])) {
                $arrKey[] = $callable[1];
            }
        } else {
            $arrKey = explode('::', $callable);
        }
        $key = $this->concatKey(array_merge($arrKey, $args));
        $key = preg_replace('/\s+/', '_', $key);
        return $key;
    }

    protected function concatKey(string|array|null $key, string|array|null $_ = null): string
    {
        $arguments = func_get_args();
        $cacheKey = $this->flatArrayKey($arguments);
        return implode('_', $cacheKey);
    }

    protected function flatArrayKey($arrKey)
    {
        $cacheKey = [];
        foreach ($arrKey as $key=>$value) {
            if (is_array($value)) {
                $cacheKey = array_merge($cacheKey, $this->flatArrayKey($value));
            } else {
                if (is_string($key)) {
                    $cacheKey[] = implode('_', [$key, $value]);
                } else {
                    $cacheKey[] = $value;
                }
            }
        }
        return $cacheKey;
    }
}