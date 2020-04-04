<?php
include_once('config.php');

class ShortURL
{
    protected static $chars = ALLOWED_CHARS;
    protected static $table = DB_TABLE;
    protected static $checkUrlExists = CHECK_URL;
    protected static $trackURL = TRACK_URL;

    protected $pdo;
    protected $timestamp;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->timestamp = $_SERVER["REQUEST_TIME"];
        $this->creator = $_SERVER['REMOTE_ADDR'];
    }

    public function convertURlToShortURl($url) {
        if (empty($url)) {
            throw new Exception("No URL was supplied.");
        }

        if ($this->checkForValidURL($url) == false) {
            throw new Exception(
                "URL does not have a valid format.");
        }
        
        if (self::$checkUrlExists) {
            if (!$this->checkURLExists($url)) {
                throw new Exception(
                    "URL does not appear to exist.");
            }
        }

        $shortCode = $this->checkURLStored($url);
        if ($shortCode == false) {
            $shortCode = $this->createShortURL($url);
        }

        return $shortCode;
    }

    protected function checkForValidURL($url) {
        return filter_var($url, FILTER_VALIDATE_URL,
            FILTER_FLAG_HOST_REQUIRED);
    }

    protected function checkURLExists($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }

    protected function checkURLStored($url) {
        $query = "SELECT shortURL FROM " . self::$table .
            " WHERE url = :long_url LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "long_url" => $url
        );
        $stmt->execute($params);

        $result = $stmt->fetch();

        return (empty($result)) ? false : $result["shortURL"];
    }

    protected function createShortURL($url) {
        $id = $this->insertURL($url);
        $shortCode = $this->convertIntToShortCode($id);
        $this->insertShortCode($id, $shortCode);
        return $shortCode;
    }

    protected function insertURL($url) {
        $query = "INSERT INTO " . self::$table .
            " (url, shortURL, created, creator) " .
            " VALUES (:url, :shortURL, :timestamp, :creator)";
        $stmnt = $this->pdo->prepare($query);
        $params = array(
            "url" => $url,
            "shortURL" => ' ',
            "timestamp" => $this->timestamp,
            "creator" => $this->creator
        );

        $stmnt->execute($params);

        return $this->pdo->lastInsertId();
    }

    protected function convertIntToShortCode($id) {
        $id = intval($id);
        if ($id < 1) {
            throw new Exception(
                "The ID is not a valid integer");
        }

        $length = strlen(self::$chars);
        // make sure length of available characters is at
        // least a reasonable minimum - there should be at
        // least 10 characters
        if ($length < 10) {
            throw new Exception("Length of chars is too small");
        }

        $code = "";
        while ($id > $length - 1) {
            // determine the value of the next higher character
            // in the short code should be and prepend
            $code = self::$chars[fmod($id, $length)] .
                $code;
            // reset $id to remaining value to be converted
            $id = floor($id / $length);
        }

        // remaining value of $id is less than the length of
        // self::$chars
        $code = self::$chars[$id] . $code;

        return $code;
    }

    protected function insertShortCode($id, $code) {
        if ($id == null || $code == null) {
            throw new Exception("Input parameter(s) invalid.");
        }
        $query = "UPDATE " . self::$table .
            " SET shortURL = :shortURL WHERE id = :id";
        $stmnt = $this->pdo->prepare($query);
        $params = array(
            "shortURL" => $code,
            "id" => $id
        );
        $stmnt->execute($params);

        if ($stmnt->rowCount() < 1) {
            throw new Exception(
                "Row was not updated with short code.");
        }

        return true;
    }

    public function shortCodeToUrl($code) {
        if (empty($code)) {
            throw new Exception("No short code was supplied.");
        }
    
        if ($this->validateShortCode($code) == false) {
            throw new Exception(
                "Short code does not have a valid format.");
        }
    
        $urlRow = $this->getURL($code);
        if (empty($urlRow)) {
            throw new Exception(
                "Short code does not appear to exist.");
        }
        
        if (self::$trackURL) {
            $this->incrementURLVisit($urlRow["id"]);
        }else{
            //single use of url 
            if($urlRow["hitCount"] ===  "-1"){
                return BASE_URL."error.php";
            }
            $this->setURLVisitOnce($urlRow["id"]);
        }
        
        return $urlRow["url"];
    }
    
    protected function validateShortCode($code) {
        return preg_match("|[" . self::$chars . "]+|", $code);
    }
    
    protected function getURL($code) {
        $query = "SELECT * FROM " . self::$table .
            " WHERE shortURL = :shortURL LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params=array(
            "shortURL" => $code
        );
        $stmt->execute($params);
    
        $result = $stmt->fetch();
        return (empty($result)) ? false : $result;
    }
    
    protected function incrementURLVisit($id) {
        $query = "UPDATE " . self::$table . " SET hitCount = hitCount + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "id" => $id
        );
        $stmt->execute($params);
    }

    protected function setURLVisitOnce($id) {
        $query = "UPDATE " . self::$table . " SET hitCount= -1  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "id" => $id
        );
        $stmt->execute($params);
    }
}