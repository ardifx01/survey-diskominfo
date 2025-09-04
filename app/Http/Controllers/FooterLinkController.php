<?php
// app/Http/Controllers/FooterLinkController.php
namespace App\Http\Controllers;

use App\Models\FooterLink;
use Illuminate\Http\Request;

class FooterLinkController extends Controller
{
    private function checkAdminAuth()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    // Halaman utama manajemen footer links
    public function index()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $layananLinks = FooterLink::layanan()->ordered()->get();
        $informasiLinks = FooterLink::informasi()->ordered()->get();

        return view('admin.footer-links.index', compact('layananLinks', 'informasiLinks'));
    }

    // Form tambah link
    public function create()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        return view('admin.footer-links.create');
    }

    // Simpan link baru
    public function store(Request $request)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'category' => 'required|in:layanan,informasi'
        ]);

        $maxOrder = FooterLink::where('category', $request->category)->max('order_index') ?? 0;

        FooterLink::create([
            'title' => $request->title,
            'url' => $request->url,
            'category' => $request->category,
            'order_index' => $maxOrder + 1,
            'is_active' => true
        ]);

        return redirect()->route('admin.footer-links.index')
                        ->with('success', 'Link footer berhasil ditambahkan.');
    }

    // Form edit link
    public function edit($id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $link = FooterLink::findOrFail($id);
        return view('admin.footer-links.edit', compact('link'));
    }

    // Update link
    public function update(Request $request, $id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $link = FooterLink::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'category' => 'required|in:layanan,informasi'
        ]);

        // Jika kategori berubah, update order_index
        if ($link->category !== $request->category) {
            $maxOrder = FooterLink::where('category', $request->category)->max('order_index') ?? 0;
            $link->update([
                'title' => $request->title,
                'url' => $request->url,
                'category' => $request->category,
                'order_index' => $maxOrder + 1
            ]);
        } else {
            $link->update([
                'title' => $request->title,
                'url' => $request->url,
                'category' => $request->category
            ]);
        }

        return redirect()->route('admin.footer-links.index')
                        ->with('success', 'Link footer berhasil diperbarui.');
    }

    // Toggle status aktif/non-aktif
    public function toggle($id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $link = FooterLink::findOrFail($id);
        $link->update(['is_active' => !$link->is_active]);

        $status = $link->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.footer-links.index')
                        ->with('success', "Link '{$link->title}' berhasil $status.");
    }

    // Hapus link
    public function destroy($id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $link = FooterLink::findOrFail($id);
        $link->delete();

        return redirect()->route('admin.footer-links.index')
                        ->with('success', "Link '{$link->title}' berhasil dihapus.");
    }

    // Update urutan link
    public function updateOrder(Request $request)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $request->validate([
            'category' => 'required|in:layanan,informasi',
            'links' => 'required|array',
            'links.*' => 'required|integer|exists:footer_links,id'
        ]);

        foreach ($request->links as $index => $linkId) {
            FooterLink::where('id', $linkId)
                    ->where('category', $request->category)
                    ->update(['order_index' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}