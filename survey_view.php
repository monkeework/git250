<?php //survey_view.php
/**
 * Based on demo_view_pager.php along with index.php (demo_view_pager.php) provides a sample web application
 *
 * @package itc250-16q2
 * @author monkeework <monkeework@gmail.com>
 * @version 3.02 2011/05/18
 * @link http://www.monkeework.com/
 * @license http://www.apche.org/licenses/LICENSE-2.0
 * @see index.php
 * @todo none
 */


# '../' works for a sub-folder.  use './' for the root
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

# check variable of item passed in - if invalid data, forcibly redirect back to index.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring // if data is good, typecast it to int
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	//myRedirect(VIRTUAL_PATH . "demo/demo_list_pager.php");
	header('Location: ' . VIRTUAL_PATH . 'surveys/index.php');
}

//sql statement to select individual item
$sql = "select SurveyID, Title, Description, LastUpdated from 16q2_surveys where SurveyID = " . $myID;
//---end config area --------------------------------------------------

$foundRecord = FALSE; # Will change to true, if record found!

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
		 $foundRecord = TRUE;
		 while ($row = mysqli_fetch_assoc($result))
		 {
			$SurveyID = dbOut($row['SurveyID']);
			$Title = dbOut($row['Title']);
			$Description = dbOut($row['Description']);
			$LastUpdated = dbOut($row['LastUpdated']);
		 }
}

@mysqli_free_result($result); # We're done with the data!

if($foundRecord)
{#only load data if record found
	$config->titleTag = $Title . " Survey"; #overwrite PageTitle with Muffin info!
	#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
	//$config->metaDescription = $MetaDescription . ' ITC250 16q2! ' . $config->metaDescription;
	//$config->metaKeywords = $MetaKeywords . ', Surveys, Regular Expressions,'. $config->metaKeywords;
}
/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/
# END CONFIG AREA -------------------------------------

get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center"><?=$Title;?></h3>
<?php
if($foundRecord)
{#records exist - show muffin!

 echo '
	 <p><b>ID: ' . $SurveyID . '</b></p>
	 <p><b>Title:  ' . $Title . '</b></p>
	<p><b>Description:  ' . $Description . '</b></p>
	<p><b>Last Updated:  ' . $LastUpdated . '</b></p>
 ';
}else{//no such muffin!
		echo '<div align="center">No Surveys Available</div>';
}

echo '<div align="center"><a href="' . VIRTUAL_PATH . 'surveys/index.php">Another Survey?</a></div>';

get_footer(); #defaults to theme footer or footer_inc.php
?>
