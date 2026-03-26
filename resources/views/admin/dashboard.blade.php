<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6f9;
}
.sidebar{
    height:100vh;
    background:#1f2937;
    color:white;
    padding:20px;
}
.sidebar h3{
    margin-bottom:30px;
}
.card{
    border:none;
    border-radius:12px;
}
</style>
</head>

<body>

<div class="row g-0">

<div class="col-md-2 sidebar">
    <h3>Admin</h3>
    <p>📊 Dashboard</p>
    <p>💰 Quỹ</p>
    <p>📜 Lịch sử</p>
</div>

<div class="col-md-10 p-4">

<h2>Quản lý Quỹ Từ Thiện</h2>

<div class="card p-4 mb-4">
<form action="/fund/store" method="POST">
@csrf

<div class="row">
<div class="col-md-4">
<input type="text" name="name" class="form-control" placeholder="Tên quỹ">
</div>

<div class="col-md-4">
<input type="number" name="goal_amount" class="form-control" placeholder="Mục tiêu">
</div>

<div class="col-md-4">
<button class="btn btn-success w-100">Tạo Quỹ</button>
</div>
</div>

</form>
</div>

<table class="table table-striped">
<tr>
<th>ID</th>
<th>Tên Quỹ</th>
<th>Mục tiêu</th>
</tr>

@foreach($funds as $fund)
<tr>
<td>{{ $fund->id }}</td>
<td>{{ $fund->name }}</td>
<td>{{ number_format($fund->goal_amount) }}</td>
</tr>
@endforeach

</table>

</div>
</div>

</body>
</html>
