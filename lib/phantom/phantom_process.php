<?php 

/**
* class phantom
* Executes given task
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

		/*prepare target url lists*/
		$this->prepareMaps();

		$this->_helper = new phantomHelper();

		/*execute given task if it is available*/
		if(!isset( $_GET['task'] )){
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