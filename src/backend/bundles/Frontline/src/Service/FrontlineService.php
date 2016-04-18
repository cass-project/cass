<?php
namespace Frontline\Service;

use Frontline\Service\Exporter\SessionExporter;

class HasExporterWithSameIdException extends \Exception {}

class FrontlineService implements FrontlineExporter
{
    /** @var FrontlineExporterManager */
    static $exporters;

    public function exportToJSON() {
        return array_reduce(self::$exporters->getAllExporters(), function(array $carry, $exporter) {
            if($exporter instanceof FrontlineExporter) {
                $result = $exporter->exportToJSON();
            }else if(is_callable($exporter)) {
                $result = $exporter();
            }else{
                throw new \Exception('Invalid exporter');
            }

            return array_merge($carry, $result);
        }, []);
    }

}

FrontlineService::$exporters = new FrontlineExporterManager();

class FrontlineExporterManager
{
    /** @var FrontlineExporter[]|Callable[] */
    private $exporters = [];

    public function __construct()
    {
        $this->exporters['session'] = new SessionExporter();
    }

    public function getSession(): SessionExporter
    {
        return $this->exporters['session'];
    }

    public function getAllExporters()
    {
        return $this->exporters;
    }

    public function addExporter(string $id,  $exporter)
    {
        if($this->hasExporterWithId($id)) {
            throw new HasExporterWithSameIdException(sprintf('Exported with id "%s" is already exists', $id));
        }

        $this->exporters[$id] = $exporter;
    }

    public function removeExporter(string $id)
    {
        if($this->hasExporterWithId($id)) {
            unset($this->exporters[$id]);
        }
    }

    public function hasExporterWithId(string $id)
    {
        return isset($this->exporters[$id]);
    }
}