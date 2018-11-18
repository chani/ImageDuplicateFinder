<?php

/**
 * Class ExifThumbnailBased
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
class ExifThumbnailBased extends GenericFinder implements Finder
{
    private $hashes = [];

    public function searchDuplicates($file)
    {
        $thumbnail = @exif_thumbnail($file);
        if ($thumbnail !== false) {
            $im = new \Imagick;
            $im->readImageBlob($thumbnail);
            $hash = $im->getImageSignature();
            $im->clear();

            if (isset($this->hashes[$hash])) {
                $this->duplicates->add($file, $this->hashes[$hash]);
            }

            $this->hashes[$hash] = $file;
        }
        return false;
    }
}