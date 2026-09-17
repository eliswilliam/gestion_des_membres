@extends('layouts.app')

@section('content')
<div class="members-container">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M17 11l4-4-4-4"></path>
                    <path d="M21 7h-8"></path>
                </svg>
                Modifier le membre
            </h1>
            <p class="page-subtitle">Modifiez les informations du membre #{{ $member->id }}</p>
        </div>
        <div class="header-decoration"></div>
    </div>

    <!-- Carte du formulaire -->
    <div class="form-card">
        <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="modern-form">
            @csrf
            @method('PUT')

            <!-- Badge statut -->
            <div class="form-badge">
                <span class="badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Mode édition
                </span>
            </div>

            <!-- Section 1: Identité -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Informations d'identité</h2>
                        <p>État civil et informations personnelles</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Numéro de membre <span class="required">*</span></label>
                            <div class="input-group">
                                 <input type="text" name="numero_membre" value="{{ old('numero_membre', $member->numero_membre) }}" required 
                                       placeholder="Ex: 001" class="form-input"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('numero_membre')
                                    <span class="error-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nom <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" name="nom" value="{{ old('nom', $member->nom) }}" required 
                                       placeholder="Ex: ASSOUKA" class="form-input">
                                @error('nom')
                                    <span class="error-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Prénoms <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" name="prenoms" value="{{ old('prenoms', $member->prenoms) }}" required 
                                       placeholder="Ex: LE BRAVE" class="form-input">
                                @error('prenoms')
                                    <span class="error-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Date de naissance <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="date" name="date_naissance" value="{{ old('date_naissance', $member->date_naissance) }}" required 
                                       class="form-input">
                                @error('date_naissance')
                                    <span class="error-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Lieu de naissance <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $member->lieu_naissance) }}" required 
                                       placeholder="Ex: Lomé" class="form-input">
                                @error('lieu_naissance')
                                    <span class="error-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nationalité</label>
                        <div class="input-group">
                            <select name="nationalite" class="form-input">
                                <option value="">Sélectionnez un pays</option>
                                @foreach(config('pays') as $pays)
                                    <option value="{{ $pays }}" {{ old('nationalite', $member->nationalite) == $pays ? 'selected' : '' }}>{{ $pays }}</option>
                                @endforeach
                            </select>
                            @error('nationalite')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Filiation -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Filiation</h2>
                        <p>Informations sur les parents</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nom du père</label>
                            <div class="input-group">
                                <input type="text" name="nom_pere" value="{{ old('nom_pere', $member->nom_pere) }}" 
                                       placeholder="Ex: GATO Pierre" class="form-input">
                                @error('nom_pere')
                                    <span class="error-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nom de la mère</label>
                            <div class="input-group">
                                <input type="text" name="nom_mere" value="{{ old('nom_mere', $member->nom_mere) }}" 
                                       placeholder="Ex: GATO Marie" class="form-input">
                                @error('nom_mere')
                                    <span class="error-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Profession et situation -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Profession & Situation</h2>
                        <p>Activité professionnelle et situation familiale</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Profession</label>
                            <div class="input-group">
                                <select name="profession" class="form-input">
                                    <option value="">Sélectionnez une profession</option>
                                    @foreach(config('professions') as $profession)
                                        <option value="{{ $profession }}" {{ old('profession', $member->profession) == $profession ? 'selected' : '' }}>{{ $profession }}</option>
                                    @endforeach
                                </select>
                                @error('profession')
                                    <span class="error-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Situation Matrimoniale</label>
                            <div class="select-wrapper">
                                <select name="situation_matrimoniale" class="form-select">
                                    <option value="" disabled>Sélectionnez une option</option>
                                    <option value="célibataire" {{ old('situation_matrimoniale', $member->situation_matrimoniale) == 'célibataire' ? 'selected' : '' }}>Célibataire</option>
                                    <option value="marié(e)" {{ old('situation_matrimoniale', $member->situation_matrimoniale) == 'marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                                    <option value="divorcé(e)" {{ old('situation_matrimoniale', $member->situation_matrimoniale) == 'divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                                    <option value="veuf(ve)" {{ old('situation_matrimoniale', $member->situation_matrimoniale) == 'veuf(ve)' ? 'selected' : '' }}>Veuf(ve)</option>
                                </select>
                                @error('situation_matrimoniale')
                                    <span class="error-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Contact et photo -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Contact & Photo</h2>
                        <p>Coordonnées et photo d'identité</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-group">
                        <label>Adresse complète</label>
                        <div class="input-group">
                            <textarea name="adresse" rows="3" class="form-textarea" 
                                      placeholder="Ex: 123 Rue de la République, 701 Lomé, 90 10 72 00">{{ old('adresse', $member->adresse) }}</textarea>
                            @error('adresse')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group photo-upload">
                        <label>Photo d'identité</label>
                        <div class="photo-container">
                            <div class="photo-preview" id="photoPreview" 
                                 @if($member->photo) style="background-image: url('{{ $member->photo_url }}'); background-size: cover; background-position: center;" @endif>
                                @if(!$member->photo)
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="2" y="2" width="20" height="20" rx="2.18"></rect>
                                        <path d="M7 2v20M17 2v20M2 12h20M2 7h5M2 17h5M17 17h5M17 7h5"></path>
                                    </svg>
                                    <span>Aperçu</span>
                                @endif
                            </div>
                            <div class="photo-actions">
                                @if($member->photo)
                                    <div class="current-photo">
                                        <span class="photo-name">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="12" y1="18" x2="12" y2="12"></line>
                                                <line x1="9" y1="15" x2="15" y2="15"></line>
                                            </svg>
                                            {{ basename($member->photo) }}
                                        </span>
                                    </div>
                                @endif
                                <input type="file" name="photo" accept="image/*" id="photoInput" class="file-input">
                                <label for="photoInput" class="file-label">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M23 19v2a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-2"></path>
                                        <polyline points="16 2 12 6 8 2"></polyline>
                                        <line x1="12" y1="6" x2="12" y2="16"></line>
                                    </svg>
                                    @if($member->photo)
                                        Changer la photo
                                    @else
                                        Choisir un fichier
                                    @endif
                                </label>
                                <p class="file-hint">PNG, JPG ou JPEG (Max. 2 Mo)</p>
                            </div>
                        </div>
                        @error('photo')
                            <span class="error-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions du formulaire -->
            <div class="form-actions">
                <a href="{{ route('members.index') }}" class="btn btn-outline">
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
/* ===== VARIABLES - Avec votre vert conservé ===== */
:root {
    --green: #168a4a;
    --green-light: #1e9b54;
    --green-dark: #0f6a38;
    --green-soft: #e8f5e9;
    --blue: #2563eb;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    --white: #ffffff;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --shadow-green: 0 4px 14px 0 rgba(22, 138, 74, 0.2);
}

/* ===== CONTAINER PRINCIPAL ===== */
.members-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

/* ===== EN-TÊTE ===== */
.page-header {
    margin-bottom: 2.5rem;
    position: relative;
}

.header-content {
    position: relative;
    z-index: 2;
}

.page-title {
    font-size: 2rem;
    font-weight: 600;
    color: var(--gray-800);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.page-title .icon {
    width: 2rem;
    height: 2rem;
    color: var(--green);
}

.page-subtitle {
    color: var(--gray-500);
    font-size: 1rem;
    margin-left: 2.75rem;
}

.header-decoration {
    position: absolute;
    top: -1rem;
    right: 0;
    width: 18rem;
    height: 18rem;
    background: linear-gradient(135deg, var(--green-soft) 0%, transparent 100%);
    border-radius: 50%;
    filter: blur(60px);
    z-index: 1;
}

/* ===== BADGE ÉDITION ===== */
.form-badge {
    margin-bottom: 2rem;
}

.badge {
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

.badge svg {
    width: 1rem;
    height: 1rem;
}

/* ===== CARTE PRINCIPALE ===== */
.form-card {
    background: var(--white);
    border-radius: 1.5rem;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.modern-form {
    padding: 2.5rem;
}

/* ===== SECTIONS ===== */
.form-section {
    margin-bottom: 2.5rem;
    border-bottom: 1px solid var(--gray-200);
    padding-bottom: 2rem;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
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
    margin-bottom: 0.25rem;
}

.header-title p {
    font-size: 0.875rem;
    color: var(--gray-500);
}

/* ===== FORMULAIRES ===== */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
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
    color: #ef4444;
    margin-left: 0.25rem;
}

.input-group {
    position: relative;
}

.form-input,
.form-select,
.form-textarea {
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

.form-input:hover,
.form-select:hover,
.form-textarea:hover {
    border-color: var(--gray-300);
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    border-color: var(--green);
    box-shadow: 0 0 0 4px rgba(22, 138, 74, 0.1);
}

.form-input::placeholder,
.form-textarea::placeholder {
    color: var(--gray-400);
    font-size: 0.9rem;
}

.select-wrapper {
    position: relative;
}

.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1rem;
    padding-right: 2.5rem;
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

/* ===== PHOTO UPLOAD ===== */
.photo-upload {
    margin-top: 1rem;
}

.photo-container {
    display: flex;
    gap: 2rem;
    align-items: center;
    background: var(--gray-50);
    padding: 1.5rem;
    border-radius: 1rem;
    border: 2px dashed var(--gray-300);
}

.photo-preview {
    width: 100px;
    height: 100px;
    background: var(--white);
    border-radius: 0.75rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: var(--gray-400);
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.photo-preview svg {
    width: 2rem;
    height: 2rem;
}

.photo-preview span {
    font-size: 0.75rem;
    font-weight: 500;
}

.photo-actions {
    flex: 1;
}

.current-photo {
    margin-bottom: 1rem;
}

.photo-name {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--white);
    border: 1px solid var(--gray-300);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: var(--gray-700);
}

.photo-name svg {
    width: 1rem;
    height: 1rem;
    color: var(--green);
}

.file-input {
    display: none;
}

.file-label {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--white);
    color: var(--gray-700);
    font-size: 0.875rem;
    font-weight: 500;
    border: 2px solid var(--gray-300);
    border-radius: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.file-label:hover {
    border-color: var(--green);
    color: var(--green);
    background: var(--green-soft);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.file-label svg {
    width: 1.25rem;
    height: 1.25rem;
}

.file-hint {
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-top: 0.5rem;
}

/* ===== MESSAGES D'ERREUR ===== */
.error-feedback {
    display: block;
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.375rem;
    padding-left: 0.75rem;
    border-left: 2px solid #ef4444;
}

/* ===== BOUTONS ===== */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid var(--gray-200);
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
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-section {
    animation: slideUp 0.4s ease-out forwards;
    opacity: 0;
}

.form-section:nth-child(2) { animation-delay: 0.1s; }
.form-section:nth-child(3) { animation-delay: 0.2s; }
.form-section:nth-child(4) { animation-delay: 0.3s; }
.form-section:nth-child(5) { animation-delay: 0.4s; }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .members-container {
        margin: 1rem auto;
        padding: 0 1rem;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .page-subtitle {
        margin-left: 0;
    }

    .modern-form {
        padding: 1.5rem;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .photo-container {
        flex-direction: column;
        text-align: center;
    }

    .photo-preview {
        margin: 0 auto;
    }

    .file-label {
        width: 100%;
        justify-content: center;
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
    .modern-form {
        padding: 2rem;
    }
    
    .form-row {
        gap: 1rem;
    }
}
</style>

<script>
// Prévisualisation de la photo
document.getElementById('photoInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            showToast('Le fichier est trop volumineux. Taille maximum : 2 Mo', 'error');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.style.backgroundImage = `url('${e.target.result}')`;
            preview.style.backgroundSize = 'cover';
            preview.style.backgroundPosition = 'center';
            preview.innerHTML = '';
        }
        reader.readAsDataURL(file);
    }
});

// Confirmation avant annulation
document.querySelector('.btn-outline')?.addEventListener('click', function(e) {
    if (!confirm('Voulez-vous vraiment annuler les modifications ?')) {
        e.preventDefault();
    }
});
</script>
@endsection