{{{include "_partial/header"}}}
<!-- Header -->
<header class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-theme">
        <span mdui-drawer="{target: '#yoshino-drawer'}" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">menu</i></span>
        <a href="{{{path 'index'}}}" class="mdui-typo-headline yoshino-headline">Yoshino</a>
        <a href="{{{path 'user'}}}" class="mdui-typo-title">{{{trans 'page.user'}}}</a>
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
    <h1 class="doc-title mdui-text-color-theme">{{{trans "page.player"}}}</h1>
    <p>在这里管理您的角色<br></p>
    <div class="mdui-list" id="yoshino-player">
        {{#each players}}
        <span class="mdui-list-item mdui-ripple" id="remove-player" data-player="{{.}}">{{.}}</span>
        {{/each}}
        <div class="mdui-divider"></div>
        <span class="mdui-list-item mdui-ripple" id="add-player" data-id="123" data-player="dawn">{{{trans "user.add-user"}}}</span>
    </div>
</div>
{{{include "_partial/footer"}}}