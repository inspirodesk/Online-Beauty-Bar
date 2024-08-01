<?php
namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Advertisement;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Mews\Purifier\Facades\Purifier;

class AdvertisementController extends Controller
{
    /**
     * Instantiate a new AdvertisementController instance.
     */
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:create-Advertisement|edit-Advertisement|delete-Advertisement', ['only' => ['index','show']]);
       $this->middleware('permission:create-Advertisement', ['only' => ['create','store']]);
       $this->middleware('permission:edit-Advertisement', ['only' => ['edit','update']]);
       $this->middleware('permission:delete-Advertisement', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
    */
    public function index(): View
    {
        return view('advertisements.index', 
            ['advertisements' => Advertisement::latest()->paginate(10)]
        
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('advertisements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementRequest $request): RedirectResponse
{
  
    $imageUrl = $this->advertisementupload($request, 'upload');
   

    $advertisement = new Advertisement($request->all());

    if ($imageUrl) {
        $advertisement->image_url = $imageUrl;
    }
    $advertisement->save();
    return redirect()->route('advertisements.index')
        ->withSuccess('New Advertisement is added successfully.');
}

    
    /**
     * Display the specified resource.
     */
    public function show($advertisement): View
    {
        $advertisement = Advertisement::find($advertisement);
        return view('advertisements.show_modal', [ 'advertisement' => $advertisement ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($advertisement): View
    {
        $advertisement = Advertisement::find($advertisement);

        return view('advertisements.edit', [
            'advertisement' => $advertisement
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement): RedirectResponse
    {
        $imageUrl = $this->advertisementupload($request, 'upload');
        if ($imageUrl) {
            $advertisement->image_url = $imageUrl;
        }
        $advertisement->ispopup = $request->has('ispopup') ? $request->input('ispopup') : null;
        $advertisement->isclosepopup = $request->has('isclosepopup') ? $request->input('isclosepopup') : null;
        $advertisement->update($request->all());
        $advertisement->save();
        return redirect()->back()
                ->withSuccess('Advertisement is updated successfully.');
    }

    public function advertisementupload(Request $request, $inputName)
    {
        if ($request->hasFile($inputName)) {
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
        $advertisement = Advertisement::find($id); 
        $advertisement->delete();
        return redirect()->route('advertisements.index')->withSuccess('Advertisement is deleted successfully.');
    }
}