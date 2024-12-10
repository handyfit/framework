<div align="center">

<img src="assets/logo.png" width="554" alt="handy" />

**简体中文** | [English](/README-En_us.md)

</div>

---
## 关于 Handy

> **说明:** 该存储库使用前提是 `php` >= `8.2` 并且 <= `8.3`，同时使用的 `Laravel` 版本应该是 >= `11.9`

**Handy** 商标来自 [logoly](https://www.logoly.pro/) 贡献，特此鸣谢。

**Handy** 遵循 [语义化版本](https://semver.org/) 控制，主要版本每年发布一次（约第一季度），次要版本每月发布一次（1号至5号之间），补丁版本每周发布一次（根据 Issue，和实际情
况决定），次要版本和补丁版本不会存在重大更改（无法向下兼容的情况）。

从应用程序或包中引入 **Handy** 时，应始终使用版本约束（例如）`^0.0-alpha` / `^0.1`，因为 **Handy** 的主要版本确实包含重大更改。但是，我们始终努力确保您可以第一时间内更新到
新的主要版本。

**Handy** 是一个基于 [Laravel 11](https://github.com/laravel/laravel) 衍生而来的开发框架（或许应该称它为包），在享受原有 Laravel 生态的基础上使用 **Handy** 可以让你
的开发更加便利。例如使用 `Trace` 可以帮助你更好的定位（**可能变动的字段/列**）的使用情况，或是使用 `Cascade` 快速生成你想要的 `Migration` 、 `Model` 、 `Trace` 等。

## 安装

```
composer require handy-fp/framework
```