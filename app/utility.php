<?php
namespace App;

class Utility
{
    public static function CleanString($text)
    {
        $text = str_replace('"', "", $text);
        $text = str_replace("'", "", $text);
        return $text;
    }
}
