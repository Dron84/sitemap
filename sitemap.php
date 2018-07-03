<?php
$find = shell_exec('find -name "index.php"');
$find = explode("./", $find);
$result = array();
for ($i=1; $i < count($find); $i++) {
  $str = $find[$i];
  $info = shell_exec('stat '.$str);
  $mod = strpos($info, "Модифицирован: ");
  $mod = $mod+28;
  $info = substr($info, $mod , 19);
  if ($str == 'index.php'){
    $str = '/';
  }else{
    $str = str_replace('index.php','',$str);
  }
  $result[$i] = array('href'=> $str,'info'=> $info );
}
$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
for ($i=1; $i < count($result) ; $i++) {
  $data = $result[$i];
  $priority = explode('/',$data['href']);
  $info2 = explode(' ',$data['info']);
  $strInf = $info2[0].'T'.$info2[1].'+00:00';
  $xml .= '<url>';
    $xml.= '<loc>https://fengshui-consultant.ru/'.$data['href'].'</loc>';
    $xml.= '<lastmod>'.$strInf.'</lastmod>';
    if (count($priority)< 2){
      $xml.= '<priority>1.00</priority>';
    }else if (count($priority) == 2){
      $xml.= '<priority>0.90</priority>';
    }else if (count($priority) == 3){
      $xml.= '<priority>0.80</priority>';
    }else if (count($priority) == 4){
      $xml.= '<priority>0.70</priority>';
    }else if (count($priority) == 5){
      $xml.= '<priority>0.60</priority>';
    }else{
      $xml.= '<priority>0.50</priority>';
    }
  $xml .= '</url>';
}

$xml .= '</urlset>';
shell_exec('rm sitemap.xml');
$file = fopen('sitemap.xml', 'a+');
fwrite($file , $xml);
fclose($file);
echo 'sitemap.xml is create';
?>
