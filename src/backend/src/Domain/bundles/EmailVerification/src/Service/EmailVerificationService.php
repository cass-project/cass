<?php
namespace Domain\EmailVerification\Service;

use Domain\Account\Entity\Account;
use Domain\Auth\Service\CurrentAccountService;
use Domain\EmailVerification\Repository\EmailVerificationRepository;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class EmailVerificationService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var EmailVerificationRepository */
    private $emailVerificationRepository;

    public function __construct(
        CurrentAccountService $currentAccountService,
        EmailVerificationRepository $emailVerificationRepository,
        AMQPStreamConnection $AMQPStreamConnection
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->emailVerificationRepository = $emailVerificationRepository;
        $this->AMQPStreamConnection = $AMQPStreamConnection;
    }

    public function requestForProfile(Account $forAccount, string $requestedEmail)
    {
        $token =  md5(uniqid(rand(), TRUE));
        $subject = "Email confirmation";
        $message = "Open the link below:\n http://localhost:8080/backend/api/email-verification/confirm/{$token}";

        $AMQPChannel = $this->AMQPStreamConnection->channel();
        $AMQPChannel->queue_declare('sendMail');
        $AMQPChannel->basic_publish(
            new AMQPMessage(
                json_encode([
                    "to" => $requestedEmail,
                    "subject" => $subject,
                    "message" => $message,
                ])
            ), '', 'sendMail'
        );

        $this->emailVerificationRepository->create($forAccount, $token);
    }

    public function confirm(string $token)
    {
        throw new \Exception('Not implemented');
    }
}