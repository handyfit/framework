<div align="center">

<img src="assets/logo.png" width="554" alt="handy" />

**English** | [简体中文](/README.md)

</div>

---

## About Handy

> **Note:** The repository is used under the premise that `php` >= `8.2` and <= `8.3`, while the version of `Laravel`
> used should be >= `11.9`

Thanks for the contribution of the Handy logo from [logoly](https://www.logoly.pro/).

**Handy** follows the [Semantic Versioning](https://semver.org/) control, with major releases released once a year (
around the first quarter), minor releases released once a month (between the 1st and 5th), and patch releases once a
week (depending on Issue and availability)
There will be no major changes to minor and patch versions (cases where backward compatibility is not possible).

When introducing **Handy** from an application or package, you should always use the version constraint (for example)
`^0.0-alpha` or `^0.1` because the major version of **Handy** does contain significant changes. However, we always
strive to ensure that you can update to it in the first place
New major release.

**Handy** is a development framework (maybe it should be called a package) based
on [Laravel 11](https://github.com/laravel/laravel), and using Handy while enjoying the original Laravel ecosystem can
make your development easier. For example, using `Trace` can help you better locate the usage of fields or columns that
may change, or use Cascade to quickly generate the `Migration`, `Model`, `Trace`, etc., you want.

## Install

```
composer require handy-fp/framework
```