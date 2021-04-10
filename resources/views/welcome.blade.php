<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet"> -->

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .content {
            width: 80%;
            margin: auto;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        /*modal*/
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="content">
        <h2>Family</h2>
        <button type="button" onclick="showModal(this)">Tambah</button>
        <br>
        <br>
        <table id="table-content">
            <thead>
                <tr>
                    <th>Aksi</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tingkat</th>
                    <th>Orang Tua</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="myForm" name="myForm">
                    <label for="nama">Nama:</label><br>
                    <input type="text" id="nama" name="nama" placeholder="Nama"><br>
                    <br>
                    <label>Jenis Kelamin:</label><br>
                    <input type="radio" id="male" name="jenis_kelamin" value="L" checked>
                    <label for="male">Laki-laki</label><br>
                    <input type="radio" id="female" name="jenis_kelamin" value="P">
                    <label for="female">Wanita</label><br>
                    <br>
                    <label for="orang_tua">Orang Tua:</label><br>
                    <select name="orang_tua" id="orang_tua_list">
                       <option value="">Pilih Orang Tua</option>
                    </select>
                    <br>
                    <br>

                    <label>Tingkat:</label><br>
                    <input type="radio" id="anak" name="tingkat" value="1" checked>
                    <label for="anak">Anak</label><br>
                    <input type="radio" id="cucu" name="tingkat" value="2">
                    <label for="cucu">Cucu</label><br>
                    <br>
                    <input type="button" onclick="simpan()" value="Simpan">
                </form>
            </div>

        </div>
    </div>
</body>
<script type="text/javascript">

    const url = '{{url("api/anggota")}}';
    const modal = document.getElementById("myModal");
    const span = document.getElementsByClassName("close")[0];

    let getUrlSimpan = null;

    const c = ((s) => console.log(s));

    function setUrlSimpan(id = null) {
        if (id) {
            return `${url}/${id}`;
        }
        return `${url}`;
    }

    function setOrangTuaList() {
        let selectElement = document.getElementById('orang_tua_list');

        fetchMembers().then(members => {
          members.data.map((member) => {
            selectElement.add(new Option(member.nama, member.id));
          });
        });
    }

    function showModal(target) {
        document.getElementById("myForm").reset();
        setOrangTuaList();
        modal.style.display = "block";
        if (target.tagName !== "BUTTON") {
            getUrlSimpan = setUrlSimpan(target.getAttribute("id-member"));
            fetch(`${url}/${target.getAttribute("id-member")}`).then(function (response) {
                return response.json();
            })
                .then(function (data) {
                    document.myForm.nama.value = data.data.nama;
                    document.myForm.jenis_kelamin.value = data.data.jenis_kelamin;
                    document.myForm.tingkat.value = data.data.tingkat;
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }

    function getFormValue() {
        return JSON.stringify({
            nama: document.querySelector('[name="nama"]').value,
            jenis_kelamin: document.querySelector('[name="jenis_kelamin"]').value,
            tingkat: document.querySelector('[name="tingkat"]').value,
            nama: document.myForm.nama.value,
            jenis_kelamin: document.myForm.jenis_kelamin.value,
            tingkat: document.myForm.tingkat.value
        });
    }

    function simpan(body) {
        if (getUrlSimpan) {
            fetch(getUrlSimpan, {
                method: 'PUT',
                body: getFormValue(),
                headers: {
                    'Content-type': 'application/json; charset=UTF-8'
                }
            }).then(function (response) {
                if (response.status === 200) {
                    alert('Sukses')
                    modal.style.display = "none";
                    return response.json();
                }
                return Promise.reject(response);
            }).then(function (response) {
                getUrlSimpan = null;
                loadPage();
            }).catch(function (error) {
                console.warn('Something went wrong.', error);
            });
        } else {
            fetch(url, {
                method: 'POST',
                body: getFormValue(),
                headers: {
                    'Content-type': 'application/json; charset=UTF-8'
                }
            }).then(function (response) {
                if (response.status === 201) {
                    alert('Sukses')
                    modal.style.display = "none";
                    return response.json();
                }
                return Promise.reject(response);
            }).then(function (response) {
                getUrlSimpan = null
                loadPage();
            }).catch(function (error) {
                console.warn('Something went wrong.', error);
            });
        }
    }

    function deleteMember(target) {
        let isConfirm = false;
        if (confirm("Yakin akan menghapus data!")) {
            isConfirm = true;
        }
        if (isConfirm) {

            getUrlSimpan = setUrlSimpan(target.getAttribute("id-member"));
            fetch(getUrlSimpan, {
                method: 'DELETE',
                headers: {
                    'Content-type': 'application/json; charset=UTF-8'
                }
            }).then(function (data) {
                alert('Behasil Hapus');
                loadPage();
            })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
    function tableCreate(data) {
        let table = document.getElementById('table-content').getElementsByTagName('tbody')[0];
        table.innerHTML = '';
        for (var i = 0; i < data.length; i++) {
            var tr = table.insertRow();
            Object.keys(data[i]).map(item => {
                var td = tr.insertCell();
                if (item === 'id') {
                    var a = document.createElement('a');
                    var linkText = document.createTextNode('update');
                    a.appendChild(linkText);
                    a.setAttribute("id", "member");
                    a.setAttribute("id-member", data[i][item]);
                    a.setAttribute("action-name", 'update');
                    a.setAttribute('onclick', 'showModal(this);')
                    a.href = "#";
                    td.appendChild(a);

                    td.appendChild(document.createTextNode('\u00A0'));

                    var b = document.createElement('a');
                    var linkText = document.createTextNode('delete');
                    b.appendChild(linkText);
                    b.setAttribute("id", "member");
                    b.setAttribute("action-name", 'delete');
                    b.setAttribute('onclick', 'deleteMember(this);')
                    b.setAttribute("id-member", data[i][item]);
                    b.href = "#";

                    td.appendChild(b);
                } else {
                    td.appendChild(document.createTextNode(data[i][item]));
                }
            });
        }
    }

    async function fetchMembers() {
        const response = await fetch(url);
        if (!response.ok) {
            const message = `An error has occured: ${response.status}`;
            throw new Error(message);
        }
        const members = await response.json();
        return members;
    }

    function loadPage() {
        fetchMembers().then(members => {
          tableCreate(members.data)
        });
    }

    loadPage();

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    span.onclick = function () {
        modal.style.display = "none";
    }

</script>

</html>