<?php

namespace App\Controllers;

class Menu extends BaseController
{
    public function Akun()
    {
        return view('menu/menuAkun');
    }
    

    public function Laporan()
    {
        return view('menu/menuLaporan');
    }

}
