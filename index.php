<?php
ini_set('display_errors','OFF');
require 'vendor/autoload.php';
if (empty($_SESSION)){
    session_start();
}
const CITY_ID_URL_POSITION = 48;
const SECTION_ID_URL_POSITION = 27;
const MINSK_ID = 23;

/*
 * Вначале форма запрашивает город и категорию, потом запрашивает тело объявления через
 * форму, которая отправляет POST на тот же Action, что и форма на сайте.
 *
 * В итоге получается редирект на страницу (успех/неуспех), чего не хотелось бы.
 */


if (empty($_GET))
{
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
        $index = substr($section_name->getAttribute('href'), SECTION_ID_URL_POSITION, 2);
        $value = $section_name->textContent;
        $section_array[$index] = $value;
    }
    $_SESSION['sections']=$section_array;
    $_SESSION['cities']=$city_array;
echo <<<HERE
<!DOCTYPE html>
<html lang="en">
<head>
    <title>fee-ob-by-test</title>
    <meta charset="utf-8">
</head>
<body>
<form action="#" method="get">
    <table width="100%" border=0 cellspacing=1>
       <tr>
           <td class=form_head width="100%" colspan=2>Добавление объявления на Free-ob.by</td>
        </tr>
        <tr>
            <td class=form1 width="30%"><b>Укажите город:</b></td>
            <td class=form1 width="70%">
                <select name="city">
HERE;
foreach ($city_array as $city){
    echo "<option>$city</option>";
}
echo <<<HERE
                </select>
            </td>
        </tr>
        <tr>
            <td class=form1 width="30%"><b>Укажите категорию объявления:</b></td>
            <td class=form1 width="70%">
                <select name="category">
HERE;
foreach ($section_array as $section){
    echo "<option>$section</option>";
}
echo <<<HERE
                </select>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%" border=0 cellspacing=1>
        <tr>
            <td class=form1 width="30%">
                <input type="submit" value="Далее" id="sendbtn"/>
            </td>
        </tr>
    </table>
</form>
HERE;

} else {
    if (empty($_POST)) {
        echo <<<END
<!DOCTYPE html>
<html lang="en">
<head>
    <title>fee-ob-by-test</title>
    <meta charset="utf-8">
</head>
<body>
<form action="http://free-ob.by/command.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="cmd" value="post_ads">
END;
        $city_id=array_search($_GET['city'], $_SESSION['cities']);
        $category_id=array_search($_GET['category'], $_SESSION['sections']);
        echo "<input type='hidden' name='category_id' value='$category_id''>";
        echo "<input type='hidden' name='sel_city_id' value='$city_id''>";
        echo <<<END
    <input type="hidden" name="redirect" value="">
    <input type="hidden" name="4800f1991fe490143881fa01fd79ad526724b34d" id="humbot" value="0">

    <table width="100%" border=0 cellspacing=1>
        <tr>
            <td class=form1 width="30%"><b>Заголовок объявления</b><BR>
                <small>
                    <ul style="padding-left:20px;">
                        <li>Укажите операцию: продажа, покупка, обмен и т.п.</li>
                        <li>Укажите предмет объявления, название услуги, вакансии</li>
                    </ul>
                </small>
            </td>
            <td class=form1 width="70%">
                <input name="ads_title" value='' type="text" maxlength="70" autofocus style="width:100%;">
            </td>
        </tr>

        <tr>
            <td class=form1 width="30%">
                <b>Текст объявления</b><BR>
                <font color="#ff0000">
                    <small>
                        <UL style="padding-left:20px;">
                            <LI>не пишите здесь контактную информацию</LI>
                            <LI>не пишите весь текст БОЛЬШИМИ БУКВАМИ</LI>
                            <LI>запрещается размещать в тексте объявления фразы националистического, экстремистского или дискриминирующего характера, например, "только славянам...", "лиц кавказской национальности..." и т.п.</LI>
                        </UL>
                    </small>
                </font>
            </td>
            <td class=form1 width="70%"><textarea name="ads_description" rows=12 maxlength="4096" style="width:100%;"></textarea></td>
        </tr>

        <tr>
            <td class=form1 width="30%"><b>Прикрепить фотографию</b></td>
            <td class=form1 width="70%"><input name="req_file" type="file" accept="image/jpeg,image/png,image/gif"></td>
        </tr>

    </table>
    <BR>


    <table width="100%" border=0 cellspacing=1>

        <tr>
            <td class=form_head width="100%" colspan=2>Контактная информация</td>
        </tr>

        <tr>
            <td class=form1 width="30%"><b>Ваше имя или Название организации</b></td>
            <td class=form1 width="70%"><input name="ads_your_name" value='' type=text maxlength="70"style="width:100%;"></td>
        </tr>

        <tr>
            <td class=form1 width="30%"><b>Телефоны</b> <span style="color:red; font-size: 90%">(если Вы указали телефон в тексте объявления, то объявление не выйдет!)</span></td>
            <td class=form1 width="70%"><input name="ads_phone" value='' type="text" maxlength="255" placeholder="(999) 555-55-55, (999) 444-44-44" style="width:100%;"></td>
        </tr>

        <tr>
            <td class=form1 width="30%"><b>E-mail</b></td>
            <td class=form1 width="70%"><input name="ads_email" value='' type="email" maxlength="255" placeholder="your_mail@mail.com" style="width:100%;"></td>
        </tr>

        <tr>
            <td class=form1 width="30%"><b>ICQ</b></td>
            <td class=form1 width="70%"><input name="ads_messenger" size="50" value='' maxlength="255" type=text style="width:100%;"></td>
        </tr>

        <tr>
            <td class=form1 width="30%"><b>Сайт или Интернет-страница</b></td>
            <td class=form1 width="70%"><input name="ads_url" value='' type="url" maxlength="255" placeholder="http://" style="width:100%;"></td>
        </tr>

        <tr>
            <td class=form1 width="30%"><b>Адрес</b></td>
            <td class=form1 width="70%"><input name="ads_address" size="50" maxlength="120" value='' type=text style="width:100%;"></td>
        </tr>

    </table>
    <BR>


    <table width="100%">
        <tr>
            <td class=form1>
                <div style="text-align: justify;">
                    Нажимая кнопку "На модерацию", я соглашаюсь с правилами использования сервиса, а также с передачей и обработкой моих персональных данных сайтом «Бесплатные объявления». Я подтверждаю своё совершеннолетие и принимаю на себя всю ответственность за размещенное объявление.</div><br>
                <input type="checkbox" name="agreement" checked style="display: none;">
                <input type="submit" value="На модерацию" id="sendbtn">
                <span style="margin-left: 20px"><span style="font-weight: bold; color: red;">Важно!</span> Чтобы Ваше объявление увидело больше людей не забудьте поделиться ссылкой в социальных сетях!</span>
            </td>
        </tr>
    </table>
    <BR>
</form>
</body>
END;
    } else{
        print_r($_POST);
    }
}

