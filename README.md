# ImageDuplicateFinder

Just a tiny collection of Finders which can be used (alone or together) to find Duplicates in your Photo collection.

## Finder

* FileChecksum - Simply compares sha1 checksum of file contents
* ImagickSignature - Simply uses Imagick::getImageSignature to compare
* PixelChecksum - Tries to get Imagick::getImageSignature of the embedded thumbnail
* aHash - Uses an aHash-based-approach to identify duplicates

## Example Usage
 
```
$dr = new DuplicateFinder();
$dr->setWorkingDir($w_dir);
$dr->setDuplicateDir($c_dir);

$dr->injectFinder(new FileChecksum());
$dr->injectFinder(new PixelChecksum());
$dr->injectFinder(new ImagickSignature());
$dr->injectFinder(new aHash());


$duplicates = $dr->getDuplicates();
var_dump($duplicates);
```

## Example 

In the following Example the first key is the first match. You should ignore that (i.e.: array(4) { ["/home/jean/Pictures/agc4.png"] [..]). This will most likely be removed in one of the next updates.

### Result

```
array(16) {
  '/home/jean/test/10/01/100_0065.jpg' =>
  array(2) {
    [0] =>
    string(34) "/home/jean/test/09/01/100_0065.jpg"
    [1] =>
    string(34) "/home/jean/test/08/01/100_0065.jpg"
  }
  '/home/jean/test/10/01/100_0068.jpg' =>
  array(2) {
    [0] =>
    string(34) "/home/jean/test/09/01/100_0068.jpg"
    [1] =>
    string(34) "/home/jean/test/08/01/100_0068.jpg"
  }
  '/home/jean/test/10/01/100_0067.jpg' =>
  array(2) {
    [0] =>
    string(34) "/home/jean/test/09/01/100_0067.jpg"
    [1] =>
    string(34) "/home/jean/test/08/01/100_0067.jpg"
  }
}
```