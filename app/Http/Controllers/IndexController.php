<?php
/**
 * Created by PhpStorm.
 * User: malak
 * Date: 12/15/18
 * Time: 8:21 PM
 */

namespace App\Http\Controllers;

class IndexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function homepage()
    {
        return view('index.homepage');
    }
}
