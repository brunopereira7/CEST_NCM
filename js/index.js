function aviso(codigo_aviso){
	if (codigo_aviso == 1) {
		if (confirm("Deseja realmente LIMPAR a tabela de NCM para inserir novos dados?") == true) {
			//aqui vai uma funcao para deletar tudo
			deltaNCM();
		}
	}
	if (codigo_aviso == 2) {
		if (confirm("Deseja importar novos NCMs?") == true) {
			//aqui vai uma funcao para importar
			importaNCM();
		}
	}
}
function deltaNCM() {


	$.getJSON('ajax/deleta_ncm.ajax.php',{
		ajax: 'true',
	}, 
	function(j){
		if (j[0].resultado) {
			alert('NCMs deletados com sucesso.');
		}else{
			alert('Erro ao deletar NCMs.');
		}
	});
}
function importaNCM() {


	$.getJSON('ajax/importa_ncm.ajax.php',
	function(j){
		if (j[0].resultado) {
			captura_ncm();
			alert('Processo de importação finalizado.');
		}else{
			alert('Erro na importação NCMs.');
		}
	});
}

function captura_ncm() {

	$.getJSON('ajax/captura_ncm.ajax.php', 
	function(j){

		var tabela = '';
		var tr = '';
		var classe_do_btn = '';
		tabela = '\n<tr>';
		tabela += '\n	<th>#</th>';
		tabela += '\n	<th>ID</th>';
		tabela += '\n	<th>NCM</th>';
		tabela += '\n	<th>Tam.</th>';
		tabela += '\n	<th>QTD REGISTRO</th>';
		tabela += '\n	<th>CNPJ</th>';
		tabela += '\n	<th>!</th>';
		tabela += '\n</tr>'; 
		for (var i = 0; i < j.length; i++) {
			tr += '\n<tr>';
			tr += '\n	<td>'+i+'</td>';
			tr += '\n	<td>'+j[i].ID_NCM+'</td>';
			tr += '\n	<td>'+j[i].NCM+'</td>';
			tr += '\n	<td>'+j[i].NCM.length+'</td>';
			tr += '\n	<td>'+j[i].QTD_REGISTRO+'</td>';
			tr += '\n	<td>'+j[i].CPF_CNPJ+'</td>';

			if (j[i].AJUSTADO == 'S'){
				tr += '\n	<td><button data-toggle="modal" data-target=".bs-example-modal-lg" class="btn btn-success">Ajuste</button></td>';
			}else{
				tr += '\n	<td><button id="'+j[i].ID_NCM+'" name="'+j[i].NCM+'" onclick="verificaNCM(id,name)" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn btn-danger">Ajuste</button></td>';
			}
			tr += '\n</tr>';
		}
		var concatena;
		concatena = tabela + tr;
		document.getElementById('tabela_ncm').innerHTML = concatena;
	});
}

function verificaNCM(id_ncm,NCM){


	$.getJSON('ajax/verifica_ncm.ajax.php',{
		NCM: NCM,
	},
	function(j){
		var tabela = '';
		var tr = '';

		tabela = '\n<tr>';
		tabela += '\n	<th>ID</th>';
		tabela += '\n	<th>NCM</th>';
		tabela += '\n	<th>QTD Caracter NCM</th>';
		tabela += '\n	<th>CEST</th>';
		tabela += '\n	<th>DESCRIÇÃO</th>';
		tabela += '\n	<th>SEGMENTO</th>';
		tabela += '\n	<th>!</th>';
		tabela += '\n</tr>'; 
		for (var i = 0; i < j.length; i++) {
			tr += '\n<tr>';
			tr += '\n	<td>'+j[i].ID_CEST+'</td>';
			tr += '\n	<td>'+j[i].NCM+'</td>';
			tr += '\n	<td>'+j[i].NCM.length+'</td>';
			tr += '\n	<td>'+j[i].CEST+'</td>';
			tr += '\n	<td>'+j[i].DESCRICAO+'</td>';
			tr += '\n	<td>'+j[i].SEGMENTO+'</td>';
			tr += '\n	<td><button id="'+id_ncm+'" name="'+j[i].CEST+'" onclick="ajustaNCM(id,name)" type="button" class="btn btn-warning">Atualizar</button></td>';
			tr += '\n</tr>';
		}
		var concatena;
		concatena = tabela + tr;
		document.getElementById('nomeNCM').innerHTML = 'NCM: '+NCM;
		document.getElementById('descricaoNCM').innerHTML = 'Descrição: '+ j[0].DESCRICAO_NCM;
		document.getElementById('resultado_ncm').innerHTML = concatena;
	});
}

function ajustaNCM(id_ncm,cest) {
	$.getJSON('ajax/ajusta_ncm.ajax.php',{
		ID_NCM: id_ncm,
		CEST: cest,
	},function(j){
		if (j[0].resultado){
			$('#'+id_ncm).removeClass("btn-danger");
			$('#'+id_ncm).addClass("btn-success");
			$('#myModal').modal('hide');
		}else{
			alert('Erro ao fazer ajuste ID_NCM: '+id_ncm);
		}
		captura_ncm();
	});
}

function arrumaNCM() {
	
	$.getJSON('ajax/arruma_ncm.ajax.php',
	function(j){
		if (j[0].resultado){
			alert('NCMs ajustados com sucesso!');
		}else{
			alert('Erro ao fazer ajustar NCMs');
		}
	});
}

function listarUpdate() {

	$.getJSON('ajax/gerar_scripts.ajax.php',
	function(j){
		var tabela_update = '';
		tabela_update = '<tr><th>UPDATE</th></tr>';

		for (var i = 0; i < j.length; i++) {
			tabela_update += '<tr>';
			tabela_update += '	<td>'+j[i].UPDATE+'</td>';
			tabela_update += '</tr>';
		}
		document.getElementById('tabela_update').innerHTML = tabela_update;
	});
}