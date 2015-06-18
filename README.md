yii2-chart
==========
Chart Extension for Yii 2.0 With ChartNewJs

What is ChartNewJs??
It's library for chart from https://github.com/FVANCOP/ChartNew.js/
This library improved from https://github.com/nnnick/Chart.js/ with awesome added feature

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hscstudio/yii2-chart "~1.0"
```

or add

```
"hscstudio/yii2-chart": "~1.0"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hscstudio\chart\Chart::widget(); ?>
```
or

```php
<?php
use hscstudio\chart\ChartNew;
echo ChartNew::widget([
  'type'=>'bar', # pie, doughnut, line, bar, horizontalBar, radar, polar, stackedBar, polarArea
  'title'=>'PHP Framework',
  'labels'=>['Yii','Laravel','CI','Symfony'],
  'datasets' => [
	  ['title'=>'2014','data'=>[35,45,15,5]],
	  ['title'=>'2015','data'=>[45,35,5,15]],
  ],
]);
?>
```

