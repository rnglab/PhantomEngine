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
		$this->prepareUsPresidentsMap();
	}	
	
	/**
	* Get Map
	* @param string $mapCode
	**/
	public function getMap( $mapCode )
	{
		return $this->$mapCode;
	}
	
	/**
	* 
	* Url Map For Us Presidents
	**/
	public function prepareUsPresidentsMap()
	{
		$this->_usPresidentsMap = Array(
										"https://en.wikipedia.org/wiki/George_Washington",
										"https://en.wikipedia.org/wiki/John_Adams",
										"https://en.wikipedia.org/wiki/Thomas_Jefferson",
										"https://en.wikipedia.org/wiki/James_Madison",
										"https://en.wikipedia.org/wiki/James_Monroe",
										"https://en.wikipedia.org/wiki/John_Quincy_Adams",
										"https://en.wikipedia.org/wiki/Andrew_Jackson",
										"https://en.wikipedia.org/wiki/Martin_Van_Buren",
										"https://en.wikipedia.org/wiki/William_Henry_Harrison",
										"https://en.wikipedia.org/wiki/John_Tyler",
										"https://en.wikipedia.org/wiki/James_K._Polk",
										"https://en.wikipedia.org/wiki/Zachary_Taylor",
										"https://en.wikipedia.org/wiki/Millard_Fillmore",
										"https://en.wikipedia.org/wiki/Franklin_Pierce",
										"https://en.wikipedia.org/wiki/James_Buchanan",
										"https://en.wikipedia.org/wiki/Abraham_Lincoln",
										"https://en.wikipedia.org/wiki/Andrew_Johnson",
										"https://en.wikipedia.org/wiki/Ulysses_S._Grant",
										"https://en.wikipedia.org/wiki/Rutherford_B._Hayes",
										"https://en.wikipedia.org/wiki/James_A._Garfield",
										"https://en.wikipedia.org/wiki/Chester_A._Arthur",
										"https://en.wikipedia.org/wiki/Grover_Cleveland",
										"https://en.wikipedia.org/wiki/Benjamin_Harrison",
										"https://en.wikipedia.org/wiki/Grover_Cleveland",
										"https://en.wikipedia.org/wiki/William_McKinley",
										"https://en.wikipedia.org/wiki/Theodore_Roosevelt",
										"https://en.wikipedia.org/wiki/William_Howard_Taft",
										"https://en.wikipedia.org/wiki/Woodrow_Wilson",
										"https://en.wikipedia.org/wiki/Warren_G._Harding",
										"https://en.wikipedia.org/wiki/Calvin_Coolidge",
										"https://en.wikipedia.org/wiki/Herbert_Hoover",
										"https://en.wikipedia.org/wiki/Franklin_D._Roosevelt",
										"https://en.wikipedia.org/wiki/Harry_S._Truman",
										"https://en.wikipedia.org/wiki/Dwight_D._Eisenhower",
										"https://en.wikipedia.org/wiki/John_F._Kennedy",
										"https://en.wikipedia.org/wiki/Lyndon_B._Johnson",
										"https://en.wikipedia.org/wiki/Richard_Nixon",
										"https://en.wikipedia.org/wiki/Gerald_Ford",
										"https://en.wikipedia.org/wiki/Jimmy_Carter",
										"https://en.wikipedia.org/wiki/Ronald_Reagan",
										"https://en.wikipedia.org/wiki/George_H._W._Bush",
										"https://en.wikipedia.org/wiki/Bill_Clinton",
										"https://en.wikipedia.org/wiki/George_W._Bush",
										"https://en.wikipedia.org/wiki/Barack_Obama"										
		 								);	
	}
}

?>