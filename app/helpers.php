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

if (! function_exists('perm_edit_input')) {
    function perm_edit_input($user_id)
    {
        // ha van szerkesztési joga -> (4) true
        // ha megnézheti -> (3) false
        // ha saját magát nézi ->  false
        // ha saját magát nézi és szerkesztheti -> (7) true
        //

        $permission_ids = \Illuminate\Support\Facades\Auth::user()->permission_listIds;

        if(in_array(4, $permission_ids)) return true;
        if(in_array(8, $permission_ids)) return true;


        if(!cp(4,$permission_ids) && cp(3,$permission_ids)) return false;

        if((int)$user_id === \Illuminate\Support\Facades\Auth::user()->id )
            if(cp(7,$permission_ids)) return true;

        return false;

    }
}

