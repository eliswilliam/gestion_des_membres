@extends('layouts.app')

@section('content')
<div class="member-details-container">
    <!-- En-tête avec navigation -->
    <div class="details-header">
        <div class="header-left">
            <a href="{{ route('members.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour à la liste
            </a>
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Profil membre
            </h1>
        </div>
        <div class="member-badge">
            <!-- #{{ $member->id }} -->
           <strong> <span class="badge-text">N° {{ $member->numero_membre }}</span></strong>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="profile-card">
        <!-- Bannière de profil -->
        <div class="profile-banner">
            <div class="banner-overlay"></div>
        </div>

        <div class="profile-content">
            <!-- Photo et informations principales -->
            <div class="profile-main">
                <div class="profile-avatar-wrapper">
                    @if($member->photo)
                        <img src="{{ $member->photo_url }}" alt="photo" class="profile-avatar">
                        <span class="avatar-status"></span>
                    @else
                        <div class="profile-avatar-placeholder">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="profile-title">
                    <h2 class="profile-name">{{ $member->nom }} {{ $member->prenoms }}</h2>
                    <div class="profile-meta">
                        @if($member->profession)
                            <span class="meta-badge profession">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                                {{ $member->profession }}
                            </span>
                        @endif
                        
                        @if($member->nationalite)
                            <span class="meta-badge nationality">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="8" r="4"></circle>
                                    <path d="M5.8 15.2a8 8 0 0 1 12.4 0"></path>
                                    <circle cx="12" cy="20" r="2"></circle>
                                </svg>
                                {{ $member->nationalite }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Grille d'informations -->
            <div class="info-grid">
                <!-- Identité -->
                <div class="info-section">
                    <h3 class="section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Identité
                    </h3>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Date de naissance</span>
                            <span class="info-value">
                                {{ \Carbon\Carbon::parse($member->date_naissance)->format('d/m/Y') }}
                                <small>({{ \Carbon\Carbon::parse($member->date_naissance)->age }} ans)</small>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Lieu de naissance</span>
                            <span class="info-value">{{ $member->lieu_naissance }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Situation matrimoniale</span>
                            @if($member->situation_matrimoniale)
                                @php
                                    $situationColors = [
                                        'célibataire' => ['bg' => '#e8f5e9', 'text' => '#2e7d32'],
                                        'marié(e)' => ['bg' => '#fff3e0', 'text' => '#f57c00'],
                                        'divorcé(e)' => ['bg' => '#ffebee', 'text' => '#c62828'],
                                        'veuf(ve)' => ['bg' => '#f3e5f5', 'text' => '#7b1fa2'],
                                    ];
                                    $color = $situationColors[$member->situation_matrimoniale] ?? ['bg' => '#f5f5f5', 'text' => '#616161'];
                                @endphp
                                <span class="situation-badge" style="background: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                                    {{ $member->situation_matrimoniale }}
                                </span>
                            @else
                                <span class="info-value">-</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Filiation -->
                <div class="info-section">
                    <h3 class="section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Filiation
                    </h3>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Nom du père</span>
                            <span class="info-value">{{ $member->nom_pere ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nom de la mère</span>
                            <span class="info-value">{{ $member->nom_mere ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="info-section">
                    <h3 class="section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        Contact
                    </h3>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Adresse</span>
                            <span class="info-value address">{{ $member->adresse ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions du profil -->
            <div class="profile-actions">
                @if(!auth()->user()->isAdmin())
                    <a href="{{ route('members.cotisations', $member->id) }}" class="action-btn secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                        Voir les cotisations
                    </a>

                    <div class="action-group">
                        <a href="{{ route('members.edit', $member->id) }}" class="action-btn edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                            </svg>
                            Modifier
                        </a>

                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" onclick="return confirm('Voulez-vous vraiment supprimer ce membre ? Cette action est irréversible.')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
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
    --red-soft: #ffebee;
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
.member-details-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

/* ===== HEADER ===== */
.details-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--white);
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-back:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
    color: var(--gray-800);
    transform: translateX(-2px);
}

.btn-back svg {
    width: 1.25rem;
    height: 1.25rem;
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

.member-badge {
    padding: 0.5rem 1rem;
    background: var(--green-soft);
    color: var(--green-dark);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid var(--green);
}

/* ===== PROFILE CARD ===== */
.profile-card {
    background: var(--white);
    border-radius: 1.5rem;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

/* ===== BANNIÈRE ===== */
.profile-banner {
    height: 120px;
    background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
    position: relative;
}

.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
}

/* ===== CONTENU PRINCIPAL ===== */
.profile-content {
    padding: 2rem;
    margin-top: -40px;
}

/* ===== AVATAR ===== */
.profile-main {
    display: flex;
    gap: 2rem;
    align-items: flex-end;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.profile-avatar-wrapper {
    position: relative;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 1rem;
    object-fit: cover;
    border: 4px solid var(--white);
    box-shadow: var(--shadow-lg);
    transition: all 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow-xl);
}

.avatar-status {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 16px;
    height: 16px;
    background: var(--green);
    border: 3px solid var(--white);
    border-radius: 50%;
}

.profile-avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 1rem;
    background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid var(--white);
    box-shadow: var(--shadow-lg);
}

.profile-avatar-placeholder svg {
    width: 60px;
    height: 60px;
    color: var(--gray-500);
}

.profile-title {
    flex: 1;
    padding-bottom: 0.5rem;
}

.profile-name {
    font-size: 2rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0 0 0.5rem 0;
}

.profile-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--gray-100);
    color: var(--gray-700);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.meta-badge.profession {
    background: var(--green-soft);
    color: var(--green-dark);
}

.meta-badge.nationality {
    background: var(--yellow-soft);
    color: var(--yellow);
}

.meta-badge svg {
    width: 1rem;
    height: 1rem;
}

/* ===== GRILLE D'INFORMATIONS ===== */
.info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin: 2rem 0;
    padding: 2rem 0;
    border-top: 2px solid var(--gray-200);
    border-bottom: 2px solid var(--gray-200);
}

.info-section {
    background: var(--gray-50);
    padding: 1.5rem;
    border-radius: 1rem;
    transition: all 0.2s ease;
}

.info-section:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    background: var(--white);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-700);
    margin: 0 0 1rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--gray-200);
}

.section-title svg {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--green);
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-label {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-value {
    font-size: 0.95rem;
    color: var(--gray-800);
    font-weight: 500;
}

.info-value small {
    font-size: 0.8rem;
    color: var(--gray-500);
    font-weight: normal;
    margin-left: 0.25rem;
}

.info-value.address {
    line-height: 1.5;
}

/* ===== SITUATION BADGE ===== */
.situation-badge {
    display: inline-block;
    padding: 0.35rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
}

/* ===== ACTIONS ===== */
.profile-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.action-group {
    display: flex;
    gap: 0.75rem;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-size: 0.95rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.action-btn svg {
    width: 1.25rem;
    height: 1.25rem;
}

.action-btn.secondary {
    background: var(--gray-100);
    color: var(--gray-700);
    border: 2px solid var(--gray-200);
}

.action-btn.secondary:hover {
    background: var(--gray-200);
    color: var(--gray-800);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.action-btn.edit {
    background: var(--yellow-soft);
    color: var(--yellow);
    border: 2px solid var(--yellow);
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
    border: 2px solid var(--red);
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

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .member-details-container {
        margin: 1rem auto;
        padding: 0 1rem;
    }

    .details-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-left {
        width: 100%;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .profile-main {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .profile-title {
        text-align: center;
    }

    .profile-meta {
        justify-content: center;
    }

    .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .profile-actions {
        flex-direction: column;
    }

    .action-group {
        width: 100%;
    }

    .action-btn {
        flex: 1;
        justify-content: center;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* ===== ANIMATIONS ===== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.profile-card {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script>
// Confirmation de suppression
document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce membre ? Cette action est irréversible.')) {
        e.preventDefault();
    }
});
</script>
@endsection