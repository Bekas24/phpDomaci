<?php
    include './komponente/header.php';
?>
<div class="row">
    <div class="col-11">
        <h1 class="text-center">Knjige</h1>
    </div>
    <div class="col-1">
        <button data-toggle='modal' data-target='#exampleModal' class="form-control btn btn-primary">Kreiraj</button>
    </div>
</div>
<input id='pretraga' placeholder="Pretrazi..." class="form-control" type="text">
<table class="table mt-2">
    <thead>
        <tr>
            <th>ID</th>
            <th>Naziv</th>
            <th>Trajanje</th>
            <th>Pisac</th>
            <th>Zanr</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
        </tr>
    </thead>
    <tbody id='knjige'>

    </tbody>
</table>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Forma pisac</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="forma">
                    <div class="form-group">
                        <label for="naziv" class="col-form-label">Naziv</label>
                        <input required type="text" class="form-control" id="naziv">
                    </div>
                    <div class="form-group">
                        <label for="trajanje" class="col-form-label">Trajanje</label>
                        <input required type="number" class="form-control" id="trajanje">
                    </div>
                    <div class="form-group">
                        <label for="zanr" class="col-form-label">Zanr</label>
                        <select required type="number" class="form-control" id="zanr"></select>
                    </div>
                    <div class="form-group">
                        <label for="pisac" class="col-form-label">Pisac</label>
                        <select required type="number" class="form-control" id="pisac"></select>
                    </div>
                    <button type="submit" class="btn btn-primary form-control">Sacuvaj</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        let id = 0;
        let knjige = [];
        $(document).ready(function () {
            ucitaj();
            $('#pretraga').change(iscrtajTabelu);
            ucitajOpcije('zanr', 'zanr', e => e.naziv);
            ucitajOpcije('pisac', 'pisac', e => e.ime + ' ' + e.prezime);
            $('#exampleModal').on('show.bs.modal', function (e) {
                let dugme = $(e.relatedTarget);
                const odabraniId = dugme.data('id');
                const knjiga = knjige.find(e => e.id == odabraniId);
                if (!knjiga) {
                    id = 0;
                    $('#ime').val('');
                    $('#prezime').val('');
                    $('#godinaRodjenja').val('');
                } else {
                    id = odabraniId;
                    $('#ime').val(pisac.ime);
                    $('#prezime').val(pisac.prezime);
                    $('#godinaRodjenja').val(pisac.godinaRodjenja);
                }
            })
            $("#forma").submit(function (e) {
                e.preventDefault();
                let telo = {
                    naziv: $('#naziv').val(),
                    trajanje: $("#trajanje").val(),
                    zanr: $("#zanr").val(),
                    pisac: $("#pisac").val(),
                }
                if (id === 0) {
                    $.post('./api/knjiga/kreiraj.php', telo, function (res) {
                        res = JSON.parse(res);
                        if (!res.status) {
                            alert(res.error)
                            return;
                        }
                        knjige.push(res.data);
                        iscrtajTabelu();
                    })
                } else {
                    $.post('./api/knjiga/izmeni.php?id=' + id, telo, function (res) {
                        res = JSON.parse(res);
                        if (!res.status) {
                            alert(res.error)
                            return;
                        }
                        const index = knjige.findIndex(e => e.id == id);
                        knjige[index] = res.data;
                        iscrtajTabelu();
                    })
                }
            })
        })
        function ucitaj() {
            $.getJSON('./api/knjiga/ucitaj.php', function (res) {
                if (!res.status) {
                    alert(res.error)
                    return;
                }
                knjige = res.data;
                iscrtajTabelu();
            })
        }
        function iscrtajTabelu() {
            let pretraga = $('#pretraga').val();
            $('#knjige').html('');
            for (let knjiga of knjige) {
                if (knjiga.naziv.toLocaleLowerCase().includes(pretraga.toLocaleLowerCase())) {
                    $('#knjige').append(`
                    <tr>
                        <td>${knjiga.id}</td>
                        <td>${knjiga.naziv}</td>
                        <td>${knjiga.trajanje}</td>
                        <td>${knjiga.pisac.ime + ' ' + knjiga.pisac.prezime}</td>
                        <td>${knjiga.zanr.naziv}</td>
                        <td>
                            <button data-id=${knjiga.id} 
                                data-toggle='modal'
                                data-target='#exampleModal'
                                class="form-control btn" >Izmeni</button>
                        </td>
                        <td>
                            <button 
                                onClick="obrisi(${knjiga.id})"
                                class="form-control btn btn-danger" >Obrisi</button>
                        </td>
                    </tr>
                `)
                }
            }
        }
        function obrisi(selId) {
            $.post('./api/knjiga/obrisi.php?id=' + selId, function (res) {
                res = JSON.parse(res);
                if (!res.status) {
                    alert(res.data)
                } else {
                    knjige = knjige.filter(function (e) {
                        return e.id != selId;
                    })
                    id = 0;
                    iscrtajTabelu();
                }
            })
        }
        function ucitajOpcije(klasa, htmlId, fSadrzaj) {
            $.getJSON(`./api/${klasa}/ucitaj.php`, function (res) {
                if (!res.status) {
                    alert(res.error);
                    return;
                }
                for (let opcija of res.data) {
                    $('#' + htmlId).append(`
                        <option value='${opcija.id}'>
                            ${fSadrzaj(opcija)}
                        </option>
                    `)
                }
            })
        }
    </script>
    <?php
    include './komponente/footer.php';
?>