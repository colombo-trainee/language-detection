<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/16/18
 * Time: 10:31 AM
 */

include ('vendor/autoload.php');

use LanguageDetection\Trainer;

$t = new Trainer();

$t->learn();