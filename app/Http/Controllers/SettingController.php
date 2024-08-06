<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting; // Assuming 'Setting' is your model name
use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:create-setting|edit-setting|delete-setting', ['only' => ['index','show']]);
       $this->middleware('permission:create-setting', ['only' => ['create','store']]);
       $this->middleware('permission:edit-setting', ['only' => ['edit','update']]);
       $this->middleware('permission:delete-setting', ['only' => ['destroy']]);
    }


    public function index()
    {
        $setting = Setting::findOrFail(1);
        return view('settings.index', compact('setting'));
    }

    public function create()
    {
        return view('settings.create');
    }

    public function store(Request $request)
    {
        Setting::create($request->all());
        return redirect()->route('settings.index');
    }

    public function show($id)
    {
        $setting = Setting::findOrFail($id);
        return view('settings.show', compact('setting'));
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('settings.edit', compact('setting'));
    }

    public function update(UpdateSettingRequest $request, $id)
    {
        $setting = Setting::findOrFail($id);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $setting->logo = $logoPath;
        }

        // Handle favicon upload (similar logic for other fields)
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            $setting->favicon = $faviconPath;
        }

        if ($request->hasFile('login_img')) {
            $login_imgPath = $request->file('login_img')->store('login_imgs', 'public');
            $setting->login_img = $login_imgPath;
        }

        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('profiles', 'public');
            $setting->profile = $profilePath;
        }

        $cssFilePath = public_path('assets/css/style.css');
        $cssContent = file_get_contents($cssFilePath);

        // Replace the placeholder with the retrieved color code
        $cssContent = str_replace($request->old_color, $request->main_color , $cssContent);
        $cssContent = str_replace($request->second_old_color, $request->second_color , $cssContent);

        // Save the updated CSS content
        file_put_contents($cssFilePath, $cssContent);
        // Update other fields

        $setting->fill($request->except(['logo', 'favicon', 'login_img', 'profile']));
        $setting->save();

        return redirect()->route('settings.index')->withSuccess('Setting is updated successfully.');
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();
        return redirect()->route('settings.index');
    }

    public function showAPIForm()
    {
        // Get current settings from the .env file
        $settings = [
            'woocommerce_url' => env('WOOCOMMERCE_URL'),
            'woocommerce_consumer_key' => env('WOOCOMMERCE_CONSUMER_KEY'),
            'woocommerce_consumer_secret' => env('WOOCOMMERCE_CONSUMER_SECRET'),
            'api_key' => env('API_KEY'),
            'fde_client_id' => env('FDE_CLIENT_ID'),
        ];

        return view('settings.api', compact('settings'));
    }

    public function updateAPIs(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'woocommerce_url' => 'required|url',
            'woocommerce_consumer_key' => 'required|string',
            'woocommerce_consumer_secret' => 'required|string',
            'api_key' => 'required|string',
            'fde_client_id' => 'required|string',
        ]);

        // Update the .env file
        $settings = [
            'WOOCOMMERCE_URL' => $request->input('woocommerce_url'),
            'WOOCOMMERCE_CONSUMER_KEY' => $request->input('woocommerce_consumer_key'),
            'WOOCOMMERCE_CONSUMER_SECRET' => $request->input('woocommerce_consumer_secret'),
            'API_KEY' => $request->input('api_key'),
            'FDE_CLIENT_ID' => $request->input('fde_client_id'),
        ];

        $this->updateEnv($settings);

        return redirect('/api-settings')->with('success', 'Settings updated successfully.');
    }

    protected function updateEnv(array $settings)
    {
        $path = base_path('.env');
        $envContent = file_get_contents($path);

        foreach ($settings as $key => $value) {
            $envContent = preg_replace('/^' . $key . '=.*/m', $key . '=' . $value, $envContent);
        }

        file_put_contents($path, $envContent);

        // Clear config cache
        Artisan::call('config:cache');
    }
}


?>
