<?php
namespace Domain\Theme\Repository;

use Application\Util\SerialManager\SerialManager;
use Doctrine\ORM\EntityRepository;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Exception\ThemeNotFoundException;
use Domain\Theme\Exception\ThemeWithThisIdExistsException;
use Domain\Theme\Parameters\CreateThemeParameters;
use Domain\Theme\Parameters\UpdateThemeParameters;

class ThemeRepository extends EntityRepository
{
    public function createTheme(CreateThemeParameters $parameters): Theme
    {
        $em = $this->getEntityManager();

        if($parameters->hasForcedId()) {
            $forceId = $parameters->getForceId();

            if($this->hasThemeWithId($forceId)) {
                throw new ThemeWithThisIdExistsException(sprintf('Theme with ID `%s` already exists', $forceId));
            }

            $themeEntity = new Theme($parameters->getTitle(), $forceId);
        }else{
            $themeEntity = new Theme($parameters->getTitle());
        }

        $themeEntity->setDescription($parameters->getDescription());

        if($parameters->hasSpecifiedURL()) {
            $themeEntity->setURL($parameters->getSpecifiedURL());
        }

        $parentId = $parameters->hasParent()
            ? $parameters->getParentId()
            : null;

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

    public function hasThemeWithId(int $themeId): bool
    {
        return $this->find($themeId) instanceof Theme;
    }

    public function updateTheme(int $themeId, UpdateThemeParameters $parameters): Theme
    {
        $theme = $this->getThemeById($themeId);

        $theme->setTitle($parameters->getTitle());
        $theme->setDescription($parameters->getDescription());

        if($parameters->hasSpecifiedURL()) {
            $theme->setURL($parameters->getSpecifiedURL());
        }

        if($parameters->hasChangedPreview()) {
            $theme->setPreview($parameters->getPreview());
        }

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
            throw new ThemeNotFoundException(sprintf('Theme with ID `%s` not found', $themeId));
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