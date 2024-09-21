<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>公共施設名</th>
            <th>予約確定日</th>
            <th>予約時間</th>
            <th>人数</th>
            <th>キャンセルフラグ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->public_facilities->name }}</td>
                <td>{{ $reservation->confirmed_reservation_date }}</td>
                <td>{{ $reservation->confirmed_reservation_time }}時間</td>
                <td>{{ $reservation->people }}</td>
                <td>{{ $reservation->cancel_flag ? 'キャンセル済み' : '未キャンセル' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
