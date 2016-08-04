<?php
namespace CASS\Project\Bundles\Stage\Fixture;

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

        if(count($themes)) {
            foreach($themes as $themeJSON) {
                $this->createTheme($themeJSON);
                $this->lookupTree($json, $themeJSON['id']);
            }
        }
    }

    private function createTheme(array $themeJSON)
    {
        $this->output->writeln(sprintf(
            ' * [#NEW THEME] id: %d, title: %s, parent_id: %s',
            $themeJSON['id'],
            $themeJSON['title'],
            $themeJSON['parent_id']
        ));

        if(! $this->themeService->hasThemeWithId($themeJSON['id'])) {
            $parameters = new CreateThemeParameters(
                $themeJSON['title'],
                $themeJSON['description'],
                $themeJSON['image'],
                $themeJSON['parent_id'],
                $themeJSON['id']
            );
        }
    }
}