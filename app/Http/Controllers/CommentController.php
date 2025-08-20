<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($menuId) {
        return Comment::with('user')->where('menu_id', $menuId)
            ->latest()->paginate(50);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'body'    => 'required|string'
        ]);
        $data['user_id'] = $request->user()->id;
        return Comment::create($data);
    }
}
