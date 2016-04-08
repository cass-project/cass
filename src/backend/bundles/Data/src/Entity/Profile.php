<?php

namespace Data\Entity;

/**
 * @Entity(repositoryClass="Data\Repository\Post\PostRepository")
 * @Table(name="profile")
 */
class Profile
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Data\Entity\Account",cascade={"persist"})
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * @Column(type="string")
     * @var string
     */
    private $call;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @Column(type="string")
     * @var string
     */
    private $nick;

    /**
     * @Column(type="string")
     * @var string
     */
    private $surname;

    /**
     * @Column(type="string")
     * @var string
     */
    private $patronymic;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    private $gender;

    /**
     * @Column(type="datetime")
     * @var string
     */
    private $birthday;

    /**
     * @Column(type="string")
     * @var string
     */
    private $avatar;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id) : self
    {
        $this->id = $id;
        return $this;
    }

    public function getAccount() : Account
    {
        return $this->account;
    }

    public function setAccount($account) : self
    {
        $this->account = $account;
        return $this;
    }

    public function getCall()
    {
        return $this->call;
    }

    public function setCall($call) : self
    {
        $this->call = $call;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function getNick()
    {
        return $this->nick;
    }

    public function setNick($nick) : self
    {
        $this->nick = $nick;
        return $this;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname) : self
    {
        $this->surname = $surname;
        return $this;
    }

    public function getPatronymic()
    {
        return $this->patronymic;
    }

    public function setPatronymic($patronymic) : self
    {
        $this->patronymic = $patronymic;
        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday) : self
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar) : self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender) : self
    {
        $this->gender = $gender;
        return $this;
    }
}