{{{include "_partial/header"}}}
<!-- Header -->
<header class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-theme">
        <span mdui-drawer="{target: '#yoshino-drawer'}" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">menu</i></span>
        <a href="{{{path 'index'}}}" class="mdui-typo-headline yoshino-headline">Yoshino</a>
        <a href="{{{path 'index'}}}" class="mdui-typo-title">{{{trans "page.index"}}}</a>
        <div class="mdui-toolbar-spacer"></div>
    </div>
</header>

<!-- Sidebar -->
{{{include "_partial/index/sidebar"}}}

<!-- Content -->
<div class="mdui-container doc-container doc-no-cover">
    <h1 class="doc-title mdui-text-color-theme">{{{trans "index.welcome"}}}</h1>
    <p>一个轻量的 Minecraft 皮肤站</p>
    <div class="mdui-list">
        <a href="{{{path 'login'}}}" class="mdui-list-item mdui-ripple">{{{trans "index.login"}}}</a>
        <a href="{{{path 'reg'}}}" class="mdui-list-item mdui-ripple">{{{trans "index.reg"}}}</a>
    </div>
</div>
{{{include "_partial/footer"}}}