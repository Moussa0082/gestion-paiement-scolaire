



// Obtenez une référence à l'élément de champ de recherche
var searchInput = document.getElementById('searchInput');

// Obtenez une référence au tableau
var studentTable = document.getElementById('studentTable');

// Ajoutez un gestionnaire d'événements pour détecter les modifications de l'entrée de recherche
searchInput.addEventListener('input', function () {
    var searchValue = searchInput.value.trim().toLowerCase();

   

    // Parcourez les lignes du tableau et masquez celles qui ne correspondent pas à la recherche
    var rows = studentTable.querySelectorAll('tbody tr');
    rows.forEach(function (row) {
        var shouldShowRow = false;
        var cells = row.querySelectorAll('td');
        cells.forEach(function (cell) {
            var cellText = cell.textContent.toLowerCase();
            if (cellText.includes(searchValue)) {
                shouldShowRow = true;
            }
        });
        if (shouldShowRow || row.querySelector('th')) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});



