<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreRequest; // フォームリクエスト
use Illuminate\Support\Facades\Hash; // ハッシュ化

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $sort = $request->sort;
        $users = User::query()->sortable()->paginate(5);
        return view('user.index', ['users' => $users, 'sort' => $sort]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated(); // バリデーション済み全データ
        $inputs['password'] = Hash::make($inputs['password']); // ハッシュ化
        User::create($inputs);

        session()->flash('add_user', '新規登録が完了しました。'); // フラッシュメッセージ
        return redirect('/user'); // 一覧ページにリダイレクト
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id); // 主キー（id）を指定
        return view('user.show', compact('user')); // compact()関数でshow.blade.phpにデータを渡す
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect('/user'); // 一覧ページにリダイレクト
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
