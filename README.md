# Yoshino
A lite &amp; fast Minecraft skin server, written in php.

还记得 `dawn-skin-server` 吗？现在，将以全新的姿态呈现！

> 暂时的离别，是为了以后更好地相见

# TODO

- [ ] 个人中心
  - [x] 登录 / 注册
  - [x] 管理角色
  - [x] 管理皮肤
  - [x] 管理披风
  - [ ] 账号信息（e.g. 密码、邮箱）
  - [ ] 邮箱验证
- [ ] 仪表盘
  - [ ] 总览
  - [ ] 设置
  - [ ] 用户管理
- [x] API
  - [x] CustomSkinAPI Revision 2 `/(.*?).json` `/csl/(.*?).json` `/csl/v2/(.*?).json`
  - [x] CustomSkinAPI Revision 1 `/csl/v1/(.*?).json`
  - [x] UniSkinMod 1.4+ `/usm/(.*?).json`
  - [x] Legacy (CustomSkinLoader 13.1- && UniSkinMod 1.2-) `/legacy/skin/(.*?).png` `/legacy/cape/(.*?).png`

  PS：UniSkinMod 1.2 & 1.3 的奇特 API 我实在看不懂，也没法支持