<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        // هر کاربر میتونه یک رای برای غذا بده
        $survey = Survey::updateOrCreate(
            ['user_id'=>$request->user()->id, 'menu_id'=>$data['menu_id']],
            ['rating'=>$data['rating'], 'comment'=>$data['comment'] ?? null]
        );

        // محاسبه میانگین با Query Builder برای تمرین
        $avg = DB::table('surveys')
            ->where('menu_id', $data['menu_id'])
            ->avg('rating');

        Menu::where('id', $data['menu_id'])->update(['avg_rating' => $avg]);

        return $survey;
    }
}
