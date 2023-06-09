@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>詳細</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <div class="container">
  <h1 class="my-3">詳細</h1>
    <table class="table table-striped table-bordered">
      <tr><th>ID  </th><td>{{ $user->id }}</td></tr>
      <tr><th>部署  </th><td>{{ $user->department->name }}</td></tr>
      <tr><th>名前  </th><td>{{ $user->name }}</td></tr>
      <tr><th>Eメール  </th><td>{{ $user->email }}</td></tr>
      <tr><th>パスワード  </th><td>{{ $user->password }}</td></tr>
      <tr><th>追加日時  </th><td>{{ $user->created_at }}</td></tr>
      <tr><th>更新日時  </th><td>{{ $user->updated_at }}</td></tr>
    </table>
  </div>
</body>
</html>
@endsection
