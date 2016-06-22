<?php
namespace Domain\Theme\Service;

use Domain\Auth\Service\CurrentAccountService;
use Application\Util\SerialManager\SerialManager;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Repository\ThemeRepository;
use Evenement\EventEmitter;
use Evenement\EventEmitterInterface;

class ThemeService
{
    const EVENT_ACCESS = 'domain.theme.access';
    const EVENT_CREATED = 'domain.theme.created';
    const EVENT_UPDATED = 'domain.theme.updated';
    const EVENT_DELETE = 'domain.theme.delete';
    const EVENT_DELETED = 'domain.theme.deleted';

    /** @var EventEmitterInterface */
    private $events;

    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var ThemeRepository */
    private $themeRepository;

    public function __construct(CurrentAccountService $currentAccountService, ThemeRepository $themeRepository)
    {
        $this->events = new EventEmitter();
        $this->currentAccountService = $currentAccountService;
        $this->themeRepository = $themeRepository;
    }

    public function getEventEmitter(): EventEmitterInterface
    {
        return $this->events;
    }

    public function createTheme(string $title, string $description, int $parentId = null): Theme
    {
        return $this->themeRepository->createTheme($title, $description, $parentId);
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
        return $this->themeRepository->moveTheme($themeId, $newParentThemeId, $position);
    }

    public function updateTheme(int $themeId, string $title, string $description = ''): Theme
    {
        return $this->themeRepository->updateTheme($themeId, $title, $description);
    }

    public function deleteTheme(int $themeId)
    {
        $this->themeRepository->deleteTheme($themeId);
    }
}