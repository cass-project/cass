<?php
namespace Theme\Repository;

use Common\Tools\SerialManager\SerialManager;
use Doctrine\ORM\EntityRepository;
use Theme\Entity\Theme;

class ThemeRepository extends EntityRepository
{
    public function createTheme(string $title, string $description, int $parentId = null): Theme
    {
        $em = $this->getEntityManager();

        $themeEntity = new Theme();
        $themeEntity->setTitle($title);
        $themeEntity->setDescription($description);

        if ($parentId) {
            $themeEntity->setParent($em->getReference(Theme::class, $parentId));
        }

        $sameLevelThemes = $this->getThemesByParentId($parentId);

        $serialManager = new SerialManager($sameLevelThemes);
        $serialManager->insertLast($themeEntity);
        $serialManager->normalize();

        $em->persist($themeEntity);
        $em->flush($sameLevelThemes + [$themeEntity]);

        return $themeEntity;
    }

    /** @return Theme[] */
    public function getThemesByParentId(int $parentId = null): array
    {
        return $this->findBy(['parent' => $parentId]);
    }

    /** @return Theme[] */
    public function getAllThemes(): array
    {
        return $this->findBy([]);
    }
}