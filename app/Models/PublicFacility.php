<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicFacility extends Model
{
    // The table associated with the model
    protected $table = 'public_facilities';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'address',
        'phone',
        'reservation_flag',
        'lat',
        'lng',
        'postal_code',
        'display_flag'
    ];

    /**
     * Get the temporary reservations for the public facility.
     */
    public function temporaryReservations()
    {
        return $this->hasMany(TemporaryPublicFacilityReservation::class, 'facility_id');
    }

    /**
     * Get the confirmed reservations for the public facility.
     */
    public function confirmedReservations()
    {
        return $this->hasMany(ConfirmedPublicFacilityReservation::class, 'facility_id');
    }
}
