<?php
namespace Data\Repository;

use Cocur\Chain\Chain;
use Data\Entity\Host;
use Data\Entity\Theme;
use Data\Exception\DataEntityNotFoundException;
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
        return Chain::create($this->findBy($getThemeRequest->getCriteria()))
            ->map(function(Theme $theme) {
                return $theme->toJSON();
            })
            ->array
        ;
    }

    public function create(Host $host, PutThemeRequest $PUTEntityRequest): Theme {
        $em = $this->getEntityManager();

        $themeEntity = new Theme();
        $themeEntity->setTitle($PUTEntityRequest->getTitle()->value());
        $themeEntity->setHost($host);

        $PUTEntityRequest->getParentId()->on(function($value) use ($themeEntity, $em) {
            $themeEntity->setParent($em->getReference(Theme::class, $value));
        });

        $PUTEntityRequest->getPosition()
            ->on(function($value) use ($themeEntity) {
                $themeEntity->setPosition($value);
            })
            ->none(function() use ($themeEntity) {
                $parentId = $themeEntity->hasParent() ? $themeEntity->getParent()->getId() : null;
                $position = $this->getLastPosition($parentId);

                $themeEntity->setPosition($position + 1);
            })
        ;

        $parentId = $themeEntity->hasParent() ? $themeEntity->getParent()->getId() : null;
        $this->shiftPositions($themeEntity->getPosition(), $parentId);

        $em->persist($themeEntity);
        $em->flush();

        return $themeEntity;
    }

    public function update(UpdateThemeRequest $updateThemeRequest): Theme {
        $em = $this->getEntityManager();
        $themeEntity = $this->find($updateThemeRequest->getId()); /** @var Theme $themeEntity */

        if($themeEntity === null) {
            throw new DataEntityNotFoundException(sprintf("Entity with ID `%d` not found", $updateThemeRequest->getId()));
        }

        if($updateThemeRequest) {
            $themeEntity->setTitle($updateThemeRequest->getTitle());
        }

        $em->persist($themeEntity);
        $em->flush($themeEntity);

        return $themeEntity;
    }

    public function move(MoveThemeRequest $moveThemeRequest): Theme {
        $em = $this->getEntityManager();

        $themeEntity = $this->find($moveThemeRequest->getThemeId()); /** @var Theme $themeEntity */

        if($themeEntity === null) {
            throw new DataEntityNotFoundException(sprintf("Entity with ID `%d` not found", $moveThemeRequest->getThemeId()));
        }

        if($parentId = $moveThemeRequest->getParentThemeId()) {
            $themeEntity->setParent($em->getReference(Theme::class, $parentId));
        }else{
            $themeEntity->setParent(null);
        }

        if($position = $moveThemeRequest->getPosition()) {

        }

        $em->persist($themeEntity);
        $em->flush($themeEntity);

        return $themeEntity;
    }

    public function delete(DeleteThemeRequest $deleteThemeRequest): Theme {
        $themeEntity = $this->find($deleteThemeRequest->getId()); /** @var Theme $themeEntity */

        if($themeEntity === null) {
            throw new DataEntityNotFoundException(sprintf("Entity with ID `%d` not found", $deleteThemeRequest->getId()));
        }

        $em = $this->getEntityManager();
        $em->remove($themeEntity);
        $em->flush($themeEntity);

        return $themeEntity;
    }

    public function getLastPosition(int $parentId = null): int {
        $qb = $this->createQueryBuilder('theme')
            ->select('MAX(theme.position) AS last_theme_position')
        ;

        is_null($parentId)
            ? $qb->where('theme.parent IS NULL')
            : $qb->where('theme.parent = :parentId')->setParameter('parentId', $parentId)
        ;

        return (int) $qb->getQuery()->getResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    public function shiftPositions(int $fromPosition, int $parentId = null) {
        $em = $this->getEntityManager();

        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.position = :position')
            ->setParameter('position', $fromPosition)
        ;

        is_null($parentId)
            ? $qb->andWhere('t.parent IS NULL')
            : $qb->andWhere('t.parent = :parentId')->setParameter('parentId', $parentId);
        ;

        foreach($qb->getQuery()->getResult() as $themeEntity) { /** @var Theme $themeEntity */
            $themeEntity->inrementPosition();

            $em->persist($themeEntity);
        }
    }
}