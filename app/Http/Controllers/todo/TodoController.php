<?php

namespace App\Http\Controllers\todo;

use App\Http\Controllers\Controller;
use App\Models\todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $max_data = 5;
        if (request('search')) {
            $data = todo::where('task', 'like', '%' . request('search') . '%')->paginate($max_data);
        } else {
            $data = todo::orderby("id", "asc")->paginate($max_data);
        }
        return view('components.app', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'task' => 'required|min:3'
            ],
            [
                'task.required' => "Kolom harus diisi",
                'task.min' => 'Minimal 3 karakter!'
            ]

        );

        $data = [
            'task' => $request->input('task'),
        ];

        todo::create($data);
        return redirect()->route('todo')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'task' => 'required|min:3'
            ],
            [
                'task.required' => "Kolom harus diisi",
                'task.min' => 'Minimal 3 karakter!'
            ]

        );

        $data = [
            'task' => $request->input('task'),
            'is_done' => $request->input('is_done', 0),
        ];

        todo::where('id', $id)->update($data);
        return redirect()->route('todo')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        todo::where('id', $id)->delete();
        return redirect()->route('todo')->with('success', 'Data berhasil dihapus!');
    }
}
