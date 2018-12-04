<?php
include('src/finder/Finder.php');
include('src/finder/AbstractFinder.class.php');
include('src/finder/FileChecksum.class.php');
include('src/finder/PixelChecksum.class.php');
include('src/finder/aHash.class.php');
include('src/finder/ImagickSignature.class.php');
include('src/DuplicateFinder.class.php');

use Image\DuplicateFinder\DuplicateFinder;
use Image\DuplicateFinder\finder\aHash;
use Image\DuplicateFinder\finder\FileChecksum;
use Image\DuplicateFinder\finder\ImagickSignature;
use Image\DuplicateFinder\finder\PixelChecksum;

// working directory
$w_dir = '/home/jean/test';

// copy directory, duplicates are moved here
$c_dir = '/home/jean/copies';

$dr = new DuplicateFinder();
$dr->setWorkingDir($w_dir);
$dr->setDuplicateDir($c_dir);

// inject Finders
$dr->injectFinder(new FileChecksum());
$dr->injectFinder(new PixelChecksum());
$dr->injectFinder(new ImagickSignature());
$dr->injectFinder(new aHash());

// this will return a list of duplicates as array
$start = microtime(true);
$duplicates = $dr->getDuplicates();
$diff = round(microtime(true) - $start, 4);
var_dump($duplicates);
echo "\ntook $diff seconds\n";

// this will move duplicates to $c_dir
// mind that this one will call getDuplicates() on its
// own if you didn't do it before.
//$dr->moveDuplicates();
