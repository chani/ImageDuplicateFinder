<?php

/**
 * Class aHashBased
 *
 * This class uses an aHash-based-approach to find duplicates
 * by scaling down the photo to 8x8px, getting the average (mean)
 * and thresholding the image. Finally the IM Fingerprint is retrieved
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
class aHashBased extends GenericFinder implements Finder
{
    private $hashes = [];

    public function searchDuplicates($file)
    {
        $im = new \Imagick($file);
        $im->blurImage(0, 1);
        $im->sampleImage(8, 8);
        $im->transformImageColorspace(\Imagick::COLORSPACE_GRAY);
        $data = $im->getImageChannelMean(\Imagick::CHANNEL_RED);
        $mean = $data['mean'];
        $im->thresholdImage($mean);
        $hash = $im->getImageSignature();
        $im->clear();

        if (isset($this->hashes[$hash])) {
            $this->duplicates->add($file, $this->hashes[$hash]);
        }

        $this->hashes[$hash] = $file;
    }
}