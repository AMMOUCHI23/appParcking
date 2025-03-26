
/**
 * Valide un champ texte.
 * @param {string} fieldId - L'ID du champ à valider.
 * @param {string} regex - L'expression régulière pour valider le contenu du champ (si vide, aucune validation regex).
 * @param {number} isRequired - 1 si le champ est requis, 0 sinon.
 * @returns {boolean} - True si la validation passe, false sinon.
 */
console.log("je suis appelé");
function checkFormTexte(fieldId, regex, isRequired) {
    const field = document.getElementById(fieldId);
    const value = field.value.trim(); // Récupère et nettoie la valeur

    // Vérifie si le champ est requis et vide
    if (isRequired && value === "") {
        displayError(fieldId, "Ce champ est requis."); // Affiche une erreur
        return false;
    }

    // Vérifie si une regex est fournie et si la valeur ne correspond pas
    if (regex && !new RegExp(regex).test(value)) {
        displayError(fieldId, "Le format du champ est incorrect."); // Affiche une erreur
        return false;
    }

    // Supprime les erreurs si tout est correct
    removeError(fieldId);
    return true;
}

/**
 * Affiche un message d'erreur pour un champ spécifique.
 * @param {string} fieldId - L'ID du champ.
 * @param {string} message - Le message d'erreur à afficher.
 */
function displayError(fieldId, message) {
    const errorElement = document.getElementById(fieldId + "Erreur");
    if (errorElement) {
        errorElement.textContent = message; // Affiche le message d'erreur
        errorElement.style.color = "red";
    }
}

/**
 * Supprime le message d'erreur pour un champ spécifique.
 * @param {string} fieldId - L'ID du champ.
 */
function removeError(fieldId) {
    const errorElement = document.getElementById(fieldId + "Erreur");
    if (errorElement) {
        errorElement.textContent = ""; // Supprime le message d'erreur
    }
}

