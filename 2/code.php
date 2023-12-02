<?php

$lines = file('input.txt');
$result = 0;

$test = [
    'red' => 12,
    'green' => 13,
    'blue' => 14,
];

function getIdFromLine($line)
{
    $parts = explode(':', $line);
    $parts = explode(' ', $parts[0]);
    return (int)trim($parts[1]);
}

function getResultsFromLine($line)
{
    $results = [];

    $parts = explode(':', $line);
    $picks = explode(';', $parts[1]);

    $i = 0;
    foreach ($picks as $pick) {
        $jewels = explode(',', trim($pick));
        foreach ($jewels as $jewel) {
            $r = explode(' ', trim($jewel));
            $results[$i][trim($r[1])] = (int)$r[0];
        }

        $i++;
    }

    return $results;
}

function resultsPassTest($results, $test)
{
    foreach ($test as $k => $v) {
        foreach ($results as $result) {
            if (array_key_exists($k, $result) && $result[$k] > $v) {
                return false;
            }
        }
    }

    return true;
}

function getPowerFromResults($results)
{
    $fewest = [
        'red' => 0,
        'green' => 0,
        'blue' => 0,
    ];

    foreach ($results as $result) {
        foreach ($result as $k => $v) {
            if ($fewest[$k] < $v) {
                $fewest[$k] = $v;
            }
        }
    }

    $power = ($fewest['red']) * ($fewest['green']) * ($fewest['blue']);
    return $power;
}

foreach($lines as $line) {
    $id = getIdFromLine($line);
    $results = getResultsFromLine($line);
    $power = getPowerFromResults($results);
    $result += $power;
    echo $result ."\n";
    /*
    if (resultsPassTest($results, $test)) {
        $result += $id;
        echo $id . " passed => {$result}\n";
    } else {
        echo $id . " failed => {$result}\n";
    }
    */
}
