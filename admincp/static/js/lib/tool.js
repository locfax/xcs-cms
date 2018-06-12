
function _attachEvent(obj, evt, func, eventobj) {
  eventobj = !eventobj ? obj : eventobj;
  if (obj.addEventListener)
    obj.addEventListener(evt, func, false);
  else if (eventobj.attachEvent)
    obj.attachEvent('on' + evt, func);
}

function _getEvent() {
  if (document.all)
    return window.event;
  func = _getEvent.caller;
  while (func != null) {
    var arg0 = func.arguments[0];
    if (arg0)
      if ((arg0.constructor == Event || arg0.constructor == MouseEvent) || (typeof(arg0) == "object" && arg0.preventDefault && arg0.stopPropagation))
        return arg0;
    func = func.caller;
  }
  return null;
}

//阻断
function _doane(event) {
  e = event ? event : window.event;
  if (!e)
    e = _getEvent();
  if (e && $.browser.msie) {
    e.returnValue = false;
    e.cancelBubble = true;
  } else if (e) {
    e.stopPropagation();
    e.preventDefault();
  }
}

/*收藏*/
function bookmark() {
  var url = document.location.href;
  var title = document.title;
  window.external.AddFavorite(url, title);
}

function fireCopy(obj, text) {
  obj.zclip({
    path: 'assets/js/zero.swf',
    copy: text
  });
}

//复制文本到剪切板
function copyText(obj, text) {
  if ($.browser.msie) {
    window.clipboardData.setData('text', text);
    alert('已复制，请使用Ctrl+V粘贴出来');
  } else {
    fireCopy(obj, text); //采用flash方式复制
  }
}

/**
 * 检测是否装了Flash播放器
 */
function flashVer() {
  var f = "-",
    n = navigator;
  if (n.plugins && n.plugins.length) {
    for (var ii = 0; ii < n.plugins.length; ii++) {
      if (n.plugins[ii].name.indexOf('Shockwave Flash') != -1) {
        f = n.plugins[ii].description.split('Shockwave Flash ')[1];
        break;
      }
    }
  } else if (window.ActiveXObject) {
    for (var ii = 10; ii >= 2; ii--) {
      try {
        var fl = eval("new ActiveXObject('ShockwaveFlash.ShockwaveFlash." + ii + "');");
        if (fl) {
          f = ii + '.0';
          break;
        }
      } catch (e) {}
    }
  }
  //return f;
  if (f.indexOf("8") != 0 && f.indexOf("9") != 0)
    alert("您的系统未安装Flash8版本及其以上的Flash播放器无法正常查看相关内容");
}

function makesmallpic(obj, w, h) {
  var srcImage = new Image();
  srcImage.src = obj.src;
  var srcW = srcImage.width;
  var srcH = srcImage.height;

  if (srcW == 0) {
    obj.src = srcImage.src;
    srcImage.src = obj.src;
    var srcW = srcImage.width;
    var srcH = srcImage.height;
  }

  if (srcH == 0) {
    obj.src = srcImage.src;
    srcImage.src = obj.src;
    var srcW = srcImage.width;
    var srcH = srcImage.height;
  }

  if (srcW > srcH) {
    if (srcW > w) {
      obj.width = newW = w;
      obj.height = newH = (w / srcW) * srcH;
    } else {
      obj.width = newW = srcW;
      obj.height = newH = srcH;
    }
  } else {
    if (srcH > h) {
      obj.height = newH = h;
      obj.width = newW = (h / srcH) * srcW;
    } else {
      obj.width = newW = srcW;
      obj.height = newH = srcH;
    }
  }
  if (newW > w) {
    obj.width = w;
    obj.height = newH * (w / newW);
  } else if (newH > h) {
    obj.height = h;
    obj.width = newW * (h / newH);
  }
}

function login_reg_input(b) {
  setinputcss(b);
  $(b).mouseup(function() {
    setinputcss(b);
  });
  $(b).blur(function() {
    if ($.trim($(this).val()) == "") {
      $(this).removeClass("form-input-focus");
      $(this).prev().removeClass("item-tip-focus");
    }
  });
  $(b).focus(function() {
    if (!$(this).hasClass("form-input-focus")) {
      $(this).addClass("form-input-focus");
      $(this).prev().addClass("item-tip-focus");
    }
  });
  $(".item-tip").click(function() {
    $(this).next().focus();
  });
}

function setinputcss(b) {
  $(b).each(function() {
    if ($.trim($(this).val()) != "") {
      $(this).addClass("form-input-focus");
      $(this).prev().addClass("item-tip-focus");
    }
  });
}

/* 取本地全路径 */
function getFullPath(obj) {
  if (obj) {
    //ie
    if (window.navigator.userAgent.indexOf("MSIE") >= 1) {
      obj.select();
      return document.selection.createRange().text;
    }
    //firefox
    else if (window.navigator.userAgent.indexOf("Firefox") >= 1) {
      if (obj.files) {
        return obj.files.item(0).getAsDataURL();
      }
      return obj.value;
    }
    return obj.value;
  }
}

function getQueryStr(url, str) {
  var rs = new RegExp("(^|)" + str + "=([^\&]*)(\&|$)", "gi").exec(url),
    tmp;
  if (tmp = rs) {
    return tmp[2];
  }
  return "";
}