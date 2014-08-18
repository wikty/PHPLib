jQuery(function($) {
    var processFilePath = "asset/inc/ajax.process.inc.php";
    var myfunc = {
        "initModal": function() {
            if ($(".modal-window").length == 0) {
                return $("<div>").addClass("modal-window").hide().appendTo("body");
            }
            else {
                return $(".modal-window");
            }
        },
        "myOut": function(event) {
            if (event != undefined) {
                event.preventDefault();
            }
            $("li>a").removeClass("active");
            /*$(".modal-window").fadeOut('slow', function() {
            $(this).remove();
            });*/
            /*$(".modal-window").hide('slow', function() {
            $(this).remove();
            });*/
            $(".modal-overlay,.modal-window").fadeOut('slow', function() {
                $(this).remove();
            });
        },
        "myIn": function(mymodal, myrtn) {
            $("<div>").addClass("modal-overlay").hide().click(function(event) {
                myfunc.myOut(event);
            }).appendTo("body");
            mymodal.html(myrtn);
            $("<a>").attr("href", "#").addClass("modal-close-btn").html("&times;").click(
                 function(event) {
                     myfunc.myOut(event);
                 }).appendTo(mymodal);
            //mymodal.fadeIn('slow');
            $(".modal-overlay,.modal-window").fadeIn('slow');
            //mymodal.fadeIn('slow');

            //书上原来是append方法添加，这样的话，每次的请求就会累加在窗口，换成html有清空的作用
            //可是我改成html有一个问题，上面的设置的关闭按钮会被我这里的html清空的，鉴于此可以将关闭按钮放在这里添加
        },
        "mydecode": function(mydata) {
            //书上解码之前先用正则替换+为空格，解码的函数连这个也做不到吗
            //经过检验，该函数确实没有将+替换为空格的能力，这样的话导致我后续提取时间时出了问题

            return decodeURIComponent(mydata.replace(/\+/g, " "));
        },
        "deserialize": function(formdata) {
            var rtnobj = {};
            var myarray = [];
            var temp = [];
            var key, value;
            myarray = formdata.split("&");
            for (var i in myarray) {
                temp = myarray[i].split("=");
                key = myfunc.mydecode(temp[0]);
                value = myfunc.mydecode(temp[1]);
                rtnobj[key] = value;
            }
            return rtnobj;
        },
        "addEvent": function(event_id, formdata) {
            var dedata = myfunc.deserialize(formdata);
            var cur = new Date(NaN);
            var add = new Date(NaN);
            var pageid = $("h2").attr("id");
            var tempcur = pageid.split("-");
            var tempadd = (dedata.event_start).split(" ")[0];
            tempadd = tempadd.split("-");
            cur.setFullYear(tempcur[1], tempcur[2], 1);
            add.setFullYear(tempadd[0], tempadd[1], tempadd[2]);
            //add.setMinutes(add.getTimezoneOffset());
            //这里涉及到与客户端与服务端时间的一致性，现在暂时搁置不管，因为这个东西使得我插入的记录不在我想要它在的位置
            //alert("ay" + add.getFullYear() + " " + "cy " + cur.getFullYear() + "  am" + add.getMonth() + "  cm" + cur.getMonth());
            if (add.getFullYear() == cur.getFullYear() && cur.getMonth() == add.getMonth()) {
                var day = String(add.getDate());
                day = (day.length == 1 ? "0" + day : day);
                //alert(day);
                $("<a>").hide().attr("href", "view.php?event_id=" + event_id).
                text(dedata.event_title).insertAfter($("strong:contains(" + day + ")")).delay(1000).fadeIn('slow');
            }
        },
        "removeEvent": function() {
            $("li>a.active").fadeOut('slow', function() {
                $(this).remove();
            });
            myfunc.myOut();

        }




    }
    $("li>a").live("click", function(event) {

        event.preventDefault();
        $("li>a").removeClass("active");
        $(this).addClass("active");
        var data = $(this).attr("href").replace(/.*\?(.*)$/, "$1");
        var modal = myfunc.initModal();
        $.ajax({
            type: "post",
            url: processFilePath,
            typeData: "html",
            data: "action=event_view&" + data,
            success: function(myrtn) {
                myfunc.myIn(modal, myrtn);
            },
            error: function(msg) {
                modal.html(msg);
                $("<a>").attr("href", "#").addClass("modal-close-btn").html("&times;").click(
                 function(event) {
                     myfunc.myOut(event);
                 }).appendTo(modal);
            }
        });


        //console.log(data);

    });
    $("a.admin:contains(Add),.admin-options form input:[name=event_edit]").live('click', function(event) {
        event.preventDefault();
        var action = "event_create";
        var id = $(this).next("input:[name=event_id]").val();
        id = (id != undefined) ? "event_id=" + id : "";
        $.ajax({
            url: processFilePath,
            data: "action=" + action + "&" + id,
            dataType: "html",
            type: "post",
            success: function(data) {
                //alert(data);
                var modal = myfunc.initModal();
                //var form = $(data).addClass("edit-form").appendTo(modal);
                //alert($(data).addClass("edit-form").html());
                myfunc.myIn(modal, $(data).addClass("edit-form"));
            },
            error: function(msg) {
                alert(msg);
            }
        });
    });
    $(".edit-form a:contains(cancel)").live('click', function(event) {
        myfunc.myOut(event);
    });
    $(".edit-form input:[type=submit]").live('click', function(event) {
        event.preventDefault();
        var mydata = $(this).parent("form").serialize();
        var start = $(this).siblings("input:[name=event_start]").val();
        var end = $(this).siblings("input:[name=event_end]").val();
        if (!validDate(start) || !validDate(end)) {
            alert("date unvalidated,use YYYY:mm:dd hh:mm:ss");
            return;
        }
        $.ajax({
            type: "post",
            data: mydata,
            url: processFilePath,
            success: function(data) {
                //console.log(data);
                myfunc.myOut();
                if ($(this).siblings("[name=event_id]").val() == "") {
                    myfunc.addEvent(data, mydata);
                }
            },
            error: function(msg) {
                alert(msg);
            }
        });
    });
    $(".admin-options form input:[name=event_delete]").live("click", function(event) {
        event.preventDefault();
        var id = $(this).next("input:hidden").val();
        $.ajax({
            type: "post",
            data: { event_id: id, action: "event_delete" },
            url: processFilePath,
            success: function(data) {
                var mymodal = myfunc.initModal();
                myfunc.myIn(mymodal, data);
            },
            error: function(msg) {
                alert(msg);
            }
        });
    });
    $("input:[name=confirm_delete]").live("click", function(event) {
        event.preventDefault();
        var myv = $(this).val();
        if (myv.indexOf("Yes") >= 0) {
            var formdata = $(this).parent("form").serialize();
            $.ajax({
                type: "post",
                data: formdata + "&action=event_delete",
                url: processFilePath,
                success: function(data) {
                    myfunc.removeEvent();
                },
                error: function(msg) {
                    alert(msg);
                }
            });
        }
        else {
            myfunc.myOut();
        }
    });
});