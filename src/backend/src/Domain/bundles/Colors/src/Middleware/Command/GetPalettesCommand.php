<?php
namespace Domain\Colors\Middleware\Command;

use CASS\Application\Command\Command;
use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Colors\Entity\Palette;
use Domain\Colors\Service\ColorsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetPalettesCommand implements Command
{
    /** @var ColorsService */
    private $colorsService;

    public function __construct(ColorsService $colorsService) {
        $this->colorsService = $colorsService;
    }

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
        return $responseBuilder
            ->setJson([
                'palettes' => array_map(function(Palette $palette) {
                    return $palette->toJSON();
                }, $this->colorsService->getPalettes())
            ])
            ->setStatusSuccess()
            ->build();
    }
}