async function runGetRdvsDatas(dstId) {
    let dst = document.getElementById(dstId);

    if(null === dst) return false;

    try {
        let resp = await fetch('./models/Queries.php?q=get_rdvs');
        if(200 === resp.status && true === resp.ok) {
            const len = Number(resp.headers.get('content-length'));
            if(0 !== len) {
                datas = await resp.json();
                let typeSoins = ['CONSULT', 'DETARTRAGE', 'CARIE', 'DEVITALISATION', 'PROTHESE'];
                let typeSoinsStr = ['Consultation', 'Détartrage', 'Carie', 'Dévitalisation', 'Prothèse'];
                let confirmValues = [0, 1];
                let confirmValuesStr = ['A confirmer', 'Confirmé'];
                datas.forEach(rdv => {
                    let erdv = document.createElement('div');
                    let edate_rdv = document.createElement('input');
                    let etype_soin = document.createElement('select');
                    let econfirm = document.createElement('select');
                    let enom = document.createElement('div');
                    let eprenom = document.createElement('div');
                    let eemail = document.createElement('div');
                    let btn_edit = document.createElement('input');
                    let btn_del = document.createElement('input');
                    let i, tmp, blk, dte;
                    
                    erdv.classList.add('rdv_block');

                    //Données perso, lecture seule
                    blk = document.createElement('div');
                    blk.classList.add('rdv_block_personal');
                    enom.textContent = rdv.nom;
                    blk.appendChild(enom);
                    eprenom.textContent = rdv.prenom;
                    blk.appendChild(eprenom);
                    eemail.textContent = rdv.email;
                    blk.appendChild(eemail);
                    erdv.appendChild(blk);

                    //Données RDV modifiable
                    blk = document.createElement('div');
                    blk.classList.add('rdv_block_editable');
                    edate_rdv.setAttribute('type', 'text');

                    dte = new Date(rdv.date_rdv);
                    edate_rdv.value = dte.toLocaleString();
                    blk.appendChild(edate_rdv);

                    i = 0;
                    typeSoins.forEach(val => {
                        tmp = document.createElement('option');
                        tmp.value = val;
                        tmp.textContent = typeSoinsStr[i++];
                        etype_soin.appendChild(tmp);
                    });
                    i = typeSoins.indexOf(rdv.type_soin);
                    if(-1 === i) i = 0;
                    etype_soin.selectedIndex = i;
                    blk.appendChild(etype_soin);

                    i = 0;
                    confirmValues.forEach(val => {
                        tmp = document.createElement('option');
                        tmp.value = val;
                        tmp.textContent = confirmValuesStr[i++];
                        econfirm.appendChild(tmp);
                    });
                    econfirm.selectedIndex = rdv.confirm ? 1 : 0;
                    blk.appendChild(econfirm);
                    erdv.appendChild(blk);

                    //Boutons
                    blk = document.createElement('div');
                    blk.classList.add('rdv_block_btns');
                    btn_edit.setAttribute('type', 'button');
                    btn_edit.value = 'Modifier';
                    btn_edit.addEventListener('click', e => {
                        const regex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4} \d{2}:\d{2}:\d{2}$/;
                        if(!regex.test(edate_rdv.value)) {
                            alert('Date invalide (' + edate_rdv.value + '), format demandé: JJ/MM/AAAA hh:mm:ss');
                        }
                    });
                    blk.appendChild(btn_edit);

                    btn_del.setAttribute('type', 'button');
                    btn_del.value = 'Supprimer';
                    btn_del.addEventListener('click', e => {

                    });
                    blk.appendChild(btn_del);


                    erdv.appendChild(blk);

                    dst.appendChild(erdv);

/*{
    "id": 1,
    "client_id": 8,
    "date_rdv": "2027-11-02 10:00:00",
    "type_soin": "CONSULT",
    "nom": "Martin",
    "prenom": "Lucas",
    "email": "lucas.martin@gmail.com"
}*/

                });
            }
        }

    }
    catch(e) {
        console.error(e);
    }
    
    /*.then(resp => resp.json())
    .then(datas => {
        console.log(datas);
        datas.forEach(rdv => {

            console.log(rdv.nom);
        });
    })
    .catch(e => {
        console.error(e);
    })*/
}
