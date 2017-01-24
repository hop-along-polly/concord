<?php
$srcRoot = __DIR__ . "/src";
$buildRoot = __DIR__ . "/build";

if(!file_exists('$buildRoot')) {
    mkdir($buildRoot, 0777, true);
}

$phar = new Phar($buildRoot . "/concord.phar", FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, "concord.phar");
$phar["Concord.php"] = file_get_contents($srcRoot . "/Concord.php");
$phar["Concordance.php"] = file_get_contents($srcRoot . "/Concordance.php");
$phar["ConcordanceItem.php"] = file_get_contents($srcRoot . "/ConcordanceItem.php");
$phar->setStub($phar->createDefaultStub("Concord.php"));

