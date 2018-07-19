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

$t = new Trainer();
$t->setMaxNgrams(9000);
$t->learn();

//benchMarkLeaning();
//benchMarkDetect();
//
//function benchMarkLeaning(){
//    //default
//    try{
//        $start = microtime('float');
//        $t = new Trainer();
//        $t->learn();
//        $end = microtime('float');
//        echo "Default learning takes ". ($end-$start)." s\n";
//    }catch (Exception $e){
//        echo $e->getMessage();
//    }
//
//    try{
//        $start = microtime('float');
//        $t = new Trainer();
//        $t->setMaxNgrams(3000);
//        $t->learn();
//        $end = microtime('float');
//        echo "3000 ngram learning takes ". ($end-$start)." s\n";
//    }catch (Exception $e){
//        echo $e->getMessage();
//    }
//
//    try{
//        $start = microtime('float');
//        $t = new Trainer();
//        $t->setMaxNgrams(9000);
//        $t->learn();
//        $end = microtime('float');
//        echo "9000 ngram learning takes ". ($end-$start)." s\n";
//    }catch (Exception $e){
//        echo $e->getMessage();
//    }
//
//    try{
//        $start = microtime('float');
//        $t = new Trainer();
//        $t->setMaxNgrams(12000);
//        $t->learn();
//        $end = microtime('float');
//        echo "12000 ngram learning takes ". ($end-$start)." s\n";
//    }catch (Exception $e){
//        echo $e->getMessage();
//    }
//}
//
//function benchMarkDetect(){
//    $s = '1 BAB I  PENDAHULUAN  1.1  Latar Belakang Praktek Kerja Lapangan Perkembangan  Sistem  Informasi  berbasis  komputer  pada  saat  ini  sudah menjadi  tuntutan  utama  pada setiap  perusahaan  dalam  skala  besar  maupun kecil sebagai sistem pengolahan data. Informasi menjadi bagian terpenting pada setiap pengambilan keputusan dalam suatu organisasi. Informasi yang tepat, akurat dapat membantu perusahaan dalam mencapai tujuan perusahaan tersebut.';
//
//    //default
//    try{
//        $start = microtime('float');
//        $t = new Language();
//        echo $t->detect($s)->bestResults()."\n";
//        $end = microtime('float');
//        echo "Default detect takes ". ($end-$start)." s\n";
//    }catch (Exception $e){
//        echo $e->getMessage();
//    }
//
//    try{
//        $start = microtime('float');
//        $t = new Language();
//        $t->setMaxNgrams(3000);
//        echo $t->detect($s)->bestResults()."\n";
//        $end = microtime('float');
//        echo "3000 ngram detect takes ". ($end-$start)." s\n";
//    }catch (Exception $e){
//        echo $e->getMessage();
//    }
//
//    try{
//        $start = microtime('float');
//        $t = new Language();
//        $t->setMaxNgrams(9000);
//        echo $t->detect($s)->bestResults()."\n";
//        $end = microtime('float');
//        echo "9000 ngram detect takes ". ($end-$start)." s\n";
//    }catch (Exception $e){
//        echo $e->getMessage();
//    }
//
//    try{
//        $start = microtime('float');
//        $t = new Language();
//        $t->setMaxNgrams(12000);
//        echo $t->detect($s)->bestResults()."\n";
//        $end = microtime('float');
//        echo "12000 ngram detect takes ". ($end-$start)." s\n";
//    }catch (Exception $e){
//        echo $e->getMessage();
//    }
//}