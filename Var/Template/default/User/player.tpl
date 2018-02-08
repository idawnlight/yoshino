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
    <div class="mdui-container">
        <div class="mdui-row">
            <div class="mdui-col-sm-7">
                <div class="mdui-card">
                    <div class="mdui-container">
                        <div class="mdui-card-primary">
                            <div class="mdui-card-primary-title">{{{trans "user.player-list"}}}</div>
                            <div class="mdui-card-primary-subtitle">{{{trans "user.player-list-tip"}}}</div>
                        </div>
                        <div class="mdui-divider"></div>
                        <div class="mdui-list" id="yoshino-player">
                            {{#each players}}
                            <span class="mdui-list-item mdui-ripple" id="edit-skin" data-player="{{.}}">{{.}}</span>
                            {{/each}}
                            <div class="mdui-divider"></div>
                            <span class="mdui-list-item mdui-ripple" id="add-player">{{{trans "user.add-user"}}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mdui-col-sm-5">
                <div class="mdui-card yoshino-skin-preview">
                    <div class="mdui-container">
                        <div class="mdui-card-primary">
                            <div class="mdui-card-primary-title">
                                {{{trans "user.player-preview"}}}
                                <button class="mdui-btn mdui-btn-icon mdui-float-right" id="yoshino-skin-preview-del" mdui-tooltip="{content: '{{{trans 'user.skin/del'}}}'}" data-player=""><i class="mdui-icon material-icons mdui-text-color-red">delete</i></button>
                                <button class="mdui-btn mdui-btn-icon mdui-float-right" id="yoshino-skin-preview-rotate" mdui-tooltip="{content: '{{{trans 'user.skin/rotate'}}}'}"><i class="mdui-icon material-icons">repeat</i></button>
                                <button class="mdui-btn mdui-btn-icon mdui-float-right" id="yoshino-skin-preview-run" mdui-tooltip="{content: '{{{trans 'user.skin/run'}}}'}"><i class="mdui-icon material-icons">directions_run</i></button>
                                <button class="mdui-btn mdui-btn-icon mdui-float-right" id="yoshino-skin-preview-walk" mdui-tooltip="{content: '{{{trans 'user.skin/walk'}}}'}"><i class="mdui-icon material-icons">directions_walk</i></button>
                            </div>
                        </div>
                        <div class="mdui-divider"></div>
                        <div id="skin-preview">
                            <!-- Container for 3D Preview -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{{file 'js/three.min.js'}}}" type="text/javascript"></script>
    <script src="{{{file 'js/three.msp.js'}}}" type="text/javascript"></script>
    <script>
        var dskin = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAAAgCAYAAACinX6EAAAFgUlEQVRogdVYTWwUVRz/7fbtTmY626Ef2aXYArGlEvTQ0AQjEGJiAiE1pgdDIvEAGg948CAxHqzGEElUbob4cTBiTAycDAc1eDBEEw4KUZGPUhdLLVq26VKG3Z3Nm93ueni8mffma7cLhfJLJvNm3u+9ef+v37yZGBpgU3+qDgDVahWEEPA2ANByHHueHIwcf+TUH7FGz1hO1Ov1yP54M5NUq1WoShKJNpmuqDUAQInGYOhJ52zoyRaXe/9BmiGpCjOoTG0nC7z44vebrDHDTrv6U2hXor2/EtAwA3i6VxZrzj1CCFQlGeqMhwkNHeA1slqt+krhYUZTllQWa04m8HJohBs3rNZXdR/RVA5zEaws1lCmNmg5jlWr5KG7+lMBI1e+BjTlAEIIytR2rhW1JmnCwyB2YYgN9arS6gkhvhqvLNaQaItLpcC1QeSK/eJ8QPg+YvpWaVn3CY32AYEZwKPLjeb3Em1xdOsaACBftH38MPAS8nIVtQbcamTC8oIQQnxRdaPIrj98ZR80TRa/ebOAw1+d8GVF0HzN7CMeFOI8Nb3G81J4d98LAJjBlmXj7/9yAIBC7h+8tvMpJNrigWO5I1b6PiIOwFkoX+z+7ZtxcPc2dKgEWkLB6Nsf4fjpAQDAo2syOHoyjZc++x6pzFp0qAQHd2/D/u2bETTXSt9HOCLII0YIwd4tG9Gl6zAtG+nOFFKZtdASCr778WcAwPPPPoOpyYuYzefRFk/C0JK4WSzi618mnDnCykrcR1QWa7g0U3igIhjb1J+q80U/PTCAkaHVAIDZfB5m0cYjmU4kYzFMzxSlgb197SiWSjCLNgw9id7ubgDAuckbOH31qk/1+T6iWq06+4iV4ACyd8tGZlB3N2bzeQAApRRt8SQAG//mFlCiMazpTgAAzKKNrg4d5XIF5p03AeMyjAytlpzIx5w8P+lwFLWGnY+th6EnMT7z672xtEX4vL9n91nJZeenXpT6JyYmoiN29mz9jbdeDuw6cvhz4OjR6BUdOxY9//HjdQze+QeRzeLVT9/HrFlCr9GOWbOEb377Sxrf0j7gblGiy5jVg4PB7RaxcuS4FWSzUvR7jfYlT7EsGbCs3wbZ7D2JPEdseOPrdQCwaA6akkG6a0QizN085/QBkPqL5es485zw2ZvNAjt2AIkE3vv2E0lYx0cPMM70tLyCdesATXOvFYWdKWXny5eD+YrCON7+4WHpsj42FlmPcW58K9DVPtbI5dgxOAgYBqBpGB89IBvf2ckOkZ/LucbwwwuRC7hzAIBlyZwW4JQAj/CS4X2wYMT46AGgUpEjHMH33acUyGTkMZS6Yzo7/Rm1RNy9CBYKbjubdduiYWJb5IvtuTl2ptRtB8ESSm5hYWlrDUBTIqgpGUcHiuXrcmcqFWxIOs0ixK9Fo0Q+4Na7F4qCj6/95Fyal/7EQO1xYMqlXJ24CIN/qV67gp7arDzH2FikbYEZUCxflwyN1AjRmJTnt5homGH4Obxtmv55w5wCYP52yZ1WS8K07FBuIwRmgCNuArhG+PpSU/6IptPsbJqu4V6IjjAMxhXr2zSBdBqmZbsR9kB0RND9no7G+wIC3IUAAkykgtrN8DnChNAD7ogww0zLRk9EfxCa1oCmwaPvRZCRojPEcQFzRGVC2P1mQIzMOfaA3EgkkfM2PCHX5g/oYQ1ujCh2huG+zsKiLPLTaVlEKY00rqejHfPCP0XOnb9dYn0hJSLCyYAwA+mFC5ETDJ8owKIFaIoGi+awvndI6F0EYLEd4zvu/aFTTDM0RUO6S3cE98ybrl5sPTTJ9GZD8HO5kTwzojIkCvf0YyisVHS1D1sPsf8BwycKPq6u9jHOB2xTs/NL3Se2YnQ5vG+DVvA/HqN2mM1SAU4AAAAASUVORK5CYII=";
        MSP.changeSkin(dskin);
        console.log('[3D Preview] Default skin rendered.');
    </script>
    <script>
        window.onload = function () {
            $$('#yoshino-skin-preview-walk').on('click', function () {
                MSP.setStatus("movements")
            });
            $$('#yoshino-skin-preview-run').on('click', function () {
                MSP.setStatus("running")
            });
            $$('#yoshino-skin-preview-rotate').on('click', function () {
                MSP.setStatus("rotation")
            });
        }
    </script>
</div>
{{{include "_partial/footer"}}}