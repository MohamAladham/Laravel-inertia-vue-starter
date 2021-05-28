<?php

namespace App\Exports;

use App\Models\Admin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdminsExport implements FromView
{
    public function view(): View
    {
        return view('exports.admins', [
            'items' => Admin::all()
        ]);
    }
}
