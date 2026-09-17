@extends('layouts.app')

@section('content')
<div class="cotisation-edit-container">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('cotisations.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour à la liste
            </a>
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                    <path d="M17 14v2"></path>
                </svg>
                Modifier la cotisation
            </h1>
        </div>
        <div class="header-badge">
            <span class="badge">#{{ $cotisation->id }}</span>
        </div>
    </div>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ $error }}', 'error'); });</script>
        @endforeach
    @endif

    <!-- Formulaire de modification -->
    <div class="form-card">
        <form action="{{ route('cotisations.update', $cotisation->id) }}" method="POST" class="modern-form">
            @csrf
            @method('PUT')

            <!-- Champ caché pour member_id -->
            <input type="hidden" name="member_id" value="{{ $cotisation->member_id }}">

            <!-- Badge édition -->
            <div class="form-badge">
                <span class="edit-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Mode édition
                </span>
            </div>

            <!-- Section Membre (lecture seule) -->
            <div class="form-section readonly-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Membre concerné</h2>
                        <p>Informations non modifiables</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="member-info-card">
                        <div class="member-avatar">
                            @if($cotisation->member->photo)
                                <img src="{{ $cotisation->member->photo_url }}" alt="photo">
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            @endif
                        </div>
                        <div class="member-details">
                            <span class="member-name">{{ $cotisation->member->nom }} {{ $cotisation->member->prenoms }}</span>
                            <span class="member-info">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="8" r="4"></circle>
                                    <path d="M5.8 15.2a8 8 0 0 1 12.4 0"></path>
                                </svg>
                                Membre depuis {{ \Carbon\Carbon::parse($cotisation->member->created_at)->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                    <small class="readonly-hint">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="12" x2="12" y2="16"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        Le membre ne peut pas être modifié
                    </small>
                </div>
            </div>

            <!-- Section Période -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Période de cotisation</h2>
                        <p>Modifiez le mois et l'année concernés</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Mois <span class="required">*</span></label>
                            <div class="select-wrapper">
                                <select name="mois" class="form-select" required>
                                    @php
                                        $moisNoms = [
                                            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                                            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                                            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                                        ];
                                    @endphp
                                    @foreach($moisNoms as $numero => $nom)
                                        <option value="{{ $numero }}" {{ old('mois', $cotisation->mois) == $numero ? 'selected' : '' }}>
                                            {{ $nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                            @error('mois')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Année <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="number" name="annee" class="form-input" 
                                       value="{{ old('annee', $cotisation->annee) }}" 
                                       min="2020" max="2100" required>
                                <span class="input-suffix">ans</span>
                            </div>
                            @error('annee')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Montant et date -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 6v6l4 2"></path>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Paiement</h2>
                        <p>Modifiez le montant et la date</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Montant <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-prefix">cfa</span>
                                <input type="number" name="montant" class="form-input with-prefix" 
                                       value="{{ old('montant', $cotisation->montant) }}" 
                                       min="0" max="1000" step="0.01" 
                                       placeholder="0.00" required>
                            </div>
                            <small class="input-hint">Maximum 1000 CFA</small>
                            @error('montant')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Date de paiement <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="date" name="date_paiement" class="form-input" 
                                       value="{{ old('date_paiement', \Carbon\Carbon::parse($cotisation->date_paiement)->format('Y-m-d')) }}" required>
                            </div>
                            @error('date_paiement')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Récapitulatif des modifications -->
            <div class="form-section summary-section">
                <div class="summary-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span>Récapitulatif de la cotisation</span>
                </div>
                <div class="summary-content">
                    <div class="summary-item">
                        <span class="summary-label">Mois</span>
                        <span class="summary-value" id="summaryMois">{{ $moisNoms[$cotisation->mois] ?? $cotisation->mois }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Année</span>
                        <span class="summary-value" id="summaryAnnee">{{ $cotisation->annee }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Montant</span>
                        <span class="summary-value" id="summaryMontant">{{ number_format($cotisation->montant, 2) }} CFA</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Date</span>
                        <span class="summary-value" id="summaryDate">{{ \Carbon\Carbon::parse($cotisation->date_paiement)->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="summary-note">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    Vérifiez les informations avant de confirmer la modification
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <a href="{{ route('cotisations.index') }}" class="btn btn-outline">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Mettre à jour
                </button>
            </div>
        </form>
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
.cotisation-edit-container {
    max-width: 800px;
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

.header-badge .badge {
    padding: 0.5rem 1rem;
    background: var(--green-soft);
    color: var(--green-dark);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid var(--green);
}

/* ===== MESSAGES D'ERREUR ===== */
.alert-error {
    background: var(--red-soft);
    border: 1px solid var(--red);
    border-radius: 1rem;
    padding: 1.25rem;
    margin-bottom: 2rem;
}

.alert-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--red);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.alert-header svg {
    width: 1.25rem;
    height: 1.25rem;
}

.error-list {
    margin: 0;
    padding-left: 2rem;
    color: var(--gray-700);
}

.error-list li {
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

/* ===== FORMULAIRE ===== */
.form-card {
    background: var(--white);
    border-radius: 1.5rem;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.modern-form {
    padding: 2rem;
}

/* ===== BADGE ÉDITION ===== */
.form-badge {
    margin-bottom: 2rem;
}

.edit-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--green-soft);
    color: var(--green-dark);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
    border: 1px solid var(--green);
}

.edit-badge svg {
    width: 1rem;
    height: 1rem;
}

/* ===== SECTIONS ===== */
.form-section {
    margin-bottom: 2rem;
    border-bottom: 1px solid var(--gray-200);
    padding-bottom: 1.5rem;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 1.5rem;
    padding-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.header-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: var(--green-soft);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--green);
}

.header-icon svg {
    width: 1.25rem;
    height: 1.25rem;
}

.header-title h2 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0 0 0.25rem 0;
}

.header-title p {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0;
}

/* ===== SECTION LECTURE SEULE ===== */
.readonly-section {
    background: var(--gray-50);
    border-radius: 1rem;
    padding: 1.25rem;
    border: 1px dashed var(--gray-300);
}

.member-info-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.member-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--green);
}

.member-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.member-avatar svg {
    width: 24px;
    height: 24px;
    color: var(--gray-500);
}

.member-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.member-name {
    font-weight: 600;
    color: var(--gray-800);
}

.member-info {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--gray-500);
}

.member-info svg {
    width: 0.875rem;
    height: 0.875rem;
}

.readonly-hint {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-top: 0.5rem;
    padding: 0.5rem;
    background: var(--white);
    border-radius: 0.5rem;
}

.readonly-hint svg {
    width: 0.875rem;
    height: 0.875rem;
}

/* ===== FORMULAIRES ===== */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.required {
    color: var(--red);
    margin-left: 0.25rem;
}

/* ===== INPUTS ===== */
.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    color: var(--gray-800);
    background: var(--white);
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    outline: none;
}

.form-input.with-prefix {
    padding-left: 2.5rem;
}

.form-input:hover {
    border-color: var(--gray-300);
}

.form-input:focus {
    border-color: var(--green);
    box-shadow: 0 0 0 3px rgba(22, 138, 74, 0.1);
}

.input-prefix {
    position: absolute;
    left: 1rem;
    color: var(--gray-500);
    font-weight: 500;
    z-index: 1;
}

.input-suffix {
    position: absolute;
    right: 1rem;
    color: var(--gray-500);
    font-size: 0.875rem;
}

.input-hint {
    display: block;
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-top: 0.375rem;
}

/* ===== SELECTS ===== */
.select-wrapper {
    position: relative;
}

.form-select {
    width: 100%;
    padding: 0.75rem 2.5rem 0.75rem 1rem;
    font-size: 0.95rem;
    color: var(--gray-800);
    background: var(--white);
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    outline: none;
    appearance: none;
}

.form-select:hover {
    border-color: var(--gray-300);
}

.form-select:focus {
    border-color: var(--green);
    box-shadow: 0 0 0 3px rgba(22, 138, 74, 0.1);
}

.select-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 1rem;
    height: 1rem;
    color: var(--gray-400);
    pointer-events: none;
}

/* ===== RÉCAPITULATIF ===== */
.summary-section {
    background: var(--gray-50);
    border-radius: 1rem;
    padding: 1.25rem;
    margin: 1.5rem 0;
}

.summary-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-600);
    font-weight: 500;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--gray-300);
}

