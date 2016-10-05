<?php
namespace CASS\Chat\Bundles\Contact\Entity;

class Contact
{
    private $profileId;
    private $contactProfileId;

    /**
     * @return mixed
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * @param mixed $profileId
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }

    /**
     * @return mixed
     */
    public function getContactProfileId()
    {
        return $this->contactProfileId;
    }

    /**
     * @param mixed $contactProfileId
     */
    public function setContactProfileId($contactProfileId)
    {
        $this->contactProfileId = $contactProfileId;
    }


}