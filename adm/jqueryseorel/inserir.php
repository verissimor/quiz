<?php
//REQUIRE E CONEXÃO
require_once '../../jquerycms/config.php';
require_once '../lib/admin.php';
$msg = "";

$registro = new objJqueryseorel($Conexao);

$ctrlSeo = new CtrlJquerySeo($Conexao, 0, 'jqueryseoctrlSeo');


//POST
if (count($_POST) > 0) {
    try {
        
        $ctrlSeo->keyTitle = issetpost('cod');
        $registro->setSeo($ctrlSeo->inserirByPost()); 
        //$registro->setSeo(dbJqueryseo::Inserir($Conexao, '', ''));
        $registro->setPalavra(issetpostInteger('palavra'));
        
        
        $exec = $registro->Save();

        if ($exec && $adm_tema != 'branco') {
            header("Location: $cancelLink");
        } else {
            $msg = fEnd_MsgString("O registro foi inserido.$fEnd_closeTheIFrameImDone", 'success');
        }
    } catch (jquerycmsException $exc) {
        $msg = fEnd_MsgString("Ocorreram problemas ao inserir o registro.", 'error', $exc->getMessage());
    }
}

    
//FORM
$form = new autoform2();
$form->start("cadastro","","POST");
    
$form->insertHtml($ctrlSeo->getCtrl());
$form->selectDb(__('jqueryseorel.palavra'), 'palavra', $registro->getPalavra(), '1', $Conexao, 'jqueryseopalavra', 'cod', 'palavra');

    
$form->send_cancel("Salvar", $cancelLink);
$form->end();
?><!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo __('table_jqueryseorel');?> - Inserir</title>

        <?php include '../lib/masterpage/head.php'; ?>
        <?php echo $form->getHead(); ?>
        <?php echo $ctrlSeo->getHead(); ?>
        
    </head>
    <body>        
        <?php include '../lib/masterpage/header.php'; ?>

        <div class="main">
            <div class="inner">
                <div class="page-header">
                    <h3><?php echo __('table_jqueryseorel');?> <small>Inserir</small></h3>
                </div>
                
                <?php echo $msg; ?>
                <?php echo $form->getForm(); ?>
            </div>
        </div>
        <?php include '../lib/masterpage/footer.php'; ?>
    </body>
</html>