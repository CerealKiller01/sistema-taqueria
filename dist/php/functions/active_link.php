<?php

function active_link($nombre_archivo){
  $url= $_SERVER["REQUEST_URI"];
  $data = explode("/",$url);
  if($data[3] == $nombre_archivo){
    return  'active';
  }
}
?>