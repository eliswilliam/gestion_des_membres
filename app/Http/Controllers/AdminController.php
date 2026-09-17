<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Cotisation;
use App\Models\Depense;
use App\Models\Caisse;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
{

 // Statistiques générales
        $totalMembres = Member::count();
        $totalCotisations = Cotisation::count();
        $montantTotal = Cotisation::sum('montant');
        $nouveauxMembres = Member::whereMonth('created_at', now()->month)->count();
        
        // Graphique des cotisations par mois
        $selectedYear = $request->get('year', date('Y'));
        $availableYears = Cotisation::select('annee as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }
        
        // Données des cotisations par mois
        $cotisationsParMois = [];
        for ($mois = 1; $mois <= 12; $mois++) {
            $montant = Cotisation::where('annee', $selectedYear)
                ->where('mois', $mois)
                ->sum('montant');
            $cotisationsParMois[$mois] = $montant;
        }
        
        // Trouver le meilleur mois
        $meilleurMois = [
            'nom' => '',
            'montant' => 0
        ];
        $moisNoms = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        
        foreach ($cotisationsParMois as $mois => $montant) {
            if ($montant > $meilleurMois['montant']) {
                $meilleurMois['nom'] = $moisNoms[$mois - 1];
                $meilleurMois['montant'] = $montant;
            }
        }
        
        // Activités récentes
        $recentActivities = $this->getRecentActivities();
        
        return view('admin.dashboard', compact(
            'totalMembres',
            'totalCotisations',
            'montantTotal',
            'nouveauxMembres',
            'cotisationsParMois',
            'selectedYear',
            'availableYears',
            'meilleurMois',
            'recentActivities'
        ));
    }
    
    private function getRecentActivities($limit = 5)
    {
        $activities = [];
        
        // Derniers membres ajoutés
        $recentMembers = Member::orderBy('created_at', 'desc')->limit(3)->get();
        foreach ($recentMembers as $member) {
            $activities[] = [
                'text' => "Nouveau membre : {$member->nom} {$member->prenoms}",
                'time' => $member->created_at->diffForHumans(),
                'color' => 'var(--green)'
            ];
        }
        
        // Dernières cotisations
        $recentCotisations = Cotisation::with('member')->orderBy('created_at', 'desc')->limit(3)->get();
        foreach ($recentCotisations as $cotisation) {
            $activities[] = [
                'text' => "Cotisation de {$cotisation->member->nom} {$cotisation->member->prenoms} : " . number_format($cotisation->montant, 0, ',', ' ') . " FCFA",
                'time' => $cotisation->created_at->diffForHumans(),
                'color' => 'var(--blue)'
            ];
        }
        
        // Dernières dépenses
        $recentDepenses = Depense::with('member')->orderBy('created_at', 'desc')->limit(3)->get();
        foreach ($recentDepenses as $depense) {
            $activities[] = [
                'text' => "Dépense pour {$depense->member->nom} {$depense->member->prenoms} : " . number_format($depense->montant, 0, ',', ' ') . " FCFA",
                'time' => $depense->created_at->diffForHumans(),
                'color' => 'var(--red)'
            ];
        }
        
        // Trier par date décroissante et limiter
        $activities = collect($activities)->sortByDesc('time')->take($limit)->values()->toArray();
        
        return $activities;
    return view('admin.dashboard');
}

}
