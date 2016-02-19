<?php
namespace ThemeEditor\Service;

use Cocur\Chain\Chain;
use Data\Entity\Theme;
use Data\Repository\ThemeRepository;
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

        return $theme;
    }

    public function read(array $criteria = []) {
        $em = $this->entityManager;
        $themeRepository = $em->getRepository(Theme::class); /** @var ThemeRepository $themeRepository */

        return Chain::create($themeRepository->findBy($criteria))
            ->map(function(Theme $theme) {
                return $theme->toJSON();
            });
    }

    public function update($themeId, $title) {
        $em = $this->entityManager;

        $themeRepository = $em->getRepository(Theme::class); /** @var ThemeRepository $themeRepository */
        $theme = $themeRepository->find($themeId); /** @var Theme $theme */

        $theme->setTitle($title);

        $em->persist($theme);
        $em->flush($theme);
    }

    public function move(int $themeId, int $parentThemeId) {
        $em = $this->entityManager;

        $theme = $this->getThemeById($themeId);
        $theme->setParent($em->getReference(Theme::class, $parentThemeId));

        $em->persist($theme);
        $em->flush($theme);
    }

    public function destroy(int $themeId) {
        $theme = $this->getThemeById($themeId);

        $em = $this->entityManager;
        $em->remove($theme);
        $em->flush($theme);
    }

    private function getThemeById(int $themeId) {
        $em = $this->entityManager;
        $themeRepository = $em->getRepository(Theme::class); /** @var ThemeRepository $themeRepository */

        return $themeRepository->find($themeId); /** @var Theme $theme */
    }
}