<?php

/*здесь пробую имитировать отправление "захардкоренных" данных нового объявления cURL
ответ получаю следующий:

HTTP/1.1 100 Continue HTTP/1.1 307 Temporary Redirect Server: nginx Date: Sun, 11 Jun 2017 07:30:54 GMT
Content-Type: text/html; charset=UTF-8 Transfer-Encoding: chunked Connection: keep-alive Keep-Alive:
timeout=5 X-Powered-By: PHP/5.6.30-0+deb8u1 Set-Cookie: onset=b3f759e5a7409488652e45a98b896b04; path=/ Set-Cookie:
onsetd=f14e543ae4187078255fea215667f59c; path=/ Set-Cookie: client=browser; path=/ Set-Cookie:
emailverification=deleted; expires=Thu, 01-Jan-1970 00:00:01 GMT; Max-Age=0; path=/; domain=.free-ob.by
Set-Cookie: start=1497166254; expires=Wed, 06-Jun-2018 07:30:54 GMT; Max-Age=31104000; path=/; domain=.free-ob.by
Set-Cookie: source=Web; expires=Wed, 06-Jun-2018 07:30:54 GMT; Max-Age=31104000; path=/; domain=.free-ob.by
Location: /load.php?back_url=%2Fcommand.php&1497166254.4653 X-Frame-Options: deny

Array ( [url] => http://free-ob.by/command.php [content_type] => text/html; charset=UTF-8 [http_code] => 307
[header_size] => 844 [request_size] => 386 [filetime] => -1 [ssl_verify_result] => 0 [redirect_count] => 0
[total_time] => 0.468 [namelookup_time] => 0 [connect_time] => 0.094 [pretransfer_time] => 0.094 [size_upload] => 1920
[size_download] => 0 [speed_download] => 0 [speed_upload] => 4102 [download_content_length] => -1
[upload_content_length] => 1920 [starttransfer_time] => 0.172 [redirect_time] => 0 [certinfo] => Array ( )
[redirect_url] => http://free-ob.by/load.php?back_url=%2Fcommand.php&1497166254.4653 )


Я не понимаю добавилось ли моё объявление
*/

$curl = curl_init(); //инициализация сеанса
curl_setopt($curl, CURLOPT_URL, 'http://free-ob.by/command.php'); //урл сайта к которому обращаемся
curl_setopt($curl, CURLOPT_HEADER, 1); //выводим заголовки
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_POST, 1); //передача данных методом POST
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //теперь curl вернет нам ответ, а не выведет
curl_setopt($curl, CURLOPT_POSTFIELDS, //тут переменные которые будут переданы методом POST
     array(
        'cmd'=>'post_ads',
        'category_id'=>'83',
        'sel_city_id'=>'40',
        'redirect'=>'',
        '4800f1991fe490143881fa01fd79ad526724b34d'=>'0',
        'ads_title'=>'новое12 объявление',
        'req_file'=>'ads_your_name=Bdfy',
        'ads_phone'=>'9995555555',
        'ads_email'=>'Hfa123garin_sdfsdf@tut.by',
        'ads_messenger'=>'478985265',
        'ads_url'=>'',
        'ads_address'=>'г.Минск',
        'agreement'=>'on'));
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 (.NET CLR 3.5.30729)'); //эта строчка как-бы говорит: "я не скрипт, я IE5" :)
curl_setopt ($curl, CURLOPT_REFERER, "http://free-ob.by/command.php"); //а вдруг там проверяют наличие рефера
$res = curl_exec($curl);
$info=curl_getinfo($curl);
//если ошибка то печатаем номер и сообщение
if(!$res) {
    $error = curl_error($curl).'('.curl_errno($curl).')';
    echo $error;
}
print_r($info);
curl_close($curl);