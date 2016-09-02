<?php
namespace CASS\Application\Bundles\Stage\Fixture;

use Domain\Theme\Parameters\CreateThemeParameters;
use Domain\Theme\Service\ThemeService;
use Symfony\Component\Console\Output\OutputInterface;

final class ThemeFixture
{
    const THEMES_JSON_PATH = __DIR__.'/../Resources/Data/JSON/themes.json';
    const THEMES_PREVIEW_DIR = __DIR__.'/../Resources/Data/Images/categories/preview';

    /** @var OutputInterface */
    private $output;

    /** @var array */
    private $json;

    /** @var ThemeService */
    private $themeService;

    /** @var int */
    private $counter = 0;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    public function up(OutputInterface $output)
    {
        $this->output = $output;
        $this->json = $this->fetchJSON(self::THEMES_JSON_PATH);

        $this->output->writeln([
            '',
            '[Theme migration]',
            ''
        ]);

        $this->lookupTree($this->json);
        $this->lookupTree($this->json); // Yes we're doing it again.

        if($this->counter == 0) {
            $this->output->writeln([
                '',
                'Everything is up to date',
                ''
            ]);
        }
    }

    private function fetchJSON(string $path): array
    {
        $this->output->writeln(sprintf('Fetch JSON: %s', $path));

        if(! ($source = file_get_contents($path))) {
            throw new \Exception(sprintf('Failed to read JSON file `%s`', $path));
        }

        return json_decode($source, true);
    }

    private function lookupTree(array $json, $currentParentId = null)
    {
        $themes = array_filter($json, function(array  $input) use ($currentParentId) {
            return $input['parent_id'] === $currentParentId;
        });

        if(count($themes) > 0) {
            foreach($themes as $themeJSON) {
                $this->createTheme($themeJSON);
                $this->lookupTree($json, $themeJSON['id']);
            }
        }
    }

    private function createTheme(array $themeJSON)
    {
        if(! $this->themeService->hasThemeWithId($themeJSON['id'])) {
            ++$this->counter;

            $this->output->writeln(sprintf(
                ' * [#NEW THEME] id: %d, title: %s, parent_id: %s, preview: %s',
                $themeJSON['id'],
                $themeJSON['title'],
                $themeJSON['parent_id'],
                $themeJSON['image'] ?? '<NONE>'
            ));

            $parameters = new CreateThemeParameters(
                $themeJSON['title'],
                $themeJSON['description'] ?? '',
                null,
                $themeJSON['parent_id'],
                $themeJSON['id']
            );

            $theme = $this->themeService->createTheme($parameters);

            if($themeJSON['image']) {
                $this->themeService->uploadImagePreview($theme->getId(), sprintf('%s/%s', self::THEMES_PREVIEW_DIR, $themeJSON['image']));
            }
        }
    }
}