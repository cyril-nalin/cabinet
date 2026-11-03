function regCheckAndDo() {
    let ereg_btn = document.querySelector('#btn_reg');

    let ereg_err_msg = document.querySelector('#reg_err_msg');
    
    let snom = document.getElementById('nom').value.trim();
    let sprenom = document.getElementById('prenom').value.trim();
    let semail = document.getElementById('email').value.trim();
    let spassword = document.getElementById('password').value.trim();
    let sconfirmation = document.getElementById('confirmation').value.trim();

    //e.preventDefault();
    if(snom.length < 4 || sprenom.length < 4) {
        ereg_err_msg.textContent = 'Merci de vérifier que le nom et le prénom comportent au moins 4 caractères chacun.';
        return;
    }
    if(semail.length < 6) {
        ereg_err_msg.textContent = 'Merci de vérifier que l\'adresse e-mail comporte au moins 6 caractères.';
        return;
    }
    if(spassword.length < 8) {
        ereg_err_msg.textContent = 'Le mot de passe doit contenir au moins 8 caractères.'
        return;
    }
    if(spassword !== sconfirmation) {
        ereg_err_msg.textContent = 'Le mot de passe de confirmation ne correspond pas au mot de passe saisi.'
        return;
    }

    fetch('./models/Queries.php?q=reg', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify({
            nom: snom,
            prenom: sprenom,
            email: semail,
            password: spassword
        })
    })
    .then(a => a.text())
    .then(s => {
        if('1' === s) {
            alert("Merci, tu es inscrit! Temps de se connecter maintenant ;)");
            window.document.location.assign('index.php?page=login');
        } else if('2' === s){
            alert('Impossible de créer ce compte (' + semail + ') car il existe déjà.');
        } else {
            alert("Impossible de créer ce compte.");
        }
    })
    .catch(e => {
    })

}
