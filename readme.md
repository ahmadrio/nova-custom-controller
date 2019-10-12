# Laravel Nova Custom Controllers

**Package Nova Custom Controller** berfungsi untuk mengolah request tanpa perlu membuat controller baru, karna fitur ini sudah otomatis meng-override controller pada Laravel Nova anda.

### Required:

1. PHP Version >= 7.1
2. Laravel >= 5.5
3. Laravel Nova >= 2.0.7

### Cara Install:

1. Tambahkan line `composer.json`

```json
"require": {
    "dot-nova/nova-custom-controllers": "*"
},
...
"repositories": [
    ...
    {
        "type": "git",
        "url": "https://gitlab.com/pt-dot-playground/nova-custom-controllers"
    }
]
```

2. Kemudian jalankan command: `composer update`
3. Selesai

### Cara Penggunaan:

1. Daftarkan `trait` di file `app/Nova/Resource.php`

```php
...
use DotNova\NovaCustomControllers\Traits;

abstract class Resource extends NovaResource
{
    use NovaCustomControllers;
    
    ...
}
```

2. Tambahkan method yang anda butuhkan di resources, contoh pada resource `app/Nova/User.php`

```php
class User extends Resource
{
    ...
    
    /**
     * Before updated in controller
     *
     * @param Request $request
     */
    public static function beforeUpdated(Request $request)
    {}

    /**
     * After updated in controller
     *
     * @param Request $request
     */
    public static function afterUpdated(Request $request)
    {}

    /**
     * Before created in controller
     *
     * @param Request $request
     */
    public static function beforeCreated(Request $request)
    {}

    /**
     * After created in controller
     *
     * @param Request $request
     */
    public static function afterCreated(Request $request)
    {}
}
```

#### Daftar yang harus diselesaikan:
- [x] Custom route & controller for all resources
- [ ] Custom route & controller for custom tools
- [ ] Config to set custom links
- [x] Store Controller
- [x] Update Controller
- [ ] Delete Controller
- [ ] Attach Controller
- [ ] Action Controller
- [x] Add your request in issue

#### Terima kasih buat:
- Mas Ardi
- Mas Didik
- Mas Haris
- Team Project SMI-Collateral

> Semoga berguna dan bermanfaat buat teman-teman DOT Indonesia.
