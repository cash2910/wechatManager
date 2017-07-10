var mgUI = {
	msgTpl = '<div class="js_dialog" id="iosDialog2" style="opacity: 0; display: none;">'+
				    '<div class="weui-mask"></div>'+
				    '<div class="weui-dialog">'+
				        '<div class="weui-dialog__bd">{$msg}</div>'+
				        '<div class="weui-dialog__ft">'+
				            '<a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>'+
				        '</div>'+
				   ' </div>'+
			 '</div>';
	msg:function( msg, callback ){
		$(msgTpl).fadeIn(200);
	}
}