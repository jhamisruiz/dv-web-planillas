<?php
class DotEnv
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    protected $path;


    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        }
        $this->path = $path;
    }

    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}
(new DotEnv(__DIR__ . '/../../.env'))->load();

/* ============================================================
`//////////////////////////- config hos_name -////////////
===============================================================*/
    $parts= array(
        "www"   =>  getenv('APP_URL'),
        "src"   =>  "",
        "logo"   =>  "",
        "_file" =>  getenv('_FILE'),
    );

    if (substr($parts["www"], -1)=="/") {
        $host= substr($parts["www"], 0, -1);
    }else{
        $host= $parts["www"];
    }

/* ============================================================
`//////////////////////////- config data base -////////////
===============================================================*/

    $DATABSE= array(
        "HOST"    => getenv('DB_HOST'),
        "DB_NAME" => getenv('DB_DATABASE'),
        "DB_USER" => getenv('DB_USERNAME'),
        "DB_PASS" => getenv('DB_PASSWORD'),
        "PORT"    => getenv('DB_PORT'),
    );
/* ////////////////////////////////////////////////////////// */

define("URL_HOST_WEB", $host);
define("FOLDER_URL_IMG_ALMACEN", $parts["_file"]);

/* ////////////////////////////////////////////////////////// */

define("HOST", $DATABSE["HOST"]);
define("DB_NAME", $DATABSE["DB_NAME"]);
define("DB_USER", $DATABSE["DB_USER"]);
define("DB_PASS", $DATABSE["DB_PASS"]);
define("PORT", $DATABSE["PORT"]);

$sgbd= "mysql:host=". HOST. ";dbname=". DB_NAME;

define("SGBD", $sgbd);