<?php
ini_set('display_errors','OFF');
require 'vendor/autoload.php';

const CITY_ID_URL_POSITION = 48;
const MINSK_ID = 23;


//подымаем список городов
//на сервере потребуется теневой JS, т.к. нужные элементы ДОМ появляются после JS.
$client = \JonnyW\PhantomJs\Client::getInstance();
$client->getEngine()->setPath(dirname(__FILE__).'/bin/phantomjs.exe');
//запрос
$request = $client->getMessageFactory()->createRequest('http://free-ob.by/post.php', 'GET');
//ответ
$response = $client->getMessageFactory()->createResponse();
$client->send($request, $response);
$html = $response->getContent();

//создаем ДОМ
$cities_dom = new DOMDocument();
$cities_dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$cities_xpath = new DOMXPath($cities_dom);
//парсим ДОМ по нужному класу
$cities = $cities_xpath->query("/html/body//div[contains(@class,'index_city')]/b/a");
//создаем массив городов и заполняем его
$city_array = Array();
for ($i = 0; $i < $cities->length; $i++) {
    $city_name = $cities->item($i);
    $city_array[substr($city_name->getAttribute('href'), CITY_ID_URL_POSITION)] = $city_name->textContent;
}

//получаем категории объявлений
//запрос
$request = $client->getMessageFactory()->createRequest('http://free-ob.by/post_category.php?sel_city_id='.MINSK_ID, 'GET');
//ответ
$response = $client->getMessageFactory()->createResponse();
$client->send($request, $response);
$section_html = $response->getContent();

//создаем ДОМ
$dom = new DOMDocument();
$dom->loadHTML(mb_convert_encoding($section_html, 'HTML-ENTITIES', 'UTF-8'));
$xpath = new DOMXPath($dom);
//парсим ДОМ по нужному класу
$cities = $xpath->query("/html/body//span[contains(@class,'subcategory_name')]/a");
//создаем массив городов и заполняем его
$section_array = Array();
for ($i = 0; $i < $cities->length; $i++) {
    $section_name = $cities->item($i);
    $section_array[] = $section_name->textContent;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>fee-ob-by-test</title>
    <meta charset="utf-8">
</head>
<body>
<form action="#" method="get">
    <div>
        <label for="city">Укажите город: </label>
        <select>
            <?php
            foreach ($city_array as $city){
                echo "<option>$city</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label for="section">Укажите Категорию: </label>
        <select>
            <?php
            foreach ($section_array as $section){
                echo "<option>$section</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label for="title">Заголовок</label>
        <input type="text" name="title" id="title">
    </div>
</form>
</body>


