<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteContentController extends Controller
{
    public function index(): View
    {
        $sections = SiteContent::orderBy('section')->orderBy('id')->get()->groupBy('section');

        return view('admin.contenido.index', compact('sections'));
    }

    public function edit(SiteContent $content): View
    {
        return view('admin.contenido.edit', compact('content'));
    }

    public function update(Request $request, SiteContent $content): RedirectResponse
    {
        $validated = $request->validate([
            'value' => ['required', 'string'],
        ]);

        $content->update(['value' => $validated['value']]);

        SiteContent::clearCache($content->key);

        return redirect()->route('admin.contenido.index')
            ->with('success', "Contenido \"{$content->label}\" actualizado correctamente.");
    }
}
