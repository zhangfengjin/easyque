<?php
if(!function_exists("singleton")){
    function singleton($key,$value){
        if(!isset($GLOBALS[$key])){
            $GLOBALS[$key] = $value;
        }
    }
}
if(!function_exists("app")){
    function app($key){
        return $GLOBALS[$key];
    }
}


if(!function_exists("tap")){

}