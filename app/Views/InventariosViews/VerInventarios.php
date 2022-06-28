<?php use App\Controllers\Inventarios; ?>
<?php if(isset($_SESSION['Rol'])): ?>
        <?php if($_SESSION['Rol']=="Administrador"):?>
            <?=$header?>
                <br/>
                <br/>
                <br/>
                <button id="butonAyuda" type="button"> <img class="remove-bg" height="50" width="50" src="<?=base_url('/images/pregunta.png');?>" /></button>
                <div  class="overlay" id="overlay">
                    <div class="popup" id="popup">
                        <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                        <h3>Info sobre los colores</h3>
                        <h5>verde: 75% o mas del producto</h5>
                        <h5>Amarillo: entre 50 y 75% del producto</h5>
                        <h5>Rojo:menos del 50% restante</h5>
                        
                    </div>
                </div>
                <div class="container mt-5 justify-content-center ml-3">
                    <table id="dtDynamicVerticalScrollExample" class="table-light table table-striped table-bordered table-sm" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th hidden="true">id_inventario</th> 
                                <th>Nombre del producto</th>
                                <th>Precio del producto</th>
                                <th>Tipo de producto</th>
                                <th>Cantidad actual del producto</th>
                                <th>Medida</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($inventarios as $inventario):?>
                                <?php if(Inventarios::IsPrioridad3($inventario['idInventario'])):?>
                                    <tr id="datosTabla" class="table-success">
                                        <td hidden="true"><?=$inventario['idInventario']?></td>
                                        <td><?=$inventario['nombre']?></td>
                                        <td><?=$inventario['precio']?></td>
                                        <td><?=$inventario['tipo']?></td>
                                        <td><?=$inventario['cantidadActual']?></td>
                                        <td><?=$inventario['medida']?></td>
                                        <td>
                                            <a id="DeleteProducto" class="DeleteProducto btn btn-danger" type="button">Borrar</a>
                                        </td>
                                    </tr>
                                <?php elseif(Inventarios::IsPrioridad2($inventario['idInventario'])):?>
                                    <tr id="datosTabla" class="table-warning">
                                        <td  hidden="true"><?=$inventario['idInventario']?></td>
                                        <td><?=$inventario['nombre']?></td>
                                        <td><?=$inventario['precio']?></td>
                                        <td><?=$inventario['tipo']?></td>
                                        <td><?=$inventario['cantidadActual']?></td>
                                        <td><?=$inventario['medida']?></td>
                                        <td>
                                            <a id="DeleteProducto"  class="DeleteProducto btn btn-danger" type="button">Borrar</a>
                                        </td>
                                    </tr>
                                <?php else:?>
                                    <tr id="datosTabla" class="table-danger">
                                        <td  hidden="true"><?=$inventario['idInventario']?></td>
                                        <td><?=$inventario['nombre']?></td>
                                        <td><?=$inventario['precio']?></td>
                                        <td><?=$inventario['tipo']?></td>
                                        <td><?=$inventario['cantidadActual']?></td>
                                        <td><?=$inventario['medida']?></td>
                                        <td>
                                            <a id="DeleteProducto"  class="DeleteProducto btn btn-danger" type="button">Borrar</a>
                                        </td>
                                    </tr>
                                <?php endif?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php elseif($_SESSION['Rol']== "Doctor"):?>
                    <?=$header?>
                <br/>
                <br/>
                <br/>
                <div class="overlay" id="overlay">
                    <div class="popup" id="popup">
                        <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                        <h3>Info sobre los colores</h3>
                        <h5>verde: 75% o mas del producto</h5>
                        <h5>Amarillo: entre 50 y 75% del producto</h5>
                        <h5>Rojo:menos del 50% restante</h5>
                        
                    </div>
                </div>
                <div class="container mt-5 justify-content-center ml-3">
                    <table id="dtDynamicVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0">
                    <thead class="thead-light">
                            <tr>
                                <th hidden="true">id_inventario</th> 
                                <th>Nombre del producto</th>
                                <th>Precio del producto</th>
                                <th>Tipo de producto</th>
                                <th>Cantidad actual del producto</th>
                                <th>Medida</th>
                            </tr>
                        </thead>
                        <?php foreach($inventarios as $inventario):?>
                                <?php if(Inventarios::IsPrioridad3($inventario['idInventario'])):?>
                                    <tr id="datosTabla" class="table-success">
                                        <td hidden="true"><?=$inventario['idInventario']?></td>
                                        <td><?=$inventario['nombre']?></td>
                                        <td><?=$inventario['precio']?></td>
                                        <td><?=$inventario['tipo']?></td>
                                        <td><?=$inventario['cantidadActual']?></td>
                                        <td><?=$inventario['medida']?></td>
                                    </tr>
                                <?php elseif(Inventarios::IsPrioridad2($inventario['idInventario'])):?>
                                    <tr id="datosTabla" class="table-warning">
                                        <td  hidden="true"><?=$inventario['idInventario']?></td>
                                        <td><?=$inventario['nombre']?></td>
                                        <td><?=$inventario['precio']?></td>
                                        <td><?=$inventario['tipo']?></td>
                                        <td><?=$inventario['cantidadActual']?></td>
                                        <td><?=$inventario['medida']?></td>
                                    </tr>
                                <?php else:?>
                                    <tr id="datosTabla" class="table-danger">
                                        <td  hidden="true"><?=$inventario['idInventario']?></td>
                                        <td><?=$inventario['nombre']?></td>
                                        <td><?=$inventario['precio']?></td>
                                        <td><?=$inventario['tipo']?></td>
                                        <td><?=$inventario['cantidadActual']?></td>
                                        <td><?=$inventario['medida']?></td>
                                    </tr>
                                <?php endif?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        <?php endif ?>
</body>
</html>
</body>
</html>