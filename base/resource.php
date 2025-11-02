<?php
/**
 * see article: https://www.leyeah.com/blog/leo/article-resource-php-data-types-4046829
 */
function resourceTest($fileHandle)
{
    var_dump($fileHandle);
    return $fileHandle;
}

$fileHandle = fopen('/Users/leo/Downloads/test.txt', 'r');
resourceTest($fileHandle);

//db
//mysql_connect('localhost', 'root', 'password123', 'db_name');

//fsockopen
$fp = fsockopen("www.example.com", 80, $errno, $errstr, 30);
var_dump($fp);

//method
var_dump(get_resource_type($fileHandle));
var_dump(get_resource_type($fp));

var_dump(get_resource_id($fileHandle));
var_dump(get_resource_id($fp));

var_dump(is_resource($fileHandle));
var_dump(is_resource($fp));