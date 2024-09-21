<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmedPublicFacilityReservation extends Model
{
    // The table associated with the model
    protected $table = 'confirmed_public_facility_reservations';

    // The attributes that are mass assignable
    protected $fillable = [
        'facility_id',
        'temporary_reservation_id',
        'confirmed_reservation_date',
        'confirmed_reservation_time',
        'people',
        'cancel_flag'
    ];

    /**
     * Get the public facility associated with the confirmed reservation.
     */
    public function publicFacility()
    {
        return $this->belongsTo(PublicFacility::class, 'facility_id');
    }

    /**
     * Get the temporary reservation associated with the confirmed reservation.
     */
    public function temporaryReservation()
    {
        return $this->belongsTo(TemporaryPublicFacilityReservation::class, 'temporary_reservation_id');
    }
}
