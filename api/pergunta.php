<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <?php
  require 'cssheader.php';
  
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<img src="https://cdn.discordapp.com/attachments/665670957637173256/1160770245376606338/logo4.png?ex=6535de88&is=65236988&hm=56804b54ec1f470f5321bb58c7a94116d6bca829898b17afa7539d45520b61c6&" id="logo">
  <?php
  
require 'seguranca.php';
require 'menu.php';
?>

<div class="container">

  

<?php
  include("conexao.php");
  $executa=$db->prepare("select anonimo,idpergunta, mensagem, usuario, fotoPerfil, apelido, dataPergunta from pergunta as p inner join usuario as u on p.remetente = u.idusuario left join resposta r on p.idpergunta=r.pergunta where p.destinatario=:id and r.pergunta is null;");
  $executa->BindParam(":id",$_COOKIE['idusuario']);
  $executa->execute();

  while($linha=$executa->fetch(PDO::FETCH_OBJ)){
    ?>
    <div class="mensagem">
      <div class="remetente"> 
      <?php if($linha->anonimo==1){ ?>
          <a class="usuario" > <img src="https://cdn-icons-png.flaticon.com/512/4123/4123751.png"  width="50px" height="50px"><b> Bixcônimo</b></a>
<?php }else{  ?>

  <a class="usuario" href="perfil.php?<?php echo $linha->usuario; ?>"> <img src="<?php echo $linha->fotoperfil ?>"  width="50px" height="50px"><b> <?php echo $linha->apelido ?></b></a>

<?php  }?>
        <div class="data">
          <?php
          echo $linha->datapergunta;
          ?>
          </div>
           </div>
          <div class="conteudo">
            <?php
    echo $linha->mensagem;

  ?>

  </div>
      <button onclick='modal(<?php echo $linha->idpergunta ?>)' type="button" class="fas fa-paper-plane fa-lg botao " data-toggle="modal" data-target="#exampleModal" id="<?php echo $linha->idpergunta ?>" ></button>
      


    </div>
    
    <?php
  }

?>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Responder <span id="titl"></span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <label id="mens"></label>
      <label id="idpergunta" hidden></label>
      <div id="texto">
<textarea  rows="8" maxlength="500" id="resp" placeholder="Digite aqui sua resposta ... "></textarea>
</div>
      </div>
      
      <div class="modal-footer">
      <span>Compartilhar</span>
      <div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" id="post">
</div>

  <span>Retornar</span>
      <div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" id="ret">

  
</div>

        <button type="button" id="fecharmodal" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="responder()">Responder</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
<style type="text/css">

 #logo{
      
      text-align: center;
      width: 26%;
      margin-left: 37%;
  
  
    }

      .usuario, .usuario:hover{
        text-decoration: none;
        color: white;


      }
      .usuario img{
        border-radius: 50%;

      }

      .mensagem{

        width: 100%;
        background-color: #141211;
        border-left: 3px solid white;
        margin-top: 5%;



      }
      .remetente{
        color: white;
        margin-left: 1%;
        font-size: clamp(1em, 1em + 2vw, 1.5em);


      }
      .data{
        color: white;
        float: right;
        margin-right: 1px;
        margin-top: 1.5%;
        opacity: 60%;
        font-size: clamp(0.3em, 0.5em + 1vw, 0.7em);

      }
      .conteudo{
        color: white;
        width: 90%;
        margin-left: 5%;
        border-bottom: 0.8px solid white;
        font-size: clamp(1em, 1em + 1vw, 1.5em);
        word-wrap: break-word;
        

      }
      .botao{
        text-decoration:none;
       
       
       background-color:transparent;
       border:none;
       color:white;
float:right;
margin-right:1%;
margin-top:2%;
   


      }
      .botao:hover{
        text-decoration:none;
       
       
       background-color:transparent;
       border:none;
       color:#339af0;
float:right;


      }
      textarea{
        width: 100%;
        

      }
      #mens{
        word-break:break-word;
      }
      .ball {
  position: absolute;
  border-radius: 100%;
  opacity: 0.7;
  z-index:-1;
}
    
</style>

<script>

 function modal(idpergunta){

  //$('#exampleModal').modal('show');

  $.ajax({
  type: "POST",
  url: "dadopergunta.php",
  data: {'idpergunta':idpergunta}
  
  
  
}).done(function(data){
  
  
  var dados = JSON.parse(data);
  $("#titl").empty();
  $("#mens").empty();
  $("#idpergunta").empty();
  if(dados.anonimo==1){
    $("#titl").append("Bixcônimo");
  }else{
    $("#titl").append(dados.apelido);
  }
  $("#idpergunta").val(dados.id);
  $("#mens").val(dados.mensagem);
  $("#mens").text(dados.mensagem);
  $("#resp").val("");
  $("#post").prop('checked',false);
  
  

});
  


 }

 
function responder(){

  var idpe = $("#idpergunta").val();
  
  var resposta = $("#resp").val();
  var mensagem = $("#mens").val();
  var post =$("#post").is(':checked');
  var ret =$("#ret").is(':checked');
console.log(post);

 $.ajax({
  type: "POST",
  url: "modalresponder.php",
  data: {'idpergunta':idpe , 'resposta':resposta,'pergunta':mensagem,'post':post, 'ret':ret},
  
  beforeSend: function(){
    //$('#exampleModal').modal('hide');
    
//$('.modal-backdrop').remove();
    
    $("#"+idpe).parent().remove();
    $("#post").prop('checked',false);
    $("#ret").prop('checked',false);
    $("#resp").val("");
  }
 
}).done(function(data){
 // document.location.reload();
  console.log(data);
});
  
  

  
}


</script>