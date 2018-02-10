var $$ = mdui.JQ;

$$('.reg-button').on('click', function (e) {
    $$.ajax({
        method: 'POST',
        url: '',
        dataType: "json",
        data: $$('form#reg').serialize(),
        beforeSend: function (xhr) {
            $$('.reg-button').prop('disabled', true);
        },
        success: function (data) {
            $$('.reg-button').prop('disabled', false);
            //console.log(data);
            if (data.status !== "succeed") {
                mdui.alert(data.result.msg, "注册失败");
            } else if (data.status === "succeed") {
                mdui.snackbar({
                    message: '注册成功',
                    position: 'right-bottom'
                });
                $$('.reg-button').prop('disabled', true);
                setTimeout("window.location.href='/user'",1000);
            } else {
                mdui.alert("未知错误");
            }
        }
    });
});
$$('.login-button').on('click', function (e) {
    $$.ajax({
        method: 'POST',
        url: '',
        dataType: "json",
        data: $$('form#login').serialize(),
        beforeSend: function (xhr) {
            $$('.login-button').prop('disabled', true);
        },
        success: function (data) {
            $$('.login-button').prop('disabled', false);
            //console.log(data);
            if (data.status !== "succeed") {
                mdui.alert(data.result.msg, "登录失败");
            } else if (data.status === "succeed") {
                mdui.snackbar({
                    message: '登录成功',
                    position: 'right-bottom'
                });
                $$('.login-button').prop('disabled', true);
                setTimeout("window.location.href='/user'",1000);
            } else {
                mdui.alert("未知错误");
            }
        }
    });
});

$$('span#add-player').on('click', function (e) {
    mdui.prompt('角色名', '添加角色',
        function (value) {
            if (value !== "") {
                $$.ajax({
                    method: 'POST',
                    url: '',
                    dataType: "json",
                    data: "player=" + value,
                    success: function (data) {
                        //console.log(data);
                        if (data.status !== "succeed") {
                            mdui.snackbar({
                                message: '添加失败，' + data.result.msg,
                                position: 'right-bottom'
                            });
                        } else if (data.status === "succeed") {
                            mdui.snackbar({
                                message: '添加成功',
                                position: 'right-bottom'
                            });
                            $$("div#yoshino-player").prepend('<span class="mdui-list-item mdui-ripple" id="remove-player" data-player="' + value + '">' + value + '</span>');
                        } else {
                            mdui.alert("未知错误");
                        }
                    }
                });
            }
        }
    );
});

$$("span#view-skin").on('click', function (e) {
    MSP.changeSkin("/legacy/skin/" + e.srcElement.getAttribute("data-player") + ".png?default");
    MSP.changeCape("/legacy/cape/" + e.srcElement.getAttribute("data-player") + ".png");
    $$("#yoshino-skin-preview-del").attr("data-player", e.srcElement.getAttribute("data-player"));
    $$('#yoshino-skin-preview-del').prop('disabled', false);
});

$$("span#edit-skin").on('click', function (e) {
    var playerName = e.srcElement.getAttribute("data-player");
    $$("#yoshino-skin-username").replaceWith('<div class="mdui-card-primary-subtitle" id="yoshino-skin-username">' + playerName + '</div>');
    $$("#player").attr("value", playerName);
});

$$("#yoshino-skin-preview-del").on('click', function (e) {
    if (e.srcElement.parentNode.getAttribute("data-player")) {
        mdui.confirm('您确定要删除角色 "' + e.srcElement.parentNode.getAttribute("data-player") + '" 吗？这个角色将永远失去！（很长时间！）', "删除角色？", function(){
            $$.ajax({
                method: 'POST',
                url: '',
                dataType: "json",
                data: "removePlayer=" + e.srcElement.parentNode.getAttribute("data-player"),
                success: function (data) {
                    //console.log(data);
                    if (data.status !== "succeed") {
                        mdui.snackbar({
                            message: '删除失败，' + data.result.msg,
                            position: 'right-bottom'
                        });
                    } else if (data.status === "succeed") {
                        mdui.snackbar({
                            message: '删除成功',
                            position: 'right-bottom'
                        });
                        $$('span#view-skin[data-player="'+e.srcElement.parentNode.getAttribute("data-player")+'"]').addClass("hidden");
                        $$('#yoshino-skin-preview-del').prop('disabled', true);
                    } else {
                        mdui.alert("未知错误");
                    }
                }
            });
        });
    }
});

$$(".yoshino-submit").on("click", function (e) {
    var fileInfo = document.getElementById("skin").files;
    var formData = new FormData($$('#skin-upload')[0]);

    if (fileInfo[0]) {
        fileInfo = fileInfo[0];
    } else {
        mdui.alert("先选择一个文件");
        return;
    }

    if (fileInfo.size > 10240) {
        mdui.alert("皮肤大小不能超过 10 KB");
        return;
    }
    if (fileInfo.type !== "image/png") {
        mdui.alert("皮肤必须是 PNG 格式");
        return;
    }
    if ($$("#player").val() === "") {
        mdui.alert("先在左侧选择一个角色");
        return;
    }

    $$.ajax({
        method: 'POST',
        url: '',
        dataType: "json",
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function (xhr) {
            $$('.yoshino-submit').prop('disabled', true);
        },
        success: function (data) {
            //console.log(data);
            $$('.yoshino-submit').prop('disabled', false);
            if (data.status !== "succeed") {
                mdui.snackbar({
                    message: '上传失败，' + data.result.msg,
                    position: 'right-bottom'
                });
            } else if (data.status === "succeed") {
                mdui.snackbar({
                    message: '上传成功',
                    position: 'right-bottom'
                });
            } else {
                mdui.alert("未知错误");
            }
        }
    });
});