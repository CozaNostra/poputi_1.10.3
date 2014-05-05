<?php
session_start();
	define("VALID_CMS", 1);
    define('PATH', $_SERVER['DOCUMENT_ROOT']);
	include(PATH.'/core/cms.php');
    $inCore = cmsCore::getInstance();
    define('HOST', 'http://' . $inCore->getHost());
    $inCore->loadClass('page');
    $inCore->loadClass('user');
	$inDB = cmsDatabase::getInstance();
    $inUser = cmsUser::getInstance();
	$inUser->update();


$sql = "SELECT `otkuda` , `kuda` FROM `cms_poputi` WHERE `kuda` LIKE '%{$_POST['text']}%' OR `otkuda` LIKE '%{$_POST['text']}%' LIMIT 10";
$result = $inDB->query($sql);

while($arr = $inDB->fetch_assoc($result))
{
	$array[] = $arr;
}
$count = count($array);
for($i=0;$i<=$count;$i++)
{
	if(stripos($array[$i]['kuda'],$_POST['text'])===0 || stripos($array[$i]['kuda'],$_POST['text'])<0 )
	{
		$arr[] = $array[$i]['kuda'];
	}
	if(stripos($array[$i]['otkuda'],$_POST['text'])===0 || stripos($array[$i]['otkuda'],$_POST['text'])<0)
	{
		$arr[] = $array[$i]['otkuda'];
	}
}

$arr = @array_unique($arr);

for($i=0;$i<=count($arr)-1;$i++)
{
	echo "<span id='quik_search_poputi' style=\"padding:5px;\" onmouseout=\"$(this).css('background-color','white')\" onmouseover=\"$(this).css('background-color','#dddddd')\" onclick=\"$('#squery').val('{$arr[$i]}')\" >{$arr[$i]}</span>";
}
	
?>