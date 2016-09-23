<?php
namespace CASS\Domain\Bundles\Backdrop\Entity;

trait BackdropEntityAwareTrait
{
    /**
     * @Column(type="json_array", name="backdrop")
     * @var string
     */
    private $backdrop = [];

    public function exportBackdrop(Backdrop $backdrop)
    {
        $this->backdrop = $backdrop->toJSON();
    }

    public function extractBackdrop(): Backdrop
    {
        return new Backdrop(
            $this->backdrop['type'],
            $this->backdrop['public'],
            $this->backdrop['storage']
        );
    }
}