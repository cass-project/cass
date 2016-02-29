<?php
namespace Data\Repository;

use Application\Tools\SerialManager\SerialManager;
use Cocur\Chain\Chain;
use Data\Entity\Host;
use Data\Entity\Theme;
use Data\Exception\DataEntityNotFoundException;
use Data\Repository\Theme\SaveThemeProperties;
use Doctrine\ORM\EntityRepository;
use ThemeEditor\Middleware\Request\DeleteThemeRequest;
use ThemeEditor\Middleware\Request\GetThemeRequest;
use ThemeEditor\Middleware\Request\MoveThemeRequest;
use ThemeEditor\Middleware\Request\PutThemeRequest;
use ThemeEditor\Middleware\Request\UpdateThemeRequest;

class ThemeRepository extends EntityRepository
{
    /**
     * @param GetThemeRequest $getThemeRequest
     * @return Theme[]
     */
    public function getThemes(GetThemeRequest $getThemeRequest): array
    {
        return Chain::create($this->findBy([]))
            ->map(function(Theme $theme) {
                return $theme->toJSON();
            })
            ->array
        ;
    }

    public function create(Host $host, PutThemeRequest $PUTEntityRequest): Theme
    {
        $themeEntity = new Theme();
        $themeEntity->setHost($host);

        $this->setupEntity($themeEntity, $PUTEntityRequest);

        $em = $this->getEntityManager();
        $em->persist($themeEntity);
        $em->flush();

        return $themeEntity;
    }

    public function update(UpdateThemeRequest $updateThemeRequest): Theme
    {
        $themeEntity = $this->getThemeEntity($updateThemeRequest->getId());

        $this->setupEntity($themeEntity, $updateThemeRequest);

        $em = $this->getEntityManager();
        $em->persist($themeEntity);
        $em->flush();

        return $themeEntity;
    }

    public function move(MoveThemeRequest $moveThemeRequest): Theme
    {
        $em = $this->getEntityManager();
        $themeEntity = $this->getThemeEntity($moveThemeRequest->getThemeId());

        $parentId = $moveThemeRequest->getParentThemeId();

        if($parentId == 0) {
            $themeEntity->setParent(null);
        }else{
            $themeEntity->setParent($em->getReference(Theme::class, $parentId));
        }

        $siblings = new SerialManager($this->getThemesWithParent($moveThemeRequest->getParentThemeId()));
        $siblings->insertAs($themeEntity, $moveThemeRequest->getPosition());

        $em->persist($themeEntity);
        $em->flush();

        return $themeEntity;
    }

    public function delete(DeleteThemeRequest $deleteThemeRequest): Theme
    {
        $themeEntity = $this->getThemeEntity($deleteThemeRequest->getId());

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