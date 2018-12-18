<?php
//Example for generating WhatsApp APK download link.
require_once 'src/APKDownloader.php';
try{
  $apk = new APKDownloader();
  $dl = $apk->fetch('com.whatsapp'); //WhatsApp's package name is "com.whatsapp"
  if(isset($dl->url)){
    echo 'Download Link: '.$dl->url;
  } else {
    echo 'Can\'t find download link';
  }
} catch (Exception $e){
  echo $e->getMessage();
}
