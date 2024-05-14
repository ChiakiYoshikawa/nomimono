<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; //追記　データベースにアクセスするために使用されるクラスのインポート文

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'street_address',
        'representative_name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function getCompaniesQuery()
    {     
        return DB::table('companies')->get();
    }

    public function getManufacturers()
    {
        return DB::table('companies')->pluck('company_name', 'id');
    }

}
