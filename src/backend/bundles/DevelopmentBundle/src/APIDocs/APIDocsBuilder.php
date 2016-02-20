<?php
namespace Development\APIDocs;

use Cocur\Chain\Chain;
use Symfony\Component\Yaml\Yaml;

class APIDocsBuilder
{
    /**
     * @var APIDocsBuilderRequest
     */
    private $apiDocsBuildRequest;

    public function __construct(APIDocsBuilderRequest $apiDocsBuildRequest)
    {
        $this->apiDocsBuildRequest = $apiDocsBuildRequest;
    }

    public function getApiDocsBuildRequest()
    {
        return $this->apiDocsBuildRequest;
    }

    public function build() {
        $request = $this->apiDocsBuildRequest;

        return Chain::create($request->getDirectories())
            ->filter(function /* list only existing directories */ ($directory) {
                return is_dir($directory);
            })
            ->map(function /* list files to merge */ ($directory) {
                $files = [
                    'merge' => [],
                    'paths' => [],
                    'definitions' => []
                ];

                if(file_exists($globalFile = "{$directory}/global.yml")) {
                    $files['merge'][] = $globalFile;
                }

                $pathsDir = "{$directory}/paths";
                $definitionsDir = "{$directory}/definitions";

                if(is_dir($pathsDir)) {
                    $files['paths'] = $this->recursiveListYAMLFiles($pathsDir);
                }

                if(is_dir($definitionsDir)) {
                    $files['definitions'] = $this->recursiveListYAMLFiles($pathsDir);
                }

                return $files;
            })
            ->map(function /* read yml files to arrays */ ($files) {
                $ymlParsed = [];

                foreach($files['merge'] as $file) {
                    $ymlParsed[] = Yaml::parse(file_get_contents($file));
                }

                foreach($files['paths'] as $file) {
                    $ymlParsed[] = ['paths' => Yaml::parse(file_get_contents($file))];
                }

                foreach($files['definitions'] as $file) {
                    $ymlParsed[] = ['definitions' =>  Yaml::parse(file_get_contents($file))];
                }

                return $ymlParsed;
            })
            ->reduce(function /* merge all bundle configs into swagger.json */ ($config, $yml) {
                foreach($yml as $ymlConfig) {
                    $config = array_merge_recursive($config, $ymlConfig);
                }

                return $config;
            }, [
                'paths' => [],
                'definitions' => []
            ])
        ;
    }

    private function recursiveListYAMLFiles($directory) {
        $files = [];

        foreach(scandir($directory) as $input) {
            switch($input) {
                case '.':
                case '..':
                    break;

                case is_dir($subDirectory = "{$directory}/{$input}"):
                    $files = array_merge($files, $this->recursiveListYAMLFiles($subDirectory));
                    break;

                case is_file(($file = "{$directory}/{$input}")) && preg_match('/\.yml$/', $file):
                    $files[] = $file;
                    break;
            }
        }

        return $files;
    }
}