<?php

class Image
{

    static function getName($filename) {
        $name = substr(md5(microtime()),0,6);
        $name .=strrchr($filename, ".");
        return $name;
        //if (!file_exists("image/player/mini/$name")) return $name;
        //else return $this->getName();
    }

    static function SaveImage($url,$path) {
        $filetype=end(explode(".", $url));
        $name=self::getName("file.".$filetype);
        file_put_contents($path.$name, file_get_contents($url));
        return $name;
    }

    //$name=$this->SaveImage($this->data["photom"],"./image/player/mini/");
}