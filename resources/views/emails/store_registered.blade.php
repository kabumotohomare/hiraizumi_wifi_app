<h1>A New Store has been Registered!</h1>
<p>Store Name: {{ $storeName }}</p>
<p>Store Address: {{ $storeAddress }}</p>
<p>Store Email: {{ $storeEmail }}</p>
Mail::raw('Test email content', function ($message) {
    $message->to('t.morita@gmail.com')
            ->subject('Test Email');
});
