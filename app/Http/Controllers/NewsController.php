<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\News;
use App\Models\Category;
use App\Models\Site;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Mews\Purifier\Facades\Purifier;

class NewsController extends Controller
{
    /**
     * Instantiate a new NewsController instance.
     */
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:create-news|edit-news|delete-news', ['only' => ['index','show']]);
       $this->middleware('permission:create-news', ['only' => ['create','store']]);
       $this->middleware('permission:edit-news', ['only' => ['edit','update']]);
       $this->middleware('permission:delete-news', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
    */
    public function index(): View
    {

        return view('newses.index',
            ['newses' => News::latest()->paginate(7),]

        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
         $sites = Site::all();
         $categories = Category::all();
        return view('newses.create',[
            'sites' => $sites,
            'categories'=>$categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request): RedirectResponse
{
    $newsImageUrl = $this->newsupload($request, 'upload');
    \Log::info($request->all());
    $news = new News($request->all());

    if ($newsImageUrl) {
        $news->news_image_url = $newsImageUrl;
    }
    $news->save();
    $siteSelection = $request->input('siteSelection', []);
    foreach ($siteSelection as $siteId) {
        $news->sites()->attach($siteId);
    }

    // Loop through categorySelection and sync with the categories relationship
    $categorySelection = $request->input('categorySelection', []);
    foreach ($categorySelection as $categoryId) {
        $news->categories()->attach($categoryId);
    }


    return redirect()->route('newses.index')
            ->withSuccess('New news is added successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show($news): View
    {
        $news = News::find($news);
        $siteSelection = $news->sites;
        $category = $news->categories;

        return view('newses.show_modal', [
            'news' => $news,
            'siteSelection' => $siteSelection,
            'category' => $category,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($news): View
{
    $news = News::find($news);
    $allSiteSelectionOptions = Site::all();
    $allCategoryOptions = Category::all();
    $selectedSiteSelection = $news->sites;
    $selectedCategory = $news->categories;
    \Log::info($selectedSiteSelection);

    return view('newses.edit', [
        'news' => $news,
        'allCategoryOptions'=>$allCategoryOptions,
        'allSiteSelectionOptions' => $allSiteSelectionOptions,
        'selectedSiteSelection' => $selectedSiteSelection,
        'selectedCategory' => $selectedCategory,
    ]);
}




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, $newsId): RedirectResponse
{
    $news = News::find($newsId);

    $newsImageUrl = $this->newsupload($request, 'upload');

    if ($newsImageUrl) {
        $news->news_image_url = $newsImageUrl;
    }

    $news->update($request->except(['siteSelection', 'categorySelection']));

    $news->sites()->sync($request->input('siteSelection', []));
    $news->categories()->sync($request->input('categorySelection', []));

    $news->save();

    return redirect()->back()
        ->withSuccess('News is updated successfully.');
}


    public function newsupload(Request $request, $inputName)
    {
        if ($request->hasFile($inputName)) {
            \Log::info($request->file($inputName));
            $originName = $request->file($inputName)->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file($inputName)->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file($inputName)->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return $url;
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $news = News::find($id);

        if (!$news) {
            return redirect()->route('newses.index')->withError('News not found.');
        }

        $news->sites()->detach();
        $news->categories()->detach();


        $news->delete();

        return redirect()->route('newses.index')->withSuccess('News and related relationships are deleted successfully.');
    }
}
