<?php

/**
 * Class aHashBased
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