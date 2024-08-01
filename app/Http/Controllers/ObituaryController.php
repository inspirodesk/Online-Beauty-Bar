<?php
namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Obituary;
use App\Models\ContactDetail;
use App\Http\Requests\StoreObituaryRequest;
use App\Http\Requests\UpdateObituaryRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Mews\Purifier\Facades\Purifier;

class ObituaryController extends Controller
{
    /**
     * Instantiate a new ObituaryController instance.
     */
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:create-obituary|edit-obituary|delete-obituary', ['only' => ['index','show']]);
       $this->middleware('permission:create-obituary', ['only' => ['create','store']]);
       $this->middleware('permission:edit-obituary', ['only' => ['edit','update']]);
       $this->middleware('permission:delete-obituary', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $obituaries = Obituary::with('contactDetails')->latest()->paginate(10);
        return view('obituaries.index', ['obituaries' => $obituaries]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('obituaries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObituaryRequest $request): RedirectResponse
    {

        \Log::info($request->all());
        $normalImageUrl = $this->obituaryupload($request, 'upload', 'normal');
        $frameImageUrl = $this->obituaryupload($request, 'frame_upload', 'frame');

        $obituary = new Obituary($request->all());

        if ($normalImageUrl) {
            $obituary->normal_image_url = $normalImageUrl;
        }

        if ($frameImageUrl) {
            $obituary->frame_image_url = $frameImageUrl;
        }
        
        $obituary->save();
        $obituary->contactId = 'obi' . $obituary->id;
        $obituary->save();
       
        $this->saveContactDetails($request, $obituary->id);

        return redirect()->route('obituaries.index')
            ->withSuccess('New obituary is added successfully.');
    }

    // Add a similar method for updating

    private function saveContactDetails(Request $request, $obituaryId)
    {
       
        $contactDetails = $request->input('contact_details', []);
        foreach ($contactDetails as $contact) {
            ContactDetail::create([
                'contact_name' => $contact['contact_name'],
                'contact_number' => $contact['contact_number'],
                'object_id' => 'obi' . $obituaryId,
            ]);
        }
    }
   
    /** 
     * Display the specified resource.
     */
    public function show($obituary): View
    {
        $obituary = Obituary::with('contactDetails')->find($obituary);
        return view('obituaries.show_modal', ['obituary' => $obituary]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($obituary): View
    {
        $obituary = Obituary::find($obituary);

        return view('obituaries.edit', [
            'obituary' => $obituary
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateObituaryRequest $request, Obituary $obituary): RedirectResponse
    {
      
        $normalImageUrl = $this->obituaryupload($request, 'upload', 'normal');
        $frameImageUrl = $this->obituaryupload($request, 'frame_upload', 'frame');
        
        if ($normalImageUrl) {
            $obituary->normal_image_url = $normalImageUrl;
        }
    
        if ($frameImageUrl) {
            $obituary->frame_image_url = $frameImageUrl;
        }
    
        $obituary->update($request->all());
        $obituary->save();
    

        $this->updateContactDetails($request, $obituary->id);
    
        return redirect()->back()->withSuccess('Obituary is updated successfully.');
    }
    
    private function updateContactDetails(Request $request, $obituaryId)
    {
        $contactDetails = $request->input('contact_details', []);
    

        $existingContacts = ContactDetail::where('object_id', 'obi' . $obituaryId)->get();
    

        foreach ($existingContacts as $existingContact) {
            $found = false;
    
            foreach ($contactDetails as $contact) {
         
                if (
                    isset($contact['id']) &&
                    $contact['id'] == $existingContact->id &&
                    isset($contact['contact_name']) &&
                    isset($contact['contact_number'])
                ) {
                 
                    $existingContact->update([
                        'contact_name' => $contact['contact_name'],
                        'contact_number' => $contact['contact_number'],
                    ]);
    
                    $found = true;
                    break;
                }
            }
    
     
            if (!$found) {
                $existingContact->delete();
            }
        }
    
     
        foreach ($contactDetails as $contact) {
          
            if (isset($contact['id'])) {
                continue;
            }
    
            ContactDetail::create([
                'contact_name' => $contact['contact_name'],
                'contact_number' => $contact['contact_number'],
                'object_id' => 'obi' . $obituaryId,
            ]);
        }
    }
    
    public function obituaryupload(Request $request, $inputName, $imageType)
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
        $obituary = Obituary::find($id);
      
    $obituary->contactDetails()->delete();



        $obituary->delete();
        return redirect()->route('obituaries.index')->withSuccess('Obituary is deleted successfully.');
    }
}