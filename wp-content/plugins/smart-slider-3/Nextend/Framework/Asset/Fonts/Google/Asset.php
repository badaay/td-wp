<?php


namespace Nextend\Framework\Asset\Fonts\Google;


use Nextend\Framework\Asset\AbstractAsset;
use Nextend\Framework\Asset\Css\Css;
use Nextend\Framework\Url\UrlHelper;

class Asset extends AbstractAsset {

    public function getLoadedFamilies() {
        return array_keys($this->files);
    }

    function addSubset($subset = 'latin') {
        if (!in_array($subset, $this->inline)) {
            $this->inline[] = $subset;
        }
    }

    function addFont($family, $style = '400') {
        $style = (string)$style;
        if (!isset($this->files[$family])) {
            $this->files[$family] = array();
        }
        if (!in_array($style, $this->files[$family])) {
            $this->files[$family][] = $style;
        }
    }

    public function loadFonts() {

        if (!empty($this->files)) {
            //https://fonts.googleapis.com/css?display=swap&family=Montserrat:400%7CRoboto:100italic,300,400&subset=latin,greek-ext

            $families = array();
            foreach ($this->files as $name => $styles) {
                if (count($styles) && !in_array($name, Google::$excludedFamilies)) {
                    $families[] = $name . ':' . implode(',', $styles);
                }
            }

            if (count($families)) {
                $params = array(
                    'display' => 'swap',
                    'family'  => implode('|', $families),
                    'subset'  => implode(',', $this->inline)
                );

                Css::addUrl(UrlHelper::add_query_arg($params, 'https://fonts.googleapis.com/css'));
            }

        }

        return true;
    }
}