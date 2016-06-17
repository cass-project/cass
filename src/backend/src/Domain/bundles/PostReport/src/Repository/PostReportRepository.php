<?php


namespace Domain\PostReport\Repository;


use Doctrine\ORM\EntityRepository;
use Domain\PostReport\Entity\PostReport;
use Domain\PostReport\Parameters\CreatePostReportParameters;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Exception\ProfileNotFoundException;

class PostReportRepository extends EntityRepository
{

  public function createPostReport(CreatePostReportParameters $createPostReportParameters):PostReport
  {
    $em = $this->getEntityManager();

    /** @var Profile $authorProfile */
    $authorProfile = $em->getRepository(Profile::class)->find($createPostReportParameters->getProfileId());
    if(is_null($authorProfile)) throw new ProfileNotFoundException("Profile {$createPostReportParameters->getProfileId()} not found ");

    $postReport = new PostReport();

    $postReport->setCreatedAt($createPostReportParameters->getCreatedAt())
      ->setDescription($createPostReportParameters->getDescription())
      ->setProfile($authorProfile)
      ->setReportTypes($createPostReportParameters->getReportTypes());


    $em->persist($postReport);
    $em->flush([$postReport]);

    return $postReport;
  }

  public function getPostReports(int $type, $offset, $limit): array
  {
    $r = $this->getEntityManager()->getRepository(PostReport::class);
    $result = $r->findBy([],null,$limit,$offset);

    return array_filter($result, function(PostReport $postReport)use ($type){
      return array_walk($postReport->getReportTypes(), function($report_type)use($type){
        return $report_type == $type;
      });
    });


  }
}