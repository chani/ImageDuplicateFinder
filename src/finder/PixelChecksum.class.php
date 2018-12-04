<?php

namespace Image\DuplicateFinder\finder;

/**
 * Class FileChecksum
 *
 * Simple sha1 checksum on the file contents to find duplicates
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
class PixelChecksum extends AbstractFinder implements Finder
{
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

        // using the embedded thumbnail reduced time from 2.6 seconds to 0.15 seconds for 67 photos
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
            // reduced time from 6,6 seconds to 2,6 seconds for 67 photos
            $im->sampleImage(64, 64);
        }

        $hash = hash('SHA256', $im->getImageBlob());

        $im->clear();
        unset($im);

        return $hash;
    }
}