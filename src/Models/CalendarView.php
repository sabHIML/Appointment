<?php
namespace Himl\Models;


class CalendarView
{

    private $calendar;


    public function __construct(Calendar $calendar)
    {
        $this->setCalendar($calendar);
    }

    public function render()
    {
        $calender = $this->getCalendar();
        return $calender->getAppointmentList();
    }

    /**
     * @return mixed
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * @param mixed $calendar
     */
    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
    }
}
