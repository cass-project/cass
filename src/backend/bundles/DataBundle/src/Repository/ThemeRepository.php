<?php
namespace Data\Repository;

use Cocur\Chain\Chain;
use Data\Entity\Host;
use Data\Entity\Theme;
use Data\Exception\DataEntityNotFoundException;
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
        $themeEntity->setTitle($PUTEntityRequest->getTitle());
        $themeEntity->setHost($host);

        if($parentId = $PUTEntityRequest->getParentId()) {
            $themeEntity->setParent($em->getReference(Theme::class, $parentId));
        }

        $em->persist($themeEntity);
        $em->flush($themeEntity);

        return $themeEntity;
    }

    public function update(UpdateThemeRequest $updateThemeRequest): Theme {
        $em = $this->getEntityManager();
        $themeEntity = $this->find($updateThemeRequest->getId()); /** @var Theme $themeEntity */

        if($themeEntity === null) {
            throw new DataEntityNotFoundException(sprintf("Entity with ID `%d` not found", $updateThemeRequest->getId()));
        }

        if($updateThemeRequest->getTitle() !== null) {
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
}