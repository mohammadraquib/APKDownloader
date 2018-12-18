# APKDownloader
An easy to use PHP wrapper for the Evozi APK Downloader API.

## Example

````
require_once 'src\APKDownloader.php';
try{
  $apk = new APKDownloader();
  $dl = $apk->fetch('com.whatsapp');
  if(isset($dl->url)){
    echo 'Download Link: '.$dl->url;
  } else {
    echo 'Error Occured';
  }
} catch(Exception $e){
  echo 'Error: '.$e->getMessage();
}
````

## Methods

### APKDownloader::fetch(String $package_name, boolean $force_refetch = false)

Fetches the APK details & download link from the Evozi API.
$package_name is the package name of the Android application.
$force_refetch is a boolean stating if that the APK should be fetched from the Play store or Evozi cache (Unfortunately this doesn't works now. APKs are only fetched from the cache if exists otherwise from the Play Store).
