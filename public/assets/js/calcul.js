// Lorsque le contenu de la page est entièrement chargé, cet événement s'exécute
document.addEventListener('DOMContentLoaded', function() {

    // Récupère les éléments input correspondants
    const prixHTInput = document.getElementById('materiel_prix_ht'); 
    const prixTTCInput = document.getElementById('materiel_prix_ttc'); 
    const tvaSelect = document.getElementById('materiel_tva');

    // Fonction pour recalculer les prix en fonction du taux de TVA et des valeurs HT et TTC
    function calculPrix() {
        // Récupère la valeur du prix HT (convertie en nombre), ou 0 si elle est vide ou invalide
        const prixHT = parseFloat(prixHTInput.value) || 0;

        // Récupère la valeur du prix TTC (convertie en nombre), ou 0 si elle est vide ou invalide
        const prixTTC = parseFloat(prixTTCInput.value) || 0;

        // Récupère le taux de TVA sélectionné (converti en nombre), ou 0 si le taux est vide ou invalide
        const tva = parseFloat(tvaSelect.options[tvaSelect.selectedIndex].textContent) || 0;

        // Si l'utilisateur modifie le champ prix HT ou le taux de TVA, recalculer le prix TTC
        if (document.activeElement === prixHTInput || document.activeElement === tvaSelect) {
            prixTTCInput.value = (prixHT * (1 + tva)).toFixed(2);
        }

        // Si l'utilisateur modifie directement le prix TTC, recalculer le prix HT
        if (document.activeElement === prixTTCInput) {
            prixHTInput.value = (prixTTC / (1 + tva)).toFixed(2);
        }
    }

    // Ecouteurs d'événements pour recalculer les prix lorsque l'utilisateur modifie les champs HT, TTC ou le taux de TVA
    prixHTInput.addEventListener('input', calculPrix);
    prixTTCInput.addEventListener('input', calculPrix);
    tvaSelect.addEventListener('change', calculPrix);
});
