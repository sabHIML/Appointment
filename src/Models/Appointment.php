<?php
namespace Himl\Models;

class Appointment
{
    private $date;
    private $user;

    public function __construct($date, $user)
    {
        $this->setDate($date);
        $this->setUser($user);
    }

    public function addAppointment()
    {
        echo CalendarMapper::save($this);
        $this->sendReminder();
    }

    public function sendReminder()
    {
        $body = "Dear " . $this->getUser()->getName() .", You have an appointment on " . $this->getDate();
        mail($this->getUser()->getEmail(),'Reminder!',$body);

    }

    /* Getters and Setters */

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}