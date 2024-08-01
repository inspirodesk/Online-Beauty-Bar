<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Carbon\Carbon;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use Mews\Purifier\Facades\Purifier;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('pages.index', compact('pages'));
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(PageStoreRequest $request)
    {
        $validatedData = $request->validated();
        Page::create($validatedData);

        return redirect()->route('pages.index')->with('success', 'Page created successfully');
    }

    public function show(Page $page)
    {
        return view('pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    public function update(PageUpdateRequest $request, Page $page)
    {
        $validatedData = $request->validated();
        $page->update($validatedData);

        return redirect()->route('pages.index')->with('success', 'Page updated successfully');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted successfully');
    }
}
