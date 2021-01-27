<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Random;
use App\Models\Breakdown;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function make(Request $request)
    {
        try {
            $data = array(  //reference data for names
                'Johnathon',
                'Anthony',
                'Erasmo',
                'Raleigh',
                'Nancie',
                'Tama',
                'Camellia',
                'Augustine',
                'Christeen',
                'Luz',
                'Diego',
                'Lyndia',
                'Thomas',
                'Georgianna',
                'Leigha',
                'Alejandro',
                'Marquis',
                'Joan',
                'Stephania',
                'Elroy',
                'Zonia',
                'Buffy',
                'Sharie',
                'Blythe',
                'Gaylene',
                'Elida',
                'Randy',
                'Margarete',
                'Margarett',
                'Dion',
                'Tomi',
                'Arden',
                'Clora',
                'Laine',
                'Becki',
                'Margherita',
                'Bong',
                'Jeanice',
                'Qiana',
                'Lawanda',
                'Rebecka',
                'Maribel',
                'Tami',
                'Yuri',
                'Michele',
                'Rubi',
                'Larisa',
                'Lloyd',
                'Tyisha',
                'Samatha',
            );
            $test = array();
            $loop = rand(5,10); //random iteration
            for ($i=0; $i < $loop; $i++) { 
                $random_val = $data[rand ( 0 , count($data) -1)]; //random name
                $random_ = Random::create([
                    'values' => $random_val,
                    'flag' => 0,
                ]);
                $loop_break = rand(5,10); //random iteration
                for ($x=0; $x < $loop_break; $x++) { 
                    $ref_string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; //reference string to be used for break down value
                    $breakdown_val = substr(str_shuffle($ref_string), 0, 5); //shuffle the reference string the get the substring from index 0 - 5
                    $break_ = Breakdown::create([
                        'values' => $breakdown_val,
                        'random_id' => $random_->id,
                    ]);
                }
            }
            // dd($test);
            return [
                'succes' => true,
                'data' => $random_->getBreakDowns,
            ];
        } catch (Exception $e) {
            return [
                'succes' => false,
                'msg' => $e,
            ];
        }
    }
    public function getRandom(Request $request)
    {
        try {
            $random_ = Random::where('flag', 0)->with('getBreakDowns')->get();
            $random = '';
            $breakdown = '';
            foreach ($random_ as $key => $value) {
                $random = $random . $value->values;
                foreach ($value->getBreakDowns as $k => $val) {
                    $breakdown = $breakdown . $val->values;
                }
                // $value->update([
                //     'flag' => 1,
                // ]);
            }
            return [
                'succes' => true,
                'random' => $random,
                'breakdown' => $breakdown,
            ];
        } catch (Exception $e) {
            return [
                'succes' => false,
                'msg' => $e,
            ];
        }
    }
}
