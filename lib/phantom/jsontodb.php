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
	
	
	/**
	*  
	**/
	public function prepareKcTrQuery()
	{
		/*json file names için mapi hazırlıyoruz*/
		$maps = new maps();
		$map = $maps->getMap("_trKcMaps");		
		
		/*json dosyları için pathi hazırlıyoruz*/
		$this->_currentJsonPath = $this->_outputPath . "processBooksKC" . DS;
		
		/*mapi baz alarak json dosyalarını işlemeye başlıyoruz*/
		foreach ( $map as $key => $item )
		{
			$data = @file_get_contents( $this->_currentJsonPath . $item["name"] . ".json" );			
			if( $data ) 
			{
				$data = json_decode($data);
				$currentItemId = $key + 1;
				
				/** @TODO sqlite php driver verisonu ile ilgili multiple insert bugı var. Bu versiyon güncellendiğinde multiple insert e geçiş yapacağız **/
				//$this->_db->_query = "INSERT INTO phn_content (parent_id, language, body, body_ar, body_html, body_ar_html) VALUES ";					
				
				foreach ($data->result as $subKey => $subItem)
				{
					$this->_db->_query = "INSERT INTO phn_content (parent_id, language, body, body_ar, body_html, body_ar_html) VALUES ";
					$subItem->trContent     = $this->_db->escapeString( urldecode($subItem->trContent) );
					$subItem->arContent     = $this->_db->escapeString( urldecode($subItem->arContent) );
					$subItem->trContentHtml = $this->_db->escapeString( urldecode($subItem->trContentHtml) );
				    $subItem->arContentHtml = $this->_db->escapeString( urldecode($subItem->arContentHtml) );
					
					$this->_db->_query .= "( {$currentItemId}, 'tr', '{$subItem->trContent}', '{$subItem->arContent}', '{$subItem->trContentHtml}', '{$subItem->arContentHtml}' )";
					//$this->_db->_query .= ( count($data->result) > $subKey+1 ? ", " : "" );
					$this->_db->executeQuery();
				}
				
				//$this->_db->executeQuery();

				echo "OK => {$item["name"]} db process complated. <br>";
			} 
			else 
			{
				exit( "Error : File Not Found" . $this->_currentJsonPath . $item["name"] . ".json" );
			}
						
		}
	}
	
	
	
	/**
	 *
	 **/
	public function prepareKcTrReasonsQuery()
	{
		/*json file names için mapi hazırlıyoruz*/
		$maps = new maps();
		$map = $maps->getMap("_trKcMaps");
	
		/*json dosyları için pathi hazırlıyoruz*/
		$this->_currentJsonPath = $this->_outputPath . "processBooksReasonsKC" . DS;
	
		/*mapi baz alarak json dosyalarını işlemeye başlıyoruz*/
		foreach ( $map as $key => $item )
		{
			$data = @file_get_contents( $this->_currentJsonPath . $item["name"] . ".json" );
			if( $data )
			{
				$data = json_decode($data);
				$currentItemId = $key + 1;
	
				/** @TODO sqlite php driver verisonu ile ilgili multiple insert bugı var. Bu versiyon güncellendiğinde multiple insert e geçiş yapacağız **/
				//$this->_db->_query = "INSERT INTO phn_content (parent_id, language, body, body_ar, body_html, body_ar_html) VALUES ";
	
				foreach ($data->result as $subKey => $subItem)
				{
					$this->_db->_query = "INSERT INTO phn_items (id, name, reason, reason_html) VALUES ";

					$subItem->trContent = $this->_db->escapeString( urldecode($subItem->trContent) );
					$subItem->trContentHtml = $this->_db->escapeString( urldecode($subItem->trContentHtml) );
						
					$this->_db->_query .= "( {$currentItemId}, '{$item["name"]}', '{$subItem->trContent}', '{$subItem->trContentHtml}' )";
					//$this->_db->_query .= ( count($data->result) > $subKey+1 ? ", " : "" );
					$this->_db->executeQuery();
				}
	
				//$this->_db->executeQuery();
	
				echo "OK => {$item["name"]} db process complated. <br>";
			}
			else
			{
				exit( "Error : File Not Found" . $this->_currentJsonPath . $item["name"] . ".json" );
			}
	
		}
	}	
	
	
	
	
}


?>