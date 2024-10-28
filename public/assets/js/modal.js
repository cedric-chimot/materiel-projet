// Lorsque le contenu de la page est entièrement chargé, cet événement s'exécute
document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('materielModal');
    modal.addEventListener('show.bs.modal', event => {
        // Récupérer la ligne sur laquelle on a cliqué
        const button = event.relatedTarget; 
        
        // Récupérer les données depuis le bouton
        const id = button.getAttribute('data-id');

        // On active le bouton de modification pour ce matériel en modifiant le href
        document.getElementById('modifierBtn').href = `/materiel/${id}/edit`;
        
        // Ici, on fait une requête pour récupérer les détails du matériel
        fetch(`/materiel/detail/${id}`)
            .then(response => response.text())
            .then(html => {
                // Mettre à jour le contenu de la modale avec le HTML récupéré
                modal.querySelector('#modalContent').innerHTML = html;
            })
            .catch(error => console.error('Erreur:', error));
    });

});
