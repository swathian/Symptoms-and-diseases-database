<?php

// Data functions for table patient_symptoms

// This script and data application were generated by AppGini 4.52
// Download AppGini for free from http://www.bigprof.com/appgini/download/

function patient_symptoms_insert(){
	global $Translation;

	if($_GET['insert_x']!=''){$_POST=$_GET;}

	// mm: can member insert record?
	$arrPerm=getTablePermissions('patient_symptoms');
	if(!$arrPerm[1]){
		return 0;
	}

	$data['patient'] = makeSafe($_POST['patient']);
	$data['symptom'] = makeSafe($_POST['symptom']);
	$data['observation_date'] = makeSafe($_POST['observation_dateYear']) . '-' . makeSafe($_POST['observation_dateMonth']) . '-' . makeSafe($_POST['observation_dateDay']);
	$data['observation_date'] = parseMySQLDate($data['observation_date'], '1');
	$data['observation_time'] = makeSafe($_POST['observation_time']);
	$data['symptom_value'] = makeSafe($_POST['symptom_value']);
	if($data['patient']== ''){
		echo StyleSheet() . "\n\n<div class=\"Error\">" . $Translation['error:'] . " 'Patient': " . $Translation['field not null'] . '<br /><br />';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['symptom']== ''){
		echo StyleSheet() . "\n\n<div class=\"Error\">" . $Translation['error:'] . " 'Symptom': " . $Translation['field not null'] . '<br /><br />';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}

	// hook: patient_symptoms_before_insert
	if(function_exists('patient_symptoms_before_insert')){
		$args=array();
		if(!patient_symptoms_before_insert($data, getMemberInfo(), $args)){ return FALSE; }
	}

	sql('insert into `patient_symptoms` set `patient`=' . (($data['patient'] != '') ? "'{$data['patient']}'" : 'NULL') . ', `symptom`=' . (($data['symptom'] != '') ? "'{$data['symptom']}'" : 'NULL') . ', `observation_date`=' . (($data['observation_date'] != '') ? "'{$data['observation_date']}'" : 'NULL') . ', `observation_time`=' . (($data['observation_time'] != '') ? "'{$data['observation_time']}'" : 'NULL') . ', `symptom_value`=' . (($data['symptom_value'] != '') ? "'{$data['symptom_value']}'" : 'NULL'));
	$recID=mysql_insert_id();

	// hook: patient_symptoms_after_insert
	if(function_exists('patient_symptoms_after_insert')){
		$data['selectedID']=$recID;
		$args=array();
		if(!patient_symptoms_after_insert($data, getMemberInfo(), $args)){ return; }
	}

	// mm: save ownership data
	sql("insert into membership_userrecords set tableName='patient_symptoms', pkValue='$recID', memberID='".getLoggedMemberID()."', dateAdded='".time()."', dateUpdated='".time()."', groupID='".getLoggedGroupID()."'");

	return (get_magic_quotes_gpc() ? stripslashes($recID) : $recID);
}

function patient_symptoms_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('patient_symptoms');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='patient_symptoms' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='patient_symptoms' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return FALSE;
	}

	// hook: patient_symptoms_before_delete
	if(function_exists('patient_symptoms_before_delete')){
		$args=array();
		if(!patient_symptoms_before_delete($selected_id, $skipChecks, getMemberInfo(), $args)){ return FALSE; }
	}

	sql("delete from `patient_symptoms` where `id`='$selected_id'");

	// hook: patient_symptoms_after_delete
	if(function_exists('patient_symptoms_after_delete')){
		$args=array();
		patient_symptoms_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='patient_symptoms' and pkValue='$selected_id'");
}

