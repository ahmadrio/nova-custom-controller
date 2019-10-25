# Laravel Nova Custom Controller

**Package Nova Custom Controller** berfungsi untuk mengolah request tanpa perlu membuat controller baru, karna fitur ini sudah otomatis meng-override controller pada Laravel Nova anda.

### Required:

1. PHP Version >= 7.1
2. Laravel >= 5.5
3. Laravel Nova >= 2.0.7

### Cara Install:

1. Tambahkan line `composer.json`

```json
"require": {
    "pt-dot-playground/nova-custom-controller": "*"
},
...
"repositories": [
    ...
    {
        "type": "git",
        "url": "https://gitlab.com/pt-dot-playground/nova-custom-controller.git"
    }
],
"config": {
    ...
    "gitlab-token": {
        "gitlab.com": "hDTLd7YF-LmxpzbE488v"
    }
},
```

2. Kemudian jalankan command: `composer update`
3. Selesai

### Cara Penggunaan:

1. Daftarkan `trait` di file `app/Nova/Resource.php`

```php
...
use PtDotPlayground\NovaCustomController\Traits\NovaCustomEvents;

abstract class Resource extends NovaResource
{
    use NovaCustomEvents;
    
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
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public static function beforeUpdated(Request $request, Model $model)
    {}

    /**
     * After updated in controller
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public static function afterUpdated(Request $request, Model $model)
    {}

    /**
     * Before created in controller
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public static function beforeCreated(Request $request, Model $model)
    {}

    /**
     * After created in controller
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public static function afterCreated(Request $request, Model $model)
    {}
}
```

#### Daftar method yang bisa digunakan:

| Method Name | Type | Return | Description |
|---|---|---|---|
| `beforeCreated()` | `static function` | | Proses sebelum melakukan penyimpanan data baru |
| `afterCreated()` | `static function` | | Proses setelah melakukan penyimpanan data baru |
| `beforeUpdated()` | `static function` | | Proses sebelum melakukan penyimpanan data lama |
| `afterUpdated()` | `static function` | | Proses setelah melakukan penyimpanan data lama |
| `afterSave()` | `static function` | | Proses setelah melakukan penyimpanan data baru & lama |
| `customStoreController()` | `static function` | | Custom full store process controller |
| `customUpdateController()` | `static function` | | Custom full update process controller |
| `$unsetCustomFields` | `static variable` | `array` | Unset model jika terdapat nama custom field yang tidak tersedia di `fillable` |
| `$setCustomRequests` | `static variable` | `array` | Menambah request baru untuk melakukan process pada model |

### Daftar yang harus diselesaikan:
- [x] Custom route & controller for all resources
- [ ] Custom route & controller for custom tools
- [ ] Config to set custom links
- [x] Store Controller
- [x] Update Controller
- [ ] Delete Controller
- [ ] Attach Controller
- [ ] Action Controller
- [x] Fix `NovaCustomEvents` is not used in `app/Nova/Resource.php`
- [x] Add your request in issue

#### Terima kasih buat:
- Mas Ardi
- Mas Didik
- Mas Haris
- Team Project SMI-Collateral

> Semoga berguna dan bermanfaat buat teman-teman DOT Indonesia.
