<?php
namespace CASS\Domain\OpenGraph\Parser;

final class OpenGraphParser
{
    /** @var \DOMNodeList */
    private $metaTags;

    public function parse(string $origURL, \DOMDocument $document)
    {
        $this->metaTags = $document->getElementsByTagName('meta');

        return [
            'basic' => $this->fetchBasic($origURL, $document),
            'og' => $this->fetchOG($document)
        ];
    }

    private function fetchBasic(string $origURL, \DOMDocument $document): array
    {
        $result = [
            'title' => '',
            'description' => '',
            'url' => $origURL
        ];

        $titleElements = $document->getElementsByTagName('title');
        $descriptionElements = $this->getMetaTags('description', 'name');

        if($titleElements->length) {
            $result['title'] = $titleElements->item(0)->textContent;
        }

        if(count($descriptionElements)) {
            $result['description'] = $descriptionElements[0]->attributes->getNamedItem('content')->textContent;
        }

        return $result;
    }

    private function fetchOG(\DOMDocument $document): array
    {
        $result = [
            'basic' => $this->fetchOGBasic($document),
            'images' => $this->fetchOGImages($document),
            'audios' => $this->fetchOGAudios($document),
            'videos' => $this->fetchOGVideos($document),
        ];

        return $result;
    }

    private function fetchOGBasic(\DOMDocument $document)
    {
        $attributes = [
            'og:title' => '',
            'og:type' => '',
            'og:url' => '',
            'og:description' => '',
            'og:determiner' => '',
            'og:locale' => '',
            'og:locale:alternate' => '',
            'og:site_name' => '',
            'og:image' => '',
            'og:video' => '',
            'og:audio' => '',
        ];

        foreach(array_keys($attributes) as $attr) {
            $elements = $this->getMetaTags($attr);

            $attributes[$attr] = count($elements)
                ? $elements[0]->attributes->getNamedItem('content')->textContent
                : '';
        }

        return $attributes;
    }

    private function fetchOGImages(\DOMDocument $document)
    {
        $result = [];
        $attributes = [
            'og:image',
            'og:image:url',
            'og:image:secure_url',
            'og:image:type',
            'og:image:width',
            'og:image:height',
        ];

        foreach($attributes as $attr) {
            $elements = $this->getMetaTags($attr);

            if(count($elements)) {
                for($index = 0; $index < count($elements); $index++) {
                    if(! isset($result[$index])) {
                        $result[$index] = [
                            'og:image' => '',
                            'og:image:url' => '',
                            'og:image:secure_url' => '',
                            'og:image:type' => '',
                            'og:image:width' => '',
                            'og:image:height' => '',
                        ];
                    }

                    $result[$index][$attr] = $elements[0]->attributes->getNamedItem('content')->textContent;
                }
            }
        }

        foreach($result as &$res) {
            if((! strlen($res['og:image'])) && strlen($res['og:image:url'])) $res['og:image'] = $res['og:image:url'];
            if((! strlen($res['og:image:url'])) && strlen($res['og:image'])) $res['og:image:url'] = $res['og:image'];
        }

        return $result;
    }

    private function fetchOGVideos(\DOMDocument $document)
    {
        $result = [];
        $attributes = [
            'og:video',
            'og:video:url',
            'og:video:secure_url',
            'og:video:type',
            'og:video:width',
            'og:video:height',
        ];

        foreach($attributes as $attr) {
            $elements = $this->getMetaTags($attr);

            if(count($elements)) {
                for($index = 0; $index < count($elements); $index++) {
                    if(! isset($result[$index])) {
                        $result[$index] = [
                            'og:video' => '',
                            'og:video:url' => '',
                            'og:video:secure_url' => '',
                            'og:video:type' => '',
                            'og:video:width' => '',
                            'og:video:height' => '',
                        ];
                    }

                    $result[$index][$attr] = $elements[0]->attributes->getNamedItem('content')->textContent;
                }
            }
        }

        foreach($result as &$res) {
            if((! strlen($res['og:video'])) && strlen($res['og:video:url'])) $res['og:video'] = $res['og:video:url'];
            if((! strlen($res['og:video:url'])) && strlen($res['og:video'])) $res['og:video:url'] = $res['og:video'];
        }

        return $result;
    }

    private function fetchOGAudios(\DOMDocument $document)
    {
        $result = [];
        $attributes = [
            'og:audio',
            'og:audio:url',
            'og:audio:secure_url',
            'og:audio:type',
            'og:audio:width',
            'og:audio:height',
        ];

        foreach($attributes as $attr) {
            $elements = $this->getMetaTags($attr);

            if(count($elements)) {
                for($index = 0; $index < count($elements); $index++) {
                    if(! isset($result[$index])) {
                        $result[$index] = [
                            'og:audio' => '',
                            'og:audio:url' => '',
                            'og:audio:secure_url' => '',
                            'og:audio:type' => '',
                            'og:audio:width' => '',
                            'og:audio:height' => '',
                        ];
                    }

                    $result[$index][$attr] = $elements[0]->attributes->getNamedItem('content')->textContent;
                }
            }
        }

        foreach($result as &$res) {
            if((! strlen($res['og:audio'])) && strlen($res['og:audio:url'])) $res['og:audio'] = $res['og:audio:url'];
            if((! strlen($res['og:audio:url'])) && strlen($res['og:audio'])) $res['og:audio:url'] = $res['og:audio'];
        }

        return $result;
    }


    private function getMetaTags(string $property, string $attrName = 'property'): array
    {
        /** @var \DOMNode[] $result */
        $result = [];

        for($index = 0; $index < $this->metaTags->length; $index++) {
            $node = $this->metaTags->item($index);

            if($attrNode = $node->attributes->getNamedItem($attrName)) {
                if($attrNode->textContent === $property) {
                    $result[] = $node;
                }
            }
        }

        return $result;
    }
}