@extends('layouts.app')

@section('content')
<div class="cotisations-container">
    <!-- En-tête avec statistiques -->
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
                Gestion des cotisations
            </h1>
            {{-- <p class="page-subtitle">{{ $cotisations->total() }} cotisations enregistrées</p> --}}
        </div>
        
        @if(!auth()->user()->isAdmin())
            <a href="{{ route('cotisations.create') }}" class="btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Nouvelle cotisation
            </a>
        @endif
    </div>

    {{-- <!-- Stats rapides -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #e8f5e9; color: var(--green);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total cotisations</h3>
                <p>{{ $cotisations->total() }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: #fff3e0; color: #f59e0b;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M17 5H9.5M17 12h-5M17 19h-5"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Montant total</h3>
                <p>{{ number_format($cotisations->sum('montant'), 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: #e6f7ff; color: #0ea5e9;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Ce mois</h3>
                <p>{{ $cotisations->where('mois', date('n'))->where('annee', date('Y'))->count() }}</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2; color: #ef4444;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M5.8 15.2a8 8 0 0 1 12.4 0"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Moyenne/mois</h3>
                <p>{{ number_format($cotisations->avg('montant') ?? 0, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
    </div> --}}

    <!-- Filtres -->
    <div class="filters-bar">
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" placeholder="Rechercher un membre..." id="searchInput">
        </div>
        
        <div class="filter-group">
            <select class="filter-select" id="yearFilter">
                <option value="">Toutes années</option>
                @foreach(range(date('Y'), date('Y')-3) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            
            <select class="filter-select" id="monthFilter">
                <option value="">Tous mois</option>
                @php
                    $moisNoms = [
                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                    ];
                @endphp
                @foreach($moisNoms as $num => $nom)
                    <option value="{{ $num }}">{{ $nom }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Carte du tableau -->
    <div class="table-card">
        <div class="table-header">
            <h3>Liste des cotisations</h3>
            <span class="badge">{{ $cotisations->count() }} affichées</span>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Membre</th>
                        <th>Période</th>
                        <th>Montant</th>
                        <th>Date paiement</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cotisations as $cotisation)
                        @php
                            $estEnRetard = $cotisation->date_paiement < now()->subMonth();
                            $moisNoms = [
                                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                            ];
                        @endphp
                        <tr class="cotisation-row" data-member="{{ strtolower($cotisation->member->nom . ' ' . $cotisation->member->prenoms) }}">
                            <td>
                                <div class="member-info">
                                    @if($cotisation->member->photo)
                                        <img src="{{ $cotisation->member->photo_url }}" 
                                             alt="photo" class="member-avatar">
                                    @else
                                        <div class="member-avatar-placeholder">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="member-details">
                                        <span class="member-name">{{ $cotisation->member->nom }} {{ $cotisation->member->prenoms }}</span>
                                        <!-- <span class="member-id">#{{ $cotisation->member_id }}</span> -->
                                        <span class="member-number">N° {{ $cotisation->member->numero_membre }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="period-badge">
                                    <span class="month">{{ $moisNoms[$cotisation->mois] ?? $cotisation->mois }}</span>
                                    <span class="year">{{ $cotisation->annee }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="montant-badge">{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td>
                                <span class="date-badge">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($cotisation->date_paiement)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statutClass = $estEnRetard ? 'retard' : 'ok';
                                    $statutText = $estEnRetard ? 'En retard' : 'À jour';
                                @endphp
                                <span class="statut-badge statut-{{ $statutClass }}">
                                    {{ $statutText }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if(!auth()->user()->isAdmin())
                                        <a href="{{ route('cotisations.edit', $cotisation->id) }}" 
                                           class="action-btn edit" title="Modifier">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('cotisations.destroy', $cotisation->id) }}" 
                                              method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" 
                                                    onclick="return confirm('Supprimer cette cotisation ? Cette action est irréversible.')"
                                                    title="Supprimer">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-content">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                        <line x1="2" y1="10" x2="22" y2="10"></line>
                                    </svg>
                                    <h3>Aucune cotisation trouvée</h3>
                                    <p>Commencez par ajouter votre première cotisation</p>
                                    @if(!auth()->user()->isAdmin())
                                        <a href="{{ route('cotisations.create') }}" class="btn-primary">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            Nouvelle cotisation
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($cotisations, 'links'))
            <div class="pagination-container">
                {{ $cotisations->links() }}
            </div>
        @endif
    </div>
</div>

<style>
/* ===== VARIABLES ===== */
:root {
    --green: #168a4a;
    --green-light: #1e9b54;
    --green-dark: #0f6a38;
    --green-soft: #e8f5e9;
    --blue: #2563eb;
    --yellow: #f59e0b;
    --yellow-soft: #fff3e0;
    --red: #ef4444;
    --red-soft: #fee2e2;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --white: #ffffff;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --shadow-green: 0 4px 6px rgba(22, 138, 74, 0.2);
}

/* ===== CONTAINER PRINCIPAL ===== */
.cotisations-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

/* ===== HEADER ===== */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-left {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.page-title {
    font-size: 2rem;
    font-weight: 600;
    color: var(--gray-800);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
}

.page-title .icon {
    width: 2rem;
    height: 2rem;
    color: var(--green);
}

.page-subtitle {
    color: var(--gray-500);
    font-size: 0.95rem;
    margin: 0;
    margin-left: 2.75rem;
}

/* ===== STATS CARDS ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.stat-icon {
    width: 3rem;
    height: 3rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon svg {
    width: 1.5rem;
    height: 1.5rem;
}

.stat-content h3 {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0 0 0.25rem 0;
    font-weight: 500;
}

.stat-content p {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

/* ===== BOUTON PRINCIPAL ===== */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    background: var(--green);
    color: white;
    border: none;
    border-radius: 0.75rem;
    font-size: 0.95rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: var(--shadow-green);
}

.btn-primary:hover {
    background: var(--green-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-primary svg {
    width: 1.25rem;
    height: 1.25rem;
}

/* ===== MESSAGE SUCCÈS ===== */
.alert-success {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    background: var(--green-soft);
    color: var(--green-dark);
    border-radius: 1rem;
    margin-bottom: 2rem;
    border: 1px solid var(--green);
    font-weight: 500;
}

.alert-success svg {
    width: 1.25rem;
    height: 1.25rem;
}

/* ===== FILTRES ===== */
.filters-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.search-box {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    border: 2px solid var(--gray-200);
    flex: 1;
    min-width: 250px;
    transition: all 0.2s ease;
}

.search-box:focus-within {
    border-color: var(--green);
    box-shadow: 0 0 0 3px rgba(22, 138, 74, 0.1);
}

.search-box svg {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--gray-400);
}

.search-box input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 0.95rem;
    color: var(--gray-800);
    background: transparent;
}

.search-box input::placeholder {
    color: var(--gray-400);
}

.filter-group {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-select {
    padding: 0.625rem 2rem 0.625rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    font-size: 0.9rem;
    color: var(--gray-700);
    background: white;
    cursor: pointer;
    outline: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 1rem;
}

.filter-select:focus {
    border-color: var(--green);
    box-shadow: 0 0 0 3px rgba(22, 138, 74, 0.1);
}

/* ===== TABLE CARD ===== */
.table-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.table-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.table-header .badge {
    padding: 0.25rem 0.75rem;
    background: var(--gray-100);
    color: var(--gray-600);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
}

/* ===== TABLE ===== */
.table-responsive {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table thead th {
    text-align: left;
    padding: 1rem 1.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
}

.modern-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--gray-200);
}

.modern-table tbody tr:last-child {
    border-bottom: none;
}

.modern-table tbody tr:hover {
    background: var(--gray-50);
}

.modern-table td {
    padding: 1rem 1.5rem;
    color: var(--gray-700);
}

/* ===== MEMBER INFO ===== */
.member-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.member-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--green);
}

.member-avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
}

.member-avatar-placeholder svg {
    width: 20px;
    height: 20px;
}

.member-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.member-name {
    font-weight: 500;
    color: var(--gray-800);
}

.member-id {
    font-size: 0.75rem;
    color: var(--gray-500);
}

/* ===== BADGES ===== */
.period-badge {
    display: inline-flex;
    flex-direction: column;
    background: var(--gray-100);
    padding: 0.5rem 0.75rem;
    border-radius: 0.75rem;
    text-align: center;
}

.period-badge .month {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--gray-700);
}

.period-badge .year {
    font-size: 0.7rem;
    color: var(--gray-500);
}

.montant-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: var(--green-soft);
    color: var(--green-dark);
    border-radius: 2rem;
    font-weight: 600;
}

.date-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--gray-100);
    border-radius: 2rem;
    font-size: 0.9rem;
}

.date-badge svg {
    width: 1rem;
    height: 1rem;
    color: var(--gray-500);
}

.statut-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.statut-ok {
    background: var(--green-soft);
    color: var(--green-dark);
}

.statut-retard {
    background: var(--red-soft);
    color: var(--red);
}

/* ===== ACTION BUTTONS ===== */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.action-btn svg {
    width: 18px;
    height: 18px;
}

.action-btn.edit {
    background: var(--yellow-soft);
    color: var(--yellow);
}

.action-btn.edit:hover {
    background: var(--yellow);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
}

.action-btn.delete {
    background: var(--red-soft);
    color: var(--red);
}

.action-btn.delete:hover {
    background: var(--red);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

.delete-form {
    display: inline;
}

/* ===== EMPTY STATE ===== */
.empty-state td {
    padding: 4rem 2rem;
}

.empty-content {
    text-align: center;
    max-width: 400px;
    margin: 0 auto;
}

.empty-content svg {
    width: 80px;
    height: 80px;
    color: var(--gray-300);
    margin-bottom: 1.5rem;
}

.empty-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.empty-content p {
    color: var(--gray-500);
    margin-bottom: 1.5rem;
}

/* ===== PAGINATION ===== */
.pagination-container {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--gray-200);
    display: flex;
    justify-content: center;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .cotisations-container {
        padding: 1rem;
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .page-subtitle {
        margin-left: 0;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .filters-bar {
        flex-direction: column;
    }

    .search-box {
        width: 100%;
    }

    .filter-group {
        width: 100%;
    }

    .filter-select {
        flex: 1;
    }

    .modern-table thead {
        display: none;
    }

    .modern-table tbody tr {
        display: block;
        padding: 1rem;
        border: 1px solid var(--gray-200);
        border-radius: 1rem;
        margin-bottom: 1rem;
    }

    .modern-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border: none;
    }

    .modern-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--gray-500);
        margin-right: 1rem;
    }

    .member-info {
        justify-content: flex-start;
    }

    .action-buttons {
        justify-content: flex-end;
    }
}
</style>

<script>
// Recherche en temps réel
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.cotisation-row');
    
    rows.forEach(row => {
        const memberName = row.getAttribute('data-member') || '';
        if (memberName.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filtres
document.getElementById('yearFilter')?.addEventListener('change', filterTable);
document.getElementById('monthFilter')?.addEventListener('change', filterTable);

function filterTable() {
    const yearFilter = document.getElementById('yearFilter').value;
    const monthFilter = document.getElementById('monthFilter').value;
    const rows = document.querySelectorAll('.cotisation-row');
    
    rows.forEach(row => {
        const year = row.querySelector('.year')?.textContent;
        const month = row.querySelector('.month')?.textContent;
        
        let show = true;
        
        if (yearFilter && year !== yearFilter) show = false;
        if (monthFilter) {
            const monthNum = Object.keys({
                1: 'Janvier', 2: 'Février', 3: 'Mars', 4: 'Avril',
                5: 'Mai', 6: 'Juin', 7: 'Juillet', 8: 'Août',
                9: 'Septembre', 10: 'Octobre', 11: 'Novembre', 12: 'Décembre'
            }).find(key => {
                return ['Janvier','Février','Mars','Avril','Mai','Juin',
                       'Juillet','Août','Septembre','Octobre','Novembre','Décembre'][key-1] === month;
            });
            
            if (monthNum != monthFilter) show = false;
        }
        
        row.style.display = show ? '' : 'none';
    });
}

// Confirmation de suppression
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('Voulez-vous vraiment supprimer cette cotisation ? Cette action est irréversible.')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection