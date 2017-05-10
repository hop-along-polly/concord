<?php
require_once "phar://concord.phar/Concordance.php";

$options = getopt('f:');

$directory = getcwd();
$filename = $options['f'];
if(!file_exists("{$directory}/{$filename}")) {
    fwrite(STDERR, "{$filename} could not be found in the current directory." . PHP_EOL);
    exit(1);
}

$contents = file_get_contents("{$directory}/{$filename}");
$sentences = canonocalize($contents);
$concordance = new \Concordance();

//The boundary on this is -1 because of canonocalize adding a new line character to the very end of the array.
for( $i = 0; $i < count($sentences) -1; ++$i) {
    $sentence = explode(' ', $sentences[$i]);
    foreach($sentence as $word) {
        if ($concordance->contains($word)) {
            $concordance->increment($word, $i);
            continue;
        }

        $concordance->add($word, $i);
    }
}

fwrite(STDOUT, $concordance->alphabetize()->toString() . PHP_EOL); 

/**
 * Canonocalizes raw text as sentences.
 *
 * @param string $raw The raw text to be canonocalized.
 *
 * @return array A numerically indexed array in which each value is a sentence.
 */
function canonocalize($raw)
{
    //Strip new line characters before running the preg_replace.
    $contents = str_replace("\n", ' ', $raw);
    $contents = preg_replace('([\.!?]\s(?=[A-Z]?))', "\n", $contents);
    return explode("\n", $contents);
}

