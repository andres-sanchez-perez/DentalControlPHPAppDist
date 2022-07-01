<?=$header?>
<div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Ingrese los datos de la cirujía</h5>
            
            <p class="card-text">
                
                    <div class="form-group">
                        <label class="font-weight-bold" for="NombreProducto">Nombre del producto</label>
                        <input required id="NombreProducto" class="form-control" type="text" name="NombreProducto">
                    </div>
                    
                    <div class="form-group mt-3s">
                        <label class="font-weight-bold" for="TipoProducto">Tipo de producto</label>
                        <input required id="TipoProducto" class="form-control" type="text" name="TipoProducto">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="CantidadInicial">Precio del producto obtenido (precio unitario)</label>
                        <input required id="decimales" class="form-control " type="text" name="Precio">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="CantidadInicial">Cantidad del producto obtenido</label>
                        <input required id="decimales" class="form-control" type="text" name="CantidadInicial">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="Medida">Medida en la que viene el producto</label>
                        <br/>
                        <select id="ComboConBusqueda" class="form-select" aria-label="Default select example" name="Medida">
                            <option selected value="Null">Seleccione una medida</option>
                            <option value="ml">mililitros</option>
                            <option value="l">litros</option>
                            <option value="dl">decilitros</option>
                            <option value="µg">microgramos</option>
                            <option value="mg">miligramos</option>
                            <option value="g">gramos</option>
                            <option value="lb">libra</option>
                            <option value="paquete">Paquetes</option>
                            <option value="oz">onza</option>
                        </select>
                    </div>
                    <button id="CrearProducto" class="btn btn-success mt-3" type="submit">Registrar nuevo producto</button>
                
            </p>
        </div>
    </div>
</body>
</html>