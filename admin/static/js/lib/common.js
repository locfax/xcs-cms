//window.onerror = function(){ return true;}
"use strict";

function loadJS(url,callback,charset){
	var script = document.createElement('script');
	script.onload = script.onreadystatechange = function (){
		if (script && script.readyState && /^(?!(?:loaded|complete)$)/.test(script.readyState)) return;
		script.onload = script.onreadystatechange = null;
		script.src = '';
		script.parentNode.removeChild(script);
		script = null;
		if(typeof callback == 'function')callback();
	};
	script.charset=charset || document.charset || document.characterSet;
	script.src = url;
	try {document.getElementsByTagName("head")[0].appendChild(script);} catch (e) {}
}

var screendata = {};

function _screen() {
	var win = $(window), body = $('body');
	screendata = {
		winwidth: win.width(),
		winheight: win.height(),
		docwidth: body.width(),
		docheight: body.height()
	};
}

function mobile(){
	var u = navigator.userAgent; //, app = navigator.appVersion;
	//var trident = u.indexOf('Trident') > -1; //IE内核
	//var presto = u.indexOf('Presto') > -1; //opera内核
	//var webKit = u.indexOf('AppleWebKit') > -1; //苹果、谷歌内核
	//var gecko = u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1; //火狐内核
	//var mobile = !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/); //是否为移动终端
	var ios = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
	var android = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
	var iPhone = u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1; //是否为iPhone或者QQHD浏览器
	var iPad = u.indexOf('iPad') > -1; //是否iPad
	//var webApp = u.indexOf('Safari') == -1; //是否web应该程序，没有头部与底部
	if(ios || iPhone || iPad || android){
		return true;
	}
	return false;
}

var storebtndata = {}, editid = null, conmaskEl = null, contentEl = null, contentElhtml = null;


var downup_tips = function (msg, time, bgc) {
	top.showLoader(msg, time);
};

var check_tips = function(str, follow) {

	top.showLoader(str, 5);

	follow.focus();
	if (follow.type == "text") {
		follow.select();
	}

};

$.fn.btnload = function(opt) {
	if (opt == 'loading') {
		if (this.data('loading-text')) {
			if (!this.attr('value')) {
				storebtndata['resetText'] = this.html();
				this.html(this.data('loading-text'));
			} else {
				storebtndata['resetText'] = this.val();
				this.val(this.data('loading-text'));
			}
		}
		this.attr("disabled", true);
	} else if (opt == 'reset') {
		if (this.data('loading-text')) {
			if (!this.attr('value')) {
				this.html(storebtndata['resetText']);
			} else {
				this.val(storebtndata['resetText']);
			}
		}
		this.attr("disabled", false);
	}
};

