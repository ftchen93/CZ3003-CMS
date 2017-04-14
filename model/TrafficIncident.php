<?php
include_once MODEL_PATH . "MySQL_DB.php";

abstract class IncidentStatus {
    const PENDING = 0;
    const APPROVED = 1;
    const DEACTIVATED = 2;
}

class TrafficIncident
{
    private $id;
    private $type;
    private $lat;
    private $lng;
    private $msg;
    private $status; /** 0 - pending approval, 1 - approved, 2 - deactivated **/
    private $reportTime;

    /**
     * TrafficIncident constructor.
     * @param int $id
     * @param $type
     * @param $lat
     * @param $lng
     * @param $msg
     * @param int $status
     */
    public function __construct($id = -1, $type, $lat, $lng, $msg, $status = IncidentStatus::PENDING, $reportTime = null)
    {
        $this->id = $id;
        $this->type = MySQL_DB::escape_str($type);
        $this->lat = floatval($lat);
        $this->lng = floatval($lng);
        $this->msg = MySQL_DB::escape_str($msg);
        $this->status = $status;
        if ($reportTime instanceof DateTime)
            $this->reportTime = $reportTime;
        else
            $this->reportTime = strtotime($reportTime);

        if ($reportTime == null)
            $this->reportTime = new DateTime();
        else
            $this->reportTime = $reportTime;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = MySQL_DB::escape_str($type);
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return floatval($this->lat);
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = floatval($lat);
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return floatval($this->lng);
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = floatval($lng);
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = MySQL_DB::escape_str($msg);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return intval($this->status);
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = intval($status);
    }

    /**
     * @return mixed
     */
    public function getReportTime()
    {
        return $this->reportTime;
    }

    public function getReportTimeAsStr()
    {
        return $this->reportTime->format("Y-m-d H:i:s");
    }

    /**
     * @param mixed $reportTime
     */
    public function setReportTime($reportTime)
    {
        $this->reportTime = $reportTime;
    }

    public function saveIncident() {
        $query = "INSERT INTO `Traffic_Incidents` (type, lat, lng, msg, status, report_time)
                  VALUES ('$this->type', $this->lat, $this->lng, '$this->msg', $this->status, '" . $this->getReportTimeAsStr() . "')";
        $result = MySQL_DB::query($query);
        if ($result && $result["affected"]) {
            $this->id = MySQL_DB::getLastInsertID();
            return true;
        }
        else {
            error_log(MySQL_DB::get_error());
            return false;
        }
    }

    public function updateStatus() {
        $query = "UPDATE `Traffic_Incidents` SET status=$this->status WHERE id=$this->id";
        $result = MySQL_DB::query($query);
        if ($result && $result["affected"]) {
            return true;
        }
        else {
            error_log(MySQL_DB::get_error());
            return false;
        }
    }

    public static function retrieveAll($status) {
        $query = "SELECT * FROM `Traffic_Incidents` WHERE status=$status";
        $result = MySQL_DB::query($query);
        if ($result) {
            $rows = null;
            if ($result->num_rows > 0)
                $rows = MySQL_DB::fetch_all_row($result);
            MySQL_DB::close_result($result);
            if ($rows != null) {
                $incidents = array();
                foreach ($rows as $row) {
                    $incidents[] = new TrafficIncident($row["id"], $row["type"], $row["lat"], $row["lng"], $row["msg"], $row["status"], new DateTime($row["report_time"]));
                }
                return $incidents;
            }
        }
        return null;
    }

    public static function updateStatusByID($id, $status) {
        $query = "UPDATE `Traffic_Incidents` SET status=$status WHERE id=$id";
        $result = MySQL_DB::query($query);
        if ($result && $result["affected"]) {
            return true;
        }
        else {
            error_log(MySQL_DB::get_error());
            return false;
        }
    }

    public static function getIncidentByID($id) {
        $query = "SELECT * FROM `Traffic_Incidents` WHERE id=$id";
        $result = MySQL_DB::query($query);
        if ($result) {
            $row = null;
            if ($result->num_rows > 0)
                $row = MySQL_DB::fetch_row($result);
            MySQL_DB::close_result($result);
            if ($row != null) {
                return new TrafficIncident($row["id"], $row["type"], $row["lat"], $row["lng"], $row["msg"], $row["status"], new DateTime($row["report_time"]));
            }
        }
        return null;
    }
}
?>