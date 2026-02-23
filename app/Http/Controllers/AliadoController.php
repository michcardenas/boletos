<?php

namespace App\Http\Controllers;

use App\Models\Aliado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AliadoController extends Controller
{
    public function index(): View
    {
        $aliados = Aliado::orderBy('orden')->get();

        return view('admin.aliados.index', compact('aliados'));
    }

    public function create(): View
    {
        return view('admin.aliados.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'imagen' => ['required', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'url' => ['nullable', 'url', 'max:255'],
            'orden' => ['nullable', 'integer', 'min:0'],
        ]);

        $path = $request->file('imagen')->store('aliados', 'public');

        Aliado::create([
            'nombre' => $validated['nombre'],
            'imagen' => $path,
            'url' => $validated['url'],
            'orden' => $validated['orden'] ?? 0,
            'activo' => true,
        ]);

        return redirect()->route('admin.aliados.index')
            ->with('success', "Aliado \"{$validated['nombre']}\" agregado correctamente.");
    }

    public function edit(Aliado $aliado): View
    {
        return view('admin.aliados.edit', compact('aliado'));
    }

    public function update(Request $request, Aliado $aliado): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'url' => ['nullable', 'url', 'max:255'],
            'orden' => ['nullable', 'integer', 'min:0'],
            'activo' => ['nullable'],
        ]);

        $data = [
            'nombre' => $validated['nombre'],
            'url' => $validated['url'],
            'orden' => $validated['orden'] ?? 0,
            'activo' => $request->has('activo'),
        ];

        if ($request->hasFile('imagen')) {
            Storage::disk('public')->delete($aliado->imagen);
            $data['imagen'] = $request->file('imagen')->store('aliados', 'public');
        }

        $aliado->update($data);

        return redirect()->route('admin.aliados.index')
            ->with('success', "Aliado \"{$validated['nombre']}\" actualizado correctamente.");
    }

    public function destroy(Aliado $aliado): RedirectResponse
    {
        Storage::disk('public')->delete($aliado->imagen);
        $nombre = $aliado->nombre;
        $aliado->delete();

        return redirect()->route('admin.aliados.index')
            ->with('success', "Aliado \"{$nombre}\" eliminado correctamente.");
    }
}