var theList = {

	redirect: function(o, msg) {
		if(!confirm(msg)) {
			return false;
		}
		location.href = o.href;
	},

	confirm: function (o, msg) {
		if(!confirm(msg)) {
			return false;
		}
		$.ajax({
			url: o.href,
			dataType: 'json',
			beforeSend: function () {
				$(o).btnload('loading');
			},
			error: function (xhr, ts, et) {
				downup_tips('err:' + ts + et, 5, 'red');
			},
			success: function (res) {
				if (typeof res.errmsg != 'undefined') {
					if (res.errcode == 1) {
						downup_tips(res.errmsg, 5, 'red');
					} else {
						downup_tips(res.errmsg);
					}
					if (typeof res.reload != 'undefined') {
						theList.reload();
					}
				} else {
					downup_tips(res);
				}
			},
			complete: function () {
				setTimeout(function () {
					$(o).btnload('reset');
				}, 1000);
			},
			cache: false
		});
		return false;
	},

	reload: function () {
		document.location.replace(document.location.href);
	},

	edit: function (id, o, callback) {
		//$(o).btnload('loading');
		var url = o.href;
		$('#col_right').html('<div style="align:center; margin-left:10px; margin-top:10px;"><img src="static/img/loading.gif" width="15" height="15"/> 玩命加载中...</div>');
		$.ajax({url: url,
			dataType: "xml",
			error: function (xhr, ts, et) {
				$('#col_right').html('err:' + ts + et);
				//$(o).btnload('reset');
			},
			success: function (res) {
				if (typeof callback == 'function') {
					callback(id, res);
				} else {
					var top = $('#col_right').html($(res).find("root").text()).offset().top;
					$('.con_scoll').height(screendata.winheight-top-44);
				}
				if (editid) {
					$('#' + editid).removeClass(callback);
				}
				if (id) {
					$('#' + id).addClass(callback);
					editid = id;
				}
				//$(o).btnload('reset');
			},
			cache: false
		});
		return false;
	},

	openDrawer: function (id, o, callback, editor) {
		if (conmaskEl == null) {
			$('body').append('<div id="drawer-overlay"></div><div id="drawer-wrapper"><ol class="breadcrumb" style="margin-bottom:0;margin-left:0;"><li><a href="javascript:;" onclick="theList.closeDrawer();"><img src="static/img/icons/chkerror.gif" title="双击黑色背景也可关闭"/></a> <span id="title_tips">...</span></li></ol><div id="drawer-wrapper-html"></div></div>');
			conmaskEl = $('#drawer-overlay');
			contentEl = $('#drawer-wrapper');
			contentElhtml = $('#drawer-wrapper-html');
			if (contentEl.length <= 0) {
				downup_tips('打开失败');
				return;
			}
		}
		var docwidth = screendata.docwidth, docheight = screendata.docheight;
		if (screendata.winwidth > screendata.docwidth) {
			docwidth = screendata.winwidth;
		}
		if (screendata.winheight > screendata.docheight) {
			docheight = screendata.winheight;
		}

		conmaskEl.width(docwidth).height(docheight).show().on('dblclick',function(){ theList.closeDrawer();}).on('selectstart',function(){ return false; });
		contentEl.css({'top': $('body').scrollTop()+35}).width(docwidth-200).height(docheight-35).show();
		if (id) {
			$('#title_tips').html('编辑');
		} else {
			$('#title_tips').html('创建');
		}
		contentElhtml.html('<div style="align:center;margin-left:10px; margin-top:10px;"><img src="static/img/loading.gif" width="15" height="15"/> 玩命加载中...</div>');

		$.ajax({
			url: o.href,
			dataType: "xml",
			error: function (xhr, ts, et) {
				contentElhtml.html('err:' + ts + et);
			},
			success: function (res) {
				if (typeof callback == 'function') {
					callback(id, res);
				} else {
					contentElhtml.html($(res).find("root").text());
					$('.con_scoll').height(screendata.winheight-80);
					if (typeof editor != 'undefined' && editor) {
						theForm.editor(".richtext-clone", 400);
					}
				}
			},
			cache: false
		});
		return false;
	},

	closeDrawer: function () {
		if(conmaskEl == null) {
			return;
		}
		contentEl.hide();
		conmaskEl.hide();
		if (typeof KindEditor != 'undefined') {
			KindEditor.remove($('.richtext-clone'));
		}
		contentElhtml.html('');
	},

	checkAll: function (form, prefix, checkall, styleid, changestyle) {
		var checkall = checkall ? checkall : 'chkall';
	    var count = 0;
	    for (var i = 0; i < form.elements.length; i++) {
	        var e = form.elements[i];
	        if (e.name && e.name != checkall && (!prefix || (prefix && e.name.match(prefix)))) {
	            e.checked = form.elements[checkall].checked;
	            if (e.checked) {
	                count++;
	                if (changestyle){
	                    $('#' + styleid + '_' + e.value).addClass(changestyle);
	                }
	            } else {
	                if (changestyle){
	                    $('#' + styleid + '_' + e.value).removeClass(changestyle);
	                }
	            }
	        }
	    }
	    return count;
	}
};

