<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryPublicFacilityReservation extends Model
{
    // The table associated with the model
    protected $table = 'temporary_public_facility_reservations';

    // The attributes that are mass assignable
    protected $fillable = [
        'facility_id',
        'reservation_name',
        'reservation_phone',
        'reservation_email',
        'reservation_postal_code',
        'reservation_address',
        'reservation_date',
        'people',
        'reservation_time',
        'approval_flag'
    ];

    /**
     * Get the public facility associated with the temporary reservation.
     */
    public function publicFacility()
    {
        return $this->belongsTo(PublicFacility::class, 'facility_id');
    }

    /**
     * Get the confirmed reservation associated with the temporary reservation.
     */
    public function confirmedReservation()
    {
        return $this->hasOne(ConfirmedPublicFacilityReservation::class, 'temporary_reservation_id');
    }
}
