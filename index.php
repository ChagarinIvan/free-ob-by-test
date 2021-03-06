<?php

//ini_set('display_errors','OFF');

if (empty($_SESSION)){
    session_start();
}

/*
 * Вначале форма запрашивает город и категорию, потом запрашивает тело объявления через
 * форму, которая отправляет POST на тот же Action, что и форма на сайте.
 *
 * В итоге получается редирект на страницу (успех/неуспех), чего не хотелось бы.
 */


if (empty($_GET))
{
    $city_array = Array(
        2 => 'Барановичи',
        82 => 'Барань',
        5 => 'Берёза',
        83 => 'Березино',
        48 => 'Берёзовка',
        31 => 'Бобруйск',
        24 => 'Борисов',
        81 => 'Браслав',
        1 => 'Брест',
        78 => 'Верхнедвинск',
        29 => 'Вилейка',
        6 => 'Витебск',
        20 => 'Волковыск',
        63 => 'Воложин',
        75 => 'Ганцевичи',
        61 => 'Глубокое',
        60 => 'Глуск',
        10 => 'Гомель',
        32 => 'Горки',
        17 => 'Гродно',
        46 => 'Дзержинск',
        37 => 'Дрогичин',
        73 => 'Дятлово',
        69 => 'Ельск',
        56 => 'Житковичи',
        12 => 'Жлобин',
        27 => 'Жодино',
        84 => 'Заславль',
        66 => 'Иваново',
        43 => 'Ивацевичи',
        15 => 'Калинковичи',
        40 => 'Клецк',
        49 => 'Климовичи',
        4 => 'Кобрин',
        55 => 'Копыль',
        87 => 'Кореличи',
        68 => 'Корма',
        39 => 'Костюковичи',
        34 => 'Кричев',
        62 => 'Крупки',
        71 => 'Лельчицы',
        54 => 'Лепель',
        18 => 'Лида',
        88 => 'Логойск',
        74 => 'Лоев',
        45 => 'Лунинец',
        90 => 'Любань',
        47 => 'Марьина Горка',
        23 => 'Минск',
        80 => 'Миоры',
        30 => 'Могилёв',
        11 => 'Мозырь',
        26 => 'Молодечно',
        76 => 'Мосты',
        86 => 'Мстиславль',
        59 => 'Мядель',
        57 => 'Несвиж',
        22 => 'Новогрудок',
        8 => 'Новополоцк',
        7 => 'Орша',
        33 => 'Осиповичи',
        58 => 'Островец',
        36 => 'Ошмяны',
        70 => 'Петриков',
        3 => 'Пинск',
        9 => 'Полоцк',
        35 => 'Поставы',
        42 => 'Пружаны',
        14 => 'Речица',
        16 => 'Рогачёв',
        13 => 'Светлогорск',
        50 => 'Славгород',
        19 => 'Слоним',
        28 => 'Слуцк',
        38 => 'Смолевичи',
        21 => 'Сморгонь',
        25 => 'Солигорск',
        64 => 'Старые Дороги',
        41 => 'Столбцы',
        89 => 'Столин',
        91 => 'Толочин',
        65 => 'Узда',
        77 => 'Фаниполь',
        67 => 'Хойники',
        53 => 'Хотимск',
        52 => 'Чаусы',
        79 => 'Червень',
        51 => 'Чериков',
        72 => 'Чечерск',
        44 => 'Шклов',
        85 => 'Щучин',
    );
    $section_array = Array(
        78 => 'Ищу работу, резюме',
        79 => 'Предложения работы, вакансии',
        80 => 'Дополнительный заработок',
        81 => 'Работа в интернете',
        82 => 'Работа за рубежом',
        83 => 'Кадровые агентства, услуги поиска работы',
        84 => 'Другая работа',
        24 => 'Квартиры',
        25 => 'Комнаты',
        26 => 'Дома, коттеджи, земельные участки',
        85 => 'Услуги, сделки с недвижимостью',
        29 => 'Гаражи, стоянки',
        27 => 'Коммерческие площади',
        28 => 'Зарубежная недвижимость',
        30 => 'Другая недвижимость',
        69 => 'Медицинские услуги',
        68 => 'Юридические услуги',
        62 => 'Бизнес услуги',
        61 => 'Грузоперевозки',
        63 => 'Здоровье и красота',
        65 => 'Образование и наука',
        64 => 'Строительство и ремонт',
        66 => 'Финансовые услуги',
        70 => 'Ремонт бытовой, теле-, видео, кино-, фототехники, сотовых, компьютеров',
        67 => 'Другие услуги',
        55 => 'Покупка',
        56 => 'Продажа',
        57 => 'Отдам даром',
        58 => 'Услуги',
        59 => 'Товары для животных и растений',
        31 => 'Легковые автомобили',
        33 => 'Мотоциклы и мототехника',
        36 => 'Квадроциклы. Вездеходы. Снегоходы',
        32 => 'Запчасти, комплектующие, аксессуары',
        34 => 'Грузовики, автобусы, прицепы',
        35 => 'Спецтехника',
        37 => 'Водный транспорт',
        38 => 'Самолеты. Вертолеты. Воздушный транспорт',
        44 => 'Бытовая техника и электронника',
        86 => 'Все для дома',
        71 => 'Домашний обиход',
        41 => 'Инструменты, электроинструмент',
        39 => 'Компьютерная и оргтехника',
        51 => 'Косметика, парфюмерия',
        50 => 'Мебель, интерьер',
        53 => 'Музыкальные инструменты',
        42 => 'Одежда, обувь, аксессуары',
        48 => 'Подарки и сувениры',
        47 => 'Спортивные товары',
        45 => 'Строительство и ремонт',
        40 => 'Телефоны и связь',
        43 => 'Товары для детей',
        49 => 'Товары для дома и дачи',
        46 => 'Туризм, альпинизм, экспедиции',
        52 => 'Ювелирные украшения, бижутерия',
        75 => 'Все что не вошло в другие рубрики',
        76 => 'Общение и знакомства',
        73 => 'Потери и находки',
        74 => 'Розыск людей',
    );
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

