<?php 

/**
* class phantom
* Hedef url'leri phantom ile tarar ve geçerli js process'i çalıştırarak sonuçları işler.
* @author RNG
**/
class phantom extends Base {
	
	public $_helper;
	public $_mapUsPresidents; /*target uri array*/
	
	/**
	* class construct
	**/
	public function __construct()
	{
		parent::__construct();
		
		/*phantom için hedef url'leri içeren kütüphaneyi hazırlıyoruz*/
		$this->prepareMaps();
		
		/*helper sınıfını hazırla*/
		$this->_helper = new phantomHelper();
		
		/*request ile talep edilen methodu çalıştırıyoruz*/
		if(!isset( $_GET["task"] )){
            exit('ERROR : Task can not be empty');
		}

        $this->$_GET['task']();
    }
	
	/**
	 * phantom action for Us Presidents List
	 **/
	public function processUsPresidentsDetail()
	{
        $total = count($this->_mapUsPresidents);

		for( $i = 0; $i  < $total; $i++ )
		{
			/*main process js dosyasını yüklüyor ve hedef url için replace işlemi gerçekleştiriyoruz*/
			$filename = $this->processJsPath . 'uspresidents'.DS.'pf_clean_wiki.js';
			$proceesJsFile = @file_get_contents( $filename );
			$this->pjCode = str_replace("##_url_replace_##", $this->_mapUsPresidents[$i], $proceesJsFile);

			$this->executePhantom();				

			if(empty($this->result)){
                echo 'WARNING : It seems there is no result data for given phantomJs process on file :'. $filename . "\n";
                continue;
            }

			$resultJson = @json_decode($this->result);
			
			$resultHtml = '<html>
								<head>
								<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
								<style>ul, ol {text-align:left;} body {color:rgb(75, 74, 74);padding:5px;font-size:16px;font-family: sans-serif;}</style>
								</head>
								<body>
								
								<p align="center"> <img width="100%" src="img/'.$i.'.jpg" onerror="this.remove();"></img> </p>';			
			$resultHtml .= urldecode( trim( $resultJson->html ) );			
			$resultHtml .= "</body></html>";
			
			$this->saveToFile($i.".html", $resultHtml, __FUNCTION__ );

			$imgSet = explode(",", $resultJson->imageSet);
			
			$url = trim( str_replace(array(" 1x"," 1.5x"," 2x"," 2.5x"," 3x"," 3.5x",), "", end($imgSet)) );
			
			$imgFile = file_get_contents( "https:" . $url );
			
			if( $imgFile )
			{
				$this->saveToFile($i.".jpg", $imgFile, __FUNCTION__."/img/");
			}
		}
	}	

	
	/**
	* Uri map for phantom engine
	**/
	public function prepareMaps()
	{	
		$maps = new maps();
		$this->_mapUsPresidents = $maps->getMap("_usPresidentsMap");
		
		return true;		
	}
	
}


?>