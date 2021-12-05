# uuid-for-laravel
Menggunakan UUID sebagai pengganti ID Laravel

## Persiapan
Untuk menggunakan UUD sebagai pengganti ID, maka yang harus dipersiapkan adalah hal-hal sebagai berikut: 

1. Model
2. Database
3. Traits (fungsinya sama kayak Helper, fungsi ini dapat dipakai difungsi-fungsi lainnya)


## Simulasi
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