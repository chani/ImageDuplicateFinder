<?php

/**
 * Class ExifThumbnailBased
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