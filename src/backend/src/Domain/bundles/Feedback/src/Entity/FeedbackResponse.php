<?php
namespace Domain\Feedback\Entity;

use Application\Util\IdTrait;
/**
 * @Entity(repositoryClass="Domain\Feedback\Repository\FeedbackResponseRepository")
 * @Table(name="feedback_response")
 */
class FeedbackResponse
{
  use IdTrait;

}