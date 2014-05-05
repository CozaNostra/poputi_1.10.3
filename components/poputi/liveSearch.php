<?php
	define("VALID_CMS", 1);
	define('PATH', $_SERVER['DOCUMENT_ROOT']);
	include(PATH.'/core/cms.php');
	$inCore = cmsCore::getInstance();
	$inDB = cmsDatabase::getInstance();
	$text = $inCore->request('text','str');

$sql = "SELECT * FROM `cms_poputi` WHERE `kuda` LIKE '%{$text}%' OR `otkuda` LIKE '%{$text}%' LIMIT 10";
$result = $inDB->query($sql);

$resultHtml = "";

if($inDB->num_rows($result)==0)
{
	$resultHtml = "<span id='quik_search_poputi' >Ничего не найдено...</span>";
}
else
{
	while($row = $inDB->fetch_assoc($result))
	{
		$value = (strstr($row['kuda'],$text)) ? $row['kuda'] : $row['otkuda'];	
		$resultHtml .= "<span id='quik_search_poputi' style=\"padding:5px;\" onmouseout=\"$(this).css('background-color','white')\" onmouseover=\"$(this).css('background-color','#dddddd')\" onclick=\"$('#squery').val('{$value}')\" >{$value}</span>";
	}
}	

echo $resultHtml;
?>