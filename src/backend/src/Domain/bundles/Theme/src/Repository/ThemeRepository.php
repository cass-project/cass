<?php
namespace Domain\Theme\Repository;

use Application\Exception\EntityNotFoundException;
use Application\Util\SerialManager\SerialManager;
use Doctrine\ORM\EntityRepository;
use Domain\Theme\Entity\Theme;

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

    public function moveTheme(int $themeId, int $newParentThemeId = null, int $position = SerialManager::POSITION_LAST): Theme
    {
        $theme = $this->getThemeById($themeId);
        $themeIsMovingToAnotherTree = $theme->getParentId() !== $newParentThemeId;

        if ($themeIsMovingToAnotherTree) {
            $oldParentId = $theme->getParentId();

            if ($newParentThemeId === null) {
                $theme->setParent(null);
            } else {
                $theme->setParent($this->getEntityManager()->getReference(Theme::class, $newParentThemeId));
            }

            $sameLevelThemes = $this->getThemesByParentId($newParentThemeId);

            $serialManager = new SerialManager($sameLevelThemes);
            $serialManager->insertAs($theme, $position);
            $serialManager->normalize();

            $this->normalizeTree($oldParentId);

            $this->getEntityManager()->flush();
        } else {
            $sameLevelThemes = $this->getThemesByParentId($newParentThemeId);

            $serialManager = new SerialManager($sameLevelThemes);
            $serialManager->swap($serialManager->locate($position), $theme);
            $serialManager->normalize();

            $this->getEntityManager()->flush();
        }

        return $theme;
    }

    public function updateTheme(int $themeId, string $title, string $description = ''): Theme
    {
        $theme = $this->getThemeById($themeId);
        $theme
            ->setTitle($title)
            ->setDescription($description);

        $this->getEntityManager()->flush($theme);

        return $theme;
    }

    public function deleteTheme(int $themeId)
    {
        $theme = $this->getThemeById($themeId);

        $sameLevelThemes = $this->getThemesByParentId($theme->getParentId());

        $serialManager = new SerialManager($sameLevelThemes);
        $serialManager->remove($theme);
        $serialManager->normalize();

        $this->getEntityManager()->remove($theme);
        $this->getEntityManager()->flush($sameLevelThemes + [$theme]);
    }

    private function normalizeTree(int $parentId = null)
    {
        $themes = $this->getThemesByParentId($parentId);

        $serialManager = new SerialManager($themes);
        $serialManager->normalize();

        return $themes;
    }

    public function getThemeById(int $themeId): Theme
    {
        $result = $this->find($themeId);

        if($result === null) {
            throw new EntityNotFoundException(sprintf('Theme with ID `%s` not found', $themeId));
        }

        return $result;
    }
    
    public function getThemesByParentId(int $parentId = null): array
    {
        /** @var Theme[] $result */
        $result = $this->findBy(['parent' => $parentId]);

        return $result;
    }

    /** @return Theme[] */
    public function getAllThemes(): array
    {
        return $this->findBy([]);
    }
}