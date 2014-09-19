<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Тестовое задание для Yii программиста</h1>

Задача:
<p>Нужно спроектировать и создать модуль каталога товаров на  Yii 1.x, состоящий из категории товара, товара и тегов товаров. У товара может быть несколько категорий и тегов. Выводятся и участвуют в расчетах только активные сущности. В модуле должны быть следующие веб страницы на которые должны выводится: </p>
<p>1.список категорий и всех товаров (разбить товары по категориям).</p>
<p><a href="/category/list">список категорий и всех товаров</a></p>
<p>2.список товаров в категории (идентификатор категории передается через параметры запроса, у каждого товара вывести его теги и другие категории к которым он принадлежит)</p>
<p><a href="/category/index">список категорий, перейти на страницу категории (id содержится в url)(первая ссылка)</a></p>
<p>3.страница товара с тегами и категориями товара (идентификатор товара передается через параметры запроса)</p>
<p><a href="/product/index">список товаров, перейти на страницу товара (id содержится в url)</a></p>
<p>4.список тегов товаров присутствующих в категории и список тегов отсутствующих в категории (идентификатор категории передается через параметры запроса)</p>
<p><a href="/category/index">список тегов товаров присутствующих в категории и список тегов отсутствующих в категории (id содержится в url)(последняя ссылка)</a></p>
<p>5.список всех товаров  отсортированный по кол-ву тегов товара (посчитать кол-во тегов у каждого товара и отсортировать его)</p>
<p><a href="/product/ViewTagsCounts">список всех товаров  отсортированный по кол-ву тегов товара</a></p>
<p>6.создать облако тегов</p>
<p><a href="/tag/all">облако тегов</a></p>
