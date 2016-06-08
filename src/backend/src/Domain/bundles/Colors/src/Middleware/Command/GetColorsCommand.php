<?php
namespace Domain\Colors\Middleware\Command;

use Application\Command\Command;
use Application\REST\Response\ResponseBuilder;
use Domain\Colors\Entity\Color;
use Domain\Colors\Service\ColorsService;
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