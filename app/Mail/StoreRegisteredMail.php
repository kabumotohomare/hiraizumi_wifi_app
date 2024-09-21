<?php

namespace App\Mail;

use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StoreRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function build()
    {
        return $this->subject('New Store Registered')
                    ->view('emails.store_registered')
                    ->with([
                        'storeName' => $this->store->name,
                        'storeAddress' => $this->store->address,
                        'storeEmail' => $this->store->email,
                    ]);
    }
}
