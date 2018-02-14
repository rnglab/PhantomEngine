<?php 

/**
* Push Json values to Db 
* @author rng
**/
class jsonToDb 
{
	public  $_outputPath;
	public  $_db;
	public  $_driver;
	public  $_task;
	public  $_currentJsonPath;
	
	/**
	* class construct
	**/
	public function __construct()
	{
		$this->_outputPath = ROOT_PATH . DS . "output" . DS;
		$this->setDatabaseDriver();
		$this->runTargetProcess();
	}
	
	/**
	* set current database driver 
	* @return boolean
	**/
	public function setDatabaseDriver()
	{		
		/**Load database driver**/
		$this->_driver = ( isset($_GET["driver"]) ? $_GET["driver"] : false );
		if( $this->_driver == "sqlite" )
		{
			require_once ROOT_PATH . DS . "lib" . DS . "database" . DS . "sqlite.php";
			$this->_db = new sqlite( ROOT_PATH . DS . "output" . DS . "db" . DS . "data.db" );//sqlite db dosyası
		}/** @TODO bu noktada mysql vb diğer driverlar eklenebilir. **/
		else
		{
			exit("Invalid database driver - " . __FILE__ . " on line " .  __LINE__);
		}	

		return true;
	}
	
	
	/**
	* start target process 
	* @return boolean
	**/
	public function runTargetProcess()
	{
		/**start target process**/
		if( !isset($_GET["task"]) ) { exit("Invalid process task - " . __FILE__ . " on line " .  __LINE__); }
		
		$this->$_GET["task"]();
		
		return true;
	}
}


?>