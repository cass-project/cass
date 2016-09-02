<?php
namespace CASS\Domain\Colors\Middleware\Command;

use CASS\Application\Command\Command;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Colors\Entity\Color;
use CASS\Domain\Colors\Service\ColorsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetColorsCommand implements Command
{
    /** @var ColorsService */
    private $colorsService;

    public function __construct(ColorsService $colorsService) {
        $this->colorsService = $colorsService;
    }

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
        return $responseBuilder
            ->setJson([
                'colors' => array_map(function(Color $color) {
                    return $color->toJSON();
                }, $this->colorsService->getColors())
            ])
            ->setStatusSuccess()
            ->build();
    }
}