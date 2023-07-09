<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();

        return response()->json($sliders);
    }

    public function show($id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json(['error' => 'Slider not found'], 404);
        }

        return response()->json($slider);
    }

    public function create(CreateSliderRequest $request)
    {


        $slider = new Slider();
        $slider->nama = $request->input('nama');
        $image = $request->file('image');
        $imagePath = $image->store('public/upload/slider');
        $slider->image = $imagePath;
        $slider->save();

        return response()->json($slider);
    }

    public function update(UpdateSliderRequest $request, $id)
    {
        try {
            $slider = Slider::find($id);

            if (!$slider) {
                return response()->json(['error' => 'Slider not found'], 404);
            }

            $slider->nama = $request->input('nama');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('public/upload/slider');

                // Hapus gambar lama jika ada
                if ($slider->image) {
                    Storage::delete($slider->image);
                }

                $slider->image = $imagePath;
            }

            $slider->save();

            return response()->json($slider);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json(['error' => 'Slider not found'], 404);
        }

        // Hapus file menggunakan Storage
        if ($slider->image) {
            Storage::delete($slider->image);
        }
        $slider->delete();

        return response()->json(['message' => 'Slider deleted']);
    }
}
