echo '<!DOCTYPE html>
<html>
<head>
    <title>Editar APU - {{ $apu->code }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h1, h2 { color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        input { width: 100%; padding: 5px; }
        .btn { padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-cancel { background: #6c757d; }
        .btn-save { background: #007bff; }
        .section { margin-top: 30px; }
        .totals-box { background: #d4edda; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: right; }
        .grand-total { font-size: 20px; font-weight: bold; color: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Editar APU: {{ $apu->code }}</h1>
        
        <form method="POST" action="/apu/{{ $apu->id }}" id="editForm">
            @csrf
            @method("PUT")
            
            <div class="form-group">
                <label>Código:</label>
                <input type="text" name="code" value="{{ $apu->code }}" required>
            </div>
            
            <div class="form-group">
                <label>Rubro:</label>
                <input type="text" name="name" value="{{ $apu->name }}" required>
            </div>
            
            <div class="form-group">
                <label>Unidad:</label>
                <input type="text" name="unit" value="{{ $apu->unit }}" required>
            </div>
            
            <!-- EQUIPOS -->
            @php $equipos = $apu->items->where("section", "equipment"); @endphp
            @if($equipos->count() > 0)
            <div class="section">
                <h3>🖥️ EQUIPOS</h3>
                <table id="tabla-equipos">
                    <thead>
                        <tr><th>Descripción</th><th>Cantidad</th><th>Tarifa</th><th>Rendimiento</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                        @foreach($equipos as $item)
                        <tr class="item-row" data-section="equipment" data-id="{{ $item->id }}">
                            <td><input type="text" name="items[{{ $item->id }}][description]" value="{{ $item->description }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}" class="quantity" data-id="{{ $item->id }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][unit_price]" value="{{ $item->unit_price }}" class="price" data-id="{{ $item->id }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][performance]" value="{{ $item->performance }}"></td>
                            <td><span class="total-{{ $item->id }}">{{ number_format($item->total, 2) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            
            <!-- MANO DE OBRA -->
            @php $labor = $apu->items->where("section", "labor"); @endphp
            @if($labor->count() > 0)
            <div class="section">
                <h3>👷 MANO DE OBRA</h3>
                <table id="tabla-labor">
                    <thead>
                        <tr><th>Descripción</th><th>Cantidad</th><th>Jornal/HR</th><th>Rendimiento</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                        @foreach($labor as $item)
                        <tr class="item-row" data-section="labor" data-id="{{ $item->id }}">
                            <td><input type="text" name="items[{{ $item->id }}][description]" value="{{ $item->description }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}" class="quantity" data-id="{{ $item->id }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][unit_price]" value="{{ $item->unit_price }}" class="price" data-id="{{ $item->id }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][performance]" value="{{ $item->performance }}"></td>
                            <td><span class="total-{{ $item->id }}">{{ number_format($item->total, 2) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            
            <!-- MATERIALES -->
            @php $materiales = $apu->items->where("section", "material"); @endphp
            @if($materiales->count() > 0)
            <div class="section">
                <h3>🧱 MATERIALES</h3>
                <table id="tabla-materiales">
                    <thead>
                        <tr><th>Descripción</th><th>Cantidad</th><th>Precio Unit.</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                        @foreach($materiales as $item)
                        <tr class="item-row" data-section="material" data-id="{{ $item->id }}">
                            <td><input type="text" name="items[{{ $item->id }}][description]" value="{{ $item->description }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}" class="quantity" data-id="{{ $item->id }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][unit_price]" value="{{ $item->unit_price }}" class="price" data-id="{{ $item->id }}"></td>
                            <td><span class="total-{{ $item->id }}">{{ number_format($item->total, 2) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            
            <!-- TRANSPORTE -->
            @php $transporte = $apu->items->where("section", "transport"); @endphp
            @if($transporte->count() > 0)
            <div class="section">
                <h3>🚚 TRANSPORTE</h3>
                <table id="tabla-transporte">
                    <thead>
                        <tr><th>Descripción</th><th>Cantidad</th><th>Tarifa</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                        @foreach($transporte as $item)
                        <tr class="item-row" data-section="transport" data-id="{{ $item->id }}">
                            <td><input type="text" name="items[{{ $item->id }}][description]" value="{{ $item->description }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}" class="quantity" data-id="{{ $item->id }}"></td>
                            <td><input type="number" step="0.01" name="items[{{ $item->id }}][unit_price]" value="{{ $item->unit_price }}" class="price" data-id="{{ $item->id }}"></td>
                            <td><span class="total-{{ $item->id }}">{{ number_format($item->total, 2) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            
            <!-- Totales -->
            <div class="totals-box">
                <p><strong>TOTAL COSTO DIRECTO:</strong> $ <span id="total-directo">0.00</span></p>
                <p><strong>INDIRECTOS (20%):</strong> $ <span id="indirectos">0.00</span></p>
                <p class="grand-total"><strong>COSTO TOTAL DEL RUBRO:</strong> $ <span id="total-general">0.00</span></p>
            </div>
            
            <!-- Campos ocultos para los totales -->
            <input type="hidden" name="total_direct_cost" id="total_direct_cost" value="0">
            <input type="hidden" name="indirect_cost" id="indirect_cost" value="0">
            <input type="hidden" name="total_cost" id="total_cost" value="0">
            
            <button type="submit" class="btn btn-save">💾 Guardar Cambios</button>
            <a href="/apu/{{ $apu->id }}" class="btn btn-cancel">Cancelar</a>
        </form>
    </div>
    
    <script>
        function calcularTodosLosTotales() {
            var equiposTotal = 0;
            var laborTotal = 0;
            var materialesTotal = 0;
            var transporteTotal = 0;
            
            // Procesar cada fila de la tabla
            document.querySelectorAll(".item-row").forEach(function(row) {
                var section = row.getAttribute("data-section");
                var id = row.getAttribute("data-id");
                var quantity = parseFloat(row.querySelector(".quantity").value) || 0;
                var price = parseFloat(row.querySelector(".price").value) || 0;
                var total = quantity * price;
                
                // Actualizar el total mostrado
                var totalSpan = row.querySelector(".total-" + id);
                if (totalSpan) {
                    totalSpan.innerHTML = total.toFixed(2);
                }
                
                // Sumar por sección
                if (section === "equipment") equiposTotal += total;
                if (section === "labor") laborTotal += total;
                if (section === "material") materialesTotal += total;
                if (section === "transport") transporteTotal += total;
            });
            
            var totalDirecto = equiposTotal + laborTotal + materialesTotal + transporteTotal;
            var indirectos = totalDirecto * 0.20;
            var totalGeneral = totalDirecto + indirectos;
            
            // Mostrar totales
            document.getElementById("total-directo").innerHTML = totalDirecto.toFixed(2);
            document.getElementById("indirectos").innerHTML = indirectos.toFixed(2);
            document.getElementById("total-general").innerHTML = totalGeneral.toFixed(2);
            
            // Actualizar campos ocultos
            document.getElementById("total_direct_cost").value = totalDirecto;
            document.getElementById("indirect_cost").value = indirectos;
            document.getElementById("total_cost").value = totalGeneral;
        }
        
        // Agregar eventos a todos los inputs de cantidad y precio
        document.querySelectorAll(".quantity, .price").forEach(function(input) {
            input.addEventListener("input", calcularTodosLosTotales);
            input.addEventListener("change", calcularTodosLosTotales);
        });
        
        // Calcular al cargar la página
        calcularTodosLosTotales();
    </script>
</body>
</html>' > resources\views\apus\edit.blade.php