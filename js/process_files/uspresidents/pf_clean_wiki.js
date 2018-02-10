var page = require('webpage').create();

/*parametre dinamik olarak backend application taraf�ndan replace edilir*/
page.open('##_url_replace_##', function(status)
{
	var data = page.evaluate(function()
	{
			/**
			* Simple wiki Clean
			* @requires jQuery
			**/
			var wic = {
				_removeItems 	  : Array(/*"dl",*/"span.mw-editsection","table.metadata","sup","div.thumb","table.infobox","ol.references",
										  "div#toc","div#seealso","div#siteSub","div#contentSub","img","div.reflist","a.external","table.plainlinks",
										  "div#mw-navigation","div#mw-page-base","div#mw-head-base","table.navbox","h1.firstHeading","div#catlinks",
										  "div.hatnote","table.vertical-navbox","div.refbegin","div.tright","div#section_SpokenWikipedia","div.rellink",
										  "div.dablink","div#footer","table.navbox","noscript","div.printfooter","div#catlinks","table.mbox-small",
										  "span.collapseButton"
										  ),
			    _removeReferenceItems : Array("See_also","Further_reading","References","External_links","Notes","Primary_sources",
			    							  "Writings","Scholarly_studies","Biographies","Analytic_studies","Primary_sources","Bibliography",
			    							  "Pronunciation_note","Books_by_Van_Buren","Explanatory_notes","Citations","Administration_and_Cabinet",
			    							  "Judicial_appointments","Plaques_to_Fillmore","Sources","Cited_in_footnotes","Historiography",
			    							  "Additional_references","Electoral_history","Books","Media","Time","The_Washington_Post","Online_sources",
			    							  "Portraits","Photos","Paintings","Appendix","Other","Endmatter","Scholarly_topical_studies","Foreign_policy_and_World_War_II",
			    							  "Criticism","FDR.27s_rhetoric","Primary_sources","Interviews.2C_speeches_and_statements",
			    							  "Media_coverage"
			    							  ),
				_removeItemsAttr  : Array("a"),
				_updateItemsStyle : Array("a"),
				_tempBlock : "",

				/*run wic*/
				init : function()
				{
					wic.removeItems();
					wic.removeItemsAttr();
					wic.updateItemStyle();
					wic.removeReferenceBlocks();

					return "Ok - Wic process complated.";
				},

				/*remove target elements*/
				removeItems : function()
				{
					$.each(wic._removeItems,function(index,item)
				    {
						$(item).each( function(index,item){ $(item).remove() } );
					});
				},

				/*remove href attr for target elements*/
				removeItemsAttr : function()
				{
					$.each(wic._removeItemsAttr,function(index,item)
					{
						$(item).each( function(index,item){ $(item).removeAttr("href") } );
					});
				},

				/*remove reference blocks*/
				removeReferenceBlocks : function()
				{
					$.each( wic._removeReferenceItems, function( index,block )
					{	wic._tempBlock = block;
						$("h2 span.mw-headline, h3 span.mw-headline, h4 span.mw-headline").each( function( index,item )
						{
							if( $(this).attr("id") == wic._tempBlock )
							{
								$( $(this).parent() ).next().remove();
								$(this).parent().remove();
							}
						});
					});

				},

				/*update css style for target elements*/
				updateItemStyle : function()
				{
					$.each(wic._updateItemsStyle,function(index,item)
					{
						$(item).each( function(index,item){ $(item).attr("style","color:#252525") } );
					});
				}
			};


			/**
			* Data Parser
			**/
			var fmr = {
						current : 0,
						result : { data : {} },
						imageSet  : "",

						setData : function()
						{
							fmr.imageSet = $("a.image img").attr("srcset");
							wic.init();//clean the given wiki page with object wic

							return fmr.toJson();
						},


						toJson : function()
						{
							this.jsonResult = '{';
							this.jsonResult += '"html" : "' + encodeURIComponent( $("div#mw-content-text").html() ) + '",';
							this.jsonResult += '"imageSet" : "' + fmr.imageSet + '"';
							this.jsonResult += '}';
							return this.jsonResult;
						}

					};

					return fmr.setData();

	});

	console.log(data);
	phantom.exit();
});


/*us presidents list sayfas�n� tarar*/
/*$.each( $("table.wikitable tr"), function(item,index)
{
	this.target = $(this).children("td").eq(2).find("big a").attr("href");
	if( typeof( this.target ) != "undefined" )
	{
		console.log( "https://en.wikipedia.org" + this.target );
	}

} );
*/

