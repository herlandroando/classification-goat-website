<?php

namespace App\Http\Livewire;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PredictPage extends Component
{
    use WithFileUploads;
    public int $step;
    public $image;
    public bool $is_prediction_success = false;
    public $filename;
    public string $prediction_type;
    public string $prediction_rate;
    public string $datetime;
    public string $prediction_start_time;
    public bool $on_predict = false;

    public function mount()
    {
        $this->step = 1;
    }

    public function nextStep()
    {
        if ($this->step < 3)
            $this->step++;
    }

    public function prevStep()
    {
        if ($this->step > 1)
            $this->step--;
    }

    public function uploadImage()
    {
        $this->filename = 'image_input.' . $this->image->extension();
        // dd($this->filename);
        $this->image->storeAs('public/images', $this->filename, 'local');
    }

    public function removeFilename()
    {
        $this->filename = null;
    }

    public function predict()
    {
        $this->on_predict = true;
        $this->is_prediction_success = false;
        if ($this->filename == null) {
            $this->uploadImage();
        }
        Storage::disk('local')->delete('predicts/result.json');
        // Storage::put('predicts/name.txt', $this->filename);
        //get current path
        $path_to_py = base_path('storage/app/predicts/predict.py');
        // dd($path_to_py);
        //get path image on storage
        $path_image = base_path('storage/app/public/images/' . $this->filename);

        // dd('python '.$path_to_py.' --filename=' . $path_image);
        // dd($this->filename, $path_image, 'conda activate && python ' . $path_to_py . ' --filename=' . $path_image);

        //Run conda command
        $this->prediction_start_time = date('Y-m-d H:i:s');
        $output = '';
        exec('python ' . $path_to_py . ' --filename=' . $path_image, $output);

        Storage::disk('local')->put('predicts/log.txt', json_encode($output));

        // dd($output);

    }

    public function pollPredict()
    {
        if (Storage::disk('local')->exists('predicts/result.json')) {
            // Storage::disk('local')->get('predicts/result.json');
            $result = json_decode(Storage::disk('local')->get('predicts/result.json'));
            $this->is_prediction_success = true;
            $this->on_predict = false;
            // dd($result);
            if ($result->status == 'success') {
                $this->prediction_type = $result->result;
                $this->prediction_rate = $result->probability;
                $this->datetime = $result->time ?? 'null';
                // $this->nextStep();
            } else {
                $this->prediction_type = 'Error';
                $this->prediction_rate = 'Error';
                $this->datetime = $result->time ?? 'null';
            }
        }
    }

    public function render()
    {
        return view('livewire.predict-page');
    }
}
