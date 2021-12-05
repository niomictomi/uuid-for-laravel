

<p align="center">
<a href="https://github.com/niomictomi/uuid-for-laravel" target="_blank">
<img src="https://github.com/niomictomi/uuid-for-laravel/blob/main/file/tomslock.png" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/badge/apps-siitsa-brightgreen" alt="Apps"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# uuid-for-laravel
Menggunakan UUID sebagai pengganti ID Laravel

## Persiapan
Untuk menggunakan UUD sebagai pengganti ID, maka yang harus dipersiapkan adalah hal-hal sebagai berikut: 

1. Model
2. Database
3. Traits (fungsinya sama kayak Helper, fungsi ini dapat dipakai difungsi-fungsi lainnya)


## Setting
1. Buat model dan migration Blog
   ```sh
   $ php artisan make:model Blog -m
   ```

2. Setting Database
   ```sh
   Schema::create('blogs', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('title');
            $table->timestamps();
        });
   ```
   yang menjadi perhatian bagian uuid disetting sebagai primary dan unique.

3. Setting Model
   ```sh
   <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;

    class Blog extends Model
    {
        use HasFactory;

        /**
        * The attributes that are mass assignable.
        *
        * @var array
        */
        protected $fillable = ['title', 'id'];

        protected $primaryKey = 'id';

        public $incrementing = false;

        protected $keyType = 'string';
    }

   ```
   increment disetting false, karena tidak menggunakan ID lagi.

4. Buat Traits
   Saya membuat file trait HasUuid sebagai file yang berfungsi untuk men-generate UUID pada folder Model\Traits. Berikut potongan kode nya:
   ```sh
   <?php

    namespace App\Models\Traits;

    use Illuminate\Support\Str;

    trait HasUuid
    {
        /**
        * Boot the Has Uuid trait for the model.
        *
        * @return void
        */
        public static function bootHasUuid()
        {
            static::creating(function ($model) {
                if (empty($model->{$model->getKeyName()})) {
                    $model->{$model->getKeyName()} = Str::uuid();
                }
            });
        }
    }

   ```

5. Menambahkan file Trait HasUuid ke dalam Model Blog
   
   yaitu memanggil HasUuid dengan ```use HasUuid``` dan menambahkan ```use App\Models\Traits\HasUuid;```.
   ```sh
   <?php

    namespace App\Models\Test;

    use App\Models\Traits\HasUuid;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;

    class BlogTest extends Model
    {
        use HasFactory, HasUuid;

        /**
        * The attributes that are mass assignable.
        *
        * @var array
        */
        protected $fillable = ['title', 'id'];

        protected $primaryKey = 'id';

        public $incrementing = false;

        protected $keyType = 'string';
    }

    ```

## Simulasi

Dengan menggunakan laravel tinker ```php artisan tinker```, kita menambahkan title dengan value "test 2".

```sh
$ php artisan tinker
Psy Shell v0.10.9 (PHP 7.3.31 — cli) by Justin Hileman
>>> BlogTest::create(['title' => 'test 2']);
```

dan hasilnya sebagai berikut:

```sh
[!] Aliasing 'BlogTest' to 'App\Models\Blog' for this Tinker session.
=> App\Models\Blog {#4617
     title: "test 2",
     id: Ramsey\Uuid\Lazy\LazyUuidFromString {#4622
       uuid: "98ecfa52-8953-4476-b835-cc073e53db42",
     },
     updated_at: "2021-12-05 08:39:21",
     created_at: "2021-12-05 08:39:21",
   }
```
<img  src="https://github.com/niomictomi/uuid-for-laravel/blob/main/file/ssdb.png">