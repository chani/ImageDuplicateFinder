<?php

namespace Image\DuplicateFinder\finder;

/**
 * Class ImagickFingerprint
 *
 * Here just the ImagickMagick Fingerprint method is used to detect duplicates
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
class ImagickSignature extends AbstractFinder implements Finder
{
    /**
     * @var array
     */
    private $hashes = [];

    /**
     * @param $file
     *
     * @return string
     * @throws \ImagickException
     */
    public function getHash($file)
    {
        $useThumbnail = false;
        $im = new \Imagick();

        // using the embedded thumbnail reduced time from 2.5 seconds to 0.15 seconds for 67 photos
        $thumbnail = @exif_thumbnail($file);
        if ($thumbnail !== false) {
            $im->readImageBlob($thumbnail);
            if ($im->getImageWidth() >= 64 && $im->getImageHeight() >= 64) {
                $im->stripImage();
                $useThumbnail = true;
            }
        }

        if (!$useThumbnail) {
            $im->readImage($file);
            $im->stripImage();
            // reduced time from 8,7 seconds to 2,5 seconds for 67 photos
            $im->sampleImage(64, 64);
        }

        $hash = $im->getImageSignature();

        $im->clear();
        unset($im);

        $this->hashes[$hash] = $file;
        return $hash;
    }
}