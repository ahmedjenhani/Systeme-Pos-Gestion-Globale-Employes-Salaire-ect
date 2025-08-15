<?php

namespace App\Http\Controllers\Dashboard;

use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class DatabaseBackupController extends Controller
{
    public function index()
    {
        $backupDirectory = storage_path('app/backup');
        
        
        if (!File::isDirectory($backupDirectory)) {
            File::makeDirectory($backupDirectory, 0777, true, true);
        }

        return view('database.index', [
            'files' => File::allFiles($backupDirectory)
        ]);
    }

    public function create()
    {
        try {
            
            $backupDirectory = storage_path('app/backup');

            
            if (!File::isDirectory($backupDirectory)) {
                File::makeDirectory($backupDirectory, 0777, true, true);
            }

            
            $exitCode = Artisan::call('backup:run', [
                '--only-db' => true,
                '--disable-notifications' => true,
                '--verbose' => true
            ]);
            
            $output = Artisan::output();

            
            if ($exitCode === 0) {
                return Redirect::route('backup.index')->with('success', 'Sauvegarde de la base de données réussie!');
            } else {
                Log::error('Backup command failed with output: ' . $output);
                return Redirect::route('backup.index')->with('error', "Échec de la sauvegarde. Code: $exitCode | Détails: $output");
            }
        } catch (\Exception $e) {
            
            Log::error('Database backup failed: ' . $e->getMessage());

            
            return Redirect::route('backup.index')->with('error', 'Échec de la sauvegarde de la base de données : ' . $e->getMessage());
        }
    }

    public function download(String $getFileName)
    {
        
        $path = storage_path('app/backup/' . $getFileName);

        return response()->download($path);
    }

    public function delete(String $getFileName)
    {
        
        Storage::delete('backup/' . $getFileName);

        return Redirect::route('backup.index')->with('success', 'Sauvegarde de la base de données supprimée avec succès!');
    }
}
