<?php

function update_downtime($status,$downtime,$ip){
    if ($status == "0") {
        if ($downtime == "") {
           $down = date('Y-m-d H:i:sa', time());
          
        } else {
           $down = $downtime;
        }
        kirimtelegram('perangkat mati'.$ip);
    } else {
        $down = "";
        kirimtelegram('perangkat Hidup'.$ip);
    }
    
return $down;
}

function ubah($kata)
{
    $hari = array(
        '1' => 'a', 
        '2' => 'b', 
        '3' => 'c',
        '4' => 'd', 
        '5' => 'e', 
        '6' => 'f', 
        '7' => 'g',
        '8' => 'h',
        '9' => 'i',
        '0' => 'j',
        'a' => '1',
        'b' => '2',
        'c' => '3',
        'd' => '4',
        'e' => '5',
        'f' => '6',
        'g' => '7',
        'h' => '8',
        'i' => '9',
        'j' => '0'


    );
    return $hari[$kata];
}



function kata($kata){
    $data = "";
    $str = $kata;
    $stri = str_replace(".", "", $str);
    $lenght = strlen($stri);
    for($i=0; $i<$lenght; $i++){  
        $data .= ubah($stri[$i]);
    }
    return $data;
}



?>