 <div data-options="region:'north'" style="height:70px; background-color:#0B4492;  " >
 <img style="height:65px;" src='img/logo2.png' />
 </div>      
 <script>

setInterval(myMethod, 5000);

function myMethod( )
{
    $.get( "php/mensaje/select_mensaje.php", function( data ) {

console.log(data);

data.forEach(element => {
    $.messager.alert('Mensaje enviado',element.mens_mensaje,'info');
 
    setleido(element.mens_id);
 
} ); 

});
}

function setleido(id){
    $.get( "php/mensaje/set_leido_mensaje.php?mens_id="+id, function( data ) {

   
});
}


  </script>  