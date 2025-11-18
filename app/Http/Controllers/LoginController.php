<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TTecnical;
use App\Models\TAssign;


class LoginController extends Controller
{
    public function actLogin()
    {
        // dd('actlovdnsj');
        if (!Session::has('tecnical'))
            return redirect('/');
        // else
        //     return view('login/login');
    }
    public function actSigin(Request $r)
    {
        // dd($r->all());
        Carbon::setLocale('es');
    	$tec = TTecnical::where('dni',$r->dni)->first();

        if($tec != null)
        {
            $assign = TAssign::where('idTec',$tec->idTec)->orderby('idTec','desc')->first();
            session(['tecnical' => $tec]);
            session(['assign' => $assign]);
            session(['lastMonth' => Carbon::now()->subMonth()->translatedFormat('F')]);
            return response()->json(['estado' => true, 'message' => 'ok']);
        }
        else
            return response()->json(['estado' => false, 'message' => 'Ingrese un usuario valido']);
    }
    public function actLogout(Request $r)
    {
//         $sessionData = Session::all();
// dd($sessionData);
        // dd('aki');
    	session()->flush();
        return redirect('/');
    	// return redirect('login/login');
    }
}