var theForm = {

	confirm: function (o) {
		$.ajax({
			url: o.href,
			dataType: 'json',
			error: function (xhr, ts, et) {
				downup_tips('err:' + ts + et, 5, 'red');
			},
			success: function (res) {
				if (typeof res.errmsg != 'undefined') {
					if (res.errcode == 1){
						downup_tips(res.errmsg, 5, 'red');
					} else {
						downup_tips(res.errmsg);
					}
					if (typeof res.tourl != 'undefined') {
						theForm.redirect(res.tourl);
					}
					if (typeof res.reload != 'undefined') {
						theList.reload();
					}
				} else {
					downup_tips(res);
				}
			},
			cache: false
		});
		return false;
	},

	submit: function(btn, form, callback, check) {

	 	if (typeof check != 'undefined' && check) {
	 		if(!this.checkform(form)) {
	 			return false;
	 		}
	 	}

		$('#'+form).ajaxSubmit({
			dataType: "json",
			beforeSend: function () {
				$(btn).btnload('loading');
			},
			error: function (xhr, ts, et) {
				downup_tips('err:'+ ts + et, 5, 'red');
			},
			success: function(res) {
				if (typeof callback == 'function') {
					callback(res);
				} else {
					if (typeof res.errmsg != 'undefined') {
						if (res.errcode == 1) {
							downup_tips(res.errmsg, 5, 'red');
						} else {
							downup_tips(res.errmsg, 5);
						}
						if (typeof res.tourl != 'undefined') {
							theForm.redirect(res.tourl);
						}
						if (typeof res.reload != 'undefined') {
							theList.reload();
						}
					} else {
						downup_tips(res);
					}
				}
			},
			complete: function () {
				setTimeout(function () {
					$(btn).btnload('reset');
				}, 500);
			},
			cache: false
		});

		return false;
	},

	checkform: function(form) {
		var ret = $.checkform($('#' + form).get(0), check_tips);
		return ret;
	},

	redirect: function(url) {
		location.href = url;
	},

	editormin: function (selector, height) {
		var selector = selector ? selector : 'textarea[class="richtext"]';
		var option = {
			basePath: 'static/editor/kindeditor/',
			themeType: 'simple',
			langType: 'zh-CN',
			width: '100%',
			minHeight: height+'%',
			resizeType: 0,
			items: ['fontsize', 'forecolor', 'hilitecolor', '|' ,'source'],
			afterBlur: function(){this.sync();}
		};
		if (typeof KindEditor == 'undefined') {
			loadJS('static/editor/kindeditor/kindeditor-min.js', function () {
				initKindeditor(selector, option);
			});
		} else {
			initKindeditor(selector, option);
		}
		function initKindeditor(selector, option) {
			try{
				KindEditor.create(selector, option);
			}catch(e){
				downup_tips('KindEditor load failed !', 5, 'red');
			}
		}
	},

	editor: function (selector, height) {
		var selector = selector ? selector : 'textarea[class="richtext"]';
		var option = {
			basePath: 'static/editor/kindeditor/',
			themeType: 'simple',
			langType: 'zh-CN',
			uploadJson: '?c=attach&a=upload&type=editor',
			width: '100%',
			//height: height+'px',
			minHeight: height+'px',
			resizeType: 1,
			allowImageUpload: true,
			//items: ['undo', 'redo', '|', 'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'strikethrough', '|', 'image', 'multiimage', 'emoticons', 'link', 'unlink', '|', 'plainpaste', 'removeformat', 'source', 'fullscreen'],
			filterMode: false,
			htmlTags :{
				font : ['color', 'size', 'face', '.background-color'],
				span : ['style'],
				div : ['class', 'align', 'style'],
				table: ['class', 'border', 'cellspacing', 'cellpadding', 'width', 'height', 'align', 'style'],
				'td,th': ['class', 'align', 'valign', 'width', 'height', 'colspan', 'rowspan', 'bgcolor', 'style'],
				a : ['class', 'href', 'target', 'name', 'style'],
				embed : ['src', 'width', 'height', 'type', 'loop', 'autostart', 'quality','style', 'align', 'allowscriptaccess', '/'],
				img : ['src', 'width', 'height', 'border', 'alt', 'title', 'align', 'style', '/'],
				hr : ['class', '/'],
				br : ['/'],
				'p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6' : ['align', 'style'],
				'tbody,tr,strong,b,sub,sup,em,i,u,strike' : []
			},
			afterBlur: function(){this.sync();}
		};
		if (typeof KindEditor == 'undefined') {
			loadJS('static/editor/kindeditor/kindeditor-min.js', function () {
				initKindeditor(selector, option);
			});
		} else {
			initKindeditor(selector, option);
		}
		function initKindeditor(selector, option) {
			try{
				KindEditor.create(selector, option);
			}catch(e){
				downup_tips('KindEditor load failed !', 5, 'red');
			}
		}
	},

	editorUploadBtn: function (obj, callback) {
		if (typeof KindEditor == 'undefined') {
			loadJS('static/editor/kindeditor/kindeditor-min.js', initUploader);
		} else {
			initUploader();
		}
		function initUploader() {
			var uploadbutton = KindEditor.uploadbutton({
				button: obj,
				fieldName: 'imgFile',
				url: '?c=attach&a=upload',
				//width: 45,
				afterUpload: function (data) {
					if (data.errcode === 0) {
						if (typeof callback == 'function') {
							callback(uploadbutton, data);
						} else {
							var url = KindEditor.formatUrl(data.url, 'absolute');
							$(uploadbutton.div.parent().parent()[0]).find('#upload-file-view').html('<input value="' + data.filename + '" type="hidden" name="' + obj.attr('fieldname') + '" id="' + obj.attr('id') + '-value" /><img src="' + url + '" width="100" />');
						}
					} else {
						downup_tips(data.errmsg);
					}
					//downup_tips('上传完成...');
				},
				afterError: function (str) {
					downup_tips(str);
				}
			});
			uploadbutton.fileBox.change(function (e) {
				//downup_tips('开始上传...');
				uploadbutton.submit();
			});
		}
	},

	uploadBtn: function (obj, upurl, showdiv, input) {
		if (typeof KindEditor == 'undefined') {
			loadJS('static/editor/kindeditor/kindeditor-min.js', initUploader);
		} else {
			initUploader();
		}
		function initUploader() {
			var uploadbutton = KindEditor.uploadbutton({
				button: obj,
				fieldName: 'imgFile',
				url: upurl,
				//width: 45,
				afterUpload: function (data) {
					if (data.errcode === 0) {
						var url = data.url;
						$('#'+showdiv).attr({src: url});
						$('#'+input).val(data.path);
					} else {
						downup_tips(data.errmsg);
					}
					//downup_tips('上传完成...');
				},
				afterError: function (str) {
					downup_tips(str);
				}
			});
			uploadbutton.fileBox.change(function (e) {
				//downup_tips('开始上传...');
				uploadbutton.submit();
			});
		}
	},

	strLen: function (str) {
		return ($.browser.msie && str.indexOf('\n') != -1) ? str.replace('/\r?\n/g', '_').length : str.length;
	},

	cutStr: function (str, len) {
		var num = 0;
		var strlen = 0;
		var newstr = "";
		var laststrlen = 1;
		var obj_value_arr = str.split("");
		for (var i = 0; i < obj_value_arr.length; i++) {
			if (i < len && num + strLen(obj_value_arr[i]) <= len) {
				num += strLen(obj_value_arr[i]);
				strlen = i + 1;
			}
		}
		if (str.length > strlen) {
			if (strLen(str.charAt(strlen - 1)) == 1) {
				laststrlen = 2;
			}
			newstr = str.substr(0, strlen - laststrlen) + '...';
		} else
			newstr = str;
		return newstr;
	},

	inArray: function(needle, haystack) {
	    if (typeof needle == 'string' || typeof needle == 'number') {
	        for (var i in haystack) {
	            if (haystack[i] == needle)
	                return true;
	        }
	    }
	    return false;
	},

	isUndefined: function (mix) {
		return typeof mix == 'undefined' ? true : false;
	}
};

