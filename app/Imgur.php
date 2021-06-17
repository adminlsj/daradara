<?php

namespace App;

class Imgur
{
    public static $rectangle = 'https://i.imgur.com/JMcgEkPl.jpg';
    public static $square = 'https://i.imgur.com/sMSpYFXb.jpg';

    public static function original($model)
    {
        return "https://i.imgur.com/".$model->imgur.".jpg";
    }

    public static function s($model)
    {
        return "https://i.imgur.com/".$model->imgur."s.jpg";
    }

    public static function b($model)
    {
        return "https://i.imgur.com/".$model->imgur."b.jpg";
    }

    public static function t($model)
    {
        return "https://i.imgur.com/".$model->imgur."t.jpg";
    }

    public static function m($model)
    {
        return "https://i.imgur.com/".$model->imgur."m.jpg";
    }

    public static function l($model)
    {
        return "https://i.imgur.com/".$model->imgur."l.jpg";
    }

    public static function h($model)
    {
        return "https://i.imgur.com/".$model->imgur."h.jpg";
    }
}