function patient_symptoms_update($selected_id){
	global $Translation;

	if($_GET['update_x']!=''){$_POST=$_GET;}

	// mm: can member edit record?
	$arrPerm=getTablePermissions('patient_symptoms');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='patient_symptoms' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='patient_symptoms' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return;
	}

	$data['patient'] = makeSafe($_POST['patient']);
	if($data['patient']==''){
		echo StyleSheet() . "\n\n<div class=\"Error\">{$Translation['error:']} 'Patient': {$Translation['field not null']}<br /><br />";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['symptom'] = makeSafe($_POST['symptom']);
	if($data['symptom']==''){
		echo StyleSheet() . "\n\n<div class=\"Error\">{$Translation['error:']} 'Symptom': {$Translation['field not null']}<br /><br />";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['observation_date'] = makeSafe($_POST['observation_dateYear']) . '-' . makeSafe($_POST['observation_dateMonth']) . '-' . makeSafe($_POST['observation_dateDay']);
	$data['observation_date'] = parseMySQLDate($data['observation_date'], '1');
	$data['observation_time'] = makeSafe($_POST['observation_time']);
	$data['symptom_value'] = makeSafe($_POST['symptom_value']);
	$data['selectedID']=makeSafe($selected_id);

	// hook: patient_symptoms_before_update
	if(function_exists('patient_symptoms_before_update')){
		$args=array();
		if(!patient_symptoms_before_update($data, getMemberInfo(), $args)){ return FALSE; }
	}

	sql('update `patient_symptoms` set `patient`=' . (($data['patient'] != '') ? "'{$data['patient']}'" : 'NULL') . ', `symptom`=' . (($data['symptom'] != '') ? "'{$data['symptom']}'" : 'NULL') . ', `observation_date`=' . (($data['observation_date'] != '') ? "'{$data['observation_date']}'" : 'NULL') . ', `observation_time`=' . (($data['observation_time'] != '') ? "'{$data['observation_time']}'" : 'NULL') . ', `symptom_value`=' . (($data['symptom_value'] != '') ? "'{$data['symptom_value']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'");

	// hook: patient_symptoms_after_update
	if(function_exists('patient_symptoms_after_update')){
		$args=array();
		if(!patient_symptoms_after_update($data, getMemberInfo(), $args)){ return FALSE; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='patient_symptoms' and pkValue='".makeSafe($selected_id)."'");

}

function patient_symptoms_form($selected_id = "", $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;


	// mm: get table permissions
	$arrPerm=getTablePermissions('patient_symptoms');
	if(!$arrPerm[1] && $selected_id==""){ return ""; }
	// combobox: patient
	$combo_patient = new DataCombo;
	$combo_patient->Query = "select `id`, concat_ws('', `last_name`, ', ', `first_name`) from `patients` order by 2";
	$combo_patient->SelectName = 'patient';
	$combo_patient->ListType = 0;
	// combobox: symptom
	$combo_symptom = new DataCombo;
	$combo_symptom->Query = "select `id`, `name` from `symptoms` order by 2";
	$combo_symptom->SelectName = 'symptom';
	$combo_symptom->ListType = 0;
	// combobox: observation_date
	$combo_observation_date = new DateCombo;
	$combo_observation_date->DateFormat = "mdy";
	$combo_observation_date->MinYear = 1900;
	$combo_observation_date->MaxYear = 2100;
	$combo_observation_date->DefaultDate = parseMySQLDate('1', '1');
	$combo_observation_date->MonthNames = $Translation['month names'];
	$combo_observation_date->CSSOptionClass = 'Option';
	$combo_observation_date->CSSSelectedClass = 'SelectedOption';
	$combo_observation_date->NamePrefix = 'observation_date';

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='patient_symptoms' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='patient_symptoms' and pkValue='".makeSafe($selected_id)."'");
		if($arrPerm[2]==1 && getLoggedMemberID()!=$ownerMemberID){
			return "";
		}
		if($arrPerm[2]==2 && getLoggedGroupID()!=$ownerGroupID){
			return "";
		}

		// can edit?
		if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){
			$AllowUpdate=1;
		}else{
			$AllowUpdate=0;
		}

		$res = sql("select * from `patient_symptoms` where `id`='".makeSafe($selected_id)."'");
		$row = mysql_fetch_array($res);
		$combo_patient->SelectedData = $row["patient"];
		$combo_symptom->SelectedData = $row["symptom"];
		$combo_observation_date->DefaultDate = $row["observation_date"];
	}else{
		$combo_patient->SelectedText = ( $_REQUEST['FilterField'][1]=='2' && $_REQUEST['FilterOperator'][1]=='<=>' ? (get_magic_quotes_gpc() ? stripslashes($_REQUEST['FilterValue'][1]) : $_REQUEST['FilterValue'][1]) : "");
		$combo_symptom->SelectedText = ( $_REQUEST['FilterField'][1]=='3' && $_REQUEST['FilterOperator'][1]=='<=>' ? (get_magic_quotes_gpc() ? stripslashes($_REQUEST['FilterValue'][1]) : $_REQUEST['FilterValue'][1]) : "");
	}
	$combo_patient->Render();
	$combo_symptom->Render();

	// code for template based detail view forms

	// open the detail view template
	if(($_POST['dvprint_x']!='' || $_GET['dvprint_x']!='') && $selected_id){
		$templateCode=@implode('', @file('./templates/patient_symptoms_templateDVP.html'));
		$dvprint=true;
	}else{
		$templateCode=@implode('', @file('./templates/patient_symptoms_templateDV.html'));
		$dvprint=false;
	}

	// process form title
	$templateCode=str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Patient symptom details', $templateCode);
	// unique random identifier
	$rnd1=($dvprint ? rand(1000000, 9999999) : '');
	$templateCode=str_replace('<%%RND1%%>', $rnd1, $templateCode);
	// process buttons
	if($arrPerm[1] && !$selected_id){ // allow insert and no record selected?
		$templateCode=str_replace('<%%INSERT_BUTTON%%>', '<input type="image" src="insert.gif" name="insert" alt="' . $Translation['add new record'] . '" onclick="return validateData();">', $templateCode);
	}else{
		$templateCode=str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}
	if($selected_id){
		$templateCode=str_replace('<%%DVPRINT_BUTTON%%>', '<input type="image" src="print.gif" vspace="1" name="dvprint" id="dvprint" alt="' . $Translation['printer friendly view'] . '" onclick="document.myform.reset(); return true;" style="margin-bottom: 20px;">', $templateCode);
		if($AllowUpdate){
			$templateCode=str_replace('<%%UPDATE_BUTTON%%>', '<input type="image" src="update.gif" vspace="1" name="update" alt="' . $Translation['update record'] . '" onclick="return validateData();">', $templateCode);
		}else{
			$templateCode=str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);

			// set records to read only if user can't insert new records
			if(!$arrPerm[1]){
				$jsReadOnly.="\n\n\tif(document.getElementsByName('id').length){ document.getElementsByName('id')[0].readOnly=true; }\n";
				$jsReadOnly.="\n\n\tif(document.getElementsByName('patient').length){ var patient=document.getElementsByName('patient')[0]; patient.disabled=true; patient.style.backgroundColor='white'; patient.style.color='black'; }\n";
				$jsReadOnly.="\n\n\tif(document.getElementsByName('symptom').length){ var symptom=document.getElementsByName('symptom')[0]; symptom.disabled=true; symptom.style.backgroundColor='white'; symptom.style.color='black'; }\n";
				$jsReadOnly.="\n\n\tif(document.getElementsByName('observation_date').length){ document.getElementsByName('observation_date')[0].readOnly=true; }\n";
				$jsReadOnly.="\n\n\tif(document.getElementsByName('observation_dateDay').length){ var observation_dateDay=document.getElementsByName('observation_dateDay')[0]; observation_dateDay.disabled=true; observation_dateDay.style.backgroundColor='white'; observation_dateDay.style.color='black'; }\n";
				$jsReadOnly.="\n\n\tif(document.getElementsByName('observation_dateMonth').length){ var observation_dateMonth=document.getElementsByName('observation_dateMonth')[0]; observation_dateMonth.disabled=true; observation_dateMonth.style.backgroundColor='white'; observation_dateMonth.style.color='black'; }\n";
				$jsReadOnly.="\n\n\tif(document.getElementsByName('observation_dateYear').length){ var observation_dateYear=document.getElementsByName('observation_dateYear')[0]; observation_dateYear.disabled=true; observation_dateYear.style.backgroundColor='white'; observation_dateYear.style.color='black'; }\n";
				$jsReadOnly.="\n\n\tif(document.getElementsByName('observation_time').length){ document.getElementsByName('observation_time')[0].readOnly=true; }\n";
				$jsReadOnly.="\n\n\tif(document.getElementsByName('symptom_value').length){ document.getElementsByName('symptom_value')[0].readOnly=true; }\n";

				$noUploads=true;
			}
		}
		if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
			$templateCode=str_replace('<%%DELETE_BUTTON%%>', '<input type="image" src="delete.gif" vspace="1" name="delete" alt="' . $Translation['delete record'] . '" onClick="return confirm(\'' . $Translation['are you sure?'] . '\');">', $templateCode);
		}else{
			$templateCode=str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode=str_replace('<%%DESELECT_BUTTON%%>', "<input type=image src=deselect.gif vspace=1 name=deselect alt=\"" . $Translation['deselect record'] . "\" onclick=\"document.myform.reset(); return true;\">", $templateCode);
	}else{
		$templateCode=str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode=str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		$templateCode=str_replace('<%%DESELECT_BUTTON%%>', ($ShowCancel ? "<input type=image src=cancel.gif vspace=1 name=deselect alt=\"" . $Translation['deselect record'] . "\" onclick=\"document.myform.reset(); return true;\">" : ''), $templateCode);
	}

	// process combos
	$templateCode=str_replace('<%%COMBO(patient)%%>', $combo_patient->HTML, $templateCode);
	$templateCode=str_replace('<%%COMBOTEXT(patient)%%>', $combo_patient->MatchText, $templateCode);
	$templateCode=str_replace('<%%COMBO(symptom)%%>', $combo_symptom->HTML, $templateCode);
	$templateCode=str_replace('<%%COMBOTEXT(symptom)%%>', $combo_symptom->MatchText, $templateCode);
	$templateCode=str_replace('<%%COMBO(observation_date)%%>', $combo_observation_date->GetHTML(), $templateCode);
	$templateCode=str_replace('<%%COMBOTEXT(observation_date)%%>', $combo_observation_date->GetHTML(true), $templateCode);

	// process foreign key links
	if($selected_id){
		$templateCode=str_replace('<%%PLINK(patient)%%>', ($combo_patient->SelectedData ? "<span id=patients_plink1 style=\"visibility: hidden;\"><a href=patients_view.php?SelectedID=".$combo_patient->SelectedData."><img border=0 src=lookup.gif></a></span>" : ''), $templateCode);
		$templateCode=str_replace('<%%PLINK(symptom)%%>', ($combo_symptom->SelectedData ? "<span id=symptoms_plink2 style=\"visibility: hidden;\"><a href=symptoms_view.php?SelectedID=".$combo_symptom->SelectedData."><img border=0 src=lookup.gif></a></span>" : ''), $templateCode);
	}

	// process images
	$templateCode=str_replace('<%%UPLOADFILE(id)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(patient)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(symptom)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(observation_date)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(observation_time)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(symptom_value)%%>', '', $templateCode);

	// process values
	if($selected_id){
		$templateCode=str_replace('<%%VALUE(id)%%>', htmlspecialchars($row['id'], ENT_QUOTES), $templateCode);
		$templateCode=str_replace('<%%VALUE(patient)%%>', htmlspecialchars($row['patient'], ENT_QUOTES), $templateCode);
		$templateCode=str_replace('<%%VALUE(symptom)%%>', htmlspecialchars($row['symptom'], ENT_QUOTES), $templateCode);
		$templateCode=str_replace('<%%VALUE(observation_date)%%>', @date('n/j/Y', @strtotime(htmlspecialchars($row['observation_date'], ENT_QUOTES))), $templateCode);
		$templateCode=str_replace('<%%VALUE(observation_time)%%>', htmlspecialchars($row['observation_time'], ENT_QUOTES), $templateCode);
		$templateCode=str_replace('<%%VALUE(symptom_value)%%>', htmlspecialchars($row['symptom_value'], ENT_QUOTES), $templateCode);
	}else{
		$templateCode=str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode=str_replace('<%%VALUE(patient)%%>', '', $templateCode);
		$templateCode=str_replace('<%%VALUE(symptom)%%>', '', $templateCode);
		$templateCode=str_replace('<%%VALUE(observation_date)%%>', '1', $templateCode);
		$templateCode=str_replace('<%%VALUE(observation_time)%%>', '', $templateCode);
		$templateCode=str_replace('<%%VALUE(symptom_value)%%>', '', $templateCode);
	}

	// process translations
	foreach($Translation as $symbol=>$trans){
		$templateCode=str_replace("<%%TRANSLATION($symbol)%%>", $trans, $templateCode);
	}

	// clear scrap
	$templateCode=str_replace('<%%', '<!--', $templateCode);
	$templateCode=str_replace('%%>', '-->', $templateCode);

	// hide links to inaccessible tables
	if($_POST['dvprint_x']==''){
		$templateCode.="\n\n<script>\n";
		$arrTables=getTableList();
		foreach($arrTables as $name=>$caption){
			$templateCode.="\tif(document.getElementById('".$name."_link')!=undefined){\n";
			$templateCode.="\t\tdocument.getElementById('".$name."_link').style.visibility='visible';\n";
			$templateCode.="\t}\n";
			for($i=1; $i<10; $i++){
				$templateCode.="\tif(document.getElementById('".$name."_plink$i')!=undefined){\n";
				$templateCode.="\t\tdocument.getElementById('".$name."_plink$i').style.visibility='visible';\n";
				$templateCode.="\t}\n";
			}
		}

		$templateCode.=$jsReadOnly;

		if(!$selected_id){
		}

		$templateCode.="\n\tfunction validateData(){";
		$templateCode.="\n\t\tif(\$F('patient')==''){ alert('".addslashes($Translation['error:']).' "Patient": '.addslashes($Translation['field not null'])."'); \$('patient').focus(); return false; }";
		$templateCode.="\n\t\tif(\$F('symptom')==''){ alert('".addslashes($Translation['error:']).' "Symptom": '.addslashes($Translation['field not null'])."'); \$('symptom').focus(); return false; }";
		$templateCode.="\n\t\treturn true;";
		$templateCode.="\n\t}";
		$templateCode.="\n</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode.="<script>";
	$templateCode.="document.observe('dom:loaded', function() {";


	$templateCode.="});";
	$templateCode.="</script>";

	// handle enforced parent values for read-only lookup fields

	// don't include blank images in lightbox gallery
	$templateCode=preg_replace('/blank.gif" rel="lightbox\[.*?\]"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	// hook: patient_symptoms_dv
	if(function_exists('patient_symptoms_dv')){
		$args=array();
		patient_symptoms_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>