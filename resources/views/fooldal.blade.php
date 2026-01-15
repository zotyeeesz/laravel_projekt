<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal - Költség Követő</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #667eea;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
        }
        .logout-btn {
            background-color: #d32f2f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .logout-btn:hover {
            background-color: #b71c1c;
        }
        .container {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h2 {
            color: #333;
        }
        .add-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
        .add-btn:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #667eea;
            color: white;
        }
        table tr:hover {
            background-color: #f5f5f5;
        }
        .no-data {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            color: #666;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        .modal.show {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 500px;
        }
        .close-btn {
            float: right;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
            line-height: 20px;
        }
        .close-btn:hover {
            color: #000;
        }
        .modal h2 {
            margin-top: 0;
            color: #333;
        }
        .modal form input, .modal form textarea {
            display: block;
            width: 100%;
            margin: 15px 0;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        .modal form input:focus, .modal form textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        .modal form textarea {
            resize: vertical;
            min-height: 80px;
        }
        .modal form button {
            width: 100%;
            padding: 12px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }
        .modal form button:hover {
            background-color: #5568d3;
        }
        .kategoria-input-wrapper {
            position: relative;
            margin: 15px 0;
        }
        .kategoria-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .kategoria-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        .kategoria-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .kategoria-list.show {
            display: block;
        }
        .kategoria-item {
            padding: 10px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        .kategoria-item:hover {
            background-color: #f0f0f0;
        }
        .kategoria-item:last-child {
            border-bottom: none;
        }
    </style>
    <script>
        function openModal() {
            document.getElementById('koltsegModal').classList.add('show');
            // Reset kategória input
            document.getElementById('kategoria_input').value = '';
            document.getElementById('kategoria_selected').value = '';
        }
        
        function closeModal() {
            document.getElementById('koltsegModal').classList.remove('show');
        }
        //Kategória filter
        function filterKategoriak() {
            const input = document.getElementById('kategoria_input').value.toLowerCase();
            const list = document.getElementById('kategoria_list');
            const items = list.querySelectorAll('.kategoria-item');
            
            if (input.length > 0) {
                list.classList.add('show');
            } else {
                list.classList.remove('show');
            }
            
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(input)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        //Kategória kiválasztás
        function selectKategoria(nev) {
            document.getElementById('kategoria_input').value = nev;
            document.getElementById('kategoria_selected').value = nev;
            document.getElementById('kategoria_list').classList.remove('show');
        }
        
        // Kilépés a listából kívülre
        document.addEventListener('click', function(event) {
            const wrapper = document.getElementById('kategoria_wrapper');
            const list = document.getElementById('kategoria_list');
            
            if (wrapper && !wrapper.contains(event.target)) {
                list.classList.remove('show');
            }
        });
        
        window.onclick = function(event) {
            const modal = document.getElementById('koltsegModal');
            if (event.target == modal) {
                modal.classList.remove('show');
            }
        }
        // Kilépés a listából kívülre
        document.addEventListener('click', function(event) {
            const wrapper = document.getElementById('penznem_wrapper');
            const list = document.getElementById('penznem_list');
            
            if (wrapper && !wrapper.contains(event.target)) {
                list.classList.remove('show');
            }
        });
        //Pénznem filter
        function filterPenznemek() {
            const input = document.getElementById('penznem_input').value.toUpperCase();
            const list = document.getElementById('penznem_list');
            const items = list.querySelectorAll('.penznem-item');
            
            if (input.length > 0) {
                list.classList.add('show');
            } else {
                list.classList.remove('show');
            }
            
            items.forEach(item => {
                const text = item.textContent.toUpperCase();
                if (text.includes(input)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        //Pénznem kiválasztás
        function selectPenznem(nev) {
            document.getElementById('penznem_input').value = nev;
            document.getElementById('penznem_selected').value = nev;
            document.getElementById('penznem_list').classList.remove('show');
        }
    </script>
</head>
<body>
    <div class="header">
        <div>
            <h1>Költség Követő</h1>
            <h2>Üdvözlünk, {{ session('user')->nev }}!</h2>
        </div>
        <a href="/logout" class="logout-btn">Kijelentkezés</a>
    </div>
    
    <div class="container">
        <button onclick="openModal()" class="add-btn">+ Új Költség</button>
        
        @if($koltes->count() > 0)
            <table>
                <tr>
                    <th>Dátum</th>
                    <th>Kategória</th>
                    <th>Összeg</th>
                    <th>Leírás</th>
                </tr>
                @foreach($koltes as $item)
                    <tr>
                        <td>{{ $item->rogzites }}</td>
                        <td>
                            @if($item->kategoria)
                                {{ $item->kategoria->nev }}
                            @else
                                -
                            @endif
                        </td>
                        <td><strong>{{ $item->osszeg }}</strong> Ft</td>
                        <td>{{ $item->megjegyzes }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="no-data">
                <p>Még nincsenek költségeid. <button onclick="openModal()" style="background: none; border: none; color: #667eea; cursor: pointer; text-decoration: underline;">Hozzáadj egyet!</button></p>
            </div>
        @endif
    </div>
    
    <!-- Modal -->
    <div id="koltsegModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Új Költség Hozzáadása</h2>
            
            <form action="/koltseg/add" method="POST">
                @csrf
                <!--Kategória-->
                <div class="kategoria-input-wrapper" id="kategoria_wrapper">
                    <input type="text" id="kategoria_input" placeholder="Kategória"
                           oninput="filterKategoriak()" onclick="document.getElementById('kategoria_list').classList.add('show')">
                    <div id="kategoria_list" class="kategoria-list">                        
                        @foreach($kategoriak as $kat)
                            <div class="kategoria-item" onclick="selectKategoria('{{ $kat->nev }}')">{{ $kat->nev }}</div>
                        @endforeach
                    </div>
                    <input type="hidden" id="kategoria_selected" name="kategoria" required>
                </div>

                <input type="number" name="osszeg" placeholder="Összeg" required>
                <!--Pénznem-->
                <div class="kategoria-input-wrapper" id="penznem_wrapper">
                    <input type="text" id="penznem_input" placeholder="Pénznem"
                           oninput="filterPenznemek()" onclick="document.getElementById('penznem_list').classList.add('show')">
                    <div id="penznem_list" class="kategoria-list">
                        @foreach($penznemek as $penznem)
                            <div class="kategoria-item" onclick="selectPenznem('{{ $penznem->nev }}')">{{ $penznem->nev }}</div>
                        @endforeach
                    </div>
                    <input type="hidden" id="penznem_selected" name="penznem" required>
                </div>
                
                <input type="date" name="rogzites" required>
                <textarea name="megjegyzes" placeholder="Leírás (megjegyzés)"></textarea>
                <button type="submit">Költség Hozzáadása</button>
            </form>
        </div>
    </div>
</body>
</html>