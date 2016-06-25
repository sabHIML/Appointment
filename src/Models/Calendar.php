<?php
namespace Himl\Models;

use \DateTime;

class Calendar
{
    private $startDate;
    private $endDate;
    private $appointmentList;

    public function __construct(DateTime $startDate, DateTime $endDate)
    {

        $this->setStartDate($startDate);
        $this->setEndDate($endDate);

    }


    public function getDiffDays()
    {
        return date_diff($this->getStartDate(),$this->getEndDate());
    }

    public function getFreeDates()
    {
        $allocatedDateList = (array) CalendarMapper::getAllocatedDates($this->getStartDate(),$this->getEndDate());

        $datePeriod = $this->getAllDatesBetween($this->getStartDate(),$this->getEndDate());

        $freeDates = array();
        foreach($datePeriod as $date) {
            if(!in_array( $date->format('Y-m-d'), $allocatedDateList))
                $freeDates[]  = $date->format('Y-m-d');
        }

         return $freeDates;

    }

    public function getAllDatesBetween() {

        return new \DatePeriod(
            $this->getStartDate(),
            new \DateInterval('P1D'),
            $this->getEndDate()->modify('+1 day')
        );
    }

    /**
     * @return mixed
     */
    public function getAppointmentList()
    {
        try {
            $this->appointmentList = CalendarMapper::load($this->getStartDate(), $this->getEndDate());
            return $this->appointmentList;
        } catch(Exception $e) {
            return json_encode(array());
        }
    }

    /**
     * @param mixed $appointmentList
     */
    public function setAppointmentList($appointmentList)
    {
        $this->appointmentList = $appointmentList;
    }

    /**
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate( DateTime $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

}