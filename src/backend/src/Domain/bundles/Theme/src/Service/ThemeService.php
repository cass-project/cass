<?php
namespace CASS\Domain\Theme\Service;

use CASS\Application\Service\EventEmitterAware\EventEmitterAwareService;
use CASS\Application\Service\EventEmitterAware\EventEmitterAwareTrait;
use CASS\Util\GenerateRandomString;
use CASS\Util\SerialManager\SerialManager;
use CASS\Domain\Theme\Entity\Theme;
use CASS\Domain\Theme\Parameters\CreateThemeParameters;
use CASS\Domain\Theme\Parameters\UpdateThemeParameters;
use CASS\Domain\Theme\Repository\ThemeRepository;
use League\Flysystem\FilesystemInterface;

class ThemeService implements EventEmitterAwareService
{
    use EventEmitterAwareTrait;

    const GENERATE_FILENAME_LENGTH = 5;

    const EVENT_CREATED = 'domain.theme.created';
    const EVENT_UPDATED = 'domain.theme.updated';
    const EVENT_DELETE = 'domain.theme.delete';
    const EVENT_DELETED = 'domain.theme.deleted';

    /** @var ThemeRepository */
    private $themeRepository;

    /** @var FilesystemInterface */
    private $fileSystem;

    public function __construct(ThemeRepository $themeRepository, FilesystemInterface $fileSystem)
    {
        $this->themeRepository = $themeRepository;
        $this->fileSystem = $fileSystem;
    }

    public function createTheme(CreateThemeParameters $parameters): Theme
    {
        $theme = $this->themeRepository->createTheme($parameters);
        $this->getEventEmitter()->emit(self::EVENT_CREATED, [$theme]);

        return $theme;
    }

    public function getThemeById(int $themeId)
    {
        return $this->themeRepository->getThemeById($themeId);
    }

    public function hasThemeWithId(int $themeId): bool
    {
        return $this->themeRepository->hasThemeWithId($themeId);
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

    public function updateTheme(int $themeId, UpdateThemeParameters $parameters): Theme
    {
        $theme = $this->themeRepository->updateTheme($themeId, $parameters);
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

    public function uploadImagePreview(int $themeId, string $path): string
    {
        $theme = $this->getThemeById($themeId);

        $dir = $theme->getId();
        $name = sprintf('%s.png', GenerateRandomString::gen(self::GENERATE_FILENAME_LENGTH));
        $newPath = sprintf('%s/%s', $dir, $name);

        if($this->fileSystem->has($dir)) {
            $this->fileSystem->deleteDir($dir);
        }

        $this->fileSystem->write($newPath, file_get_contents($path));

        $theme->setPreview($newPath);

        $this->themeRepository->saveTheme($theme);

        return $theme->getPreview();
    }
}