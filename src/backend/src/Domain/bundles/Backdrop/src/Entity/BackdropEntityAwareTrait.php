<?php
namespace CASS\Domain\Bundles\Backdrop\Entity;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\ColorBackdrop;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\NoneBackdrop;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\PresetBackdrop;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\UploadedBackdrop;
use CASS\Domain\Bundles\Backdrop\Exception\UnknownBackdropTypeException;
use CASS\Domain\Bundles\Colors\Entity\Color;
use CASS\Domain\Bundles\Colors\Entity\Palette;
use Symfony\Component\Config\Definition\Exception\Exception;

trait BackdropEntityAwareTrait
{
    /**
     * @Column(type="json_array", name="backdrop")
     * @var string
     */
    private $backdrop = [];

    public function setBackdrop(Backdrop $backdrop)
    {
        $this->backdrop = $backdrop->toJSON();
    }

    public function getBackdrop(): Backdrop
    {
        return $this->extractBackdropFromJSON($this->backdrop);
    }

    private function extractBackdropFromJSON(array $json): Backdrop
    {
        if($json === null || count(array_keys($json)) === 0) {
            return new NoneBackdrop();
        }

        if(! isset($json['type'])) {
            throw new Exception('Invalid backdrop JSON');
        }

        switch($json['type']) {
            default:
                throw new UnknownBackdropTypeException(sprintf('Unable to create backdrop with type `%s`', $json['type']));
            case NoneBackdrop::TYPE_ID:
                return new NoneBackdrop();
            case ColorBackdrop::TYPE_ID:
                return new ColorBackdrop(new Palette(
                    $json['metadata']['palette']['code'],
                    new Color(
                        $json['metadata']['palette']['background']['code'],
                        $json['metadata']['palette']['background']['hexCode']
                    ),
                    new Color(
                        $json['metadata']['palette']['foreground']['code'],
                        $json['metadata']['palette']['foreground']['hexCode']
                    ),
                    new Color(
                        $json['metadata']['palette']['border']['code'],
                        $json['metadata']['palette']['border']['hexCode']
                    )
                ));
            case PresetBackdrop::TYPE_ID:
                return new PresetBackdrop(
                    $json['metadata']['preset_id'],
                    $json['metadata']['public_path'],
                    $json['metadata']['storage_path'],
                    $json['metadata']['text_color']
                );
            case UploadedBackdrop::TYPE_ID:
                return new UploadedBackdrop(
                    $json['metadata']['storage_path'],
                    $json['metadata']['public_path'],
                    $json['metadata']['text_color']
                );
        }
    }
}