<div>
    @foreach ($reports as $report)
        テストテスト
        <ul>
            <li>image : {{ $report->image }}</li>
            <li>shop : {{ $report->shop }}</li>
            <li>mail : {{ $report->id }}</li>
            <li>status_id : {{ $status_id }}</li>
        </ul>
    @endforeach
</div>
