<div class="mdui-drawer" id="yoshino-drawer">
    <ul class="mdui-list" mdui-collapse="{accordion: true}">
        <a href="{{{path 'index'}}}">
            <li class="mdui-list-item mdui-ripple{{#if index}} mdui-list-item-active{{/if}}">
                <i class="mdui-list-item-icon mdui-icon material-icons">layers</i>
                <div class="mdui-list-item-content">{{{trans "page.index"}}}</div>
            </li>
        </a>
        <li class="mdui-collapse-item{{#if collapse-1}} mdui-collapse-item-open{{/if}}">
            <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">near_me</i>
                <div class="mdui-list-item-content">{{{trans "sidebar.index/start"}}}</div>
                <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
            </div>
            <ul class="mdui-collapse-item-body mdui-list">
                <a href="{{{path 'login'}}}"><li class="mdui-list-item mdui-ripple{{#if login}} mdui-list-item-active{{/if}}">{{{trans "index.login"}}}</li></a>
                <a href="{{{path 'reg'}}}"><li class="mdui-list-item mdui-ripple{{#if reg}} mdui-list-item-active{{/if}}">{{{trans "index.reg"}}}</li></a>
            </ul>
        </li>

        <li class="mdui-divider"></li>
        <a href="{{{path 'github'}}}">
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve" class="mdui-icon" style="width: 24px;height:24px;">
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#757575" d="M18,1.4C9,1.4,1.7,8.7,1.7,17.7c0,7.2,4.7,13.3,11.1,15.5
	c0.8,0.1,1.1-0.4,1.1-0.8c0-0.4,0-1.4,0-2.8c-4.5,1-5.5-2.2-5.5-2.2c-0.7-1.9-1.8-2.4-1.8-2.4c-1.5-1,0.1-1,0.1-1
	c1.6,0.1,2.5,1.7,2.5,1.7c1.5,2.5,3.8,1.8,4.7,1.4c0.1-1.1,0.6-1.8,1-2.2c-3.6-0.4-7.4-1.8-7.4-8.1c0-1.8,0.6-3.2,1.7-4.4
	c-0.2-0.4-0.7-2.1,0.2-4.3c0,0,1.4-0.4,4.5,1.7c1.3-0.4,2.7-0.5,4.1-0.5c1.4,0,2.8,0.2,4.1,0.5c3.1-2.1,4.5-1.7,4.5-1.7
	c0.9,2.2,0.3,3.9,0.2,4.3c1,1.1,1.7,2.6,1.7,4.4c0,6.3-3.8,7.6-7.4,8c0.6,0.5,1.1,1.5,1.1,3c0,2.2,0,3.9,0,4.5
	c0,0.4,0.3,0.9,1.1,0.8c6.5-2.2,11.1-8.3,11.1-15.5C34.3,8.7,27,1.4,18,1.4z"></path>
                </svg>
                </i>
                <div class="mdui-list-item-content">Github</div>
            </li>
        </a>
    </ul>
</div>