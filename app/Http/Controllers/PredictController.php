<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PredictController extends Controller
{
    public function predict()
    {
        //get current path
        $path_to_py = base_path('storage/app/predicts/predict.py');
        // dd($path_to_py);

        //get path image on storage
        $path_image = base_path('storage/app/saanen.jpg');

        // dd('python '.$path_to_py.' --filename=' . $path_image);

        //Run conda command
        $output = shell_exec('conda activate && python ' . $path_to_py . ' --filename=' . $path_image);

        //return result
        return $output;
    }
}
