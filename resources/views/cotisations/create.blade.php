@extends('layouts.app')

@section('content')
<div class="cotisation-container">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('cotisations.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour
            </a>
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
                Nouvelle cotisation
            </h1>
        </div>
    </div>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ $error }}', 'error'); });</script>
        @endforeach
    @endif

    <!-- Formulaire de cotisation -->
    <div class="form-card">
        <form action="{{ route('cotisations.store') }}" method="POST" class="modern-form">
            @csrf

            <!-- Sélection du membre -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Membre concerné</h2>
                        <p>Sélectionnez le membre pour lequel vous ajoutez une cotisation</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-group">
                        <label>Membre <span class="required">*</span></label>
                        <div class="select-wrapper">
                            <select name="member_id" class="form-select" required>
                                <option value="" disabled {{ old('member_id') ? '' : 'selected' }}>-- Choisir un membre --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->nom }} {{ $member->prenoms }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                        @error('member_id')
                            <span class="error-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Période de cotisation -->
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
                        <p>Mois et année concernés par le paiement</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Mois <span class="required">*</span></label>
                            <div class="select-wrapper">
                                <select name="mois" class="form-select" required>
                                    <option value="" disabled {{ old('mois') ? '' : 'selected' }}>-- Sélectionner un mois --</option>
                                    @php
                                        $moisNoms = [
                                            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                                            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                                            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                                        ];
                                    @endphp
                                    @foreach($moisNoms as $numero => $nom)
                                        <option value="{{ $numero }}" {{ old('mois') == $numero ? 'selected' : '' }}>
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
                                       value="{{ old('annee', date('Y')) }}" 
                                       min="2000" max="2100" required>
                                <span class="input-suffix">ans</span>
                            </div>
                            @error('annee')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Montant et date de paiement -->
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
                        <p>Montant et date de la cotisation</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Montant <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-prefix">cfa</span>
                                <input type="number" name="montant" class="form-input with-prefix" 
                                       value="{{ old('montant') }}" 
                                       min="1" max="1000" step="0.01" 
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
                                       value="{{ old('date_paiement', date('Y-m-d')) }}" required>
                            </div>
                            @error('date_paiement')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Récapitulatif (optionnel) -->
            <div class="form-section summary-section">
                <div class="summary-content">
                    <div class="summary-item">
                        <span class="summary-label">Membre</span>
                        <span class="summary-value" id="summaryMember">Non sélectionné</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Période</span>
                        <span class="summary-value" id="summaryPeriod">-</span>
                    </div>
                    <div class="summary-item highlight">
                        <span class="summary-label">Montant</span>
                        <span class="summary-value" id="summaryAmount">0 CFA</span>
                    </div>
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
                    Enregistrer la cotisation
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
.cotisation-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

/* ===== HEADER ===== */
.page-header {
    margin-bottom: 2rem;
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

/* ===== FORMULAIRES ===== */
.form-group {
    margin-bottom: 1.25rem;
}

.form-group:last-child {
    margin-bottom: 0;
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
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

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

.summary-content {
    display: flex;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.summary-item {
    text-align: center;
    flex: 1;
    min-width: 120px;
}

.summary-item.highlight {
    background: var(--green-soft);
    padding: 0.75rem;
    border-radius: 0.75rem;
    border: 1px solid var(--green);
}

.summary-label {
    display: block;
    font-size: 0.75rem;
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

.summary-item.highlight .summary-value {
    color: var(--green-dark);
    font-size: 1.25rem;
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

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .cotisation-container {
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
        flex-direction: column;
    }

    .summary-item {
        width: 100%;
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
}
</style>

<script>
// Mise à jour dynamique du récapitulatif
document.addEventListener('DOMContentLoaded', function() {
    const memberSelect = document.querySelector('select[name="member_id"]');
    const moisSelect = document.querySelector('select[name="mois"]');
    const anneeInput = document.querySelector('input[name="annee"]');
    const montantInput = document.querySelector('input[name="montant"]');
    
    const summaryMember = document.getElementById('summaryMember');
    const summaryPeriod = document.getElementById('summaryPeriod');
    const summaryAmount = document.getElementById('summaryAmount');
    
    const moisNoms = {
        1: 'Janvier', 2: 'Février', 3: 'Mars', 4: 'Avril',
        5: 'Mai', 6: 'Juin', 7: 'Juillet', 8: 'Août',
        9: 'Septembre', 10: 'Octobre', 11: 'Novembre', 12: 'Décembre'
    };
    
    function updateSummary() {
        // Membre
        if (memberSelect && memberSelect.value) {
            const memberText = memberSelect.options[memberSelect.selectedIndex]?.text || 'Non sélectionné';
            summaryMember.textContent = memberText;
        } else {
            summaryMember.textContent = 'Non sélectionné';
        }
        
        // Période
        if (moisSelect && moisSelect.value && anneeInput && anneeInput.value) {
            const moisNom = moisNoms[moisSelect.value] || '?';
            summaryPeriod.textContent = `${moisNom} ${anneeInput.value}`;
        } else {
            summaryPeriod.textContent = '-';
        }
        
        // Montant
        if (montantInput && montantInput.value) {
            const montant = parseFloat(montantInput.value).toFixed(2);
            summaryAmount.textContent = `${montant} CFA`;
            
            // Mettre en évidence si montant > 900
            if (parseFloat(montantInput.value) > 900) {
                summaryAmount.style.color = 'var(--green-dark)';
                summaryAmount.style.fontWeight = '700';
            } else {
                summaryAmount.style.color = '';
                summaryAmount.style.fontWeight = '';
            }
        } else {
            summaryAmount.textContent = '0 CFA';
        }
    }
    
    // Écouter les changements
    if (memberSelect) memberSelect.addEventListener('change', updateSummary);
    if (moisSelect) moisSelect.addEventListener('change', updateSummary);
    if (anneeInput) anneeInput.addEventListener('input', updateSummary);
    if (montantInput) montantInput.addEventListener('input', updateSummary);
    
    // Initialisation
    updateSummary();
});
</script>
@endsection