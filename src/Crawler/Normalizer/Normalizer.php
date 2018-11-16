<?php

namespace Crawler\Normalizer;

/**
 * Class Normalizer
 */
class Normalizer
{
    /**
     * @param array $texts
     * @return mixed
     */
    public function normalize(array $texts)
    {
        $text = $this->removeUnnecessary($this->removeRegexp($this->removeUnnecessary($texts[1])));

        $text = trim($text);
        if (strlen($text) == 0) {
            return array();
        }

        return array($text);
    }

    /**
     * @param $text
     * @return mixed
     */
    private function removeUnnecessary($text)
    {
        $unnecessary = array(
            '!DOCTYPE>',
            'Bilder, Idee, Design und© 2013 by www.flurnamenpuzzle.com',
            'Design, Idee und © 2013 by www.flurnamenpuzzle.com',
            'Hesch gwüsst ...? ',
            'hesch gwüsst?',
            'Design und © 2013 by www.flurnamenpuzzle.com',
            'jquery lightbox sample by VisualLightBox.com v5.4',
            'Bemerkung: zur Übersichtskarte Klicken Sie auf ein Bild um dieses zu vergrössern.',
            'VisualLightBox Gallery',
            'Quelle: Lehrer E. Schaub- Roth',
            'Text H. Fricker',
            'was suchsch?',
            'Was suchsch?',
            'was suchsch ?',
            'Was suchsch ?',
            '""',
            '" "',
            'A / B /C / D / E / F / G / H / I / K / L / M / N / O / P / Q / R / S / T / U / W / Z',
        );

        return str_replace($unnecessary, '', $text);
    }

    /**
     * @param $text
     * @return null|string|string[]
     */
    private function removeRegexp($text)
    {
        $regexps = array(
            '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS',
            '/ISBN[ ]*[0-9-]*/i',
            '/www\.[a-z0-9_\-\.]+.[a-z]+/i',
        );

        foreach ($regexps as $regexp) {
            $text= preg_replace($regexp, '', $text);
        }

        return $text;
    }
}
