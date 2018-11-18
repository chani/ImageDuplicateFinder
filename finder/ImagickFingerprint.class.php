<?php

/**
 * Class ImagickFingerprint
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
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