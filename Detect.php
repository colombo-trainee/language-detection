<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/16/18
 * Time: 10:31 AM
 */

include ('vendor/autoload.php');

use LanguageDetection\Trainer;
use LanguageDetection\Language;

$s = "today i'm cold";
if(array_key_exists(1, $argv)) $s = $argv[1];

$t = new Language();
$t->setMaxNgrams(9000);
echo $t->detect($s)->bestResults();
