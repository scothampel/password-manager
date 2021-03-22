<?php
    $alpha = [
        "abcdefghijklmnopqrstuvwxyz",
        "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
        "1234567890",
        "!@#$%^&*()-_"
    ];
    
    $service = "testService";
    $pass = "testPass";
    $length = 16;
    
    $cost = 10;
    $salt = hash("sha512", $service);
 	$salt = sprintf("$2a$%02d$", $cost) . $salt;
 	
 	$options = [
        "cost" => $cost,
        "salt" => $salt
    ];
    $hash = password_hash($pass, PASSWORD_DEFAULT, $options);
    
    echo $hash;
    echo "</br>";
    echo password_verify($pass, $hash);
    echo "</br>";
    $sub = substr($hash, 29);
    echo $sub;
    
    $result = "";
    echo "</br>";
    echo ((strlen($sub) - $length) % ($length - 1)) - 1;
    $index = 0;
    for($i = 0; $i < $length; $i++){
        $result .= substr($sub, $index, 1);
        if($i < (strlen($sub) - $length) % ($length - 1)){
            echo "</br>";
            echo floor((strlen($sub) - $length) / ($length - 1)) + 2;
            $index += floor((strlen($sub) - $length) / ($length - 1)) + 2;
        }
        else{
            echo "</br>";
            echo floor((strlen($sub) - $length) / ($length - 1)) + 1;
            $index += floor((strlen($sub) - $length) / ($length - 1)) + 1;
        }
    }
    echo "</br>";
    echo $result;
    
    $ascii = [];
    for($i = 0; $i < strlen($result); $i++){
        $ascii[] = ord(substr($result, $i, 1));
    }
    echo "</br>";
    foreach($ascii as $val){
        echo $val.",";
    }
    
    echo "</br>";
    $mod = [];
    foreach($ascii as $val){
        echo ($val % 4).",";
        $mod[] = $val % 4;
    }
    
    echo "</br>";
    $fin = "";
    for($i = 0; $i < count($ascii); $i++){
        $fin .= substr($alpha[$mod[$i]], $ascii[$i] % strlen($alpha[$mod[$i]]), 1);
    }
    echo $fin;
?>