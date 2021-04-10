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
        /*modal end*/
    </style>
</head>

<body>

    <div class="content">
        <h2>Anggota Keluarga</h2>
        <button type="button" onclick="showModal(this)">Tambah</button>
        <br>
        <br>

        <div class="wrapper">
            <svg class="graph" id="tree-diagram" width="400" height="200" viewBox="0 0 400 240">
                <g transform="translate(10,20)">
                    <g class="links"></g>
                    <g class="nodes"></g>
                </g>
            </svg>
        </div>
        <br>
        <br>

        <table id="table-content">
            <thead>
                <tr>
                    <th>Aksi</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
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
                    <select name="id_orang_tua" id="orang_tua_list">
                    </select>
                    <br>
                    <br>

                    <input type="button" onclick="simpan()" value="Simpan">
                </form>
            </div>

        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/d3.js') }}"></script>
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

    function treeCreate(members) {
        d3.select("#tree-diagram").select("svg").remove();

        const idMapping = members.reduce((acc, el, i) => {
            acc[el.id] = i;
            return acc;
        }, {});

        let data;
        members.forEach(el => {
          if (!el.id_orang_tua) {
            data = el;
            return;
          }
          const parentEl = members[idMapping[el.id_orang_tua]];
          parentEl.children = [...(parentEl.children || []), el];
        });

        let root = d3.hierarchy(data);

        let treeLayout = d3.tree()
        treeLayout.size([400,200]);
        treeLayout(root);

        let tree = d3.select('#tree-diagram g.nodes')

        let treeNodes = tree.selectAll('g.node')
          .data(root.descendants())
          .enter()
          .append('g')
          .classed('node', true)
          

        treeNodes.append('circle')
            .classed('the-node solid', true)
            .attr('cx', d=> d.x)
            .attr('cy', d=> d.y)
            .attr('r', d => 20)
            .attr("fill", function(d) { return (d.data.jenis_kelamin == "L" ? "blue" : "red"); });


        treeNodes.append('text')
          .attr('dx', d => d.x)
          .attr('dy', d => d.y+4)
          .text(d => d.data.nama)

        let treeLinks = d3.select('#tree-diagram g.links')
          .selectAll('line.link')
          .data(root.links())
          .enter()
          .append('line')
          .classed('link', true)
          .attr("x1", d => d.source.x)
          .attr("y1", d => d.source.y)
          .attr("x2", d => d.target.x)
          .attr("y2", d => d.target.y)
          .style("stroke", "Black")

    }

    function setOrangTuaList() {
        let selectElement = document.getElementById('orang_tua_list');
        selectElement.innerHTML = '';
        fetchMembers(url).then(members => {
            members.map((member) => {
                selectElement.add(new Option(member.nama, member.id));
            });
        });
    }

    function showModal(target) {
        document.getElementById("myForm").reset();        
        modal.style.display = "block";
        setOrangTuaList()
        if (target.tagName !== "BUTTON") {
            getUrlSimpan = setUrlSimpan(target.getAttribute("id-member"));
            fetchSingleMember(target.getAttribute("id-member")).then(member => {
                setFormValue(member);
            });
        }
    }

    function getFormValue() {
        return JSON.stringify({
            nama: document.myForm.nama.value,
            jenis_kelamin: document.myForm.jenis_kelamin.value,
            id_orang_tua: document.myForm.id_orang_tua.value,
        });
    }

    function setFormValue(member) {
        document.myForm.nama.value = member.nama;
        document.myForm.jenis_kelamin.value = member.jenis_kelamin;
        document.myForm.id_orang_tua.value = member.id_orang_tua;
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
            }).then(function (response) {
                if (response.ok) {
                    return true;
                } else {
                    throw new Error('Tidak bisa menghapus, mempunyai anak');
                }
            })
            .then((responseJson) => {
                alert('Behasil Hapus');
                loadPage();
            })
            .catch((error) => {
              alert(error)
            });
        }
    }

    function tableCreate(members) {
        let table = document.getElementById('table-content').getElementsByTagName('tbody')[0];
        table.innerHTML = '';
        for (var i = 0; i < members.length; i++) {
            var tr = table.insertRow();
            Object.keys(members[i]).map(item => {
                if (item != 'id_orang_tua') {
                    var td = tr.insertCell();
                    if (item === 'id') {
                        var a = document.createElement('a');
                        var linkText = document.createTextNode('update');
                        a.appendChild(linkText);
                        a.setAttribute("id", "member");
                        a.setAttribute("id-member", members[i][item]);
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
                        b.setAttribute("id-member", members[i][item]);
                        b.href = "#";

                        td.appendChild(b);
                    } else {
                        td.appendChild(document.createTextNode(members[i][item]));
                    }
                }
            });
        }
    }

    async function fetchMembers(url) {
        const response = await fetch(url);
        if (!response.ok) {
            const message = `An error has occured: ${response.status}`;
            throw new Error(message);
        }
        const members = await response.json();
        return members.data;
    }

    async function fetchSingleMember(id_member) {
        const response = await fetch(`${url}/${id_member}`);
        if (!response.ok) {
            const message = `An error has occured: ${response.status}`;
            throw new Error(message);
        }
        const member = await response.json();
        return member.data;
    }

    function loadPage() {
        fetchMembers(url).then(members => {
            tableCreate(members)
            treeCreate(members)
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