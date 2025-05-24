<?php

namespace App\Models\Company;

use App\Models\Client\ApiClient;
use App\Models\Team\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Modules\Properties\Models\Property\Amenity;
use Modules\Settings\Models\System\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Modules\Properties\Models\Property\Feature;
use Modules\Settings\Models\Language\Language;
use Modules\Settings\Models\Localization\Country;
use Illuminate\Support\Str;
use Modules\Properties\Models\Property\Property;
use Modules\Properties\Models\Property\PropertyUnit;
use Spatie\Permission\Models\Role;

class Company extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public static function boot() {
        parent::boot();

        static::creating(function ($company): void {
            $company->uuid = (string) Str::uuid();
        });

    }

    public function scopeIsCompany(Builder $query, $company_id)
    {
        return $query->where('status', 'active');
    }

    public function isActive(Builder $builder) {
        return $builder->where('enabled', 1);
    }

    // Get Team
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }


    /**
     * Get settings for the company.
     */
    public function setting()
    {
        return $this->hasOne(Setting::class, 'company_id', 'id');
    }

    /**
     * Get client for the company.
     */
    public function client()
    {
        return $this->hasOne(ApiClient::class, 'company_id', 'id');
    }

    /**
     * Get user for the company.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }

    /**
     * Get user for the company.
     */
    public function roles()
    {
        return $this->hasMany(Role::class, 'company_id', 'id');
    }

    /**
     * Get languages for the company.
     */
    public function languages()
    {
        return $this->hasMany(Language::class, 'company_id', 'id');
    }

    /**
     * Get countries for the company.
     */
    // public function countries()
    // {
    //     return $this->hasMany(Country::class, 'company_id', 'id');
    // }

    public function countries(){
        return Country::all()->sortBy('common_name');
    }

    /**
     * Get amenities for the company.
     */
    public function amenities()
    {
        return $this->hasMany(Amenity::class, 'company_id', 'id');
    }

    /**
     * Get properties for the company.
     */
    public function properties()
    {
        return $this->hasMany(Property::class, 'company_id', 'id');
    }

    /**
     * Get units for the company.
     */
    public function units()
    {
        return $this->hasMany(PropertyUnit::class, 'company_id', 'id');
    }

    /**
     * Get features for the company.
     */
    public function features()
    {
        return $this->hasMany(Feature::class, 'company_id', 'id');
    }

}
