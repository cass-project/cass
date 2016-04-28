<?php
namespace EmailVerification\Service;

use Account\Entity\Account;
use Auth\Service\CurrentAccountService;
use EmailVerification\Repository\EmailVerificationRepository;
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
        $message = "Open the link below:\nhttp://localhost:8080/backend/api/email-verification/confirm/{$token}";
        $body = [
            "to" => $requestedEmail,
            "subject" => $subject,
            "message" => $message,
        ];
        mail($body['to'], $body['subject'], $body['message']);
        return;
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