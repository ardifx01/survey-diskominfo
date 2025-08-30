<?php
// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function checkAdminAuth()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    private function checkSuperAdminAuth()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // Gunakan session untuk cek role super admin
        if (session('admin_role') !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }
        return null;
    }

    // Halaman manajemen user
    public function index()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentAdmin = AdminUser::find(session('admin_id'));
        $users = AdminUser::orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('users', 'currentAdmin'));
    }

    // Form tambah user baru (hanya super admin)
    public function create()
    {
        $authCheck = $this->checkSuperAdminAuth();
        if ($authCheck) return $authCheck;

        return view('admin.users.create');
    }

    // Simpan user baru (hanya super admin)
    public function store(Request $request)
    {
        $authCheck = $this->checkSuperAdminAuth();
        if ($authCheck) return $authCheck;

        $request->validate([
            'username' => 'required|string|max:255|unique:admin_users',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,super_admin'
        ]);

        AdminUser::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User baru berhasil ditambahkan.');
    }

    // Form edit password
    public function editPassword($id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentAdmin = AdminUser::find(session('admin_id'));
        $user = AdminUser::findOrFail($id);

        // Cek permission: super admin bisa edit semua, admin hanya bisa edit diri sendiri
        if (session('admin_role') !== 'super_admin' && $user->id !== session('admin_id')) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Anda tidak memiliki akses untuk mengubah password user ini.');
        }

        return view('admin.users.edit-password', compact('user', 'currentAdmin'));
    }

    // Update password
    public function updatePassword(Request $request, $id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentAdmin = AdminUser::find(session('admin_id'));
        $user = AdminUser::findOrFail($id);

        // Cek permission: super admin bisa edit semua, admin hanya bisa edit diri sendiri
        if (session('admin_role') !== 'super_admin' && $user->id !== session('admin_id')) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Anda tidak memiliki akses untuk mengubah password user ini.');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update([
            'password' => $request->password,
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Password berhasil diubah.');
    }

    // Delete user (hanya super admin)
    public function destroy($id)
    {
        $authCheck = $this->checkSuperAdminAuth();
        if ($authCheck) return $authCheck;

        $currentAdmin = AdminUser::find(session('admin_id'));
        $user = AdminUser::findOrFail($id);

        // Tidak bisa hapus diri sendiri
        if ($user->id === session('admin_id')) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'User ' . $userName . ' berhasil dihapus.');
    }
}