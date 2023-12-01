<?php

$lines = file('input.txt');
$digits = [];
$words = [];
$result = 0;

function findInLine($haystack, $needle, $value, $finds = [], $offset = 0)
{
    $pos = strpos($haystack, $needle, $offset);
    if ($pos !== false) {
        $finds[$pos] = $value;
        $finds = findInLine($haystack, $needle, $value, $finds, $pos+1);
    }
    return $finds;
}

for ($i = 1; $i < 10; $i++) {
    $digits[$i] = $i;
    $words[$i] = (new NumberFormatter('en', \NumberFormatter::SPELLOUT))->format($i);
}

$lineCount = 0;
foreach($lines as $line) {

    $finds = [];

    // find digits
    foreach ($digits as $k => $v) {
        $finds = $finds + findInLine($line, $v, $v);
    }

    // find words
    foreach ($words as $k => $v) {
        $finds = $finds + findInLine($line, $v, $k);
    }

    ksort($finds);
    $first = reset($finds);
    $last = end($finds);
    $number = intval($first.''. $last);
    $result += $number;
    
    echo "{$lineCount}\tLine: ".str_replace(PHP_EOL, '', $line).", First: {$first}, Last: {$last}, Number: {$number}, Sum: {$result}\n";
    
    $lineCount++;
}

echo "-------------\n";
echo "Result: $result\n";
echo "-------------\n";
