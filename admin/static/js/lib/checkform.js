/********************************************************************************\
 | 该版本用于日期格式为（yyyy-mm-dd)
 | 函数名称：check_form
 | 传入参数：form(表单)
 | 返回值：boolean型
 | 函数功能：自动验证表单的输入值。在控件里加入验证属性即可，不需要修改任何代码。
 | 调用方式：onSubmit="$.checkform(o)"
 | 验证属性格式：<input ... check_str="控件名称" check_type="验证类型" can_empty="Y" equal="另一个控件的名字">
 |     无类型：不写check_type
 |     字符串：string,10,20
 |     整数型：integer,-111,120
 |     浮点型：float,-2.1,10000
 |     日期型：date,2003-01-01,2003-08-01
 |     时间性：time,8:30,18:30
 |     邮  件：email
 |     身份证：idcard
 |     验证属性带逗号的表示最小值和最大值，如果不指定则不写，但逗号不能省略
 \*********************************************************************************/

(function (factory) {
    "use strict";
    if (typeof define === 'function' && define.amd) {
      // using AMD; register as anon module
      define(['jquery'], factory);
    } else {
      // no AMD; invoke directly
      factory((typeof(jQuery) != 'undefined') ? jQuery : window.Zepto);
    }
  }(function ($) { "use strict";

    $.extend($, {
      checkform: function(theform, callback) {
        if (typeof callback !== 'function') {
          callback = alert;
        }
        try {
          var aa = theform.elements;
          var obj = null;
          var jumpFromFor = false;
          var tempArr = null;

          for (var i = 0; i < aa.length; i++) {
            jumpFromFor = true; //如果中途跳出，jumpFromFor的值将被保持为true,表示验证未通过
            if (aa[i].attributes["data-tip"] != null && aa[i].attributes["data-tip"].value != "") {
              obj = aa[i];
              if (obj.value.length == 0) {
                if (obj.attributes["data-empty"] != null && obj.attributes["data-empty"].value == "Y") {
                  if (i == aa.length - 1) {
                    jumpFromFor = false;
                  }
                  continue;
                } else {
                  callback("『" + obj.attributes["data-tip"].value + "』不能为空，请重新输入", obj);
                  break;
                }
              }

              if (obj.attributes["data-equal"] != null && obj.attributes["data-equal"].value.length > 0) {
                var obj2 = eval(theform.name + "." + obj.attributes["data-equal"].value);
                if (obj2 != null) {
                  if (obj.value != obj2.value) {
                    callback("『" + obj.attributes["data-tip"].value + "』" + "必须与『" + obj2.attributes["data-tip"].value + "』相同", obj);
                    break;
                  }
                }
              }

              if (obj.attributes["data-not-equal"] != null && obj.attributes["data-not-equal"].value.length > 0) {
                var obj2 = eval(theform.name + "." + obj.attributes["data-not-equal"].value);
                if (obj2 != null) {
                  if (obj.value == obj2.value) {
                    callback("『" + obj.attributes["data-tip"].value + "』" + "与『" + obj2.attributes["data-tip"].value + "』不能相同", obj);
                    break;
                  }
                }
              }

              if (obj.attributes["data-type"] != null) {
                if (obj.attributes["data-type"].value == "email") {
                  if (!$.checkEmail(obj)) {
                    callback("您输入的『" + obj.attributes["data-tip"].value + "』不是合法的邮件格式", obj);
                    break;
                  }
                }

                if (obj.attributes["data-type"].value == "idcard") {
                  if (!$.checkIDCard(obj)) {
                    callback("您输入的『" + obj.attributes["data-tip"].value + "』不是合法的身份证", obj);
                    break;
                  }
                }

                if (/^string/.test(obj.attributes["data-type"].value)) {
                  tempArr = $.checkString(obj);
                  if (!tempArr[0]) {
                    callback(tempArr[1], obj);
                    break;
                  }
                }

                if (/^float/.test(obj.attributes["data-type"].value)) {
                  tempArr = $.checkFloat(obj);
                  if (!tempArr[0]) {
                    callback(tempArr[1], obj);
                    break;
                  }
                }

                if (/^integer/.test(obj.attributes["data-type"].value)) {
                  tempArr = $.checkInteger(obj);
                  if (!tempArr[0]) {
                    callback(tempArr[1], obj);
                    break;
                  }
                }

                if (/^date/.test(obj.attributes["data-type"].value)) {
                  tempArr = $.checkDate(obj);
                  if (!tempArr[0]) {
                    callback(tempArr[1], obj);
                    break;
                  }
                }

                if (/^time/.test(obj.attributes["data-type"].value)) {
                  tempArr = $.checkTime(obj);
                  if (!tempArr[0]) {
                    callback(tempArr[1], obj);
                    break;
                  }
                }
              }

            }
            jumpFromFor = false; //循环正常结束，未从循环中跳出,验证结果：全部满足要求
          }

          if (jumpFromFor) {
            try {
              obj.focus();
              if (obj.type == "text") {
                obj.select();
              }
            } catch (aa) {

            }
            return false;
          }
          return true;

        } catch (err) {
          alert(err);
          return false;
        }
      },

      checkEmail: function(obj) {
        return (/^\w+([-.]\w+)*@([\w-]){1,}(\.([\w]){1,}){1,}$/.test(obj.value));
      },

      checkIDCard: function(obj) {
        if (obj.value.length == 15)
          return (/^([0-9]){15,15}$/.test(obj.value));
        if (obj.value.length == 18)
          return (/^([0-9]){17,17}([0-9xX]){1,1}$/.test(obj.value));
        return false;
      },

      checkString: function(obj) {
        var tempArr = new Array(true, "");
        var length = obj.value.length;
        var arr = obj.attributes["data-type"].value.split(",");
        var smallLength = parseInt(arr[1]);
        var bigLength = parseInt(arr[2]);
        if (length < smallLength || length > bigLength) {
          tempArr[0] = false;
          tempArr[1] = "『" + obj.attributes["data-tip"].value + "』的字符长度必须在" + smallLength + "~" + bigLength + "之间，请重新输入";
          return tempArr;
        }
        return tempArr;
      },

      checkFloat: function(obj) {
        var tempArr = new Array(true, "");
        if (!(/^([-]){0,1}([0-9]){1,}([.]){0,1}([0-9]){0,}$/.test(obj.value))) {
          tempArr[0] = false;
          tempArr[1] = "不是合法的实数，请重新输入『" + obj.attributes["data-tip"].value + "』";
          return tempArr;
        }
        var floatValue = parseFloat(obj.value);
        var arr = obj.attributes["data-type"].value.split(",");
        var smallFloat = parseFloat(arr[1]);
        var bigFloat = parseFloat(arr[2]);
        if (floatValue < smallFloat || floatValue > bigFloat) {
          tempArr[0] = false;
          tempArr[1] = "『" + obj.attributes["data-tip"].value + "』的大小必须在" + smallFloat + "~" + bigFloat + "之间，请重新输入";
          return tempArr;
        }
        return tempArr;
      },

      checkInteger: function(obj) {
        var tempArr = new Array(true, "");

        if (!(/^([-]){0,1}([0-9]){1,}$/.test(obj.value))) {
          tempArr[0] = false;
          tempArr[1] = "不是合法的整数，请重新输入『" + obj.attributes["data-tip"].value + "』";
          return tempArr;
        }
        var integerValue = parseInt(obj.value);
        var arr = obj.attributes["data-type"].value.split(",");
        var smallInteger = parseInt(arr[1]);
        var bigInteger = parseInt(arr[2]);
        if (integerValue < smallInteger || integerValue > bigInteger) {
          tempArr[0] = false;
          tempArr[1] = "『" + obj.attributes["data-tip"].value + "』的大小必须在" + smallInteger + "~" + bigInteger + "之间，请重新输入";
          return tempArr;
        }
        return tempArr;
      },

      checkDate: function(obj) {
        var tempArr = new Array(true, "");
        if (!(/^([0-9]){4,4}-([0-9]){1,2}-([0-9]){1,2}$/.test(obj.value))) {
          tempArr[0] = false;
          tempArr[1] = "不是合法的日期，请按\"YYYY-MM-DD\"的格式输入『" + obj.attributes["data-tip"].value + "』";
          return tempArr;
        }
        var arr = obj.value.match(/\d+/g),
        year = Number(arr[0]),
        month = Number(arr[1]),
        day = Number(arr[2]);
        var monthDay = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if (year % 400 == 0 || (year % 4 == 0 && year % 100 != 0))
          monthDay[1] = 29;
        if (year < 0 || month < 0 || month > 12 || day > 31 || day > monthDay[month - 1]) {
          tempArr[0] = false;
          tempArr[1] = "您输入了一个不存在的日期，请重新输入『" + obj.attributes["data-tip"].value + "』";
          return tempArr;
        }
        arr = obj.attributes["data-type"].value.split(",");
        if (arr[1] != null && arr[1].length > 0) {
          var arr2 = arr[1].match(/\d+/g);
          var smallYear = Number(arr2[0]);
          var smallMonth = Number(arr2[1]);
          var smallDay = Number(arr2[2]);
          if (smallYear > year || (smallYear == year && smallMonth > month) || (smallYear == year && smallMonth == month && smallDay > day)) {
            tempArr[0] = false;
            tempArr[1] = "日期不能小于" + arr[1] + "，请重新输入『" + obj.attributes["data-tip"].value + "』";
            return tempArr;
          }
        }

        if (arr[2] != null && arr[2].length > 0) {
          arr2 = arr[2].match(/\d+/g);
          var bigYear = Number(arr2[0]);
          var bigMonth = Number(arr2[1]);
          var bigDay = Number(arr2[2]);
          if (bigYear < year || (bigYear == year && bigMonth < month) || (bigYear == year && bigMonth == month && bigDay < day)) {
            tempArr[0] = false;
            tempArr[1] = "日期不能大于" + arr[2] + "，请重新输入『" + obj.attributes["data-tip"].value + "』";
            return tempArr;
          }
        }
        return tempArr;
      },

      checkTime: function(obj) {
        var tempArr = new Array(true, "");
        if (!(/^([0-9]){1,2}:([0-9]){1,2}:([0-9]){1,2}$/.test(obj.value))) {
          tempArr[0] = false;
          tempArr[1] = "不是合法的时间，请按\"hh:mm:ss\"的格式输入『" + obj.attributes["data-tip"].value + "』";
          return tempArr;
        }
        var arr = obj.value.match(/\d+/g),
        hour = Number(arr[0]),
        minute = Number(arr[1]);
        if (hour < 0 || hour >= 24 || minute < 0 || minute >= 60) {
          tempArr[0] = false;
          tempArr[1] = "您输入了一个不存在的时间，请重新输入『" + obj.attributes["data-tip"].value + "』";
          return tempArr;
        }
        arr = obj.attributes["data-type"].value.split(",");
        if (arr[1] != null && arr[1].length > 0) {
          var arr2 = arr[1].match(/\d+/g);
          var smallHour = Number(arr2[0]);
          var smallMinute = Number(arr2[1]);
          if (smallHour > hour || (smallHour == hour && smallMinute > minute)) {
            tempArr[0] = false;
            tempArr[1] = "时间不能小于" + arr[1] + "，请重新输入『" + obj.attributes["data-tip"].value + "』";
            return tempArr;
          }
        }

        if (arr[2] != null && arr[2].length > 0) {
          arr2 = arr[2].match(/\d+/g);
          var bigHour = Number(arr2[0]);
          var bigMinute = Number(arr2[1]);
          if (bigHour < hour || (bigHour == hour && bigMinute < minute)) {
            tempArr[0] = false;
            tempArr[1] = "时间不能大于" + arr[2] + "，请重新输入『" + obj.attributes["data-tip"].value + "』";
            return tempArr;
          }
        }
        return tempArr;
      }

    });

  }));