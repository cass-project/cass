<?php


namespace Domain\PostReport\Service;


use Domain\PostReport\Entity\PostReport;
use Domain\PostReport\Parameters\CreatePostReportParameters;
use Domain\PostReport\Repository\PostReportRepository;

class PostReportService
{

  /** @var PostReportRepository  */
  protected $postReportRepository;

  public function __construct(PostReportRepository $postReportRepository)
  {
    $this->postReportRepository = $postReportRepository;
  }

  public function createPostReport(CreatePostReportParameters $createPostReportParameters):PostReport
  {
    return $this->postReportRepository->createPostReport($createPostReportParameters);
  }

  public function getPostReports(int $type, int $offset, int $limit): array
  {
    return $this->postReportRepository->getPostReports($type, $offset, $limit);
  }
}