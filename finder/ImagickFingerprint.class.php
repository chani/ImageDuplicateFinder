<?php

/**
 * Class ImagickFingerprint
 */
class ImagickFingerprint extends GenericFinder implements Finder
{
    private $hashes = [];

    public function searchDuplicates($file)
    {
        $im = new \Imagick($file);
        $hash = $im->getImageSignature();
        $im->clear();

        if (isset($this->hashes[$hash])) {
            $this->duplicates->add($file, $this->hashes[$hash]);
        }

        $this->hashes[$hash] = $file;
    }
}