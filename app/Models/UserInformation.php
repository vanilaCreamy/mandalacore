<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_informations';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'nik',
        'nomor_kk',
        'fullname',
        'education',
        'place_of_birth',
        'date_of_birth',
        'phone_number',
        'shirt_size',
        'gender',
        'religion',
        'maried_status',
        'province',
        'regency',
        'subdistrict',
        'village',
        'address',
    ];
}
