<?php 

/**
* Class Maps
* @author rng
**/
class maps 
{
	public $_usPresidentsMap;

	public function __construct()
	{
	}	
	
	/**
	* Get Map
	* @param string $mapCode
	**/
	public function getMap( $mapCode )
	{
		return $this->$mapCode;
	}
}

?>