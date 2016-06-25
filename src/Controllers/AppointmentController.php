<?php
namespace Himl\Controllers;

use Himl\Models\Calendar;
use Himl\Models\User;
use Himl\Models\Appointment;
use Himl\Models\CalendarView;

use \Exception;
use \DateTime;
use \DateInterval;

class AppointmentController extends BaseController
{
    public function index() {

        $date = null;
        if(isset($_GET['date']) && !empty($_GET['date']))
            $date = $_GET['date'];

        try {
            $fromDate = new DateTime($date);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        $oneMonthLater = new DateTime($date);
        $oneMonthLater->add(new DateInterval('P1M'));

        $calender = new Calendar($fromDate, $oneMonthLater);
        $data['datePeriod'] = $calender->getAllDatesBetween();
        $data['freeDates'] = $calender->getFreeDates();
        $data['fromDate'] = $fromDate->format('Y-m-d');

        return $this->loadView('src/Views/appointment/index.php',$data);
    }

    public function get() {

        $date = null;
        if(isset($_GET['date']) && !empty($_GET['date']))
            $date = $_GET['date'];

        $fromDate =  new DateTime($date);
        $oneMonthLater = new DateTime($date);
        $oneMonthLater->add(new DateInterval('P1M'));

        $calender = new Calendar($fromDate, $oneMonthLater);

        $calendarView = new CalendarView($calender);
        header('Content-Type: application/json');
        echo $calendarView->render();
        exit;

    }

    public function post() {
        header('Content-Type: application/json');
        try {
            if(!$_POST)
                throw new Exception('No parameter supplied!');

            $user = new User($_POST['name'], $_POST['email']);

        } catch(Exception $e) {
            http_response_code(400);
            $data['status'] = 'Error';
            $data['msg'] = $e->getMessage();
            echo json_encode($data);
            exit;
        }

        $appointment = new Appointment($_POST['date'], $user);
        $appointment->addAppointment();
        exit;

    }
}
