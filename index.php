<?php
/***************************************
****************************************
********** PhantomJs Engine  ***********
**********  --------------   ***********
********** 		 RNG         ***********
****************************************
***************************************/

$me = php_uname($mode='s');

/*Set Execution Time*/
set_time_limit(2500);

/*prepare op type*/
if( isset( $_GET["op"] ) ) {
	$op = $_GET["op"];
} else {
	$op = "admin";
}

/*set defines*/
define("ROOT_PATH", __DIR__);
define("DS", DIRECTORY_SEPARATOR);
define("BASE_URL", "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

/*include maps*/
require_once ROOT_PATH . DS . "lib" . DS . "phantom" . DS . "maps.php";


/*start process by op type*/
switch($op)
{
	case "phantom" :
		require_once 'lib/phantom/phantom_base.php';
		require_once 'lib/phantom/phantom_process_helper.php';
		require_once 'lib/phantom/phantom_process.php';
		$phantom = new phantom();
	break;

	case "jsontodb" :
		require_once 'lib/phantom/jsontodb.php';
		$db = new jsonToDb();
	break;
}

?>


<?php if( $op == "admin" ) :?>

	<html>
		<head>
		  <title>Phantom Admin</title>
		  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
		  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		  <link rel="stylesheet" href="/resources/demos/style.css">
		  <script>


			  $(function() {
			     $( "#accordion" ).accordion({
			      collapsible: true
			     });

				 $("div#executeButton").click( function(){
					 this.target = $("ul.opset input[type='radio']:checked").val();
					 if( typeof( this.target ) == "undefined" ) {
						 alert( "It seems there is not Selected Process. So cannot execute!" );
					 }
					 else
					 {
						 window.open("<?php echo BASE_URL ?>" + this.target);
				     }
				 } );
			  });

		  </script>
		  <style>
		  	li { line-height: 29px;list-style-type: none; }
		  	div#executeButton { background-color: rgb(93, 144, 237);width: 250px;text-align: center;line-height: 45px;border-radius: 5px;cursor: pointer;color: white;font-size: 20px; }
		  	div#executeContainer { margin-top: 25px; }
		  </style>
		</head>
		<body>
			<h1 style="color:rgb(60, 162, 186);">Phantom Admin | Example Nodes</h1>

			<div id="accordion">
				<h3>Examples</h3>
				<div>
					<ul class="opset">
						<li> <input type="radio" name="proccessType" value="?op=phantom&task=screenShot">Take Sample Screen Shot of Sample Web Page</input></li>
                        <li> <input type="radio" name="proccessType" value="?op=phantom&task=crawlHtml">Crawl Sample Web Page ( Save crawled data as html )</input></li>
                        <li> <input type="radio" name="proccessType" value="?op=phantom&task=crawlJson">Crawl Sample Web Page ( Save crawled data as json )</input></li>
					</ul>
				</div>
			</div>

			<div id="executeContainer">
				<div id="executeButton">Execute Selected Process</div>
			</div>

		</body>
	</html>

<?php endif; ?>