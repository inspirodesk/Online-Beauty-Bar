<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Site;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\JsonResponse;


class SiteController extends Controller
{
    /**
     * Instantiate a new NewsController instance.
     */
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:create-site|edit-site|delete-site', ['only' => ['index','show']]);
       $this->middleware('permission:create-site', ['only' => ['create','store']]);
       $this->middleware('permission:edit-site', ['only' => ['edit','update']]);
       $this->middleware('permission:delete-site', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
    */
    public function index(): View
    {
        return view('sites.index', 
            ['sites' => Site::latest()->paginate(10)]
        
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiteRequest $request)
{
    

    $site = new Site($request->all());

   


    $site->save();

    if ($request->ajax()) {
    
        return response()->json(['id' => $site->id]);
    } else {
    
        return redirect()->route('sites.index')
            ->withSuccess('New site is added successfully.');
    }

}


    /**
     * Display the specified resource.
     */
    public function show($site): View
    {
        $site = Site::find($site);
      
        
        return view('sites.show_modal', [
            'site' => $site,
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($site): View
{
    $site = Site::find($site);
   

    return view('sites.edit', [
        'site' => $site,
       
    ]);
}

    


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteRequest $request, $siteId): RedirectResponse
{
    $site = Site::find($siteId);

    $site->update($request->all());


    $site->save();

    return redirect()->back()
        ->withSuccess('site is updated successfully.');
}


  
public function destroy($id): RedirectResponse
{
    $site = Site::find($id);

    if (!$site) {
        return redirect()->route('sites.index')->withError('Site not found.');
    }

    
    $site->news()->detach();

   
    $site->delete();

    return redirect()->route('sites.index')->withSuccess('Site and related relationships are deleted successfully.');
}
}