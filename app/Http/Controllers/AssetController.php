<?php
// app/Http/Controllers/AssetController.php
namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    private function checkAdminAuth()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    private function checkAssetPermission()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $admin = AdminUser::find(session('admin_id'));
        if (!$admin || (!$admin->isSuperAdmin() && $admin->role !== 'admin')) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }
        return null;
    }

    // Halaman manajemen assets
    public function index()
    {
        $authCheck = $this->checkAssetPermission();
        if ($authCheck) return $authCheck;

        $currentAdmin = AdminUser::find(session('admin_id'));
        $assets = Asset::orderBy('type')->orderBy('created_at', 'desc')->get();
        $availableTypes = Asset::getAvailableTypes();

        return view('admin.assets.index', compact('assets', 'currentAdmin', 'availableTypes'));
    }

    // Form upload asset baru
    public function create()
    {
        $authCheck = $this->checkAssetPermission();
        if ($authCheck) return $authCheck;

        $availableTypes = Asset::getAvailableTypes();
        return view('admin.assets.create', compact('availableTypes'));
    }

    // Simpan asset baru
    public function store(Request $request)
    {
        $authCheck = $this->checkAssetPermission();
        if ($authCheck) return $authCheck;

        $request->validate([
            'type' => 'required|in:' . implode(',', array_keys(Asset::getAvailableTypes())),
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload file
        $file = $request->file('file');
        $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('assets', $fileName, 'public');

        // Simpan asset baru (tidak perlu non-aktifkan yang lain karena bisa multiple)
        Asset::create([
            'type' => $request->type,
            'name' => $fileName,
            'file_path' => $filePath,
            'original_name' => $file->getClientOriginalName(),
            'is_active' => true,
            'description' => null,
        ]);

        return redirect()->route('admin.assets.index')
                        ->with('success', 'Asset berhasil diupload dan diaktifkan.');
    }

    // Toggle status aktif asset
    public function toggle($id)
    {
        $authCheck = $this->checkAssetPermission();
        if ($authCheck) return $authCheck;

        $asset = Asset::findOrFail($id);
        
        // Toggle status aktif
        $asset->update(['is_active' => !$asset->is_active]);
        
        $status = $asset->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.assets.index')
                        ->with('success', 'Asset berhasil ' . $status . '.');
    }

    // Hapus asset
    public function destroy($id)
    {
        $authCheck = $this->checkAssetPermission();
        if ($authCheck) return $authCheck;

        $asset = Asset::findOrFail($id);
        
        // Hapus file dari storage
        if (Storage::disk('public')->exists($asset->file_path)) {
            Storage::disk('public')->delete($asset->file_path);
        }

        $assetName = $asset->original_name;
        $asset->delete();

        return redirect()->route('admin.assets.index')
                        ->with('success', 'Asset ' . $assetName . ' berhasil dihapus.');
    }
}