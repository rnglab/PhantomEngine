<?php 

/**
* SQLite driver
* @author rng
**/
class sqlite 
{
	
	public $_db;
	public $_query = "";
	public $_dbPath;
	
	/**
	* class construct 
	**/
	public function __construct( $dbPath )
	{
		/*sqlite db file path*/
		$this->_dbPath = $dbPath;		
		$this->_db = new SQLite3( $this->_dbPath );
	}

	/**
	* Executes an SQL query
	**/
	public function executeQuery()
	{
		if( empty( $this->_query ) ) { exit( "ERROR : QUERY can not to be empty! " ); }

		return $this->_db->exec( $this->_query  );
	}
	
	
	/**
    * Returns a string that has been properly escaped
	* @param sqlString $str
	* @return string
	**/
	public function escapeString( $str )
	{
		return $this->_db->escapeString($str);
	}
	
}