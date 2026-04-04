<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\MarriedStatus;
use App\Enums\Religion;
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
        'joined_date',
        'bank_name',
        'account_number',
        'account_owner_name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'religion' => Religion::class,
            'maried_status' => MarriedStatus::class,
        ];
    }

    public function information()
    {
        return $this->hasOne(UserInformation::class);
    }
}
