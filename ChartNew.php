<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace hscstudio\chart;

use yii\bootstrap\Widget;
use hscstudio\chart\ChartNewAsset;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Chart with ChartNew
 * ChartNew original in https://github.com/FVANCOP/ChartNew.js, 
 * it improve from Chart.js https://github.com/nnnick/Chart.js
 *
 * For example,
 *
 * ```php
 *     <?php
 *         use hscstudio\chart\ChartNew;
 *         echo ChartNew::widget([
 *             'type'=>'bar',
 *             'title'=>'PHP Framework',
 *             'labels'=>['Yii','Laravel','CI','Symfony'],
 *             'datasets' => [
 *                 ['title'=>'2014','data'=>[35,45,15,5]],
 *                 ['title'=>'2015','data'=>[45,35,5,15]],
 *             ],
 *         ]);
 *     ?>
 * ```
 * @see http://www.hafidmukhlasin.com
 * @author Hafid Mukhlasin <hafidmukhlasin@gmail.com>
 * @since 1.0
 */
class ChartNew extends Widget
{
	# auto generate if empty
	public $id; 
	public $title='PHP Framework';
	public $labels = ['Yii','Laravel','CI','Symfony'];
	public $datasets = [
		['title'=>'2014','data'=>[35,45,15,5]],
		['title'=>'2015','data'=>[45,35,5,15]],
	];
	# pie, doughnut, line, bar, horizontalBar, radar, polar, stackedBar, polarArea
    public $type = 'pie'; 
	
	# http://developer.android.com/design/style/color.html
	public $colors = [
		'soft' => ['#33B5E5','#AA66CC','#99CC00','#FFBB33','#FF4444'],
		'hard' => ['#0099CC','#9933CC','#669900','#FF8800','#CC0000'],
	];
	
	# area canvas chart in px
	public $height = '360';
	public $width = '510';
    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    
	public function init()
    {
        parent::init();
		if(empty($this->id)){
			$this->id = 'Chart'.rand(0,1000);
		}
		echo Html::beginTag('canvas',[
			'id' => $this->id,
			'height' => $this->height,
			'width' => $this->width,
			'style' => "width: ".$this->width."px; height: ".$this->height."px;",
		]);
		echo Html::endTag('canvas');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {        
		ChartNewAsset::register($this->getView());
		return $this->renderChart();
    }

    /**
     * Renders menu items.
     * @param array $items the menu items to be rendered
     * @param array $options the container HTML attributes
     * @return string the rendering result.
     * @throws InvalidConfigException if the label option is not specified in one of the items.
     */
    protected function renderChart()
    {
		$this->view->registerJs('
			var charJSPersonnalDefaultOptions = { 
				decimalSeparator : "," , 
				thousandSeparator : ".", 
				roundNumber : "none", 
				graphTitleFontSize: 2 
			};
			var startWithDataset =1;
			var startWithData =1;
			var options = {
			  animationStartWithDataset : startWithDataset,
			  animationStartWithData : startWithData,
			  animationLeftToRight : true,
			  animationByDataset : true,
			  animateRotate : true,
			  animateScale : true,
			  animationByData : true,
			  animationSteps : 200,
			  animationEasing: "linear",
			  canvasBorders : true,
			  canvasBordersWidth : 1,
			  canvasBordersColor : "#efefef",
			  graphTitle : "'.$this->title.'",
			  legend : true,
			  inGraphDataShow : true,
			  annotateDisplay : true,
			  spaceBetweenBar : 5,
			  graphTitleFontSize: 12,
			  /*
			  crossText : ["Total:\n#sum#"],
			  crossTextIter: ["all"],
			  crossTextOverlay :   [true],
			  crossTextFontSize : [50],
			  crossTextFontColor : ["black"],
			  crossTextRelativePosX : [2],
			  crossTextRelativePosY : [2],
			  crossTextAlign : ["center"],
			  crossTextBaseline : ["middle"],
			  */
			};
			var chartCanvas'.$this->id.' = $("#'.$this->id.'").get(0).getContext("2d");
			var chart'.$this->id.' = new Chart(chartCanvas'.$this->id.');
		');
		
		if(in_array($this->type,['bar','line','horizontalBar','radar','stackedBar','horizontalStackedBar'])){
			$labels = '["'.implode('","',$this->labels).'"]';
			$chartData = '';
			$i=0;
			foreach($this->datasets as $dataset){
				$chartData .= '{'."\n";
				$data = '['.implode(',',$dataset['data']).']';
				if(in_array($this->type,['line','radar'])){
					$chartData .= ' fillColor: "#efefef",'."\n";		
				}
				else{
					$chartData .= ' fillColor: "'.$this->colors['soft'][($i%4)].'",'."\n";
				}
				$chartData .= ' strokeColor: "'.$this->colors['soft'][($i%4)].'",'."\n";		
				$chartData .= ' pointColor: "'.$this->colors['soft'][($i%4)].'",'."\n";		
				$chartData .= ' pointstrokeColor: "'.$this->colors['soft'][($i%4)].'",'."\n";		
				$chartData .= ' title: "'.$dataset['title'].'",'."\n";			
				$chartData .= ' data: '.$data.','."\n";			
				$chartData .= '},'."\n";
				$i++;
			}
			$this->view->registerJs('
				var data'.$this->id.' = {
					labels : '.$labels.',
					datasets : [
						'.$chartData.'
					]
				} 	
			');
		}
		else if(in_array($this->type,['pie','doughnut','polarArea'])){
			$chartData = '';
			$i=0;
			foreach($this->datasets as $dataset){
				$j = 0;
				foreach($this->labels as $label){
					$chartData .= '{'."\n";
					$chartData .= ' value: '.$dataset['data'][$j].','."\n";			
					$chartData .= ' color: "'.$this->colors['hard'][($j%4)].'",'."\n";		
					$chartData .= ' title: "'.$label.'",'."\n";;			
					$chartData .= '},'."\n";
					$j++;
				}
				break;
				$i++;
			}
			$this->view->registerJs('
				var data'.$this->id.' = [
				   '.$chartData.'
				];	
			');
		}
		else{
			
		}
		$this->view->registerJs('			
			chart'.$this->id.'.'.ucfirst($this->type).'(data'.$this->id.', options);
		');
    }
}
