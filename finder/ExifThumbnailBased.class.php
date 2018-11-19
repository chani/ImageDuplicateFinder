<?php

/**
 * Class ExifThumbnailBased
 *
 * This one tries to retrieve the thumbnail embedded in the image
 * using exif_thumbnail. Most of the times this won't work at all.
 * In 4k photos I just had two in which exif_thumbnail worked.
 *
 * @todo check for a better way to retrieve embedded thumbnails
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
class ExifThumbnailBased extends GenericFinder implements Finder
{
    /**
     * @var array
     */
    private $hashes = [];

    /**
     * @param string $file
     * @throws ImagickException
     */
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
    }
}