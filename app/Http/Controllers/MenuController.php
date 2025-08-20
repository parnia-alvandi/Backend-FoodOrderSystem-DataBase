<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /*لیست همه‌ی منوها*/
    public function index()
    {
        $menus = Menu::withCount(['comments','surveys'])->paginate(12);
        return view('menus.index', compact('menus'));
    }

    /*نمایش جزئیات یک منو*/
    public function show(Menu $menu)
    {
        $menu->load(['comments.user','surveys.user']);
        return view('menus.show', compact('menu'));
    }

    /*فرم ایجاد منو (ادمین)*/
    public function create()
    {
        return view('menus.create');
    }

    /*ذخیره منو جدید (ادمین)*/
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
        ]);

        Menu::create($data);
        return redirect()->route('menus.index')->with('success', 'منو با موفقیت ایجاد شد.');
    }

    /*فرم ویرایش منو (ادمین)*/
    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    /*آپدیت منو (ادمین)*/
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
        ]);

        $menu->update($data);
        return redirect()->route('menus.index')->with('success', 'منو بروزرسانی شد.');
    }

    /*حذف منو (ادمین)*/
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'منو حذف شد.');
    }
}
