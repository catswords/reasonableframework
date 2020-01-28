# ReasonableFramework
![Discord](https://img.shields.io/discord/359930650330923008.svg)
![View Licence](https://img.shields.io/github/license/gnh1201/reasonableframework.svg)
![Librapay](http://img.shields.io/liberapay/receives/catswords.svg?logo=liberapay)

- ReasonableFramework is `RVHM` structured PHP web framework, securely and compatibility
- Prefix code: `RSF` (ReasonableFramework)
- Old prefix code: `VSPF` (Very Simple PHP Framework)

## Donate us (or if you need technical support)
- https://www.patreon.com/posts/25380536
 
## Specification
- Database connection (via PDO, MySQLi (MySQL Improved), MySQL Tranditional, MySQL CLI, Oracle(OCI))
- RVHM Structure: `R` is Route (like as `controller`), `V` is View, `H` is Helper (like as `import` on Python/Go/NodeJS), `M` is Model and implemented with `KV bind`(like as `Map` data structure), Model is not required.
- AppJail(Experimental): Load a legacy PHP applications on the jailed area without modifying the source code.

## Compatible
- Tested in PHP 5.3.3
- Tested in PHP 7.x

## How to use
- Extract or clone this project to your (restrictive) shared web hosting.
- You can intergrate all of PHP projects (linear, modular (ex. `autoloader`), or others) without complicated extensions.
- You can write your code and rewrite by `route` parameter without heavy framework. (like as `controller`)
- You can add your custom `ini.php` configuration file in `config` directory.
- Enjoy it!

## Map of structure
![Map of structure](https://github.com/gnh1201/reasonableframework/raw/master/assets/img/reasonableframework.jpg)

## Roadmap: Support legacy
- Support critical legacy web server (old: PHP 4.x ~ modern: 7.x)
- Support critical old browser (old: IE 6 ~ modern: IE 11)
- Do Clean & Modern PHP without hard studies.

## Contact me
- Go Namhyeon <gnh1201@gmail.com>
- Website: https://exts.kr/go/home

## Quick Start
1. git clone https://github.com/gnh1201/reasonableframework.git
2. set up database configuration: `/storage/config/database.ini.php`
3. touch(make new file): `/route/example.php`
4. go to `http://[base_url]/?route=example` or `http://[base_url]/example/`(if set `.htaccess`) in your web browser.
5. enjoy it.

## Examples
- [REST API Integration (Naver Papago Translation REST API)](https://gist.github.com/gnh1201/081484e6f5e10bd3be819093ba5f49c8)
- [Payment Gateway Integration (KCP)](https://github.com/gnh1201/reasonableframework/blob/master/route/orderpay.pgkcp.php)
- [Gnuboard CMS Integration (version 4, version 5)](https://github.com/gnh1201/reasonableframework/blob/master/route/api.gnuboard.php)

## [NEW] Advanced security (only for sponsors)
- CORS, CSRF, XSS, SQL-injection protection is common security, it is free and open-source for everyone.
- Firewall, DDoS protection, and more tools are available only for sponsors. [see details](https://github.com/gnh1201/reasonableframework/blob/master/SECURITY.md)

## How to use CLI
```
$ php cli.php --route [route name]
```

## 한국어(Korean)
- Resonable Framework(이유있는 프레임워크)는 한국의 웹 개발 환경에 적합한 PHP 프레임워크입니다.
- **극한의 기술 및 인적 레거시 환경**에서 유효하도록 설계된 구조를 기반으로 최고 수준의 안정성과 보안을 유지할 수 있습니다.
- 개발 인력이 객체지향/모듈러(MVC), 웹 접근성, 시큐어 코딩 현대적인 웹 기술을 모르더라도, 현대적인 기술보다 **한단계 더 높은** 수준을 지원합니다.
- Resonable Framework는 CSRF, XSS, SQL 인젝션 등 기초적인 보안 위협에 대응하도록 설계되어 있습니다.
- 현대적 웹 개발 환경인 컴포저(패키지 관리자), 객체지향/모듈러(MVC) 등을 함께 사용하실 수 있습니다.
- 공식 카카오톡 오픈채팅방을 통해 신속한 버그 및 보안이슈 해결이 가능합니다. https://open.kakao.com/o/g9spGfrb

## English
- It is stable in free web hosting, or other restrictive shared web hosting.
- Ideal for environments where separate development aids, including Composer, PHP extensions, and the famous PHP framework are not available.
- Ensures a life-cycle similar to that of an object-oriented programming (OOP) level without trained developers.
- The Reasonable PHP Framework has CSRF, XSS, and SQL Injection security protection as defaults.
- Compatible with various CMS and API used with REST API, it is suitable to create implementation type that is frequently used in various environment.
- RVHM structure can be used with MVC structure, and has more flexible structure to use as existing development skill.
