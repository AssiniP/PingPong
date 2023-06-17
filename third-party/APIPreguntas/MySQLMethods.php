<?php
class MySQLMethods
{

    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    private $configFile = 'config/config.ini';

    public function __construct()
    {
        $config = $this->getArrayConfig();
        $this->host     = $config['servername'];
        $this->db       = $config['database'];
        $this->user     = $config['username'];
        $this->password =  $config['password'];
        $this->charset  = 'utf8mb4';
    }

    function connect()
    {

        try {


            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            //$pdo = new PDO($connection, $this->user, $this->password, $options);
            $pdo = new PDO($connection, $this->user, $this->password);

            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection: ' . $e->getMessage());
        }
    }

    private function getArrayConfig() {
        return parse_ini_file($this->configFile);
    }
}
