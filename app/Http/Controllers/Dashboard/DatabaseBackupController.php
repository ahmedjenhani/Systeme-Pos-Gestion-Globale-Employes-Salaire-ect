<?php
/*

namespace App\Http\Controllers\Dashboard;

use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class DatabaseBackupController extends Controller
{    public function index()
    {
        return view('database.index', [
            'files' => File::allFiles(storage_path('/app/POS'))
        ]);
    }

    // Backup database is not working, and you need to enter manually in terminal with command php artisan backup:run.
    public function create(){
        \Artisan::call('backup:run');

        return Redirect::route('backup.index')->with('success', 'Database Backup Successfully!');
    }

    public function download(String $getFileName)
    {
        $path = storage_path('app\POS/' . $getFileName);

        return response()->download($path);
    }

    public function delete(String $getFileName)
    {
        Storage::delete('POS/' . $getFileName);

        return Redirect::route('backup.index')->with('success', 'Database Deleted Successfully!');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupController extends Controller
{
    public function index()
    {
        return view('database.index', [
            'files' => File::allFiles(storage_path('/app/POS'))
        ]);
    }

    public function create()
    {
        try {
            // Call the backup:run Artisan command
            $exitCode = Artisan::call('backup:run');

            // Check if the command was successful
            if ($exitCode === 0) {
                return Redirect::route('backup.index')->with('success', 'Database Backup Successfully!');
            } else {
                return Redirect::route('backup.index')->with('error', 'Database Backup Failed with exit code: ' . $exitCode);
            }
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Database backup failed: ' . $e->getMessage());

            // Return an error message
            return Redirect::route('backup.index')->with('error', 'Database Backup Failed: ' . $e->getMessage());
        }
    }

    public function download(String $getFileName)
    {
        $path = storage_path('app/POS/' . $getFileName);

        return response()->download($path);
    }

    public function delete(String $getFileName)
    {
        Storage::delete('POS/' . $getFileName);

        return Redirect::route('backup.index')->with('success', 'Database Deleted Successfully!');
    }
}

*/
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
        return view('database.index', [
            'files' => File::allFiles(storage_path('/app/POS'))
        ]);
    }

    public function create()
    {
        try {
            // Call the backup:run Artisan command
            $exitCode = Artisan::call('backup:run');

            // Check if the command was successful
            if ($exitCode === 0) {
                return Redirect::route('backup.index')->with('success', 'Database Backup Successfully!');
            } else {
                return Redirect::route('backup.index')->with('error', 'Database Backup Failed with exit code: ' . $exitCode);
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Database backup failed: ' . $e->getMessage());

            // Return an error message
            return Redirect::route('backup.index')->with('error', 'Database Backup Failed: ' . $e->getMessage());
        }
    }

    public function download(String $getFileName)
    {
        $path = storage_path('app/POS/' . $getFileName);

        return response()->download($path);
    }

    public function delete(String $getFileName)
    {
        Storage::delete('POS/' . $getFileName);

        return Redirect::route('backup.index')->with('success', 'Database Deleted Successfully!');
    }
}