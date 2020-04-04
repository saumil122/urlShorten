# Assumptions

Below are the settings (CONFIG.PHP file) to run this code in Local/Offline system:

<code>
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/urlShorten/');
</code>

Where "urlShorten" is my project directory.




<code>
define('CHECK_URL', FALSE);
</code>

- If "CHECK_URL" is set to FALSE, the system will not check whether the URL is exists or not.
- If "CHECK_URL" is set to TRUE, the system will validat the URL using curl().




<code>
define('TRACK_URL', FALSE);
</code>

- If "TRACK_URL" is set to FALSE, the generated short URL will be used only once.
- If "TRACK_URL" is set to TRUE, the system will store the number of referrals for the specific URL and allowed to use the generated short URL multiple times.


<code>
define('ALLOWED_CHARS', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
</code>

- The system will generate the "Short URL" from the "ALLOWED_CHARS".




<pre>
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
</pre>

The function "convertIntToShortCode()" in class file will generates the Short URL.
