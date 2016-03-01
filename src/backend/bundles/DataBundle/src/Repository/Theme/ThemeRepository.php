<?php
namespace Data\Repository\Theme;

use Application\Tools\SerialManager\SerialManager;
use Cocur\Chain\Chain;
use Data\Entity\Host;
use Data\Entity\Theme;
use Data\Exception\DataEntityNotFoundException;
use Data\Repository\Theme\Parameters\CreateThemeParameters;
use Data\Repository\Theme\Parameters\DeleteThemeParameters;
use Data\Repository\Theme\Parameters\MoveThemeParameters;
use Data\Repository\Theme\Parameters\UpdateThemeParameters;
use Doctrine\ORM\EntityRepository;

class ThemeRepository extends EntityRepository
{
    public function getThemes(): array
    {
        return $this->findBy([]);
    }

    public function getThemesAsTree(/** @var $themes Theme[] */array $themes, int $parentId = null): array
    {
        $tree = [];

        foreach($themes as $theme) {
            if($theme->getParentId() === $parentId) {
                if($theme->hasChildren()) {
                    $children = $this->getThemesAsTree($themes, $theme->getId());
                }else{
                    $children = [];
                }

                $tree[] = array_merge($theme->toJSON(), [
                    'children' =>  $children
                ]);
            }
        }

        return $tree;
    }


    public function create(Host $host, CreateThemeParameters $createThemeParameters): Theme
    {
        $themeEntity = new Theme();
        $themeEntity->setHost($host);

        $this->setupEntity($themeEntity, $createThemeParameters);

        $em = $this->getEntityManager();
        $em->persist($themeEntity);
        $em->flush();

        return $themeEntity;
    }

    public function update(UpdateThemeParameters $updateThemeParameters): Theme
    {
        $themeEntity = $this->getThemeEntity($updateThemeParameters->getId());

        $this->setupEntity($themeEntity, $updateThemeParameters);

        $em = $this->getEntityManager();
        $em->persist($themeEntity);
        $em->flush();

        return $themeEntity;
    }

    public function move(MoveThemeParameters $moveThemeParameters): Theme
    {
        $em = $this->getEntityManager();
        $themeEntity = $this->getThemeEntity($moveThemeParameters->getThemeId());

        $parentId = $moveThemeParameters->getMoveToParentThemeId();

        if($parentId == 0) {
            $themeEntity->setParent(null);
        }else{
            $themeEntity->setParent($em->getReference(Theme::class, $parentId));
        }

        $siblings = new SerialManager($this->getThemesWithParent($moveThemeParameters->getMoveToParentThemeId()));
        $siblings->insertAs($themeEntity, $moveThemeParameters->getMoveToPosition());

        $em->persist($themeEntity);
        $em->flush();

        return $themeEntity;
    }

    public function delete(DeleteThemeParameters $deleteThemeParameters): Theme
    {
        $themeEntity = $this->getThemeEntity($deleteThemeParameters->getThemeId());

        $parentId = $themeEntity->hasParent() ? $themeEntity->getParent()->getId() : null;
        $siblings = new SerialManager($this->getThemesWithParent($parentId));

        $siblings->remove($themeEntity);

        $em = $this->getEntityManager();
        $em->remove($themeEntity);
        $em->flush();

        return $themeEntity;
    }

    private function setupEntity(Theme $themeEntity, SaveThemeProperties $saveThemeProperties)
    {
        $em = $this->getEntityManager();

        $saveThemeProperties->getTitle()->on(function($value) use($themeEntity) {
            $themeEntity->setTitle($value);
        });

        $saveThemeProperties->getParentId()->on(function($value) use ($themeEntity, $em) {
            if($value == 0) {
                $themeEntity->setParent(null);
            }else{
                $themeEntity->setParent($em->getReference(Theme::class, $value));
            }
        });

        $parentId = $themeEntity->hasParent() ? $themeEntity->getParent()->getId() : null;
        $siblings = new SerialManager($this->getThemesWithParent($parentId));

        if($themeEntity->isNewEntity()) {
            $saveThemeProperties->getPosition()
                ->on(function($value) use ($siblings, $themeEntity) {
                    $siblings->insertAs($themeEntity, $value);
                })
                ->none(function() use($siblings, $themeEntity) {
                    $siblings->insertLast($themeEntity);
                });
        }else{
            $saveThemeProperties->getPosition()
                ->on(function($value) use ($siblings, $themeEntity) {
                    $siblings->insertAs($themeEntity, $value);
                })
                ->none(function() use($siblings, $themeEntity) {
                    $siblings->insertLast($themeEntity);
                });
        }

        $siblings->normalize();
    }

    /**
     * @return Theme[]
     */
    public function getThemesWithParent(int $parentId = null)
    {
        if($parentId) {
            $qb = $this->createQueryBuilder('theme')
                ->andWhere('theme.parent = :parent')
                ->setParameter('parent', $parentId);
        }else{
            $qb = $this->createQueryBuilder('theme')
                ->andWhere('theme.parent is null');
        }

        return $qb->getQuery()->getResult();
    }

    public function getThemeEntity(int $id): Theme
    {
        $themeEntity = $this->find($id);
        /** @var Theme $themeEntity */

        if ($themeEntity === null) {
            throw new DataEntityNotFoundException(sprintf("Theme Entity with ID `%d` not found", $id));
        }
        return $themeEntity;
    }
}