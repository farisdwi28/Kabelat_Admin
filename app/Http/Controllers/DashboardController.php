<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komunitas;
use App\Models\MemberKomunitas;

class DashboardController extends Controller
{
    public function index () {
        $data['Komunitas'] = Komunitas :: count();
        return  view('dashboard.index', $data);
        
    }
}
