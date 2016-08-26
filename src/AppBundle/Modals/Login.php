<?php

namespace AppBundle\Modals;

class Login

{
	private $username;

    private $password;

    private $level;

    private $name;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
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
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }
    public function getLevel()
    {
        return $this->level;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
}

?>