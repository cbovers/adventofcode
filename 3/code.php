<?php

$lines = file('input.txt');
$result = 0;

$numbers = [];
$symbols = [];
$gears = [];

foreach ($lines as $k => $line) {
    // numbers
    preg_match_all('!\d+!', $line, $matches, PREG_OFFSET_CAPTURE);
    foreach ($matches as $match) {
        foreach ($match as $arr) {
            $number = $arr[0];
            $pos = $arr[1];

            $r = [
                'line' => $k,
                'number' => (int)$number,
                'pos' => $pos,
                'length' => strlen($number),
                'first' => $pos-1,
                'last' => $pos + strlen($number)
            ];

            
            $numbers[] = $r;
        }
    }

    // symbols
    preg_match_all('![\*\#\+\$\/\=\%\@\-\&]+!', $line, $matches, PREG_OFFSET_CAPTURE);
    foreach ($matches as $match) {
        foreach ($match as $arr) {
            $symbol = $arr[0];
            $pos = $arr[1];

            $r = [
                'line' => $k,
                'symbol' => $symbol,
                'pos' => $pos,
            ];

            $symbols[] = $r;
        }
    }
}

// Find adjacent numbers to symbols
foreach ($symbols as $sk => $s) {
    $symbol = $s['symbol'];
    $lines = [($s['line']-1), ($s['line']), ($s['line']+1)];
    $pos = (int)$s['pos'];

    $adjacentNumbers = [];
    foreach ($numbers as $k => $n) {
        if (in_array($n['line'], $lines)) {
            if ($pos >= $n['first'] && $pos <= $n['last']) {
                $adjacentNumbers[] = (int)$n['number'];
                $result += (int)$n['number'];
                unset($numbers[$k]);
            }
        }
    }

    if ($symbol == '*') {
        $gears[$sk] = $adjacentNumbers;
    }
}

$gearRatioSum = 0;
foreach ($gears as $gear) {
    if (count($gear) == 2) {
        $gearRatio = $gear[0] * $gear[1];
        $gearRatioSum += $gearRatio;
    }
}


var_dump($gearRatioSum);