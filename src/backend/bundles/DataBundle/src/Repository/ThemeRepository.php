<?php
namespace Data\Repository;

use Cocur\Chain\Chain;
use Data\Entity\Host;
use Data\Entity\Theme;
use Data\Exception\DataEntityNotFoundException;
use Data\Repository\Theme\SaveThemeProperties;
use Doctrine\ORM\AbstractQuery;
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
    public function getThemes(GetThemeRequest $getThemeRequest): array {
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
        $themeEntity = $this->findThemeEntity($updateThemeRequest->getId());

        $this->setupEntity($themeEntity, $updateThemeRequest);

        $em = $this->getEntityManager();
        $em->persist($themeEntity);
        $em->flush($themeEntity);

        return $themeEntity;
    }

    public function move(MoveThemeRequest $moveThemeRequest): Theme {
        throw new \Exception('Not implemented');
    }

    public function delete(DeleteThemeRequest $deleteThemeRequest): Theme {
        $themeEntity = $this->findThemeEntity($deleteThemeRequest->getId());

        $em = $this->getEntityManager();
        $em->remove($themeEntity);
        $em->flush($themeEntity);

        return $themeEntity;
    }

    private function setupEntity(Theme $themeEntity, SaveThemeProperties $saveThemeProperties) {
        $em = $this->getEntityManager();

        $themeEntity->setTitle($saveThemeProperties->getTitle()->value());

        $saveThemeProperties->getParentId()->on(function($value) use ($themeEntity, $em) {
            $themeEntity->setParent($em->getReference(Theme::class, $value));
        });

        $parentId = $themeEntity->hasParent() ? $themeEntity->getParent()->getId() : null;

        $saveThemeProperties->getPosition()
            ->on(function($value) use ($themeEntity, $parentId) {
                $themeEntity->setPosition($value);
                $this->shiftPositions($value, $parentId, $themeEntity->getId());
            })
            ->none(function() use ($themeEntity, $parentId) {
                if($themeEntity->getId() === null) {
                    $position = $this->getLastPosition($parentId) + 1;
                    $themeEntity->setPosition($position);
                }
            })
        ;
    }

    private function getLastPosition(int $parentId = null): int {
        $qb = $this->createQueryBuilder('theme')
            ->select('MAX(theme.position) AS last_theme_position')
        ;

        is_null($parentId)
            ? $qb->where('theme.parent IS NULL')
            : $qb->where('theme.parent = :parentId')->setParameter('parentId', $parentId)
        ;

        $result = (int) $qb->getQuery()->getResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);

        return ($result === null || $result < 1) ? 1 : (int) $result;
    }

    private function shiftPositions(int $fromPosition, int $parentId = null, int $excludedId = null) {
        $em = $this->getEntityManager();

        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.position = :position')
            ->setParameter('position', $fromPosition)
        ;

        if($excludedId) {
            $qb->andWhere('t.id != :excludedId')->setParameter('excludedId', $excludedId);
        }

        is_null($parentId)
            ? $qb->andWhere('t.parent IS NULL')
            : $qb->andWhere('t.parent = :parentId')->setParameter('parentId', $parentId);
        ;

        foreach($qb->getQuery()->getResult() as $themeEntity) { /** @var Theme $themeEntity */
            $themeEntity->inrementPosition();

            $em->persist($themeEntity);
        }
    }

    private function findThemeEntity(int $id): Theme
    {
        $themeEntity = $this->find($id);
        /** @var Theme $themeEntity */

        if ($themeEntity === null) {
            throw new DataEntityNotFoundException(sprintf("Theme Entity with ID `%d` not found", $moveThemeRequest->getThemeId()));
        }
        return $themeEntity;
    }
}