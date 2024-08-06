<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Clear uploaded media files
        $folderPath = public_path('media');
        File::cleanDirectory($folderPath);

        $folderPath = public_path('storage');
        File::cleanDirectory($folderPath);

        //Copy original CSS file from Duplicate CSS
        $sourcePath = public_path('assets/css/copy.css');
        $destinationPath = public_path('assets/css/style.css');

        try {
            File::copy($sourcePath, $destinationPath);
            $this->command->info('CSS file copied successfully!');
        } catch (\Exception $e) {
            $this->command->error('Error copying CSS file: ' . $e->getMessage());
        }

        // Replace color value in CSS file
        $cssFilePath = public_path('assets/css/style.css');
        $cssContent = file_get_contents($cssFilePath);

        // Replace the placeholder with the retrieved color code
        $cssContent = str_replace('{{main}}', '#BD1701' , $cssContent);
        $cssContent = str_replace('{{second}}', '#ED523D' , $cssContent);

        // Save the updated CSS content
        file_put_contents($cssFilePath, $cssContent);

        // Save app settings contents
        Setting::create([
            'company_name' => 'Online Beauty Bar',
            'email' => 'onlinebeautybarpvtltd@gmail.com',
            'mobile' => '076 060 7096',
            'logo' => 'logos/658fhMo19U69PTgFQ50UvdDx4tirydwHFT9zS4sn.png',
            'favicon' => 'favicon',
            'login_img' => 'login_imgs/0pJwzb32FY0Ier2Lz7FViHRswaGSUS917o17oFJ9.png',
            'profile' => 'profile' ,
            'desc' =>'We are a very known company in the professional skincare industry with many years of experience and service, selling at the biggest professional skincare trade shows in the world',
            'tags'=>'Online beauty bar, srilanka, srilankan creams',
            'solution' => 'Extreme Coders 🚀'
        ]);
    }
}
