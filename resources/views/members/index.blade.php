@extends('layouts.app')

@section('content')
<div class="members-wrapper">
    <!-- En-tête simplifié -->
    <div class="header-section">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Liste des membres
            </h1>
        </div>
        
        @if(!auth()->user()->isAdmin())
            <a href="{{ route('members.create') }}" class="btn-add">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Ajouter un membre
            </a>
        @endif
    </div>

    <!-- Filtres uniquement -->
    <div class="filters-section">
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" placeholder="Rechercher un membre..." id="searchInput">
        </div>
        
        <div class="filter-wrapper">
            <select class="filter-select" id="filterSelect">
                <option value="">Tous les membres</option>
                <option value="avec_photo">Avec photo</option>
                <option value="sans_photo">Sans photo</option>
                <option value="avec_profession">Avec profession</option>
            </select>
        </div>
    </div>

    <!-- Carte du tableau -->
    <div class="members-card">
        <table class="members-table">
            <thead>
                <tr>
                    <!-- <th>#</th> -->
                    <th>Numéro de membre</th>
                    <th>Photo</th>
                    <th>Nom & Prénoms</th>
                    <th>Date de naissance</th>
                    <th>Profession</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($members as $member)
                    <tr class="member-row" data-member-id="{{ $member->id }}">
                        <!-- <td data-label="#"> {{ $loop->iteration }}</td> -->
                        <td data-label="Numéro de membre"><strong>N° {{ $member->numero_membre }}</strong></td>

                        <td data-label="Photo" class="text-center">
                            @if($member->photo)
                                <div class="photo-container">
                                    <img src="{{ $member->photo_url }}"
                                         alt="photo"
                                         class="member-img">
                                </div>
                            @else
                                <div class="photo-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                            @endif
                        </td>

                        <td data-label="Nom complet">
                            <div class="member-name">
                                {{ $member->nom }} {{ $member->prenoms }}
                            </div>
                        </td>

                        <td data-label="Date naissance">
                            <div class="date-badge">
                                {{ \Carbon\Carbon::parse($member->date_naissance)->format('d/m/Y') }}
                            </div>
                        </td>

                        <td data-label="Profession">
                            @if($member->profession)
                                <span class="profession-badge">{{ $member->profession }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td data-label="Actions">
                            <div class="actions">
                                <a href="{{ route('members.show', $member->id) }}" class="btn-view" title="Voir">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7z"></path>
                                    </svg>
                                </a>
                                
                                @if(!auth()->user()->isAdmin())
                                    <a href="{{ route('members.edit', $member->id) }}" class="btn-edit" title="Modifier">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                        </svg>
                                    </a>

                                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('Voulez-vous vraiment supprimer ce membre ?')" title="Supprimer">
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
                        <td colspan="6" class="empty-state">
                            <div class="empty-content">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <line x1="23" y1="1" x2="1" y2="23"></line>
                                </svg>
                                <h3>Aucun membre trouvé</h3>
                                <p>Commencez par ajouter votre premier membre</p>
                                @if(!auth()->user()->isAdmin())
                                    <a href="{{ route('members.create') }}" class="btn-add">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Ajouter un membre
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($members, 'links'))
            <div class="pagination-wrapper">
                {{ $members->links() }}
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
    --red: #ef4444;
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
    --shadow-green: 0 4px 6px rgba(22, 138, 74, 0.2);
}

