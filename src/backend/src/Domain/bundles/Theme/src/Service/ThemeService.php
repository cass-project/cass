<?php
namespace Domain\Theme\Service;

use Application\Service\EventEmitterAware\EventEmitterAwareService;
use Application\Service\EventEmitterAware\EventEmitterAwareTrait;
use Domain\Auth\Service\CurrentAccountService;
use Application\Util\SerialManager\SerialManager;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Repository\ThemeRepository;
use Evenement\EventEmitter;
use Evenement\EventEmitterInterface;

class ThemeService implements EventEmitterAwareService
{
    use EventEmitterAwareTrait;

    const EVENT_CREATED = 'domain.theme.created';
    const EVENT_UPDATED = 'domain.theme.updated';
    const EVENT_DELETE = 'domain.theme.delete';
    const EVENT_DELETED = 'domain.theme.deleted';

    /** @var ThemeRepository */
    private $themeRepository;

    public function __construct(ThemeRepository $themeRepository)
    {
        $this->themeRepository = $themeRepository;
    }

    public function createTheme(string $title, string $description, int $parentId = null): Theme
    {
        $theme = $this->themeRepository->createTheme($title, $description, $parentId);
        $this->getEventEmitter()->emit(self::EVENT_CREATED, [$theme]);

        return $theme;
    }

    public function getThemeById(int $themeId)
    {
        return $this->themeRepository->getThemeById($themeId);
    }

    /** @return Theme[] */
    public function getAllThemes(): array
    {
        return $this->themeRepository->getAllThemes();
    }
    
    public function getThemesAsTree(int $parentId = null): array
    {
        $this->themeRepository->getAllThemes();

        /** @var Theme[] $result */
        $result = $this->themeRepository->getThemesByParentId($parentId);

        return $result;
    }

    public function moveTheme(int $themeId, int $newParentThemeId = null, int $position = SerialManager::POSITION_LAST): Theme
    {
        $theme = $this->themeRepository->moveTheme($themeId, $newParentThemeId, $position);
        $this->getEventEmitter()->emit(self::EVENT_UPDATED, [$theme]);

        return $theme;
    }

    public function updateTheme(int $themeId, string $title, string $description = ''): Theme
    {
        $theme = $this->themeRepository->updateTheme($themeId, $title, $description);
        $this->getEventEmitter()->emit(self::EVENT_UPDATED, [$theme]);

        return $theme;
    }

    public function deleteTheme(int $themeId): Theme
    {
        $theme = $this->themeRepository->getThemeById($themeId);

        $this->getEventEmitter()->emit(self::EVENT_DELETE, [$theme]);
        $this->themeRepository->deleteTheme($themeId);
        $this->getEventEmitter()->emit(self::EVENT_DELETED, [$theme]);

        return $theme;
    }
}