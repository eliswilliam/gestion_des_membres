<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembersCheckRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all(); // récupère tous les membres
        return view('members.index', compact('members'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas ajouter de membres.');
        }
        return view('members.create');
    }

    public function store(MembersCheckRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas ajouter de membres.');
        }

        $data = $request->except('photo');

        
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storePhoto($request->file('photo'));
        }

        Member::create($data);

        return redirect()->route('members.index')
            ->with('success', 'Membre ajouté avec succès !');
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('members.show', compact('member'));
    }


    public function edit($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas modifier les membres.');
        }
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas modifier les membres.');
        }

        $member = Member::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $this->deletePhoto($member->photo);
            $data['photo'] = $this->storePhoto($request->file('photo'));
        }
        $member->update($data);
        return redirect()->route('members.show', $member->id)->with('success', 'Membre mis à jour.');
    }

    public function destroy($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('members.index')->with('error', 'Les admins ne peuvent pas supprimer les membres.');
        }

        $member = Member::findOrFail($id);

        $this->deletePhoto($member->photo);

        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Membre supprimé avec succès !');
    }

    private function storePhoto(\Illuminate\Http\UploadedFile $file): string
    {
        // Encoder l'image directement en Base64
        $extension = $file->getClientOriginalExtension() ?: 'jpeg';
        $data = base64_encode(file_get_contents($file->getRealPath()));
        return "data:image/{$extension};base64,{$data}";
    }

    private function deletePhoto(?string $path): void
    {
        if (!$path) {
            return;
        }

        // Plus rien à supprimer physiquement si l'image est stockée en Base64 dans la base de données.
        // Si c'est un ancien chemin de fichier physique (pour compatibilité) :
        if (!str_starts_with($path, 'data:')) {
            $disk = config('filesystems.default');
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        }
    }
}
