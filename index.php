<?php
include('finder/Duplicates.class.php');
include('finder/Finder.php');
include('finder/GenericFinder.class.php');
include('finder/FileChecksum.class.php');
include('finder/ImagickFingerprint.class.php');
include('finder/aHashBased.class.php');
include('finder/ExifThumbnailBased.class.php');
include('DuplicateFinder.class.php');

$path = '/home/jean/Pictures';
$df = new DuplicateFinder();
$df->injectFinder(new FileChecksum());
$df->injectFinder(new ImagickFingerprint());
$df->injectFinder(new aHashBased());
$df->injectFinder(new ExifThumbnailBased());

$df->searchDuplicates($path);
var_dump($df->getDuplicates());