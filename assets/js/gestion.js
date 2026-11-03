async function runGetRdvsDatas() {
    let dst = document.getElementById('block_gest');

    fetch('./models/Queries.php?q=get_rdvs')
    .then(resp => resp.json())
    .then(datas => {
        let typeSoins = ['CONSULT', 'DETARTRAGE', 'CARIE', 'DEVITALISATION', 'PROTHESE', 'URGENCE', 'AUTRE'];
        let typeSoinsStr = ['Consultation', 'Détartrage', 'Carie', 'Dévitalisation', 'Prothèse', 'Urgence dentaire', 'Autre'];
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

            tmp = document.createElement('div');
            tmp.classList.add('rdv_block_personal_name');
            enom.textContent = rdv.nom;
            blk.appendChild(enom);
            eprenom.textContent = rdv.prenom;
            tmp.appendChild(enom);
            tmp.appendChild(eprenom);
            blk.appendChild(tmp);

            tmp = document.createElement('div');
            tmp.classList.add('rdv_block_personal_email');
            eemail.textContent = rdv.email;
            tmp.appendChild(eemail);
            blk.appendChild(tmp);
            erdv.appendChild(blk);

            //Données RDV modifiable
            blk = document.createElement('div');
            blk.classList.add('rdv_block_editable');
            edate_rdv.setAttribute('type', 'text');

            edate_rdv.value = rdv.date_rdv;
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
            btn_edit.value = 'Appliquer les modifications';
            btn_edit.addEventListener('click', e => {
                const regex = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;
                if(!regex.test(edate_rdv.value)) {
                    alert('Date invalide (' + edate_rdv.value + '), format demandé: AAAA/MM/JJ hh:mm:ss');
                } else {
                    /*dte = new Date(edate_rdv.value);
                    console.log( dte.toISOString() );
                    console.log( dte.toString() );
                    console.log( dte.toString() );*/
                    fetch('./models/Queries.php?q=upd_rdvs', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: rdv.id,
                            date_rdv: edate_rdv.value,
                            type_soin: etype_soin.value,
                            confirm: econfirm.value
                        })
                    })
                    .then(r => r.text())
                    .then(data => {

                        if('1' === data) {
                            alert("Modification faite!");
                            if(econfirm.value === '1') {
                                erdv.classList.remove('rdv_not_confirmed');
                                erdv.classList.add('rdv_confirmed');
                            } else {
                                erdv.classList.remove('rdv_confirmed');
                                erdv.classList.add('rdv_not_confirmed');
                            }
                        } else {
                            alert("Aucune modification faite!");
                        }
                    });
                    
                }
            });
            blk.appendChild(btn_edit);

            btn_del.setAttribute('type', 'button');
            btn_del.value = 'Supprimer';
            btn_del.addEventListener('click', e => {
                if(confirm("Voulez-vous vraiment supprimer ce rendez-vous?")) {
                    fetch('./models/Queries.php?q=del_rdvs', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: rdv.id
                        })
                    })
                    .then(r => r.text())
                    .then(data => {
                        if('1' === data) {
                            alert("RDV supprimé!");
                            //erdv.classList.add('hidden_block');
                            erdv.style.display = 'none';
                        } else {
                            alert("Aucune modification faite!");
                        }
                    });
                }
            });
            blk.appendChild(btn_del);

            if(rdv.confirm) {
                erdv.classList.add('rdv_confirmed');
            } else {
                erdv.classList.add('rdv_not_confirmed');
            }
            erdv.appendChild(blk);

            dst.appendChild(erdv);
        });
    })

    
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

