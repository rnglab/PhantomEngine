<?php 

/**
* class phantom
* Hedef url'leri phantom ile tarar ve geçerli js process'i çalıştırarak sonuçları işler.
* @author RNG
**/
class phantom extends Base {
	
	public $_helper;
	
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
	* Uri map for phantom engine
	**/
	public function prepareMaps()
	{	
		$maps = new maps();
		
		return true;		
	}
	
}


?>