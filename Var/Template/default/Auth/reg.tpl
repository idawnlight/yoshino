{{{include "_partial/header"}}}
<!-- Header -->
<header class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-theme">
        <span mdui-drawer="{target: '#yoshino-drawer'}" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">menu</i></span>
        <a href="javascript:;" class="mdui-typo-headline yoshino-headline">Yoshino</a>
        <a href="javascript:;" class="mdui-typo-title">{{{trans 'page.reg'}}}</a>
        <div class="mdui-toolbar-spacer"></div>
    </div>
</header>

<!-- Sidebar -->
{{{include "_partial/index/sidebar"}}}

<!-- Content -->
<div class="mdui-container doc-container doc-no-cover">
    <div class="mdui-row">
        <div class="mdui-col-sm-5">
            <h1 class="doc-title mdui-text-color-theme">{{{trans 'page.reg'}}}</h1>
            <p>注册一个新的账号</p>
        </div>

        <div class="mdui-col-sm-6 mdui-col-offset-sm-1">
            <div class="mdui-card mdui-container-fluid yoshino-form">
                <form id="reg">
                <div class="mdui-textfield">
                    <label class="mdui-textfield-label">{{{trans 'auth.username'}}}</label>
                    <input class="mdui-textfield-input" type="text" name="username" required/>
                </div>
                <div class="mdui-textfield">
                    <label class="mdui-textfield-label">{{{trans 'auth.password'}}}</label>
                    <input class="mdui-textfield-input" type="password" name="password" required/>
                </div>
                <div class="mdui-textfield">
                    <label class="mdui-textfield-label">{{{trans 'auth.repeat-pwd'}}}</label>
                    <input class="mdui-textfield-input" type="password" name="repeatpwd" required/>
                </div>
                    <div class="mdui-textfield">
                        <label class="mdui-textfield-label">{{{trans 'auth.email'}}}</label>
                        <input class="mdui-textfield-input" type="email" name="email" required/>
                    </div>
                </form>
                <button class="mdui-btn mdui-ripple mdui-text-color-theme reg-button mdui-btn-block">{{{trans 'auth.reg'}}}</button>
            </div>
        </div>
    </div>
</div>
{{{include "_partial/footer"}}}