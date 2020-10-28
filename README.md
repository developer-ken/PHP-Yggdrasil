# A PHP Yggdrasil Server

The project is for my own server, and since I am in China, I'll use a lot of Chinese instead of English. Just Googletranslate it if you want English. Sorry for inconvenience.

The project is very tiny and simple, so it should be easy for you to edit it and add features to it to satisfy your own needs.
这是一个结构简单的工程，因此你可以很容易的修改它、为它增加你需要的新的功能。

Star⭐ it if you like my project plz
喜欢的话右上角给个⭐小星星好吗qaq

⚠WARNING: This project comes whith NO guarantee to the safety or stablity of the project. NEVER use it on production servers. I(the author) take no responsibility if the project crashes or cause any damage to your properties. The code is visible, so after you using it, you agree that you have read through the code and agreed there is no harmful part.
⚠该项目用于我自己的服务器。由于没有接受过专业的训练，我无法保证我的代码拥有良好的稳定性和安全性。请不要将其用于生产环境，我不对这些代码造成的损失负责。
代码是开源、可见的。如果您使用本项目，则代表您已经完整阅读代码并认同它不存在有害的部分。

This project is aimed to build an minimal Yggdrasil server via php&mysql. It is designed to run in any php web host.
However, in some cases, php-extentions are nessesary. They are listed below:
这个项目旨在使用php+mysql实现可用的Yggdrasil服务端。设计目标是使得其可以在任何支持php的网页空间中运行。但是，在必要时我会调用一些扩展。这些扩展会在下面列出：

- mysqli
- openssl

Just import the .sql file included in the project into your mysql database, then edit the config in /src/includes.php ,and the project is ready to go.
只需导入项目中的.sql文件，然后在/src/includes.php中编辑您的服务器配置，即可使用。

WARNING:/src/includes.php contains a key pair. You MUST replace it with the one you generated yourself, or your server might be under risk.
警告：/src/includes.php中存在一对密钥，您自己使用时应当使用自己生成的密钥替换掉它们，否则可能带来安全问题。

Issues and Pull Requests are welcomed
欢迎提交Issue或Pull Request

Yet another choice for your server:
您也可以选择其它实现：

[Erythrocyte3803/PHP-Yggdrasil-Server](https://github.com/Erythrocyte3803/PHP-Yggdrasil-Server)

Referrence
参考资料

[Yggdrasil 服务端技术规范 | Yggdrasil Document (zh-CN)](https://github.com/yushijinhun/authlib-injector/wiki/Yggdrasil-%E6%9C%8D%E5%8A%A1%E7%AB%AF%E6%8A%80%E6%9C%AF%E8%A7%84%E8%8C%83)
