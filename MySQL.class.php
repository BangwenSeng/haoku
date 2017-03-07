<?php
	const HOST = 'localhost';
	const PASS = '';
	const USER = 'root';
	const DB = 'test';
	const CHARSET = 'utf8';
	// echo 123;
	
	class MySQL
	{	
		public $link;

		protected static $obj;

		protected static $tabName;


		private function __construct( $tabName )
		{
			$this->link = mysqli_connect(HOST, USER, PASS, DB);

			mysqli_set_charset($this->link, CHARSET);

			self::$tabName = $tabName;

		}

		public static function getMySQLObj( $tabName )
		{
			if (is_null(self::$obj)) {

				self::$obj = new MySQL($tabName);
			}
			self::$tabName = $tabName;

			return self::$obj;
		}
		//查询方法
		public function select()
		{
			$sql = "select * from ".self::$tabName."";

			// echo $sql;

			return $this->query($sql);

		}

		public function query($sql)
		{
			$res = mysqli_query($this->link, $sql);

			if($res && mysqli_num_rows($res) > 0) {

				$list = [];

				while( $row= mysqli_fetch_assoc($res) ){

					$list[] = $row;
				}
			}

			return $list;
		}
	}
	
// echo 123;