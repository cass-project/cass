<?php
namespace Data\Entity;

/**
 * Class Account
 * @package Data\Entity
 * @Entity()
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
}