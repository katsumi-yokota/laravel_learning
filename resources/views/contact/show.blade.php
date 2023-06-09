@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>詳細</title>
</head>
<body>
  <div class="container">
    <table class="table table-striped table-bordered">
      <tr>
        <th>状態  </th>
        <td>
        @if ($contact->is_closed)
          クローズド
        @else
          オープン
        @endif
        </td>
    </tr>
      <tr><th>お問い合わせID  </th><td>{{ $contact->id }}</td></tr>
      <tr>
        <th>タグ名</th>
        <td>
        @php
          $contactTagCount = $contact->contactTags->count();
        @endphp
        @foreach ($contact->contactTags as $i => $contactTag)
          {{ $contactTag->name }}{{ $i < $contactTagCount - 1 ? ',' : '' }}
        @endforeach
        </td>
      </tr>
      <tr><th>タイトル  </th><td>{{ $contact->title }}</td></tr>
      <tr><th>お名前  </th><td>{{ $contact->name }}</td></tr>
      <tr><th>本文  </th><td>{!! $contact->body !!}</td></tr>
      <tr><th>メールアドレス  </th><td>{{ $contact->email }}</td></tr>
      <tr><th>お問い合わせ日時  </th><td>{{ $contact->created_at }}</td></tr>
      <tr><th>更新日時  </th><td>{{ $contact->updated_at }}</td></tr>
      <tr><th>ファイル名  </th><td>{{ $contact->file_name }}</td></tr>
      <tr><th>プレビュー  </th><td>
      @if (!$contact->file_path)
        ファイルが添付されていません。
      @elseif (File::exists($contact->file_path))
        @if (preg_match('/.+\.(png|jpe?g|gif|bmp)$/', $contact->file_name))
          <img src="{{ route('contact.preview', $contact->id) }}" alt="">
        @else
        この形式のファイルはプレビューできません。
        @endif
      @else
        ファイルが削除された可能性があります。
      @endif
      </td></tr>
      <tr>
        <th>レスポンス</th>
        <td>
        @if ($contact->is_closed)
          クローズしているのでレスポンスできません。
        @else
          <form method="post" action="{{ route('contact-response.store', $contact->id) }}">
            @csrf
            <div class="form-group">
              <label for="response_content">レスポンス</label>
              <textarea name="response_content" class="form-control" id="response_content" value="" placeholder="レスポンスしてください。">{{ old('response_content') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success mt-3">送信する</button>
          </form>
        @endif
        </td>
      </tr>
      <tr>
        <th>問い合わせ者のレスポンスの可否</th>
        <td>
          @if ($contact->status === App\Models\Contact::CLOSED)
            問い合わせはクローズしているので問い合わせ者はレスポンスできません。
          @else
            @if ($contact->share_status !== App\Models\Contact::SHARED)
              <form method="post" action="{{ route('contact.shareGuest',['contact' => $contact->id]) }}">
                @csrf
                <button type="submit" class="btn btn-warning" onClick="return confirm('問い合わせ者がレスポンスできるようにしますか？');">問い合わせ者がレスポンスできるようにする。</button>
              </form>
            @else
              問い合わせ者はレスポンスできます。
            @endif
          @endif
        </td>
      </tr>
      <tr>
        <th>問い合わせ者用のURL</th>
        <td>
        @if ($contact->status === App\Models\Contact::CLOSED)
          問い合わせはクローズしているので問い合わせ者はURLにアクセスできません。
        @else
          @if ($contact->share_status === App\Models\Contact::SHARED)
              {{ request()->url() . "/contact-interaction/$contact->share_code" }}
          @else 
            URLは発行されていません。
          @endif
        @endif
        </td>
      </tr>
    </table>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>レスポンス内容</th>
          <th>対応者</th>
          <th>対応日時</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contact->contactResponses->sortByDesc('created_at') as $contactResponse)
          <?php $isSameUser = $contactResponse->user && Auth::id() === $contactResponse->user->id ?>
          <tr>
            <td>{{ $contactResponse->response_content }}</td>
            <td>@if ($contactResponse->user) {{ $contactResponse->user->name }} @endif</td>
            <td>{{ $contactResponse->created_at }}</td>
            <td>
            @if ($isSameUser && !$contact->is_closed)
              <a href="{{ route('contact-response.edit', ['contact' => $contactResponse->contact_id, 'contact_response' => $contactResponse->id]) }}" class="btn btn-primary">編集</a>
            @endif
            </td>
            <td>
            @if ($isSameUser && !$contact->is_closed) 
              <form method="post" action="{{ route('contact-response.destroy', ['contact' => $contactResponse->contact_id, 'contact_response' => $contactResponse->id]) }}">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-warning" onClick="return confirm('本当に削除しますか？');">削除</button>
              </form>
            @endif 
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <form action="{{ route('contact.patch', ['contact' => $contact->id, 'contact_response' => $contact->id, 'status' => App\Models\Contact::CLOSED]) }}" method="post">
      @method('patch')
      @csrf
      <input type="submit" value="お問い合わせをクローズする">
    </form>
  </div>
</body>
</html>
@endsection
