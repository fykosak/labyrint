<?php

$mysqli = new mysqli;
$mysqli->mysqli('localhost', 'root', 'fykos1', 'labyrint_jar_2015', null, null);
$mysqli->query("SET NAMES 'utf8'");
$mysqli->query('SET CHARACTER SET utf8');




$csv_file = fopen('otazky.csv', 'r');
$i = 0;


while ($data = fgetcsv($csv_file, 100000, ";")) {
    $alpha = "";
    if ($i < 24) {
        $door = $i % 6;
        $pos = floor($i / 6) + 1;
        $no = $pos * 10 + $door;
        $up_no = $no + 10;
        switch ($door) {
            case 0;
                $down_no = ($pos - 1) * 10 + 3;
                break;
            case 1;
                $down_no = ($pos - 1) * 10 + 4;
                break;
            case 2;
                $down_no = ($pos - 1) * 10 + 5;
                break;
            case 3;
                $down_no = ($pos - 1) * 10 + 0;
                break;
            case 4;
                $down_no = ($pos - 1) * 10 + 1;
                break;
            case 5;
                $down_no = ($pos - 1) * 10 + 2;
                break;
        }
        $stay_no = $no + 1;
        if ($stay_no % 10 == 6) {
            $stay_no-=6;
        }
    } else {
        $door = $i % 3;
        $pos = floor(($i - 24) / 3) + 5;
        $no = $pos * 10 + $door;


        $up_no = $no + 10;
        switch ($door) {
            case 0;
                $down_no = ($pos - 1) * 10 + 2;
                break;
            case 1;
                $down_no = ($pos - 1) * 10 + 0;
                break;
            case 2;
                $down_no = ($pos - 1) * 10 + 1;
                break;
        }
        $stay_no = $no + 1;


        if ($stay_no % 10 == 3) {
            $stay_no-=3;
        }
    }

    shuffle($seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'));
    foreach (array_rand($seed, 2) as $k) {
        $alpha .= $seed[$k];
    }
    var_dump($data);

    $com_s_1 = 'insert into stand (stand_id,question,label)'
            . 'values(' . $no . ','
            . '"' . mysql_escape_string($data[2]) . '", "'
            . '' . $alpha . '")'
    ;
    $mysqli->query($com_s_1);




    $com_p_1 = 'insert into path (`from`,`to`,answer) values'
            . '(' . $no . ','
            . $up_no . ',"'
            . mysql_escape_string($data[3]) . '")';

    $mysqli->query($com_p_1);


    $com_p_2 = 'insert into path (`from`,`to`,answer) values'
            . '(' . $no . ','
            . $stay_no . ',"'
            . mysql_escape_string($data[4]) . '")';

    $mysqli->query($com_p_2);
    var_dump($com_p_2);


    $com_p_3 = 'insert into path (`from`,`to`,answer) values'
            . '(' . $no . ','
            . $down_no . ',"'
            . mysql_escape_string($data[5]) . '")';

    $mysqli->query($com_p_3);
    $i++;
}



unset($csv_file);
unset($i);

$csv_file = fopen('uvod.csv', 'r');
$i = 200;
while ($data = fgetcsv($csv_file, 100000, ";")) {
    $alpha = "";

    $no = $i;
    $down_no = $no - 2;
    $stay_no = $no + 6;
    if ($i % 2) {
        $up_no = ((($no-1)/2) % 6) + 10;
    } else {
        $up_no = $no + 1;
    }

    shuffle($seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'));
    foreach (array_rand($seed, 2) as $k) {
        $alpha .= $seed[$k];
    }
    var_dump($up_no, $down_no, $stay_no, " ");

    $com_s_1 = 'insert into stand (stand_id,question,label)'
            . 'values(' . $no . ','
            . '"' . mysql_escape_string($data[2]) . '", "'
            . '' . $alpha . '")'
    ;
    $mysqli->query($com_s_1);




    $com_p_1 = 'insert into path (`from`,`to`,answer) values'
            . '(' . $no . ','
            . $up_no . ',"'
            . mysql_escape_string($data[3]) . '")';

    $mysqli->query($com_p_1);

    $com_p_2 = 'insert into path (`from`,`to`,answer) values'
            . '(' . $no . ','
            . $down_no . ',"'
            . mysql_escape_string($data[4]) . '")';

    $mysqli->query($com_p_2);



    $com_p_3 = 'insert into path (`from`,`to`,answer) values'
            . '(' . $no . ','
            . $stay_no . ',"'
            . mysql_escape_string($data[5]) . '")';

    $mysqli->query($com_p_3);


    $i++;
}



