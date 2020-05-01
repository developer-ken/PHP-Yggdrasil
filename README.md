# A PHP Yggdrasil Server

The project is for my own server, and since I am in China, I'll use Chinese instead of English. Just Googletranslate it if you want English. Sorry for inconvenience.

喜欢的话右上角给个⭐小星星好吗qaq

该项目用于我自己的服务器。由于没有接受过专业的训练，我无法保证我的代码拥有良好的稳定性和安全性。请不要将其用于生产环境，我不对这些代码造成的损失负责。

这个项目旨在使用php+mysql实现可用的Yggdrasil服务端。设计目标是使得其可以在任何支持php的网页空间中运行。但是，在必要时我会调用一些扩展。这些扩展会在下面列出：
- mysqli
- openssl

只需导入项目中的.sql文件，然后在/src/includes.php中编辑您的服务器配置，即可使用。
WARNING:/src/includes.php contains a key pair. You MUST replace it with the one you generated yourself, or your server might be unsafe.
警告：/src/includes.php中存在一对密钥，您自己使用时应当使用自己生成的密钥替换掉它们，否则可能带来安全问题

欢迎提交Issue或Pull request

参考资料
[Yggdrasil 服务端技术规范](https://github.com/yushijinhun/authlib-injector/wiki/Yggdrasil-%E6%9C%8D%E5%8A%A1%E7%AB%AF%E6%8A%80%E6%9C%AF%E8%A7%84%E8%8C%83)