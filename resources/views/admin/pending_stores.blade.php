<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>店舗名</th>
            <th>住所</th>
            <th>承認フラグ</th>
            <th>作成日</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stores as $store)
            <tr>
                <td>{{ $store->id }}</td>
                <td>{{ $store->name }}</td>
                <td>{{ $store->address }}</td>
                <td>{{ $store->approval_flag ? '承認済み' : '申請中' }}</td>
                <td>{{ $store->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
