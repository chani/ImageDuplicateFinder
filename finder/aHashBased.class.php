<?php

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
class aHashBased extends GenericFinder implements Finder
{
    /**
     * @var array
     */
    private $hashes = [];

    /**
     * @param $file
     * @throws ImagickException
     * @throws ImagickPixelException
     */
    public function searchDuplicates($file)
    {
        $im = new \Imagick($file);
        $im->transformImageColorspace(\Imagick::COLORSPACE_GRAY);
        $im->sampleImage(8, 8);
        $data = $im->getImageChannelMean(\Imagick::CHANNEL_RED);
        $mean = $data['mean'];
        $im->thresholdImage($mean);
        $bits = "";
        $imageIterator = $im->getPixelIterator();
        foreach ($imageIterator as $pixels) {
            /** @var $pixel \ImagickPixel * */
            foreach ($pixels as $pixel) {
                /** @todo 255? */
                $bits .= $pixel->getcolor()['b'] / 255;
            }
        }
        $hash = dechex(bindec($bits));
        
        $im->clear();

        if (isset($this->hashes[$hash])) {
            $this->duplicates->add($file, $this->hashes[$hash]);
        }

        $this->hashes[$hash] = $file;
    }
}