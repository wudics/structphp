<?php

class Myfunc
{
    public static function fixURL($string)
    {
        $pattern = "{(<img[^>]+src\\s*=\\s*['\\\"])([^'\\\"]+)(res/[^'\\\"]+['\\\"][^>]*/>)}";
        return preg_replace($pattern, '$1' . WEBROOT . '$3', $string);
    }
}