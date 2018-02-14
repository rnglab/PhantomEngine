<?php 


/**
* class Base
* Core Class for Phantom Engine
* @author RNG
**/
class Base {
	
    public $phantomPath;  /*phantom library path*/
    public $jsPath;       /*phantom js file path*/
    public $processJsPath;/*phantom js process files path*/
    public $task;         /*current task*/
    public $pjCode;       /*phantom js command*/
    public $pjComand;     /*phantom execute command*/
    public $result;       /*result of phantom process*/
    public $outputPath;   /*save path*/	
	public $outputPathTr; /*save path*/	
	public $outputPathEn; /*save path*/	
	public $canRemoveProcessJsFile; /*flag valuse for projess js file deletesupport*/	
	
	/**
	* class construct
	**/
	public function __construct()
	{
		/*define paths*/
		$this->phantomPath = ROOT_PATH . DS . "lib" . DS . "phantom_library" . DS;
        $this->jsPath = ROOT_PATH. DS . "js" . DS;
        $this->processJsPath = ROOT_PATH. DS . "js" . DS ."process_files" .DS;
        $this->outputPath = ROOT_PATH . DS . "output" . DS;
		$this->outputPathTr = ROOT_PATH . DS . "output" . DS . "tr" .DS;
		$this->outputPathEn = ROOT_PATH . DS . "output" . DS . "en" .DS;
		$this->canRemoveProcessJsFile = true;
		
		$this->checkOS();		
		
		/*phantom js dosyalarını store edeceğimiz dizini kontrol ediyoruz*/
		if(!is_dir( $this->jsPath )){
			mkdir( $this->jsPath, 777 );
		}
		
	}
	
	
	/**
	* check OS and set phantomjs lib path
	**/
	private function checkOS()
	{
	    $libraryMap= array();

	    $this->phantomPath .= $libraryMap[php_uname($mode='s')];
	 	
	 	$this->checkPhantomLib();
	}
	
	
	/**
	* check phantom lib exists 
	**/
	private function checkPhantomLib()
	{
		if ( !file_exists($this->phantomPath) ){
			exit( 'ERROR : PHANTOM LIB NOT FOUND.<br>' . $this->phantomPath );
		}
	} 
	
	
	/**
	* executes phantomjs command line
	**/
	public function executePhantom()
	{
        if( empty($this->pjCode) ){
            exit('ERROR : phantomjs code is empty'.$this->pjCode);
        }

        /*phantom js kodunu kaydediyoruz*/
        $time = time();
        $jsFileName = $this->jsPath . $_GET["task"] . $time . ".js";
        @file_put_contents( $jsFileName, $this->pjCode );

        /* phantom lib path + phantom js file */
        $this->pjComand =  escapeshellcmd( $this->phantomPath ." ". $jsFileName );

        exec( $this->pjComand, $output, $retval );

        if( !empty($output)){
            $this->result = $output[0];
        }

        /*js komut dosyasını siliyoruz*/
        if( $this->canRemoveProcessJsFile ) {
            unlink( $jsFileName );
        }
	}
	
	
	/**
	* save result data to file
	* @param string filename to save.
	* @param string data will be stored.
	* @param string pathname 
	**/     
	public function saveToFile($filename, $data, $path )
	{		
		if( empty($this->result) || $this->result == "null" ){
			echo "ERROR : NO DATA RECEIVED.<br>" . $this->result ."<br>";
			return;
		}

		$this->checkErrors();

		/*phantom js dosyalarını store edeceğimiz dizinleri kontrol ediyoruz*/
		if(!is_dir( $this->outputPath )){ mkdir( $this->outputPath, 777 ); }
		if(!is_dir( $this->outputPath . $path )){ mkdir( $this->outputPath . $path, 777, true ); }

		$targetOutputPath = $this->outputPath . $path . DS . $filename; 
		
		@file_put_contents($targetOutputPath, $data);
	
		echo "OK | SAVED TO FILE ==>> ". $targetOutputPath ."<br>";
	}	
	
	
	/**
	* check result for js errors 
	**/
	public function checkErrors()
	{ 
	   $errorMap = array("TypeError", "error","Error","ERROR","TYPEERROR","is not object","null","undefined");
	   foreach ($errorMap as $error)
	   {
	   	 if( strstr($this->result, $error) && strlen($this->result) < 100  ){
	   	 	exit("ERROR : Cannot save to file. Phantom operation has errors:<br><br>" . $this->result);
	   	 }	   	  
	   }
       return false;
	}		
		
	
	
	/**
	* check given output path
	**/
	public function checkOutPutPath( $path )
	{		
		if(!is_dir( $this->outputPath . $path )){
			mkdir( $this->jsPath . $path, 777 );
		}
	}	
	
}


?>