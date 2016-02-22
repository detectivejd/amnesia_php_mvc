<h3>Mostrar Compras por período</h3>
<script type="text/javascript"> 
//<![CDATA[
function procesar(v){
    document.getElementById('envia').href = 'index.php?c=pdf&a=c1&p='+v;
}
function procesar2(){
    document.elform.submit();
}
//]]>
</script>
<p>
    <a href="index.php?c=consultas&a=index" title="Volver"><img src="Public/img/go_previous.png" /></a>
    <form action="index.php?c=consultas&a=cons1" method="post" name="frmcons1">
        <input type="radio" name="rbtnperiodo" value="d" onclick="procesar(this.value);" /><b>Día</b>&nbsp;
        <input type="radio" name="rbtnperiodo" value="m" onclick="procesar(this.value);" /><b>Mes</b>&nbsp;
        <input type="radio" name="rbtnperiodo" value="a" onclick="procesar(this.value);" /><b>Año</b>&nbsp;
        <input type="button" name="btnaceptar" value="Aceptar" onclick="frmcons1.submit();" />&nbsp;
        <a href="#" onclick="procesar2();" id="envia" target="_blank"><input type="button" name="btnpdf" value="Pdf" /></a>
    </form>
</p>
<table class="table1">
    <thead>
        <th>Compra</th>
        <th>Usuario</th>
        <th>Fecha</th>
        <th>Cuotas</th>
    </thead>
    <tbody>
        <?php foreach($compras as $compra){?>
            <tr>
                <td><?php echo $compra->getId(); ?></td>
                <td><?php echo $compra->getUser()->getNick(); ?></td>
                <td><?php echo $compra->getFecha(); ?></td>
                <td><?php echo count($compra->getPagos())."/".$compra->getCuotas(); ?></td>
            </tr>
        <?php }?>
    </tbody>
</table>    
<?php if ($paginador != null) { ?> 
    <br />
    <?php if($paginador['primero']) { ?>	
        <a href="<?php echo 'index.php?c=consultas&a=cons1&p=' . $paginador['primero']; ?>" title="Primero"><img src="Public/img/go_first_page.png" /></a>        
    <?php } ?>
    &nbsp;
    <?php if($paginador['anterior']) { ?>	
        <a href="<?php echo 'index.php?c=consultas&a=cons1&p=' . $paginador['anterior']; ?>" title="Anterior"><img src="Public/img/go_previous_page.png" /></a>	
    <?php } ?>
    &nbsp;
    <?php if($paginador['siguiente']) { ?>	
        <a href="<?php echo 'index.php?c=consultas&a=cons1&p=' . $paginador['siguiente']; ?>" title="Siguiente"><img src="Public/img/go_next_page.png" /></a>
    <?php } ?>
    &nbsp;
    <?php if($paginador['ultimo']) { ?>	
        <a href="<?php echo 'index.php?c=consultas&a=cons1&p=' . $paginador['ultimo']; ?>" title="Último"><img src="Public/img/go_last_page.png" /></a>	
    <?php }     
    } ?>