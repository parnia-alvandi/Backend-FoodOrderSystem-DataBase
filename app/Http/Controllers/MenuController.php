<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // شمارش‌ها بر اساس ستون‌های موجود (menu_id)
        $menus = Menu::withCount(['comments','surveys'])->paginate(12);
        return view('menu.index', compact('menus'));
    }

    public function show(Menu $menu)
    {
        $menu->load(['comments.user','surveys.user']);
        return view('menu.show', compact('menu'));
    }

    // متدهای ادمین در گروه admin.resource ثبت می‌شوند (create/store/edit/update/destroy)
}
