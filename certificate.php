<?php

/**
 * Tutoriel file
 * Description : Simple substitutions of variables
 * You need PHP 5.2 at least
 * You need Zip Extension or PclZip library
 *
 * @copyright  GPL License 2008 - Julien Pauli - Cyril PIERRE de GEYER - Anaska (http://www.anaska.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL License
 * @version 1.3
 */


// Make sure you have Zip extension or PclZip library loaded
// First : include the librairy
require_once('../library/odf.php');

$odf = new odf("certificate.odt");

// Database Connection
$con = mysql_connect("localhost","root","lug");
mysql_select_db("certifi", $con);


// Example
/*$odf->setVars('titre', 'PHP: Hypertext PreprocessorPHP: Hypertext Preprocessor');

$message = "PHP (sigle de PHP: Hypertext Preprocessor), est un langage de scripts libre 
principalement utilisé pour produire des pages Web dynamiques via un serveur HTTP, mais 
pouvant également fonctionner comme n'importe quel langage interprété de façon locale, 
en exécutant les programmes en ligne de commande.";

$odf->setVars('message', $message);*/

// My work
$article = $odf->setSegment('articles');
$result = mysql_query("SELECT * FROM lime_survey_65311");
while($row = mysql_fetch_array($result))
{
	
		//image
		$pic = "images/" . $row['image'];
		$article->setImage('pic',$pic);
		
		$mss=$row['65311X7X12'];
		$mssData=mysql_fetch_array(mysql_query("select answer from bongo_answers where code='$mss'"));

		//name
		$article->nameArticle($mssData['answer']." ".$row['65311X7X13B1'] ." ". $row['65311X7X13B2'] ." ". $row['65311X7X13B3']);
		
		$mss=$row['65311X7X17'];
		$mssData=mysql_fetch_array(mysql_query("select answer from bongo_answers where code='$mss'"));
		
		//department
		$article->deptArticle($mssData['answer']);
	
	$article->merge();			
}	

$odf->mergeSegment($article);

// We export the file
$odf->exportAsAttachedFile();
 
?>
