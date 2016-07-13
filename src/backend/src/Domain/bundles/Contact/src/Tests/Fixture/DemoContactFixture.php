<?php
namespace Domain\Contact\Tests\Fixture;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Entity\Account;
use Domain\Account\Service\AccountService;
use Domain\Contact\Entity\Contact;
use Domain\Contact\Parameters\CreateContactParameters;
use Domain\Contact\Service\ContactService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Service\ProfileService;
use Zend\Expressive\Application;

final class DemoContactFixture implements Fixture
{
    /** @var Account[] */
    private $accounts = [];

    /** @var Profile[] */
    private $profiles = [];

    /** @var Contact[] */
    private $contacts_a1_p1 = [];

    public function up(Application $app, EntityManager $em)
    {
        $this->createDemoProfiles($app);
        $this->createProfileA1P1Contacts($app);
    }

    public function getAccount_A1(): Account
    {
        return $this->accounts[1];
    }

    public function getAccount_A2(): Account
    {
        return $this->accounts[2];
    }

    public function getAccount_A3(): Account
    {
        return $this->accounts[3];
    }

    public function getProfile_A1_P1(): Profile
    {
        return $this->profiles['a1']['p1'];
    }

    public function getProfile_A2_P1(): Profile
    {
        return $this->profiles['a2']['p1'];
    }

    public function getProfile_A2_P2(): Profile
    {
        return $this->profiles['a2']['p2'];
    }

    public function getProfile_A3_P1(): Profile
    {
        return $this->profiles['a3']['p1'];
    }

    public function getContacts_A1_P1(): array
    {
        return $this->contacts_a1_p1;
    }

    public function getContact_A1_P1_C1(): Contact
    {
        return $this->contacts_a1_p1[1];
    }

    public function getContact_A1_P1_C2(): Contact
    {
        return $this->contacts_a1_p1[2];
    }
    
    private function createDemoProfiles(Application $app)
    {
        $accountService = $app->getContainer()->get(AccountService::class);
        /** @var AccountService $accountService */
        $profileService = $app->getContainer()->get(ProfileService::class);
        /** @var ProfileService $profileService */

        $account_a1 = $accountService->createAccount('annie@gmail.com', '1234');
        $account_a2 = $accountService->createAccount('lulu@gmail.com', '1234');
        $account_a3 = $accountService->createAccount('irelia@gmail.com', '1234');

        $profile_p1 = $account_a1->getProfiles()->get(0);
        $profile_p2 = $account_a2->getProfiles()->get(0);
        $profile_p3 = $account_a3->getProfiles()->get(0);
        $profile_p4 = $profileService->createProfileForAccount($account_a2);

        $this->accounts = [
            1 => $account_a1,
            2 => $account_a2,
            3 => $account_a3,
        ];

        $this->profiles = [
            'a1' => [
                'p1' => $profile_p1,
            ],
            'a2' => [
                'p1' => $profile_p2,
                'p2' => $profile_p4,
            ],
            'a3' => [
                'p1' => $profile_p3,
            ]
        ];
    }
    
    private function createProfileA1P1Contacts(Application $app)
    {
        $contacts = [];

        $contactService = $app->getContainer()->get(ContactService::class); /** @var ContactService $contactService */

        $contacts[1] = $contactService->createContact(
            $this->getProfile_A1_P1(),
            (new CreateContactParameters($this->getProfile_A2_P1()->getId()))
        );
        $contacts[2] = $contactService->createContact(
            $this->getProfile_A1_P1(),
            (new CreateContactParameters($this->getProfile_A3_P1()->getId()))
        );

        $this->contacts_a1_p1 = $contacts;
    }
}