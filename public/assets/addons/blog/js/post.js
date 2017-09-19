var len = function (str) {
    if (!str)
        return 0;
    var length = 0;
    for (var i = 0; i < str.length; i++) {
        if (str.charCodeAt(i) >= 0x4e00 && str.charCodeAt(i) <= 0x9fa5) {
            length += 2;
        } else {
            length++;
        }
    }
    return length;
};
var ci;
$(function () {
    $userinfo = localStorage.getItem("commentuserinfo");
    $userinfo = JSON.parse($userinfo);
    if ($userinfo && typeof $userinfo.username !== 'undefined') {
        $("#username").val($userinfo.username);
        $("#email").val($userinfo.email);
        $("#website").val($userinfo.website);
    }
    var loadcomment = function (page) {
        $("#respond h3 a").trigger("click");
        $.ajax({
            url: "/addons/execute/blog-ajax-getcommentlist",
            data: {post_id: post_id, page: page},
            type: 'GET',
            success: function (data) {
                $(".commentlist").html(data);
                $('html, body').animate({scrollTop: $('#comments').position().top}, 'slow');
            }, error: function () {

            }
        });
    };
    $(document).on("click", ".pager a", function () {
        var page = $(this).text();
        loadcomment(page);
        return false;
    });
    $(document).on("click", "#submit", function () {
        var remberme = $("input[name=remberme]:checked").val() ? 1 : 0;
        var btn = $(this);
        var tips = $("#actiontips");
        tips.removeClass();
        var username = $("#username").val();
        var email = $("#email").val();
        var website = $("#website").val();
        var content = $("#commentcontent").val();
        content = $("#parent_username").val() ? '@' + $("#parent_username").val() + ':' + content : content;
        if (len(username) < 3 || len(email) < 3 || len(content) < 3) {
            tips.addClass("error").html("姓名、Email、评论内容长度不正确！最少3个字符").fadeIn().change();
            return false;
        }
        btn.attr("disabled", "disabled");
        tips.html('<img src="/images/loading.gif" />正在提交...');
        $.ajax({
            url: "/addons/execute/blog-ajax-postcomment",
            type: 'POST',
            data: $("#postform").serialize(),
            dataType: 'json',
            success: function (json) {
                //console.log(json);
                btn.removeAttr("disabled");
                if (json.code == 1) {
                    if (remberme) {
                        localStorage.setItem("commentuserinfo", JSON.stringify({username: username, email: email, website: website}));
                    } else {
                        localStorage.removeItem("commentuserinfo");
                    }
                    $("#pid").val(0);
                    tips.addClass("success").html("评论成功！").fadeIn(300).change();
                    loadcomment(1);
                    $("#commentcontent").val('');
                    $("#commentcount").text(parseInt($("#commentcount").text()) + 1);
                } else {
                    tips.addClass("error").html(json.msg).fadeIn().change();
                }
                if (json.data && json.data.token) {
                    $("#postform input[name='__token__']").val(json.data.token);
                }
            },
            error: function () {
                btn.removeAttr("disabled");
                tips.addClass("error").html("评论失败！请刷新页面重试！").fadeIn();
            }
        });
        return false;
    });
    $("#commentcontent").on("keydown", function (e) {
        if (e.ctrlKey && e.which == 13) {
            $("#submit").click();
        }
    });
    $("#actiontips").on("change", function () {
        if (typeof si != 'undefined') {
            console.log(si);
            clearTimeout(si);
        }
        var si = setTimeout(function () {
            $("#actiontips").fadeOut();
        }, 8000);
    });
    $(document).on("keyup change", "#commentcontent", function () {
        var max = 1000;
        var c = $(this).val();
        var length = len(c);
        var t = $("#actiontips");
        if (max >= length) {
            t.removeClass().show().addClass("loading").html("你还可以输入 <font color=green>" + (Math.floor((max - length) / 2)) + "</font> 字");
            $("#submit").removeAttr("disabled");
        } else {
            t.removeClass().show().addClass("loading").html("你已经超出 <font color=red>" + (Math.ceil((length - max) / 2)) + "</font> 字");
            $("#submit").attr("disabled", "disabled");
        }
    });
    $(".commentlist dl dd div,.commentlist dl dd dl dd").on({
        mouseenter: function () {
            clearTimeout(ci);
            var _this = this;
            ci = setTimeout(function () {
                $(_this).find("small:first").find("a").stop(true, true).fadeIn();
            }, 300);
        },
        mouseleave: function () {
            $(this).find("small:first").find("a").stop(true, true).fadeOut();
        }
    });
    $(".reply").on("click", function () {
        $("#parent_id").val($(this).attr("rel"));
        $(this).parent().parent().append($("div#respond").detach());
        $("#respond h3 a").show();
        $("#commentcontent").focus().val($(this).attr("title"));
    });
    $("#respond h3 a").bind("click", function () {
        $(".commentlist").after($("div#respond").detach());
        $(this).hide();
    });
    $(".expandall a").on("click", function () {
        $(this).parent().parent().find("dl.hide").fadeIn();
        $(this).fadeOut();
    });
    //超过指定宽度
    var nc = $(".entry");
    if (nc.size() > 0) {
        var nw = nc.width();
        $("img", nc).each(function (i, obj) {
            var iw = $(obj).removeAttr("height").width();
            if (iw > nw) {
                $(obj).width(nw).css("cursor", "pointer").attr("title", "点击查看大图片").bind('click', function () {
                    window.open($(obj).attr("src"));
                });
            }
        });
    }
});