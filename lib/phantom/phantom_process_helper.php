<?php

/**
* Phantom processleri için yardımcı işlevleri sunar 
* @author rng
**/
class phantomHelper 
{
	
	public function getOpticalIllusionsHtmlTemplate( $body, $isReplaceActive )
	{
		$header = '<html>
					<head>
						<meta http-equiv="Content-type" content="text/html; charset=utf-8">
						<link rel="stylesheet" type="text/css" href="style.css" charset="utf-8" >
						<style>
						body { padding : 15px; }
						p {	  font-size: 1.3em;line-height: 1.75;color: #302c22;font-family: sans-serif;}
						img { max-width : 100%!important; height:auto!important;}
						</style>
					</head>
					<body>
				    <div style="text-align:center;">';
		
		if( $isReplaceActive )
		{					
			$body = str_replace(array('src="pages/','src="/pages/','src="/'), 'src="img/', $body);
			$body = str_replace(array("<hr>"), array(""), $body);
			
			if( !strstr($body,'src="img/') )
			{
				$body = str_replace(array('src="'), 'src="img/', $body);
			}			
		}		
		
		$footer = '</div>
				   </body>				
				   </html>';
		
		return $header . $body . $footer;
	}
	
	
	public function getOpticalIllusionsImage( $url )
	{
		$resource = @file_get_contents( $url );
		$filename = explode("/", $url);
		
		$image = new stdClass();
		$image->data = $resource;
		$image->name = end($filename);

		return $image;
		
	}
	
	
	
	public function getOpticalArtIllisionsJson()
	{		
		return '[{"id" : "1","title" : "Painting%20and%20Drawing%20Art%20Illusions","html" : "%3Ch2%3EPainting%20and%20Drawing%20Art%20Illusions%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20The%20Terrace%20(by%20David%20MacDonald)%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22Impossibly%20great%20painting%20by%20David%20MacDonald.%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22443%22%20src%3D%22images%2Fbuilding4.jpg%22%20alt%3D%22The%20Terrace%22%3E%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2Fa%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/building4.jpg"},{"id" : "2","title" : "Drawing%20Hands%20(by%20MC%20Escher)","html" : "%3Ch2%3EDrawing%20Hands%20(by%20MC%20Escher)%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22Amazing%20drawing%20by%20MC%20Escher.%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22337%22%20src%3D%22images%2Fdrawinghands.jpg%22%20alt%3D%22Drawing%20Hands%22%3E%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2Fa%3E%0A%20%20%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/drawinghands.jpg"},{"id" : "3","title" : "Encounter%20(by%20MC%20Escher)","html" : "%3Ch2%3EEncounter%20(by%20MC%20Escher)%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22Illusion%20where%20the%20past%20meets%20the%20present.%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22289%22%20src%3D%22images%2Fmonkeymen.jpg%22%20alt%3D%22Encounter%22%3E%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%3C%2Fa%3E%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/monkeymen.jpg"},{"id" : "4","title" : "Waterfalls%20(by%20MC%20Escher)","html" : "%3Ch2%3EWaterfalls%20(by%20MC%20Escher)%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22How%20can%20the%20water%20flow%20up%3F%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22431%22%20src%3D%22images%2Fwaterfalls.jpg%22%20alt%3D%22Waterfalls%22%3E%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%3C%2Fa%3E%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/waterfalls.jpg"},{"id" : "5","title" : "Waterfalls%202%20(by%20Rob%20Gonsalves)","html" : "%3Ch2%3EWaterfalls%202%20(by%20Rob%20Gonsalves)%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22When%20waterfall%20of%20words%20comes%20to%20life.%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22552%22%20src%3D%22images%2Fwaterfalls2.jpg%22%20alt%3D%22Waterfalls%202%22%3E%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%3C%2Fa%3E%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/waterfalls2.jpg"},{"id" : "6","title" : "Heaven%20on%20Earth","html" : "%3Ch2%3EHeaven%20on%20Earth%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22Beautiful%20picture.%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22463%22%20src%3D%22images%2Fearthnheaven.jpg%22%20alt%3D%22Heaven%20on%20Earth%22%3E%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%3C%2Fa%3E%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/earthnheaven.jpg"},{"id" : "7","title" : "Horses","html" : "%3Ch2%3EHorses%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22How%20many%20horses%20are%20on%20this%20picture%3F%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22431%22%20src%3D%22images%2Fhorses.jpg%22%20alt%3D%22Horses%22%3E%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%3C%2Fa%3E%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/horses.jpg"},{"id" : "8","title" : "Sidewalk%20Chalk%20Art%20(by%20Julian%20Beever)","html" : "%3Ch2%3ESidewalk%20Chalk%20Art%20(by%20Julian%20Beever)%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20Waterfalls%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22Jumping%20head%20first%20into%20these%20waterfalls%20is%20not%20advised%20%3A-)%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22578%22%20src%3D%22images%2Fsidewalk-waterfalls.jpg%22%20alt%3D%22Sidewalk%20Chart%20Art%20-%20Waterfalls%22%3E%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2Fa%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/sidewalk-waterfalls.jpg"},{"id" : "9","title" : "Construction%20Site","html" : "%3Ch2%3EConstruction%20Site%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22Tripping%20on%20sidewalk%20can%20be%20fatal.%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22600%22%20src%3D%22images%2Fsidewalk-construction-site.jpg%22%20alt%3D%22Sidewalk%20Chalk%20Art%20-%20Construction%20Site%22%3E%3Cbr%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%3C%2Fa%3E%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/sidewalk-construction-site.jpg"},{"id" : "10","title" : "Pit","html" : "%3Ch2%3EPit%3C%2Fh2%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%3Ca%20href%3D%22%23%22%20rel%3D%22prettyPhoto%5Bpp_gal%5D%22%20title%3D%22Politicians%20meeting%20their%20end%20-%20falling%20Down.%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cimg%20width%3D%22400%22%20height%3D%22274%22%20src%3D%22images%2Fsidewalk-well.jpg%22%20alt%3D%22Sidewalk%20Chalk%20Art%20-%20Pit%22%3E%3Cbr%3E%3C%2Fa%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20You%20can%20see%20more%20chalk%20drawings%20by%20Julian%20Beever%20in%20section%20dedicated%20to.%20%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%3C%2Fp%3E","imgUrl" : "http://brainden.com/images/sidewalk-well.jpg"}]';		
	}
	
	
}

?>