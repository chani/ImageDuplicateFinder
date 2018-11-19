# ImageDuplicateFinder

Just a tiny collection of Finders which can be used (alone or together) to find Duplicates in your Photo collection.

## Finder

* FileChecksum - Simply compares sha1 checksum of file contents
* ImagickFingerprint - Simply uses Imagick::getImageSignature to compare
* ExifThumbnail - Tries to get Imagick::getImageSignature of the embedded thumbnail
* aHashBased - Uses an aHash-based-approach to identify duplicates

## Example Usage
 
```
<?php
$df = new DuplicateFinder();
$df->injectFinder(new FileChecksum());
$df->injectFinder(new ImagickFingerprint());
$df->injectFinder(new aHashBased());
$df->injectFinder(new ExifThumbnailBased());

$df->searchDuplicates($path);
var_dump($df->getDuplicates());
```

## Example 

In the following Example the first key is the first match. You should ignore that (i.e.: array(4) { ["/home/jean/Pictures/agc4.png"] [..]). This will most likely be removed in one of the next updates.

### Result

```
object(Duplicates)#2 (1) {
  ["duplicates":"Duplicates":private]=>
  array(4) {
    ["/home/jean/Pictures/agc4.png"]=>
    array(3) {
      [0]=>
      string(26) "/home/jean/Pictures/t5.png"
      [1]=>
      string(28) "/home/jean/Pictures/agc4.png"
      [2]=>
      string(26) "/home/jean/Pictures/t3.png"
    }
    ["/home/jean/Pictures/test2.jpg"]=>
    array(7) {
      [0]=>
      string(28) "/home/jean/Pictures/test.png"
      [1]=>
      string(29) "/home/jean/Pictures/test2.jpg"
      [2]=>
      string(29) "/home/jean/Pictures/input.jpg"
      [3]=>
      string(29) "/home/jean/Pictures/test1.jpg"
      [4]=>
      string(27) "/home/jean/Pictures/foo.png"
      [5]=>
      string(31) "/home/jean/Pictures/input99.jpg"
      [6]=>
      string(42) "/home/jean/Pictures/foobarbarbarbarbar.jpg"
    }
    ["/home/jean/Pictures/agc_tr6.png"]=>
    array(2) {
      [0]=>
      string(30) "/home/jean/Pictures/agc_r6.png"
      [1]=>
      string(31) "/home/jean/Pictures/agc_tr6.png"
    }
    ["/home/jean/Pictures/test.jpg"]=>
    array(2) {
      [0]=>
      string(30) "/home/jean/Pictures/foobar.jpg"
      [1]=>
      string(28) "/home/jean/Pictures/test.jpg"
    }
  }
}
```