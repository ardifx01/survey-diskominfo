<?php
// app/Http/Controllers/ContactInfoController.php
namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    private function checkAdminAuth()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    // Halaman edit informasi kontak
    public function edit()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $contact = ContactInfo::getCurrent();
        return view('admin.contact-info.edit', compact('contact'));
    }

    // Update informasi kontak
    public function update(Request $request)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $request->validate([
            'department_name' => 'required|string|max:255',
            'regency_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'province' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        ContactInfo::updateInfo($request->only([
            'department_name',
            'regency_name', 
            'address',
            'province',
            'whatsapp',
            'email'
        ]));

        return redirect()->route('admin.contact-info.edit')
                        ->with('success', 'Informasi kontak berhasil diperbarui.');
    }
}