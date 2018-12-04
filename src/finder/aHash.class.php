<?php

namespace Image\DuplicateFinder\finder;

/**
 * Class aHashBased
 *
 * This class uses an aHash-based-approach to find duplicates
 * by scaling down the photo to 8x8px, getting the average (mean)
 * and thresholding the image. Finally the Hash is created
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 * @see https://www.hackerfactor.com/blog/?/archives/432-Looks-Like-It.html
 */
class aHash extends AbstractFinder implements Finder
{
    /**
     * @param $file
     *
     * @return string
     * @throws \ImagickException
     * @throws \ImagickPixelException
     */
    public function getHash($file)
    {
        $useThumbnail = false;
        $im = new \Imagick();

        // using the embedded thumbnail reduced time from 3.4 seconds to 0.43 seconds for 67 photos
        $thumbnail = @exif_thumbnail($file);
        if ($thumbnail !== false) {
            $im->readImageBlob($thumbnail);
            if ($im->getImageWidth() >= 64 && $im->getImageHeight() >= 64) {
                $useThumbnail = true;
            }
        }

        if (!$useThumbnail) {
            $im = new \Imagick($file);

        }
        $im->transformImageColorspace(\Imagick::COLORSPACE_GRAY);
        /**
         * @todo make it possible to work with 16x16 dechex(bindec()) will fail here
         */
        $im->sampleImage(8, 8);
        $data = $im->getImageChannelMean(\Imagick::CHANNEL_RED);
        $mean = $data['mean'];
        $im->thresholdImage($mean);
        $bits = "";
        $imageIterator = $im->getPixelIterator();
        foreach ($imageIterator as $pixels) {
            /** @var $pixel \ImagickPixel * */
            foreach ($pixels as $pixel) {
                $bits .= $pixel->getcolor()['r'] / 255;
            }
        }
        $hash = dechex(bindec($bits));
        $im->clear();
        unset($im);

        return $hash;
    }
}