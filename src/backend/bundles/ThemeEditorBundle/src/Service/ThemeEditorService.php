<?php
namespace ThemeEditor\Service;

use Data\Entity\Theme;
use Doctrine\ORM\EntityManager;

class ThemeEditorService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ThemeEditorService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create($title, $parentId = null) {
        $em = $this->entityManager;

        $theme = new Theme();
        $theme->setTitle($title);

        if($parentId) {
            $theme->setParent($em->getReference(Theme::class, $parentId));
        }

        $em->persist($theme);
        $em->flush($theme);
    }

    public function update(Theme $theme) {
        $em = $this->entityManager;
        $em->persist($theme);
        $em->flush($theme);
    }

    public function destroy(Theme $theme) {
        $em = $this->entityManager;

        $em->detach($theme);
        $em->flush($theme);
    }
}