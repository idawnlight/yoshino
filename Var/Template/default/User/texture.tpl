{{{include "_partial/header"}}}
<!-- Header -->
<header class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-theme">
        <span mdui-drawer="{target: '#yoshino-drawer'}" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">menu</i></span>
        <a href="{{{path 'index'}}}" class="mdui-typo-headline yoshino-headline">Yoshino</a>
        <a href="{{{path 'user'}}}" class="mdui-typo-title">{{{trans 'page.texture'}}}</a>
        <div class="mdui-toolbar-spacer"></div>
        <span style="padding-top: 2px;font-weight: 500;">{{username}}</span>
        <a class="mdui-btn mdui-btn-icon" mdui-menu="{target: '#yoshino-user-menu'}"><i class="mdui-icon material-icons">more_vert</i></a>
        {{{include "_partial/user/menu"}}}
    </div>

</header>

<!-- Sidebar -->
{{{include "_partial/user/sidebar"}}}

<!-- Content -->
<div class="mdui-container doc-container doc-no-cover">
    <h1 class="doc-title mdui-text-color-theme">{{{trans "page.texture"}}}</h1>
    <div class="mdui-container">
        <div class="mdui-row">
            <div class="mdui-col-sm-4">
                <div class="mdui-card">
                    <div class="mdui-container">
                        <div class="mdui-list" id="yoshino-player">
                            {{#each players}}
                            <span class="mdui-list-item mdui-ripple" id="edit-skin" data-player="{{.}}">{{.}}</span>
                            {{/each}}
                            <div class="mdui-divider"></div>
                            <a href="{{{path 'user.player'}}}" class="mdui-list-item mdui-ripple">{{{trans "user.manage-player"}}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mdui-col-sm-8">
                <div class="mdui-card yoshino-skin-upload">
                    <div class="mdui-container">
                        <div class="mdui-card-primary">
                            <div class="mdui-card-primary-title">{{{trans "user.texture/upload-new"}}}</div>
                            <div class="mdui-card-primary-subtitle" id="yoshino-skin-username">{{{trans "user.skin/upload-new-tip"}}}</div>
                        </div>
                        <div class="mdui-divider"></div>
                        <ul class="mdui-list yoshino-upload">
                            <form id="texture-upload">
                                <li>
                                    {{{trans "user.texture/upload-type"}}}
                                    <select class="mdui-select" mdui-select name="type" id="texture-type">
                                        <option value="skin">{{{trans "user.texture/upload-type-skin"}}}</option>
                                        <option value="cape">{{{trans "user.texture/upload-type-cape"}}}</option>
                                    </select>
                                </li>
                                <li id="model-select">
                                    {{{trans "user.texture/upload-model"}}}
                                    <select class="mdui-select" mdui-select name="model">
                                        <option value="default">Steve (default)</option>
                                        <option value="slim">Alex (slim)</option>
                                    </select>
                                </li>
                                <li>
                                    {{{trans "user.texture/upload-file"}}}
                                    <label class="mdui-btn mdui-ripple mdui-btn-raised">
                                        <input id="texture" type="file" name="texture" style="left:-9999px;position:absolute;" accept="image/png">
                                        <span id="file-name">{{{trans "user.texture/upload-file-select"}}}</span>
                                    </label>
                                </li>
                                <input name="player" value="" id="player" style="display: none">
                            </form>
                        </ul>
                        <div class="mdui-divider"></div>
                        <button class="mdui-btn mdui-ripple mdui-btn-block yoshino-submit">{{{trans "user.skin/upload-submit"}}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('texture').onchange = function (ev) {
        var fileValue = new Array();
        var input = $$("#texture").val();
        if (input.indexOf("/") === -1) {
            fileValue = input.split("\\");
        } else {
            fileValue = input.split("\\");
        }
        var fileName = fileValue.slice(-1)[0];
        //console.log(fileName);
        //var fileInfo = document.getElementById("skin").files[0];
        //console.log(fileInfo);
        $$("#file-name").replaceWith('<span id="file-name">' + fileName + '</span>');
    };
    document.getElementById('texture-type').onchange = function (ev) {
        console.log($$("#texture-type").val());
        if ($$("#texture-type").val() === "cape") {
            $$("#model-select").addClass("mdui-hidden");
        } else {
            $$("#model-select").removeClass("mdui-hidden");
        }
    };
</script>
{{{include "_partial/footer"}}}