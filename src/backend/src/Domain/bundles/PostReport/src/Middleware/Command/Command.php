<?php
namespace Domain\PostReport\Middleware\Command;
use Application\Command\Command as CommandInterface;
use Domain\PostReport\Service\PostReportService;

abstract class Command implements CommandInterface
{

  /** @var PostReportService */
  protected $postReportService;

  public function __construct(PostReportService $postReportService)
  {
    $this->postReportService = $postReportService;
  }
}