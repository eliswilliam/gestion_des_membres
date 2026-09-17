{{-- resources/views/depenses/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="depense-edit-container">
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('depenses.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour
            </a>
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                </svg>
                Modifier la dépense
            </h1>
        </div>
        <div class="page-badge-group">
            <div class="ref-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4v16h16V4H4z"></path>
                </svg>
                <span>{{ $depense->reference }}</span>
            </div>
            <div class="page-badge">
                <span class="badge">Mode édition</span>
            </div>
        </div>
    </div>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ $error }}', 'error'); });</script>
        @endforeach
    @endif

    <div class="form-card">
        <form action="{{ route('depenses.update', $depense->id) }}" method="POST" class="modern-form">
            @csrf
            @method('PUT')

            <!-- Solde global info -->
            <div class="solde-info-card">
                <div class="solde-info-content">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 8v8M8 12h8"></path>
                    </svg>
                    <div>
                        <span class="solde-label">Solde global disponible</span>
                        <span class="solde-value">{{ number_format($soldeGlobal, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Membre (lecture seule) -->
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
                    <div class="form-group">
                        <label>Membre</label>
                        <div class="member-selected-card">
                            <div class="member-selected-info">
                                @if($depense->member->photo)
                                    <img src="{{ $depense->member->photo_url }}" class="member-selected-avatar">
                                @else
                                    <div class="member-selected-avatar-placeholder">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <span class="member-selected-name">{{ $depense->member->nom }} {{ $depense->member->prenoms }}</span>
                                </div>
                            </div>
                        </div>
                        <small class="readonly-hint">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="12" x2="12" y2="16"></line>
                            </svg>
                            Le membre ne peut pas être modifié après l'enregistrement
                        </small>
                    </div>
                </div>
            </div>

            <!-- Type d'événement -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Type d'événement</h2>
                        <p>Modifiez la nature de la dépense</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="form-group">
                        <label>Type <span class="required">*</span></label>
                        <div class="select-wrapper">
                            <select name="type_evenement" id="typeSelect" class="form-select" required>
                                @foreach($typesEvenements as $value => $label)
                                    <option value="{{ $value }}" {{ old('type_evenement', $depense->type_evenement) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                        @error('type_evenement')
                            <span class="error-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Montant et date -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 6v6l4 2"></path>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Informations financières</h2>
                        <p>Modifiez le montant et la date</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Montant (FCFA) <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-prefix">FCFA</span>
                                <input type="number" name="montant" id="montantInput" class="form-input with-prefix" 
                                       value="{{ old('montant', $depense->montant) }}" min="1" max="100000000" step="1" required>
                            </div>
                            <small class="input-hint" id="montantHint">
                                Montant actuel : {{ number_format($depense->montant, 0, ',', ' ') }} FCFA
                            </small>
                            @error('montant')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Date <span class="required">*</span></label>
                            <input type="date" name="date_depense" id="dateInput" class="form-input" 
                                   value="{{ old('date_depense', $depense->date_depense) }}" required>
                            @error('date_depense')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-textarea" rows="3" 
                                  placeholder="Décrivez brièvement l'événement...">{{ old('description', $depense->description) }}</textarea>
                        @error('description')
                            <span class="error-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Traçabilité -->
            <div class="form-section info-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Informations de traçabilité</h2>
                        <p>Historique de la dépense</p>
                    </div>
                </div>
                <div class="section-body">
                    <div class="info-grid">
                        <div class="info-card">
                            <span class="info-label">Date création</span>
                            <span class="info-value">{{ $depense->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="info-card">
                            <span class="info-label">Dernière modification</span>
                            <span class="info-value">{{ $depense->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="info-card">
                            <span class="info-label">Enregistré par</span>
                            <span class="info-value">{{ $depense->createur->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Récapitulatif -->
            <div class="form-section summary-section">
                <div class="summary-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span>Récapitulatif des modifications</span>
                </div>
                <div class="summary-content">
                    <div class="summary-item">
                        <span class="summary-label">Membre</span>
                        <span class="summary-value">{{ $depense->member->nom }} {{ $depense->member->prenoms }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Type</span>
                        <span class="summary-value" id="summaryType">{{ $depense->type_evenement_label }}</span>
                    </div>
                    <div class="summary-item highlight">
                        <span class="summary-label">Montant</span>
                        <span class="summary-value" id="summaryAmount">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Date</span>
                        <span class="summary-value" id="summaryDate">{{ $depense->date_depense->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="summary-note">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                    </svg>
                    Les modifications seront appliquées immédiatement au solde global
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('depenses.show', $depense) }}" class="btn btn-outline">
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
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.depense-edit-container {
    max-width: 800px;
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
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: white;
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-back:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
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

.page-badge-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.ref-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--gray-100);
    border-radius: 0.75rem;
    font-family: monospace;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--blue);
    border: 1px solid var(--gray-200);
}

.ref-badge svg {
    width: 1rem;
    height: 1rem;
    color: var(--gray-400);
}

.page-badge .badge {
    padding: 0.5rem 1rem;
    background: var(--yellow-soft);
    color: var(--yellow-dark);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
    border: 1px solid var(--yellow);
}

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

.form-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.modern-form {
    padding: 2rem;
}

.solde-info-card {
    background: linear-gradient(135deg, var(--yellow-soft) 0%, #fff9e6 100%);
    border: 1px solid var(--yellow);
    border-radius: 1rem;
    padding: 1rem;
    margin-bottom: 2rem;
}

.solde-info-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.solde-info-content svg {
    width: 2rem;
    height: 2rem;
    color: var(--yellow);
}

.solde-label {
    display: block;
    font-size: 0.75rem;
    color: var(--gray-600);
    text-transform: uppercase;
}

.solde-value {
    display: block;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--yellow-dark);
}

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
    margin: 0 0 0.25rem;
}

.header-title p {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0;
}

.readonly-section {
    background: var(--gray-50);
    border-radius: 1rem;
    padding: 0 1rem 1rem;
    border: 1px dashed var(--gray-300);
}

.readonly-hint {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-top: 0.75rem;
    padding: 0.5rem;
    background: white;
    border-radius: 0.5rem;
}

.readonly-hint svg {
    width: 1rem;
    height: 1rem;
    color: var(--yellow);
}

.member-selected-card {
    background: white;
    border: 2px solid var(--green);
    border-radius: 1rem;
    padding: 1rem;
}

.member-selected-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.member-selected-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--green);
}

.member-selected-avatar-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: center;
}

.member-selected-avatar-placeholder svg {
    width: 24px;
    height: 24px;
    color: var(--gray-400);
}

.member-selected-name {
    display: block;
    font-weight: 600;
    color: var(--gray-800);
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

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
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
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    transition: all 0.2s;
    outline: none;
}

.form-input.with-prefix {
    padding-left: 4rem;
}

.form-input:focus {
    border-color: var(--green);
    box-shadow: 0 0 0 3px rgba(31, 168, 91, 0.1);
}

.input-prefix {
    position: absolute;
    left: 1rem;
    color: var(--gray-500);
    font-weight: 500;
}

.input-hint {
    display: block;
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-top: 0.375rem;
}

.form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    color: var(--gray-800);
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    resize: vertical;
    outline: none;
}

.form-textarea:focus {
    border-color: var(--green);
    box-shadow: 0 0 0 3px rgba(31, 168, 91, 0.1);
}

.select-wrapper {
    position: relative;
}

.form-select {
    width: 100%;
    padding: 0.75rem 2.5rem 0.75rem 1rem;
    font-size: 0.95rem;
    color: var(--gray-800);
    background: white;
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    appearance: none;
    outline: none;
    cursor: pointer;
}

.form-select:focus {
    border-color: var(--green);
    box-shadow: 0 0 0 3px rgba(31, 168, 91, 0.1);
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

.info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.info-card {
    background: var(--gray-50);
    padding: 0.75rem;
    border-radius: 0.75rem;
    text-align: center;
    border: 1px solid var(--gray-200);
}

.info-card .info-label {
    display: block;
    font-size: 0.7rem;
    color: var(--gray-500);
    text-transform: uppercase;
    margin-bottom: 0.25rem;
}

.info-card .info-value {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--gray-700);
}

.error-feedback {
    display: block;
    color: var(--red);
    font-size: 0.75rem;
    margin-top: 0.375rem;
    padding-left: 0.5rem;
    border-left: 2px solid var(--red);
}

.summary-section {
    background: var(--gray-50);
    border-radius: 1rem;
    padding: 1.25rem;
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
    background: white;
    border-radius: 0.75rem;
    border: 1px solid var(--gray-200);
}

.summary-item.highlight {
    background: var(--green-soft);
    border-color: var(--green);
}

.summary-label {
    display: block;
    font-size: 0.7rem;
    color: var(--gray-500);
    text-transform: uppercase;
    margin-bottom: 0.25rem;
}

.summary-value {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--gray-800);
}

.summary-item.highlight .summary-value {
    color: var(--green-dark);
    font-size: 1rem;
}

.summary-note {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: var(--gray-500);
    padding: 0.5rem;
    background: white;
    border-radius: 0.5rem;
}

.summary-note svg {
    width: 1rem;
    height: 1rem;
    color: var(--yellow);
}

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
    transition: all 0.2s;
    cursor: pointer;
    border: none;
    text-decoration: none;
}

.btn svg {
    width: 1.25rem;
    height: 1.25rem;
}

.btn-primary {
    background: var(--green);
    color: white;
    box-shadow: 0 4px 6px rgba(31, 168, 91, 0.2);
}

.btn-primary:hover {
    background: var(--green-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(31, 168, 91, 0.3);
}

.btn-outline {
    background: transparent;
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
}

.btn-outline:hover {
    background: var(--gray-100);
    color: var(--gray-800);
    transform: translateY(-1px);
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-section {
    animation: slideIn 0.3s ease-out forwards;
    opacity: 0;
}
.form-section:nth-child(1) { animation-delay: 0.1s; }
.form-section:nth-child(2) { animation-delay: 0.2s; }
.form-section:nth-child(3) { animation-delay: 0.3s; }
.form-section:nth-child(4) { animation-delay: 0.4s; }
.form-section:nth-child(5) { animation-delay: 0.5s; }

@media (max-width: 768px) {
    .depense-edit-container { padding: 1rem; }
    .header-left { flex-direction: column; align-items: flex-start; }
    .page-title { font-size: 1.5rem; }
    .page-badge-group { width: 100%; justify-content: space-between; }
    .modern-form { padding: 1.5rem; }
    .form-row { grid-template-columns: 1fr; gap: 1rem; }
    .info-grid { grid-template-columns: 1fr; }
    .summary-content { grid-template-columns: repeat(2, 1fr); }
    .member-selected-info { flex-direction: column; text-align: center; }
    .form-actions { flex-direction: column-reverse; }
    .btn { width: 100%; justify-content: center; }
}
</style>

<script>
const soldeGlobal = {{ $soldeGlobal }};
const montantOriginal = {{ $depense->montant }};

document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('typeSelect');
    const montantInput = document.getElementById('montantInput');
    const dateInput = document.getElementById('dateInput');
    
    const summaryType = document.getElementById('summaryType');
    const summaryAmount = document.getElementById('summaryAmount');
    const summaryDate = document.getElementById('summaryDate');
    const montantHint = document.getElementById('montantHint');
    
    const typesEvenements = {
        @foreach($typesEvenements as $value => $label) '{{ $value }}': '{{ $label }}', @endforeach
    };
    
    function formatNumber(value) {
        return new Intl.NumberFormat('fr-FR').format(value);
    }
    
    function updateSummary() {
        if (typeSelect && typeSelect.value) {
            summaryType.textContent = typesEvenements[typeSelect.value] || '-';
        }
        if (montantInput && montantInput.value) {
            const nouveauMontant = parseFloat(montantInput.value);
            const difference = nouveauMontant - montantOriginal;
            const nouveauSolde = soldeGlobal - difference;
            summaryAmount.textContent = formatNumber(nouveauMontant) + ' FCFA';
            
            if (!isNaN(nouveauMontant) && difference > 0 && nouveauSolde < 0) {
                montantHint.style.color = 'var(--red)';
                montantHint.innerHTML = '⚠️ Cette augmentation rendrait le solde négatif (' + formatNumber(nouveauSolde) + ' FCFA)';
            } else if (!isNaN(nouveauMontant) && nouveauMontant < 0) {
                montantHint.style.color = 'var(--red)';
                montantHint.innerHTML = '⚠️ Le montant ne peut pas être négatif';
            } else {
                montantHint.style.color = 'var(--gray-500)';
                montantHint.innerHTML = 'Solde après modification : ' + formatNumber(nouveauSolde) + ' FCFA';
            }
        }
        if (dateInput && dateInput.value) {
            const date = new Date(dateInput.value);
            summaryDate.textContent = date.toLocaleDateString('fr-FR');
        }
    }
    
    if (typeSelect) typeSelect.addEventListener('change', updateSummary);
    if (montantInput) montantInput.addEventListener('input', updateSummary);
    if (dateInput) dateInput.addEventListener('change', updateSummary);
    
    updateSummary();
});
</script>
@endsection