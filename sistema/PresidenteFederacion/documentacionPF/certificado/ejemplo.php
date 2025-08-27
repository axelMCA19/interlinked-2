<?php
    
    $nombresA = $_POST['nombres'] . ' ' . $_POST['apellidos'];
    $numeroPF = $_POST['numeroPF'];
    $carnetI = $_POST['carnet'];
    $codigoPF = $_POST['codigoPF'];
    $ciudad = $_POST['ciudad'];
    $federacion = $_POST['federacion'];
    $fecha = $_POST['solicitud'];
    $datoPF = $_POST['presidenteF'];
    $qr= 'qr.png';
    $firmaPF= 'firma.png';

    include_once('tbs_class.php'); 
    include_once('plugins/tbs_plugin_opentbs.php'); 

    $TBS = new clsTinyButStrong; 
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); 

    // Cargar la plantilla
    $template = 'CertificadoVerificacion.docx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

    // Escribir nuevos campos
    $TBS->MergeField('USU.AFILIADO', $nombresA);
    $TBS->MergeField('numeroPF', $numeroPF);
    $TBS->MergeField('usu.carnet', $carnetI);
    $TBS->MergeField('usu.codigoPF', $codigoPF);
    $TBS->MergeField('ciudad', $ciudad); //sindicato
    $TBS->MergeField('FEDERACION', $federacion);
    $TBS->MergeField('USU.PRESIDENTE', $datoPF);
    $TBS->MergeField('usu.fecha', $fecha);
    $TBS->VarRef['x'] = $qr;
    $TBS->VarRef['y'] = $firmaPF;

    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as']) !== '') && ($_SERVER['SERVER_NAME'] == 'localhost')) ? trim($_POST['save_as']) : '';
    $output_file_name = str_replace('.', '_' . date('Y-m-d') . $save_as . '.', $template);

    if ($save_as === '') {
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
        exit();
    } else {
        $TBS->Show(OPENTBS_FILE, $output_file_name);
        exit("File [$output_file_name] has been created.");
    }
//}
?>