/* ===== CONTAINER PRINCIPAL ===== */
.members-wrapper {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

/* ===== HEADER SIMPLIFIÉ ===== */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-title {
    font-size: 1.75rem;
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

/* ===== BOUTON AJOUT ===== */
.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
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

.btn-add:hover {
    background: var(--green-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-add svg {
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
    flex-shrink: 0;
}

/* ===== FILTRES UNIQUEMENT ===== */
.filters-section {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    background: white;
    padding: 1rem;
    border-radius: 1rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
}

.search-box {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--gray-50);
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

.filter-wrapper {
    min-width: 200px;
}

.filter-select {
    width: 100%;
    padding: 0.75rem 2rem 0.75rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    font-size: 0.95rem;
    color: var(--gray-700);
    background: var(--gray-50);
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

/* ===== CARD TABLE ===== */
.members-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

/* ===== TABLE ===== */
.members-table {
    width: 100%;
    border-collapse: collapse;
}

/* EN-TÊTE */
.members-table thead th {
    text-align: left;
    padding: 1.25rem 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-600);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: var(--gray-50);
    border-bottom: 2px solid var(--gray-200);
}

/* LIGNES */
.members-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--gray-200);
}

.members-table tbody tr:last-child {
    border-bottom: none;
}

.members-table tbody tr:hover {
    background: var(--gray-50);
}

/* CELLULES */
.members-table td {
    padding: 1rem;
    font-size: 0.95rem;
    color: var(--gray-700);
    vertical-align: middle;
}

/* ===== PHOTO ===== */
.photo-container {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid var(--green);
    transition: all 0.2s ease;
}

.photo-container:hover {
    transform: scale(1.1);
    border-color: var(--green-dark);
    box-shadow: 0 0 0 3px rgba(22, 138, 74, 0.2);
}

.member-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
}

.photo-placeholder svg {
    width: 24px;
    height: 24px;
}

/* ===== NOM ===== */
.member-name {
    font-weight: 500;
    color: var(--gray-800);
}

/* ===== DATE ===== */
.date-badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    background: var(--gray-100);
    border-radius: 2rem;
    font-size: 0.875rem;
    color: var(--gray-700);
    font-weight: 500;
}

/* ===== PROFESSION ===== */
.profession-badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    background: var(--green-soft);
    color: var(--green-dark);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.text-muted {
    color: var(--gray-400);
}

/* ===== ACTIONS ===== */
.actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
}

.btn-view,
.btn-edit,
.btn-delete {
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

.btn-view svg,
.btn-edit svg,
.btn-delete svg {
    width: 18px;
    height: 18px;
}

.btn-view {
    background: var(--green-soft);
    color: var(--green);
}

.btn-view:hover {
    background: var(--green);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(22, 138, 74, 0.3);
}

.btn-edit {
    background: #fff3e0;
    color: var(--yellow);
}

.btn-edit:hover {
    background: var(--yellow);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
}

.btn-delete {
    background: #ffebee;
    color: var(--red);
}

.btn-delete:hover {
    background: var(--red);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

/* ===== ÉTAT VIDE ===== */
.empty-state td {
    padding: 4rem 1rem;
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
.pagination-wrapper {
    padding: 1.5rem;
    border-top: 1px solid var(--gray-200);
    display: flex;
    justify-content: center;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .members-wrapper {
        margin: 1rem auto;
        padding: 0 1rem;
    }

    .header-section {
        flex-direction: column;
        align-items: flex-start;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .filters-section {
        flex-direction: column;
    }

    .search-box {
        width: 100%;
    }

    .filter-wrapper {
        width: 100%;
    }

    /* Table responsive */
    .members-table thead {
        display: none;
    }

    .members-table tbody tr {
        display: block;
        padding: 1rem;
        border: 1px solid var(--gray-200);
        border-radius: 1rem;
        margin-bottom: 1rem;
    }

    .members-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border: none;
    }

    .members-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--gray-500);
        margin-right: 1rem;
    }

    .photo-container,
    .photo-placeholder {
        margin: 0 auto;
    }

    .actions {
        justify-content: flex-end;
    }
}
</style>

<script>
// Recherche en temps réel
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.member-row');
    
    rows.forEach(row => {
        const memberName = row.querySelector('.member-name')?.textContent.toLowerCase() || '';
        const profession = row.querySelector('.profession-badge')?.textContent.toLowerCase() || '';
        
        if (memberName.includes(searchTerm) || profession.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filtre par catégorie
document.getElementById('filterSelect')?.addEventListener('change', function(e) {
    const filter = e.target.value;
    const rows = document.querySelectorAll('.member-row');
    
    rows.forEach(row => {
        const hasPhoto = row.querySelector('.photo-container') !== null;
        const hasProfession = row.querySelector('.profession-badge') !== null;
        
        if (filter === '') {
            row.style.display = '';
        } else if (filter === 'avec_photo' && hasPhoto) {
            row.style.display = '';
        } else if (filter === 'sans_photo' && !hasPhoto) {
            row.style.display = '';
        } else if (filter === 'avec_profession' && hasProfession) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Confirmation de suppression
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('Voulez-vous vraiment supprimer ce membre ? Cette action est irréversible.')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection