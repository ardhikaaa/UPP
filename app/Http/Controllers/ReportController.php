<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function obat(Request $request)
    {

        return view('report.obat');
    }

    public function kunjungan(Request $request)
    {

        return view('report.kunjungan');
    }

    public function siswa(Request $request)
    {

        return view('report.siswa');
    }
}
