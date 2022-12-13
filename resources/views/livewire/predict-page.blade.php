<div>
    @switch($step)
        @case(1)
            <div class="h-full flex flex-col text-gray-200 justify-center items-center mt-8">
                <p class="text-sm font-thin"> Dibuat oleh:</p>
                <h1 class="text-2xl font-bold mt-3">Team Indonesia Meriset</h1>
                <p class="text-sm mt-4">Terdiri dari 4 orang mahasiswa MTI Amikom:</p>
                <ul class="text-sm list-disc list-inside mt-2">
                    <li>Febri Yusuf Gilang</li>
                    <li>Arvi Susilo</li>
                    <li>Fail Nugroho Sulistyo</li>
                    <li>Herlandro Tribiakto</li>
                </ul>
                <button wire:click="nextStep" class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Mulai
                </button>
            </div>
        @break

        @case(2)
            <h2 class="text-xl font-bold mt-5">Model yang Digunakan</h2>
            <p class="text-sm mt-3">Model yang digunakan menggunakan Framework <a href="https://fast.ai/" target="_blank"
                    class="text-blue-500">FastAi</a> yang mana arsitektur CNN yang digunakan adalah ResNet50. Hasil akurasi
                training yang didapat dengan epoch = 10 adalah 96,45%. Confusion Matrix bisa dilihat
                di bawah ini:</p>
            <img src="{{ asset('storage/confusion matrix.jpg') }}" alt="Confusion Matrix" class="mt-3 img-confusion-matrix">

            <h2 class="text-sm mt-3">Kita bisa mengklasifikasikan Ras Kambing ini:</h2>
            <ul class="text-sm list-disc list-inside">
                <li>Saanen</li>
                <li>Bengal</li>
                <li>Boer</li>
                <li>Etawa</li>
            </ul>
            <div class="flex justify-center items-center flex-row gap-6">
                <button wire:click="prevStep" class="mt-5 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Mungkin Ingin Mengenal Lagi
                </button>
                <button wire:click="nextStep" class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Coba Sekarang!
                </button>
            </div>
        @break

        @case(3)
            <div class="flex justify-center items-center flex-col gap-6">
                <p>Upload gambar kambing yang ingin diklasifikasikan dengan format .jpg atau .png</p>
                <form wire:submit.prevent="uploadImage">
                    <input type="file" wire:model="image" id="image" wire:change="removeFilename">

                    @error('image')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    <button type="submit" class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Upload
                    </button>
                </form>

                @if ($filename)
                    <img src="{{ $image->temporaryUrl() }}" alt="Image" class="mt-3 w-2/6 h-auto">
                @endif

                <p> Klik tombol di bawah ini untuk memprediksi gambar yang telah diupload</p>
                <button wire:click="predict" class="mt-5 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                    {{ $on_predict ? 'disabled' : '' }}>
                    {{ $on_predict ? 'Memproses...' : 'Prediksi' }}
                </button>
                @if ($on_predict)
                    <div class="flex justify-center items-center flex-col gap-3" wire:poll="pollPredict">
                        <p class="text-xl font-bold">Memproses...</p>
                        <p class="text-sm">Harap tunggu sebentar</p>
                        {{-- time --}}
                        <p>{{ now()->diffForHumans(now()->parse($this->prediction_start_time)) }}</p>
                    </div>
                @endif
                @if ($is_prediction_success)
                    <div class="flex justify-center items-center flex-col gap-3">
                        <p class="text-xl font-bold">Hasil Prediksi:</p>
                        <p class="text-lg font-bold">{{ $prediction_type }}</p>
                        <p class="text-sm">Dengan akurasi {{ $prediction_rate }}</p>
                        <p class="text-sm text-gray-500">{{ $datetime }}</p>
                    </div>
                @endif

            </div>
        @break

        @default
    @endswitch

</div>