.summary-header svg {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--green);
}

.summary-content {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1rem;
}

.summary-item {
    text-align: center;
    padding: 0.5rem;
    background: var(--white);
    border-radius: 0.75rem;
    border: 1px solid var(--gray-200);
}

.summary-label {
    display: block;
    font-size: 0.7rem;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
}

.summary-value {
    display: block;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-800);
}

.summary-note {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-top: 0.5rem;
    padding: 0.5rem;
    background: var(--white);
    border-radius: 0.5rem;
}

.summary-note svg {
    width: 1rem;
    height: 1rem;
    color: var(--yellow);
}

/* ===== MESSAGES D'ERREUR ===== */
.error-feedback {
    display: block;
    color: var(--red);
    font-size: 0.75rem;
    margin-top: 0.375rem;
    padding-left: 0.5rem;
    border-left: 2px solid var(--red);
}

/* ===== BOUTONS ===== */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    font-size: 0.95rem;
    font-weight: 500;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
    outline: none;
    text-decoration: none;
}

.btn svg {
    width: 1.25rem;
    height: 1.25rem;
}

.btn-primary {
    background: var(--green);
    color: white;
    box-shadow: var(--shadow-green);
}

.btn-primary:hover {
    background: var(--green-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-outline {
    background: transparent;
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
}

.btn-outline:hover {
    background: var(--gray-100);
    color: var(--gray-800);
    border-color: var(--gray-300);
    transform: translateY(-1px);
}

/* ===== ANIMATIONS ===== */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-section {
    animation: slideIn 0.3s ease-out forwards;
    opacity: 0;
}

.form-section:nth-child(2) { animation-delay: 0.1s; }
.form-section:nth-child(3) { animation-delay: 0.2s; }
.form-section:nth-child(4) { animation-delay: 0.3s; }
.form-section:nth-child(5) { animation-delay: 0.4s; }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .cotisation-edit-container {
        margin: 1rem auto;
        padding: 0 1rem;
    }

    .header-left {
        flex-direction: column;
        align-items: flex-start;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .modern-form {
        padding: 1.5rem;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .summary-content {
        grid-template-columns: repeat(2, 1fr);
    }

    .member-info-card {
        flex-direction: column;
        text-align: center;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .form-row {
        gap: 1rem;
    }
    
    .summary-content {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
// Mise à jour dynamique du récapitulatif
document.addEventListener('DOMContentLoaded', function() {
    const moisSelect = document.querySelector('select[name="mois"]');
    const anneeInput = document.querySelector('input[name="annee"]');
    const montantInput = document.querySelector('input[name="montant"]');
    const dateInput = document.querySelector('input[name="date_paiement"]');
    
    const summaryMois = document.getElementById('summaryMois');
    const summaryAnnee = document.getElementById('summaryAnnee');
    const summaryMontant = document.getElementById('summaryMontant');
    const summaryDate = document.getElementById('summaryDate');
    
    const moisNoms = {
        1: 'Janvier', 2: 'Février', 3: 'Mars', 4: 'Avril',
        5: 'Mai', 6: 'Juin', 7: 'Juillet', 8: 'Août',
        9: 'Septembre', 10: 'Octobre', 11: 'Novembre', 12: 'Décembre'
    };
    
    function updateSummary() {
        // Mois
        if (moisSelect && moisSelect.value) {
            summaryMois.textContent = moisNoms[moisSelect.value] || '?';
        }
        
        // Année
        if (anneeInput && anneeInput.value) {
            summaryAnnee.textContent = anneeInput.value;
        }
        
        // Montant
        if (montantInput && montantInput.value) {
            const montant = parseFloat(montantInput.value).toFixed(2);
            summaryMontant.textContent = montant + ' CFA';
            
            // Mettre en évidence si montant modifié
            if (montantInput.value != {{ $cotisation->montant }}) {
                summaryMontant.style.color = 'var(--green)';
                summaryMontant.style.fontWeight = '700';
            } else {
                summaryMontant.style.color = '';
                summaryMontant.style.fontWeight = '';
            }
        }
        
        // Date
        if (dateInput && dateInput.value) {
            const date = new Date(dateInput.value);
            const formatted = date.toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            summaryDate.textContent = formatted;
        }
    }
    
    // Écouter les changements
    if (moisSelect) moisSelect.addEventListener('change', updateSummary);
    if (anneeInput) anneeInput.addEventListener('input', updateSummary);
    if (montantInput) montantInput.addEventListener('input', updateSummary);
    if (dateInput) dateInput.addEventListener('change', updateSummary);
    
    // Initialisation
    updateSummary();
});
</script>
@endsection