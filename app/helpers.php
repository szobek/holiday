<?php

use Illuminate\Support\Debug\Dumper;

if (! function_exists('dd2')) {
    function dd2(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
    }
}


if (! function_exists('user_url')) {
    function user_url($id)
    {
        return config('shorts.user_url').$id;
    }
}

if (! function_exists('company_url')) {
    function company_url($id)
    {
        return config('shorts.company_url').$id;
    }
}

if (! function_exists('cp')) {
    function cp($id, $perms)
    {
        return in_array($id, $perms);
    }
}