var itemHandler = {

  buildAddForm: function(id, targetwrap) {
    var sourceobj = $('#' + id);
    var html = $('<div class="item">');
    id = id.split('-')[0];
    var size = $('.item', $('#' + targetwrap)).size();
    var htmlid = id + '-item-' + size;
    while ($('#' + targetwrap).find('#' + htmlid).size() >= 1) {
      var htmlid = id + '-item-' + size++;
    }
    html.html(sourceobj.html().replace(/\(itemid\)/gm, htmlid));
    html.attr('id', htmlid);
    $('#' + targetwrap).append(html);
    return html;
  },

  doEditItem: function(itemid, targetwrap) {
    var parent = $('#' + itemid, $('#' + targetwrap));
    $('#form', parent).show();
    $('#show', parent).hide();
  },

  doDeleteItem: function(itemid, targetwrap, deleteurl) {
    if(confirm("确认删除么?")) {
        $('#' + itemid, $('#' + targetwrap)).remove();
		return true;
    }
    return false;
  }
};

var sweetTips = {
	 x : 10, // @Number: x pixel value of current cursor position
	 y : 20, // @Number: y pixel value of current cursor position
	 tipEls : "a", // @Array: Allowable elements that can have the toolTip,split with ","
	 init : function() {
		 $(this.tipEls).each(function() {
			 $(this).mouseover(function(e) {
				 var hasTitle = $.trim(this.title) != '';
				 if(hasTitle) {
					 this.tmpTitle = this.title;
					 this.title = "";
					 var tooltip = "<div id='tooltip'><p>"+this.tmpTitle+"</p></div>";
					 $('body').append(tooltip);
					 $('#tooltip').css({
						 "top" :( e.pageY+20)+"px",
						 "left" :( e.pageX+10)+"px"
					 }).show('fast');
				 }
			 }).mouseout(function() {
				 if(this.tmpTitle != null) {
					 this.title = this.tmpTitle;
					 $('#tooltip').remove();
				 }
			 }).mousemove(function(e) {
				 $('#tooltip').css({
					"top" :( e.pageY+20)+"px",
					"left" :( e.pageX+10)+"px"
				 });
			});
		});
	}
};

$(function(){
	if( top != self ) {
		sweetTips.tipEls = ".menu a, .table a, .table img, .table label, .table .form-control, .input-group-addon";
		sweetTips.init();
	};
	_screen();
});
