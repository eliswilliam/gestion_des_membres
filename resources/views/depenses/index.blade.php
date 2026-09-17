{{-- resources/views/depenses/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="depenses-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
                Gestion des dépenses
            </h1>
            <p class="page-subtitle">Suivez les dépenses effectuées depuis la caisse globale</p>
        </div>
        
        @if(!auth()->user()->isAdmin())
            <a href="{{ route('depenses.create') }}" class="btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Nouvelle dépense
            </a>
        @endif
    </div>

    <!-- Cartes statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(31, 79, 216, 0.1); color: var(--blue);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total cotisations</h3>
                <p class="stat-number">{{ number_format($stats['total_cotisations'], 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(31, 168, 91, 0.1); color: var(--green);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total dépenses</h3>
                <p class="stat-number">{{ number_format($stats['total_depenses'], 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(242, 194, 0, 0.1); color: var(--yellow);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M17 5H9.5M17 12h-5M17 19h-5"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Solde disponible</h3>
                <p class="stat-number {{ $stats['solde_global'] < 0 ? 'text-danger' : '' }}">
                    {{ number_format($stats['solde_global'], 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(214, 40, 40, 0.1); color: var(--red);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 12H4M12 4v16"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Nombre dépenses</h3>
                <p class="stat-number">{{ $depenses->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-bar">
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" placeholder="Rechercher une dépense..." id="searchInput">
        </div>
        
        <div class="filter-group">
            <select name="type_evenement" id="typeFilter" class="filter-select">
                <option value="">Tous les types</option>
                @foreach($typesEvenements as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            
            <select name="member_id" id="memberFilter" class="filter-select">
                <option value="">Tous les membres</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->nom }} {{ $member->prenoms }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Tableau -->
    <div class="table-card">
        <div class="table-header">
            <h3>Liste des dépenses</h3>
            <span class="badge">{{ $depenses->total() }} enregistrées</span>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Membre</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th>Enregistré par</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($depenses as $depense)
                        <tr>
                            <td data-label="Réf.">
                                <span class="ref-badge">{{ $depense->reference }}</span>
                            </td>
                            <td data-label="Membre">
                                <div class="member-info-cell">
                                    @if($depense->member->photo)
                                        <img src="{{ $depense->member->photo_url }}" class="member-avatar-mini">
                                    @else
                                        <div class="member-avatar-placeholder-mini">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="member-name">{{ $depense->member->nom }} {{ $depense->member->prenoms }}</span>
                                </div>
                            </td>
                            <td data-label="Type">
                                <span class="type-badge type-{{ $depense->type_evenement }}">
                                    {{ $depense->type_evenement_label }}
                                </span>
                            </td>
                            <td data-label="Montant">
                                <span class="montant-badge">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td data-label="Date">
                                <div class="date-info-cell">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($depense->date_depense)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td data-label="Créateur">
                                <span class="user-badge">{{ $depense->createur->name }}</span>
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <a href="{{ route('depenses.show', $depense) }}" class="action-btn view" title="Voir">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7z"></path>
                                        </svg>
                                    </a>
                                    @if(!auth()->user()->isAdmin())
                                        <a href="{{ route('depenses.edit', $depense) }}" class="action-btn edit" title="Modifier">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                            </svg>
                                        </a>
                                        <form action="{{ route('depenses.destroy', $depense) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" onclick="return confirm('Supprimer cette dépense ?')" title="Supprimer">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                            <td colspan="7" class="empty-state">
                                <div class="empty-content">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                    </svg>
                                    <h3>Aucune dépense enregistrée</h3>
                                    <p>Commencez par enregistrer votre première dépense</p>
                                    @if(!auth()->user()->isAdmin())
                                        <a href="{{ route('depenses.create') }}" class="btn-primary">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            Nouvelle dépense
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($depenses, 'links'))
            <div class="pagination-container">
                {{ $depenses->links() }}
            </div>
        @endif
    </div>

    <!-- Graphique -->
    <div class="chart-card">
        <div class="card-header">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12v-2a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v2"></path>
                    <circle cx="12" cy="16" r="5"></circle>
                </svg>
                Répartition des dépenses par type
            </h2>
        </div>
        <div class="chart-container">
            @php $colors = ['#1f4fd8', '#1fa85b', '#f2c200', '#d62828', '#8b5cf6', '#ec489a', '#14b8a6', '#f97316']; $i = 0; @endphp
            @foreach($stats['depenses_par_type'] as $type)
                @php $percentage = $stats['total_depenses'] > 0 ? ($type->total / $stats['total_depenses']) * 100 : 0; @endphp
                <div class="type-item">
                    <div class="type-header">
                        <span class="type-color" style="background: {{ $colors[$i % count($colors)] }};"></span>
                        <span class="type-name">{{ $typesEvenements[$type->type_evenement] ?? $type->type_evenement }}</span>
                        <span class="type-total">{{ number_format($type->total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $percentage }}%; background: {{ $colors[$i % count($colors)] }};"></div>
                        <span class="progress-percentage">{{ round($percentage) }}%</span>
                    </div>
                </div>
                @php $i++; @endphp
            @endforeach
        </div>
    </div>
</div>

<style>
.depenses-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

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
}

.stat-icon svg {
    width: 1.5rem;
    height: 1.5rem;
}

.stat-content h3 {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0 0 0.25rem;
    font-weight: 500;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.text-danger {
    color: var(--red) !important;
}

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

.filters-bar {
    display: flex;
    justify-content: space-between;
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
}

.search-box:focus-within {
    border-color: var(--green);
    box-shadow: 0 0 0 3px rgba(31, 168, 91, 0.1);
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
    background: transparent;
}

.filter-group {
    display: flex;
    gap: 0.5rem;
}

.filter-select {
    padding: 0.625rem 2rem 0.625rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    background: white;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
}

.filter-select:focus {
    border-color: var(--green);
    outline: none;
}

.table-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid var(--gray-200);
    margin-bottom: 2rem;
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
    margin: 0;
}

.table-header .badge {
    padding: 0.25rem 0.75rem;
    background: var(--gray-100);
    border-radius: 2rem;
    font-size: 0.875rem;
}

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
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
}

.modern-table tbody tr {
    border-bottom: 1px solid var(--gray-200);
    transition: background 0.2s;
}

.modern-table tbody tr:hover {
    background: var(--gray-50);
}

.modern-table td {
    padding: 1rem 1.5rem;
    color: var(--gray-700);
}

.ref-badge {
    font-family: monospace;
    font-weight: 600;
    background: var(--gray-100);
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    font-size: 0.8rem;
}

.member-info-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.member-avatar-mini {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--green);
}

.member-avatar-placeholder-mini {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: center;
}

.member-avatar-placeholder-mini svg {
    width: 16px;
    height: 16px;
    color: var(--gray-400);
}

.type-badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.8rem;
    font-weight: 500;
}

.type-enterrement { background: #e5e7eb; color: #374151; }
.type-aide_sociale { background: #fee2e2; color: #dc2626; }
.type-evenement_religieux { background: #e8edff; color: #1f4fd8; }
.type-urgence_medicale { background: #fed7aa; color: #ea580c; }
.type-projet_communautaire { background: #e8f5e9; color: #16a34a; }
.type-mariage { background: #fce7f3; color: #db2777; }
.type-naissance { background: #d1fae5; color: #059669; }
.type-autre { background: #f3e8ff; color: #9333ea; }

.montant-badge {
    font-weight: 600;
    color: var(--green-dark);
}

.date-info-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.date-info-cell svg {
    width: 1rem;
    height: 1rem;
    color: var(--gray-400);
}

.user-badge {
    font-size: 0.85rem;
    color: var(--gray-600);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 34px;
    height: 34px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.action-btn.view {
    background: #e8edff;
    color: var(--blue);
}

.action-btn.view:hover {
    background: var(--blue);
    color: white;
    transform: translateY(-2px);
}

.action-btn.edit {
    background: #fff3e0;
    color: var(--yellow);
}

.action-btn.edit:hover {
    background: var(--yellow);
    color: white;
    transform: translateY(-2px);
}

.action-btn.delete {
    background: #fee2e2;
    color: var(--red);
}

.action-btn.delete:hover {
    background: var(--red);
    color: white;
    transform: translateY(-2px);
}

.action-btn svg {
    width: 16px;
    height: 16px;
}

.delete-form {
    display: inline;
}

.chart-card {
    background: white;
    border-radius: 1.5rem;
    padding: 1.5rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
}

.card-header {
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--gray-200);
}

.card-header h2 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0;
}

.card-header h2 svg {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--green);
}

.type-item {
    margin-bottom: 1rem;
}

.type-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.type-color {
    width: 12px;
    height: 12px;
    border-radius: 4px;
}

.type-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
    flex: 1;
}

.type-total {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-800);
}

.progress-bar-container {
    position: relative;
    background: var(--gray-100);
    border-radius: 0.5rem;
    height: 2rem;
    overflow: hidden;
}

.progress-bar-fill {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    border-radius: 0.5rem;
    transition: width 0.5s ease;
}

.progress-percentage {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-right: 0.75rem;
    height: 100%;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--gray-700);
}

.pagination-container {
    padding: 1.5rem;
    border-top: 1px solid var(--gray-200);
    display: flex;
    justify-content: center;
}

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

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--green);
    color: white;
    border-radius: 0.75rem;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: var(--green-dark);
    transform: translateY(-2px);
}

.btn-primary svg {
    width: 1.25rem;
    height: 1.25rem;
}

@media (max-width: 768px) {
    .depenses-container { padding: 1rem; }
    .page-title { font-size: 1.5rem; }
    .page-subtitle { margin-left: 0; }
    .stats-grid { grid-template-columns: 1fr; }
    .filters-bar { flex-direction: column; }
    .search-box { width: 100%; }
    .filter-group { width: 100%; flex-direction: column; }
    .filter-select { width: 100%; }
    .modern-table thead { display: none; }
    .modern-table tbody tr { display: block; padding: 1rem; border: 1px solid var(--gray-200); border-radius: 1rem; margin-bottom: 1rem; }
    .modern-table td { display: flex; justify-content: space-between; padding: 0.5rem 0; border: none; }
    .modern-table td::before { content: attr(data-label); font-weight: 600; color: var(--gray-500); margin-right: 1rem; }
}
</style>

<script>
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    document.querySelectorAll('.modern-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
});

document.getElementById('typeFilter')?.addEventListener('change', filterTable);
document.getElementById('memberFilter')?.addEventListener('change', filterTable);

function filterTable() {
    const type = document.getElementById('typeFilter').value;
    const member = document.getElementById('memberFilter').value;
    document.querySelectorAll('.modern-table tbody tr').forEach(row => {
        let show = true;
        if (type && !row.querySelector(`.type-badge.type-${type}`)) show = false;
        if (member && member !== row.querySelector('.member-name')?.textContent.split(' ')[0]) show = false;
        row.style.display = show ? '' : 'none';
    });
}
</script>
@endsection