function runPersonnelDatas() {
    fetch('./models/Queries.php?q=getall_person')
    .then(resp => resp.json())
    .then(datas => {
        datas.forEach(pers => {
            let block = document.createElement('div');
            let enom = document.createElement('input');
            let eprenom = document.createElement('input');
            let eemail = document.createElement('input');
            let btn_edit = document.createElement('input');
            let btn_del = document.createElement('input');
            
            enom.value = pers.nom;
            enom.type = 'text';
            eprenom.value = pers.prenom;
            eprenom.type = 'text';
            eemail.type = 'text';
            eemail.value = pers.email;
            
            btn_edit.type = 'button';
            btn_edit.value = 'Modifier';
            btn_edit.addEventListener('click', e => {
                if(confirm("Voulez-vous vraiment modifier ce personnel?")) {
                        fetch('./models/Queries.php?q=upd_person', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: pers.id,
                                nom: enom.value,
                                prenom: eprenom.value,
                                email: eemail.value
                            })
                        })
                        .then(r => r.text())
                        .then(data => {
                            if('1' === data) {
                                alert("Personnel modifié!");
                            } else {
                                alert("Aucune modification faite!");
                            }
                        });
                    }
                });


            btn_del.type = 'button';
            btn_del.value = 'Supprimer';
            btn_del.addEventListener('click', e => {
                if(confirm("Voulez-vous vraiment supprimer ce personnel?")) {
                        fetch('./models/Queries.php?q=del_person', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: pers.id
                            })
                        })
                        .then(r => r.text())
                        .then(data => {
                            if('1' === data) {
                                alert("Personnel supprimé!");
                                block.style.display = 'none';
                            } else {
                                alert("Aucune modification faite!");
                            }
                        });
                    }
                });

            block.appendChild(enom);
            block.classList.add('person_block');
            block.appendChild(eprenom);
            block.appendChild(eemail);
            block.appendChild(btn_edit);
            block.appendChild(btn_del);
            document.getElementById('block_gest').appendChild(block);
        });
    })
    .catch(e => {
        console.error(e);
    });
}

function runNewsDatas() {
    fetch('./models/Queries.php?q=getall_news')
    .then(resp => resp.json())
    .then(datas => {
        datas.forEach(news => {
            let block = document.createElement('div');
            let subblock = document.createElement('div');
            let etitre = document.createElement('input');
            let econtent = document.createElement('textarea');
            let edate = document.createElement('div');
            let emediablock = document.createElement('div');
            let emediaimg = document.createElement('img');
            let evisible = document.createElement('input');
            let btn_edit = document.createElement('input');
            let btn_del = document.createElement('input');
            let label = document.createElement('label');
            
            
            etitre.value = news.titre;
            econtent.textContent = news.contenu;
            edate.textContent = news.date_news;
            label.textContent = 'Visible';
            label.htmlFor = 'visible_' + news.id;
            evisible.type = 'checkbox';
            evisible.id = 'visible_' + news.id;
            evisible.checked = news.visible ? true : false;

            block.classList.add('news_block');

            btn_edit.type = 'button';
            btn_edit.value = 'Modifier';
            btn_edit.addEventListener('click', e => {
                if(confirm("Voulez-vous vraiment modifier cette news?")) {
                        fetch('./models/Queries.php?q=upd_news', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id:news.id,
                                titre: etitre.value,
                                contenu: econtent.value,
                                lien_media: news.lien_media,
                                visible: evisible.checked
                            })
                        })
                        .then(r => r.text())
                        .then(data => {
                            if('1' === data) {
                                alert("News modifiée!");
                            } else {
                                alert("Aucune modification faite!");
                            }
                        });
                    }
                });


            btn_del.type = 'button';
            btn_del.value = 'Supprimer';
            btn_del.addEventListener('click', e => {
                if(confirm("Voulez-vous vraiment supprimer cette news?")) {
                        fetch('./models/Queries.php?q=del_news', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: news.id
                            })
                        })
                        .then(r => r.text())
                        .then(data => {
                            if('1' === data) {
                                alert("News supprimée!");
                                block.style.display = 'none';
                            } else {
                                alert("Aucune modification faite!");
                            }
                        });
                    }
                });

            subblock.classList.add('news_subblock_top');
            subblock.appendChild(etitre);
            subblock.appendChild(econtent);

            if(news.lien_media) {
                emediaimg.src = news.lien_media;
                emediaimg.alt = "image " + news.lien_media;
                emediablock.appendChild(emediaimg);
                subblock.appendChild(emediablock);
            }


            subblock.appendChild(edate);
            block.appendChild(subblock);

            subblock = document.createElement('div');
            subblock.classList.add('news_subblock_bottom');
            subblock.appendChild(label);
            subblock.appendChild(evisible);

            subblock.appendChild(btn_edit);
            subblock.appendChild(btn_del);
            block.appendChild(subblock);
            document.getElementById('block_gest_news').appendChild(block);
        });
    })
    .catch(e => {
        console.error(e);
    });
}