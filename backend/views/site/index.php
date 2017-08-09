<?php

/* @var $this yii\web\View */
$this->title = Yii::$app->params['company_name'];
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-12">
            <h3>充值记录</h3>
        </div>
        <div id="main" style="height:400px; border:1px solid black; " class="col-lg-12" ></div>
    </div>
<!--     <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div> -->
</div>
<script src="/js/echarts-all.js"></script>
<script src="/js/jquery-2.2.3.min.js"></script>
<script>
$(function(){
	var series = [], sum = [];
	$.ajax({
		url:'/Order/default/get-charge',
		async:false,
		success:function( d ){
			var ret = eval("("+d+")");
			if( !ret.isOk )
				return ;
			series = ret.data.series;
			sum = ret.data.sum;
	    }
	});
	var myChart = echarts.init(document.getElementById('main'));
	var option = {
			 	tooltip : {
			        trigger: 'axis'
			    },
			    legend: {
			        data:['充值记录']
			    },
			    toolbox: {
			        show : true,
			        feature : {
			            mark : {show: true},
			            dataView : {show: true, readOnly: false},
			            magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
			            restore : {show: true},
			            saveAsImage : {show: true}
			        }
			    },
			    calculable : true,
			    xAxis : [
			        {
			            type : 'category',
			            boundaryGap : false,
			            data : series
			        }
			    ],
			    yAxis : [
			        {
			            type : 'value'
			        }
			    ],
			    series : [
			        {
			            name:'充值总额',
			            type:'line',
			            stack: '总量',
			            data:sum
			        }
			    ]
	}
	myChart.setOption(option);
});
</script>