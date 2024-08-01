<?php
namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Rememberence;
use App\Models\ContactDetail;
use App\Http\Requests\StoreRememberenceRequest;
use App\Http\Requests\UpdateRememberenceRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Mews\Purifier\Facades\Purifier;

class RememberenceController extends Controller
{
    /**
     * Instantiate a new RememberenceController instance.
     */
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:create-rememberence|edit-rememberence|delete-rememberence', ['only' => ['index','show']]);
       $this->middleware('permission:create-rememberence', ['only' => ['create','store']]);
       $this->middleware('permission:edit-rememberence', ['only' => ['edit','update']]);
       $this->middleware('permission:delete-rememberence', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $rememberences = Rememberence::with('contactDetails')->latest()->paginate(10);
        return view('rememberences.index', ['rememberences' => $rememberences]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('rememberences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRememberenceRequest $request): RedirectResponse
{

    $normalImageUrl = $this->rememberenceupload($request, 'upload', 'normal');
    $frameImageUrl = $this->rememberenceupload($request, 'frame_upload', 'frame');
   

    $rememberence = new Rememberence($request->all());

    if ($normalImageUrl) {
        $rememberence->normal_image_url = $normalImageUrl;
    }

    if ($frameImageUrl) {
        $rememberence->frame_image_url = $frameImageUrl;
    }

    $rememberence->save();
    $rememberence->contactId = 'rem' . $rememberence->id;
    $rememberence->save();
    $this->saveContactDetails($request, $rememberence->id);
    return redirect()->route('rememberences.index')
        ->withSuccess('New rememberence is added successfully.');
}
private function saveContactDetails(Request $request, $rememberenceId)
{
   
    $contactDetails = $request->input('contact_details', []);
    foreach ($contactDetails as $contact) {
        ContactDetail::create([
            'contact_name' => $contact['contact_name'],
            'contact_number' => $contact['contact_number'],
            'object_id' => 'rem' . $rememberenceId,
        ]);
    }
}
public function rememberenceupload(Request $request, $inputName, $imageType)
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
     * Display the specified resource.
     */
    public function show($rememberence): View
    {
        $rememberence = Rememberence::with('contactDetails')->find($rememberence);
        return view('rememberences.show_modal', ['rememberence' => $rememberence]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($rememberence): View
    {
        $rememberence = Rememberence::find($rememberence);

        return view('rememberences.edit', [
            'rememberence' => $rememberence
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRememberenceRequest $request, Rememberence $rememberence): RedirectResponse
    {
        $normalImageUrl = $this->rememberenceupload($request, 'upload', 'normal');
        $frameImageUrl = $this->rememberenceupload($request, 'frame_upload', 'frame');
        \Log::info([$normalImageUrl,$frameImageUrl]);
        if ($normalImageUrl) {
            $rememberence->normal_image_url = $normalImageUrl;
        }
    
        if ($frameImageUrl) {
            $rememberence->frame_image_url = $frameImageUrl;
        }
        $rememberence->update($request->all());
        $rememberence->save();
        $this->updateContactDetails($request, $rememberence->id);
        return redirect()->back()
                ->withSuccess('Rememberence is updated successfully.');
    }
    private function updateContactDetails(Request $request, $rememberenceId)
    {
        $contactDetails = $request->input('contact_details', []);
    

        $existingContacts = ContactDetail::where('object_id', 'rem' . $rememberenceId)->get();


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
                'object_id' => 'rem' . $rememberenceId,
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $rememberence = Rememberence::find($id); 
        $rememberence->contactDetails()->delete();
        $rememberence->delete();
        return redirect()->route('rememberences.index')->withSuccess('Rememberence is deleted successfully.');
    }
}