var mgUI = {
	msgTpl : '<div class="js_dialog" id="_iosDialog2" style="display:none;">'+
				    '<div class="weui-mask"></div>'+
				    '<div class="weui-dialog">'+
				        '<div class="weui-dialog__bd">{$msg}</div>'+
				        '<div class="weui-dialog__ft">'+
				            '<a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>'+
				        '</div>'+
				   ' </div>'+
              '</div>',
    loadTpl:'<div class="js_dialog" id="_loadingToast" style="display:none;">'+
		        '<div class="weui-mask"></div>'+
		        '<div class="weui-toast">'+
		            '<i class="weui-loading weui-icon_toast"></i>'+
		            '<p class="weui-toast__content">数据加载中</p>'+
		        '</div>'+
		    '</div>',
	msg:function( msg, callback ){
		var $msg = $("#_iosDialog2");
		if(  !$msg.length ){
			$msg = $(this.msgTpl);
			$msg.appendTo( 'body' ).on('click', '.weui-dialog__btn', function(){
	            $(this).parents('.js_dialog').fadeOut(200);
	            if( typeof callback == 'function' ) 
	            	callback();
	        });
		}
		$msg.find(".weui-dialog__bd").html( msg );
		$msg.fadeIn(200);
	},
	
	startload: function( msg , timeout , callback ){
		var $load = $("#_loadingToast");
		if(  !$load.length ){
			$load = $( this.loadTpl );
			$load.appendTo('body');
		}
		!msg || $load.find(".weui-toast__content").html( msg );
		$load.fadeIn(100);
		if( !timeout )
			return false;
        setTimeout(function () {
        	$load.fadeOut(100);
        	if( typeof callback == 'function' ) 
        		callback();
        }, timeout); 
	},
	
	endload:function(){
		var $load = $("#_loadingToast");
		if( $load.length )
			$load.fadeOut(100);
	}
	

}