document.querySelectorAll('.sidebar li').forEach(li => {
  li.addEventListener('click', function() {
    // 1. Retirer la classe 'active' de tous les boutons
    document.querySelectorAll('.sidebar li').forEach(btn => {
      btn.classList.remove('active');
    });

    // 2. Ajouter la classe 'active' au bouton cliqué
    this.classList.add('active');

    // 3. (Optionnel) Changer le contenu ou la page en fonction du data-target
    const target = this.getAttribute('data-target');
    console.log('Cliqué sur : ' + target);
    // Ici, vous pouvez ajouter du code pour afficher/cacher des sections, etc.
  });
});