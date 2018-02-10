var page = require('webpage').create();

/*parametre dinamik olarak backend application taraf�ndan replace edilir*/
page.open('##_url_replace_##', function(status)
{
	var data = page.evaluate(function() 
	{
			/**
			* Data Parser 
			**/	
			var fmr = {
						current : 0,
						result : { data : {} },
						
						setData : function()
						{
							return "https:" + $("a.image img").attr("src");										
						}
						
					};													

					return fmr.setData();
		
	});
		
	console.log(data);
	phantom.exit();
});