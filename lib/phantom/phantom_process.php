<?php 

/**
* class phantom
* Hedef url'leri phantom ile tarar ve geçerli js process'i çalıştırarak sonuçları işler.
* @author RNG
**/
class phantom extends Base {
	
	public $_helper;
	public $mapTr;        /*target uri array or phantom*/
	public $mapEn;		  /*target uri array or phantom*/
	public $mapMcServers; /*target uri array or phantom*/
	public $mapOpticalIllisions; /*target uri array or phantom*/
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
	 * phantom action for Kuran Cozumu
	 **/
	public function processBooksReasonsKC()
	{
		foreach ( $this->mapTr as $item )
		{
			/*main process js dosyasını yüklüyor ve hedef url için replace işlemi gerçekleştiriyoruz*/
			$proceesJsFile = @file_get_contents( $this->processJsPath . "kc/pf_kurancozum_tr_reasons.js" );
			$this->pjCode = str_replace("##_url_replace_##", $item['url'], $proceesJsFile);
	
			$this->executePhantom();
	
			$this->result = str_replace('"}, ] }', '"} ] }', $this->result);
				
			$this->saveToFile($item["name"].".json", $this->result , __FUNCTION__);
				
		}
	}	
	
	
	/**
	 * phantom action for Kuran Cozumu English
	 **/
	public function processBooksKCenglish()
	{
    	foreach ( $this->mapEn as $item )
		{	
			/*main process js dosyasını yüklüyor ve hedef url için replace işlemi gerçekleştiriyoruz*/
			$proceesJsFile = @file_get_contents( $this->processJsPath . "kc/pf_kurancozum_en.js" );
			$this->pjCode = str_replace("##_url_replace_##", $item['url'], $proceesJsFile);
	
			$this->executePhantom();
				
			$this->result = str_replace('"}, ] }', '"} ] }', $this->result);
			
			//$this->checkErrors();
			
			$this->saveToFile($item["name"].".json", $this->result, __FUNCTION__ );
	
		}
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
	 * phantom action for Mc Servers List
	 **/
	public function processMcServersList()
	{
		$results = "";
		$i=1;
		for( $i = 1; $i < $this->mapMcServers["totalPages"]; $i++ )	
		{
			/*main process js dosyasını yüklüyor ve hedef url için replace işlemi gerçekleştiriyoruz*/
			$proceesJsFile = @file_get_contents( $this->processJsPath . "mcservers/pf_serverlist.js" );
			$this->pjCode = str_replace("##_url_replace_##", $this->mapMcServers['url'] . (string)$i, $proceesJsFile);

			$this->executePhantom();				
			$results .= ( $i > 1 ? "," : "" ) . $this->result;	
			//$this->checkErrors();								
		}
		
		$results = '{ "data" : [ ' . $results . ' ]}';
		
		$this->saveToFile($this->mapMcServers["name"].".json", $results, __FUNCTION__ );
	}	
	
	

	/**
	 * phantom action for Mc Servers Detail List
	 **/
	public function processMcServersListDetail()
	{		
		$serverListData = @file_get_contents( $this->outputPath . "processMcServersList" . DS . $this->mapMcServers["name"].".json" );
		$serverListData = @json_decode($serverListData);
		$results = "";
		if( !$serverListData ) { exit("ERROR => json resource not found @ " . $this->outputPath . "processMcServersList" . DS . $this->mapMcServers["name"].".json"); }

		foreach ($serverListData->data as $key => $server)
		{			
			/*main process js dosyasını yüklüyor ve hedef url için replace işlemi gerçekleştiriyoruz*/
			$proceesJsFile = @file_get_contents( $this->processJsPath . "mcservers/pf_serverlist_detail.js" );
			$this->pjCode = str_replace("##_url_replace_##", "http://minecraftservers.org/server/" . $server->id, $proceesJsFile);
			$this->executePhantom();
			$results .= ( $key >= 1 ? "," : "" ) . $this->result;					
		}
		
		$results = '{ "data" : [ ' . $results . ' ]}';
		
		$this->saveToFile($this->mapMcServers["name"]."_details.json", $results, __FUNCTION__ );		
		
	}	
	
	
	
	/**
	 * phantom action for optical Illisions Details
	 **/
	public function processOpticalIllusionsDetail()
	{			
		/*main process js dosyasını yüklüyor ve hedef url için replace işlemi gerçekleştiriyoruz*/
		$proceesJsFile = @file_get_contents( $this->processJsPath . "23opticalillusions/pf_optil.js" );
		$this->pjCode = str_replace("##_url_replace_##", "http://www.123opticalillusions.com/archive.php", $proceesJsFile);
		$this->executePhantom();
		$jsonData = json_decode("[" .$this->result . "]");						
		
		foreach ($jsonData as $key => $item)
		{
			echo " <b>$key ===>>> $item->name<hr> ";
			
			$proceesJsFile = @file_get_contents( $this->processJsPath . "23opticalillusions/pf_optil_detail.js" );
			$this->pjCode = str_replace("##_url_replace_##", $item->url, $proceesJsFile);
			$this->executePhantom();
			$itemData = json_decode( $this->result );
						
			$html = $this->_helper->getOpticalIllusionsHtmlTemplate( urldecode( $itemData->html ), true );
			$img = $this->_helper->getOpticalIllusionsImage( $itemData->imgUrl );
			
			/*save files*/
			$this->saveToFile($key.".html", $html, __FUNCTION__ );
			$this->saveToFile($img->name, $img->data, __FUNCTION__ . "/img" );
			
		}
	
	}	
	
	
	/**
	 * phantom action for optical Illisions multiple Details
	 **/
	public function processOpticalIllusionsMultipleDetail()
	{		
		foreach ($this->mapOpticalIllisions as $key => $item)
		{
			echo " <b>$key ===>>> {$item["name"]}<hr> ";
			
			$proceesJsFile = @file_get_contents( $this->processJsPath . "23opticalillusions/pf_optil_brainden_detail.js" );
			$this->pjCode = str_replace("##_url_replace_##", $item["url"], $proceesJsFile);
			$this->executePhantom();
			$itemData = json_decode( ( $item["name"] == "art" ? $this->_helper->getOpticalArtIllisionsJson() : "[".$this->result."]") );
			
			foreach ( $itemData as $keyItem => $itemDetail )
			{
				$html = $this->_helper->getOpticalIllusionsHtmlTemplate( urldecode( $itemDetail->html ), false );
				$img = $this->_helper->getOpticalIllusionsImage( $itemDetail->imgUrl );
					
				echo " <br><b> ----- " . urldecode( $itemDetail->title ) . "<hr> ";				
				
				/*save files*/
				$this->saveToFile($keyItem.".html", $html, __FUNCTION__ . "/" . $item["name"] );
				$this->saveToFile($img->name, $img->data, __FUNCTION__ . "/" . $item["name"] . "/images" );						
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