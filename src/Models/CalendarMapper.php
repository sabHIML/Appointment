<?php
namespace Himl\Models;
use \PDO;

class CalendarMapper
{
    private static $instance = NULL;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $config = parse_ini_file(__DIR__.'/../config/config.ini');
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            try {
                self::$instance = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['database'] , $config['user'] ,
                    $config['password'] , $pdo_options);

            } catch(\Exception $e) {
                echo 'ERROR : '. $e->getMessage();
                exit;
            }


        }
        return self::$instance;
    }

    public static function init()
    {
        $db = self::getInstance();

        $createTables = "CREATE TABLE IF NOT EXISTS `user` (
          `user_id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(50) NOT NULL,
          `email` varchar(50) NOT NULL,
          PRIMARY KEY (`user_id`),
          UNIQUE KEY `email_UNIQUE` (`email`)
        ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';

        CREATE TABLE IF NOT EXISTS `appointment` (
          `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
          `date` date DEFAULT NULL,
          `user_id` int(11) DEFAULT NULL,
          PRIMARY KEY (`appointment_id`),
          UNIQUE KEY `unique_index` (`date`,`user_id`),
          KEY `fk_appointment_1_idx` (`user_id`),
          CONSTRAINT `fk_appointment_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci'";

        $result = $db->query($createTables);
        if (!$result) {
            echo 'Error code : '.$db->errorCode();
            print_r($db->errorInfo());
            return false;
        }
        return true;

    }

    public static function save(Appointment $appointment)
    {
        $db = self::getInstance();

        try {
            $stmt = $db->prepare("SELECT user_id
                      FROM `user` WHERE email = ?");

            $stmt->execute(array($appointment->getUser()->getEmail()));

            $user_id = null;
            while ($row = $stmt->fetch(PDO::FETCH_OBJ))
            {
                $user_id = $row->user_id;
            }
            $db->beginTransaction();
            if(is_null($user_id))
            {
                //add user record if not exist
                $stmt = $db->prepare("INSERT INTO `user` VALUE (NULL ,?,?)");
                $result = $stmt->execute(array($appointment->getUser()->getName(),$appointment->getUser()->getEmail()));
                if(!$result) {
                    $data['status'] = 'Error';
                    $data['msg'] = 'Error while manage user info!';
                    $db->rollback();
                }
                $user_id = $db->lastInsertId();
                $stmt = null;
            }

            $stmt = $db->prepare("INSERT INTO `appointment` VALUE (null,?, ?)");
            $result = $stmt->execute(array($appointment->getdate(), $user_id));

            if(!$result) {

                $data['status'] = 'Error';
                $data['msg'] = 'Error while manage appointment!';
                if($stmt->errorCode() == 23000) {
                    $data['msg'] = 'Already appointed !';
                }
                $db->rollback();
            }
            $db->commit();
            $data['status'] = 'Success';
            $data['msg'] = 'Appointment successfully added';

            $data['data'][] = array('date'=>$appointment->getdate(),
               'name' => $appointment->getUser()->getName(),
               'email' => $appointment->getUser()->getEmail());

            return  json_encode($data);
        }
        catch (PDOException $e) {

            $data['status'] = 'Error';
            $data['msg'] = 'Error while manage appointment!';

            if($stmt->errorCode() == 23000) {
                $data['msg'] = 'Already appointed !';
            }
            $db->rollback();
            return  json_encode($data);
        }

    }

    public static function load($startDate, $endDate)
    {
        $startDate = $startDate->format('Y-m-d');
        $endDate = $endDate->format('Y-m-d');

        $db = CalendarMapper::getInstance();

        $data = array();
        try {
            $stmt = $db->prepare("SELECT *
                      FROM `appointment` a LEFT JOIN `user` u on a.user_id = u.user_id
                      WHERE a.date BETWEEN ? and ?");

            $stmt->execute(array($startDate, $endDate));

            $data['data'] = array();
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $data['data'][] = array('date'=>$row->date, 'name' => $row->name, 'email' => $row->email);
            }
            $stmt = null;
            return json_encode($data);
        }
        catch (PDOException $e) {
//            print $e->getMessage();

        }
    }
    public static function getAllocatedDates($startDate, $endDate)
    {
        $startDate = $startDate->format('Y-m-d');
        $endDate = $endDate->format('Y-m-d');

        $db = CalendarMapper::getInstance();

        $data = array();
        try {
            $stmt = $db->prepare("SELECT DISTINCT (date) as date
                      FROM `appointment` a
                      WHERE a.date BETWEEN ? and ?
                      ORDER BY a.date");

            $stmt->execute(array($startDate, $endDate));

            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $data[] = $row->date;
            }
            $stmt = null;
            return $data;
        }
        catch (PDOException $e) {
            print $e->getMessage();
        }

    }


}
