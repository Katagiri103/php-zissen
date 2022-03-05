<?php  
    //データベースに簡単に接続するための情報を記載

    class DB{
        private $host;
        private $dbname;
        private $portNumber;
        private $user;
        private $pass;
        protected $connect;


        function __construct($host,$dbname,$portNumber,$user,$pass){
            $this->host = $host;
            $this->dbname = $dbname;
            $this->portNumber = $portNumber;
            $this->user = $user;
            $this->pass = $pass;
        }

        //データベースに接続するメソッド
        public function connectDb(){
            $this->connect = new PDO('mysql:host='.$this->host.';port='.$this->portNumber.';dbname='.$this->dbname, $this->user, $this->pass);
            if(!$this->connect){
                echo "DBに接続できませんでしたよ？";
                die();
            }
        }
    }
?>