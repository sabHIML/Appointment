<?php
namespace Himl\Models;
use \Exception;

class User
{
    private $name;
    private $email;

    public function __construct($name, $email)
    {

        if ((preg_match("/^[a-zA-Z0-9 .-]+$/", $name) && strlen($name) < 50)
        && (preg_match("/^[a-zA-Z0-9.-_]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $email))) {

            $this->setEmail($email);
            $this->setName($name);
        } else {
            throw new Exception('Invalid name or email');
        }
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}