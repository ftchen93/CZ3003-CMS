<?php
include_once MODEL_PATH . "MySQL_DB.php";

class User {
    private $userid;
	private $username;
	private $password;

	function __construct($username = "", $password = "") {
        $this->userid = -1;
        if ($username != "")
            $username = MySQL_DB::escape_str($username);
        if ($password != "")
            $password = MySQL_DB::escape_str($password);
        $this->username = $username;
        $this->password = $password;
	}

    public function getUserid()
    {
        return $this->userid;
    }

    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

	public function verifyCredentials() {
		$query = "SELECT user_id, user_hash FROM `Users` WHERE user_name='$this->username'";
		$result = MySQL_DB::query($query);
		if ($result) {
            $row = null;
            if ($result->num_rows > 0)
                $row = MySQL_DB::fetch_row($result);
            MySQL_DB::close_result($result);
            if ($row != null) {
                if (password_verify($this->password, $row["user_hash"])) {
                    $this->userid = $row["user_id"];
                    return true;
                }
            }
        }
        return false;
	}

	public function createAccount() {
	    // The length of the resulting hash may change throughout PHP version changes
        // Recommended to set in database to VARCHAR(255)
		$user_hash = password_hash($this->password, PASSWORD_DEFAULT);
        $query = "INSERT INTO `Users` (user_name, user_hash)
                  VALUES ('$this->username', '$user_hash')";
		$result = MySQL_DB::query($query);
		if ($result && $result["affected"]) {
            $this->userid = MySQL_DB::getLastInsertID();
			return true;
		}
		else {
			return false;
		}
	}

	public function isUserExist() {
		$query = "SELECT user_name FROM `Users` WHERE user_name='$this->username'";
		$result = MySQL_DB::query($query);
		if ($result) {
            $row = null;
            if ($result->num_rows > 0)
                $row = MySQL_DB::fetch_row($result);
            MySQL_DB::close_result($result);
            if ($row != null) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
	}
}
?>