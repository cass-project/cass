<?php
namespace ZEA2\Platform\Markers\ActivatedEntity;

trait ActivatedEntityTrait
{
    /**
     * @Column(name="is_activated", type="boolean")
     * @var bool
     */
    private $isActivated = false;

    public function activate()
    {
        $this->isActivated = true;
    }

    public function deactivate()
    {
        $this->isActivated = false;
    }

    public function isActivated(): bool
    {
        return $this->isActivated;
    }
}