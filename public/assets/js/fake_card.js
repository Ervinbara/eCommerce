document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('payment-form');
    
    function formatCardNumber(value) {
        return value.replace(/\s/g, '').replace(/(\d{4})/g, '$1 ').trim();
    }

    // Fonction pour formater la date d'expiration (MM/YY)
    function formatExpiryDate(value) {
        value = value.replace(/\s/g, '').replace(/[^0-9]/g, ''); // Supprimer les espaces et autres caractères non numériques
    
        if (value.length > 2) {
            // Ajouter le séparateur '/' si la longueur est supérieure à 2
            return value.slice(0, 2) + '/' + value.slice(2);
        }
    
        return value; // Retourner la valeur inchangée si la longueur est <= 2
    }
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Vérifier si tous les champs sont remplis
        var name = document.getElementById('name').value;
        var cardNumber = document.getElementById('card-number').value;
        var expiryDate = document.getElementById('expiry-date').value;
        var cvc = document.getElementById('cvc').value;

        if (name && cardNumber && expiryDate && cvc) {
            // Afficher l'effet de traitement
            var processing = document.getElementById('processing');
            processing.style.display = 'block';

            // Désactiver le bouton de paiement
            var payButton = document.getElementById('pay-button');
            payButton.disabled = true;

            // Simulation du traitement (attente de 3 secondes)
            setTimeout(function() {
                // Masquer l'effet de traitement
                processing.style.display = 'none';

                // Afficher le message de succès
                var successMessage = document.getElementById('success-message');
                successMessage.style.display = 'block';

                // Redirection vers la page d'accueil
                setTimeout(function() {
                    window.location.href = "/"; // Mettez ici le chemin de votre page d'accueil si ce n'est pas la racine
                }, 2000); // Redirige après 3 secondes (3000 millisecondes)
            }, 3000);
        }
    });

    document.getElementById('card-number').addEventListener('input', function(event) {
        this.value = formatCardNumber(this.value);
    });

    document.getElementById('expiry-date').addEventListener('input', function(event) {
        this.value = formatExpiryDate(this.value);
    });
});
