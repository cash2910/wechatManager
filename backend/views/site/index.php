<?php

/* @var $this yii\web\View */
$this->title = Yii::$app->params['company_name'];
?>
<div class="site-index">
    <div class="row" style="border:1px solid black; margin-bottom:10px;">
        <div class="col-lg-12">
        </div>
        <div id="main" style="height:400px; " class="col-lg-12" ></div>
    </div>
    <div class="row" style="border:1px solid black; " >
        <div class="col-lg-12">
        </div>
        <div id="user_main" style="height:400px;" class="col-lg-12" ></div>
    </div>
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
			        data:['最近7天充值记录']
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

	//获取用户数据
	$.ajax({
		url:'/Wechat/default/get-cumulate',
		async:false,
		success:function( d ){
			var ret = eval("("+d+")");
			series = ret.series;
			sum = ret.sum;
	    }
	});
	
	var userChart = echarts.init(document.getElementById('user_main'));
	var option = {
		 	tooltip : {
		        trigger: 'axis'
		    },
		    legend: {
		        data:['最近7天微信关注用户数']
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
		            name:'关注人数',
		            type:'line',
		            stack: '总量',
		            data:sum
		        }
		    ]
        }
		userChart.setOption(option);
	
});
</script>