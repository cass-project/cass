<?php
namespace Auth\Entity;

/**
 * Class Account
 * @package Data\Entity
 * @Entity(repositoryClass="Auth\Repository\AccountRepository")
 * @Table(name="account")
 */
class Account
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $email;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $phone;

    /**
     * @Column(type="string")
     * @var string
     */
    private $password;

    /**
     * @Column(type="string")
     * @var string
     */
    private $token;

    /**
     * @Column(type="string")
     * @var string
     */
    private $tokenExpired;

    /**
     * @OneToMany(targetEntity="Auth\Entity\OAuthAccount", mappedBy="account")
     */
    private $oauth2;

    public function getId()
    {
        return $this->id;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getAPIKey()
    {
        return $this->password;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token=null)
    {
        $this->token = $token===null?bin2hex(random_bytes(30)):$token;
        return $this;
    }

    public function getTokenExpired()
    {
        return $this->tokenExpired;
    }

    public function setTokenExpired(int $tokenExpired)
    {
        $this->tokenExpired = $tokenExpired;
        return $this;
    }
}