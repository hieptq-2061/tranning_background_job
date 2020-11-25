<h1>Tổng số mail cần gửi: {{ $monthlyEmail->total_jobs }}</h1>
<h3>Trạng thái: {{ $monthlyEmail->ended_at ? 'Đã hoàn thành' : 'Chưa hoàn thành' }}</h3>
@if ($monthlyEmail->ended_at)
    <h3>Hoàn thành lúc: {{ $monthlyEmail->ended_at }}</h3>
<h3>Tổng thời gian đã chạy: {{ $monthlyEmail->getTotalRunningTimeAttribute() }}</h3>
@else
    <h3>Tổng số jobs đã chạy: {{ $monthlyEmail->jobs_done }}</h3>
@endif
