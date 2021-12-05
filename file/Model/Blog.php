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
