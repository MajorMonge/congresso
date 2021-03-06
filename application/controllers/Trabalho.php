<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Admin.php');


class Trabalho extends Admin {
	public function __construct(){
		parent::__construct();
		$this->load->helper('frontend_helper');
		$this->load->helper('modalform_helper');
		$this->load->model('Trabalho_model', 'trabalho_model');
		$this->load->model('Log_model', 'log_model');
		$this->load->model('Participante_model', 'participante_model');
	}

	public function get_pareceristas($id_eixo){
		$this->db->where('parecerista_eixo.id_eixo', $id_eixo);
		$this->db->join('parecerista_eixo', 'parecerista.id = parecerista_eixo.id_parecerista', 'INNER');
		$this->db->select('nome as label, id as value');
		$pareceristas = $this->db->get('parecerista')->result();

		echo json_encode($pareceristas);
	}


	public function listar_reprovados(){
		$status_parecer = 3;

		$table_header = array(

			array('icon' => '', 'label' => 'Nome'),
			array('icon' => 'fa fa-book', 'label' => 'Título Trabalho'),
			array('icon' => '', 'label' => 'Eixo'),
			array('icon' => '', 'label' => 'Tipo usuário'),
			array('icon' => '', 'label' => 'Data de Submissão'),
			array('icon' => '', 'label' => 'Nota'),
			array('icon' => '', 'label' => 'Data do Parecer'),
			array('icon' => '', 'label' => 'Parecerista'),


		);

		$table_body = array('nome', 'titulo', 'eixo', 'tipo', 'data_submissao', 'nota', 'data_parecer', 'parecerista');


		$data_input_modal = array(
			//array('name' => 'justificativa', 'label' 	=> 'Justificativa', 'type' => 'input_text'),
			array('name' => 'id_eixo', 'label' => '', 'type' => 'hidden'),
			array('name' => 'id', 'label' => 'ID', 'type' => 'input_text'),
			array('name' => 'nome', 'label' 	=> 'Nome','type' 	=> 'input_text'),
			array('name' => 'email', 'label' 	=> 'E-mail', 'type' => 'input_text'),
			array('name' => 'tipo', 'label' 	=> 'Tipo', 'type' => 'input_text'),
			array('name' => 'titulo', 'label' 	=> 'Titulo', 'type' => 'input_text'),
			array('name' => 'eixo', 'label' 	=> 'Eixo', 'type' => 'input_text'),
			array('name' => 'data_submissao', 'label' 	=> 'Data da Submissão', 'type' => 'input_text'),
			array('name' => 'arquivo_sem_nome_autor', 'label' 	=> 'Arquivo Sem Nome Autor', 'type' => 'input_file'),
			array('name' => 'arquivo_com_nome_autor', 'label' 	=> 'Arquivo Com Nome Autor', 'type' => 'input_file'),
			array('name' => 'status', 'label' 	=> 'Status', 'type' => 'input_text'),
			array('name' => 'arquivo_parecer', 'label' 	=> 'Arquivo Parecer', 'type' => 'input_file'),
			array('name' => 'nota', 'label' 	=> 'Nota', 'type' => 'input_text'),
			array('name' => 'data_parecer', 'label' 	=> 'Data Parecer', 'type' => 'input_text'),
			array('name' => 'parecerista', 'label' 	=> 'Parecerista', 'type' => 'input_text'),



		);



		$objects = $this->trabalho_model->get_where_status_parecer(2);
		$objects = array_merge($objects, $this->trabalho_model->get_where_status_parecer($status_parecer));

		$dados['table_header'] 		= $table_header;
		$dados['table_body']	 	= $table_body;
		$dados['objects'] 			= $objects;
		$dados['data_input_modal']  = $data_input_modal;


		$dados['funcao'] 			= 'listar_reprovados';
		$dados['titulo'] 			= 'Trabalhos Reprovados';

		$dados['quantidade'] 		= $this->trabalho_model->num_rows_status_parecer($status_parecer);
		$dados['mensagens'] 		= mensagens();


		//$dados['url'] = array('aprovar' => base_url('Trabalho/enviar_para_parecerista/'));
		$dados['url'] = array("parecer" => true, "aprovar" => base_url("PainelParecerista/novo_parecer/"), "reprovar" => base_url("PainelParecerista/recusar_final/"));
		$this->load->view('html-header-admin');
		$this->load->view('header-admin');
		$this->load->view('modal/modal_listar_reprovados');
		$this->load->view('modal/modal_reavaliar_parecer');
		$this->load->view('listar-trabalhos', $dados);
		$this->load->view('footer-admin');
	}


	public function listar_aprovados(){
		$status_parecer = 1;

		$table_header = array(

			array('icon' => '', 'label' => 'Nome'),
			array('icon' => 'fa fa-book', 'label' => 'Título Trabalho'),
			array('icon' => '', 'label' => 'Eixo'),
			array('icon' => '', 'label' => 'Tipo usuário'),
			array('icon' => '', 'label' => 'Data de Submissão'),
			array('icon' => '', 'label' => 'Nota'),
			array('icon' => '', 'label' => 'Data do Parecer'),
			array('icon' => '', 'label' => 'Parecerista'),


		);

		$table_body = array('nome', 'titulo', 'eixo', 'tipo', 'data_submissao', 'nota', 'data_parecer', 'parecerista');


		$data_input_modal = array(
			//array('name' => 'justificativa', 'label' 	=> 'Justificativa', 'type' => 'input_text'),
			array('name' => 'id_eixo', 'label' => '', 'type' => 'hidden'),
			array('name' => 'id', 'label' => 'ID', 'type' => 'input_text'),
			array('name' => 'nome', 'label' 	=> 'Nome','type' 	=> 'input_text'),
			array('name' => 'email', 'label' 	=> 'E-mail', 'type' => 'input_text'),
			array('name' => 'tipo', 'label' 	=> 'Tipo', 'type' => 'input_text'),
			array('name' => 'titulo', 'label' 	=> 'Titulo', 'type' => 'input_text'),
			array('name' => 'eixo', 'label' 	=> 'Eixo', 'type' => 'input_text'),
			array('name' => 'data_submissao', 'label' 	=> 'Data da Submissão', 'type' => 'input_text'),
			array('name' => 'arquivo_sem_nome_autor', 'label' 	=> 'Arquivo Sem Nome Autor', 'type' => 'input_file'),
			array('name' => 'arquivo_com_nome_autor', 'label' 	=> 'Arquivo Com Nome Autor', 'type' => 'input_file'),
			array('name' => 'status', 'label' 	=> 'Status', 'type' => 'input_text'),
			array('name' => 'arquivo_parecer', 'label' 	=> 'Arquivo Parecer', 'type' => 'input_file'),
			array('name' => 'nota', 'label' 	=> 'Nota', 'type' => 'input_text'),
			array('name' => 'data_parecer', 'label' 	=> 'Data Parecer', 'type' => 'input_text'),
			array('name' => 'parecerista', 'label' 	=> 'Parecerista', 'type' => 'input_text'),



		);



		$objects = $this->trabalho_model->get_where_status_parecer($status_parecer);


		//converter a data para PT-BR
		for($i = 0 ; $i < count($objects); $i++){
			$objects[$i]['data_parecer'] = date('d/m/Y H:i:s', strtotime($objects[$i]['data_parecer']));
			$objects[$i]['data_submissao'] = date('d/m/Y H:i:s', strtotime($objects[$i]['data_submissao']));
			switch($objects[$i]['status']){
				case 0: $objects[$i]['status'] = 'Em Análise'; break;
				case 1: $objects[$i]['status'] = 'Válido'; break;
				case 2: $objects[$i]['status'] = 'Inválido'; break;
				case 3: $objects[$i]['status'] = 'Encaminhado para Parecerista'; break;
				case 4: $objects[$i]['status'] = 'Reenviar Trabalho Sem Autor'; break;
				case 5: $objects[$i]['status'] = 'Reenviar Trabalho Com Autor'; break;
				case 6: $objects[$i]['status'] = 'Reenviar Ambos os Trabalhos'; break;
				case 7: $objects[$i]['status'] = ''; break;
			}
			/*switch($objects[$i]['status_coautores']){
				case 1: if ($objects[$i]['status'] == '') $objects[$i]['status'] = 'Alterar coautores';
				else $objects[$i]['status'] .= ' - Alterar coautores'; 
				break;
			}*/
			//$objects[$i]['pareceristas'] = $this->get_pareceristas($objects[$i]['id_eixo']);
		}
		// print_r($objects); exit();

		$dados['table_header'] 		= $table_header;
		$dados['table_body']	 	= $table_body;
		$dados['objects'] 			= $objects;
		$dados['data_input_modal']  = $data_input_modal;


		$dados['funcao'] 			= 'listar_aprovados';
		$dados['titulo'] 			= 'Trabalhos Aprovados';

		$dados['quantidade'] 		= $this->trabalho_model->num_rows_status_parecer($status_parecer);
		$dados['mensagens'] 		= mensagens();




		//$dados['url'] = array('aprovar' => base_url('Trabalho/enviar_para_parecerista/'));
		$dados['url'] = array();
		$this->load->view('html-header-admin');
		$this->load->view('header-admin');
		$this->load->view('modal/modal_listar_aprovados');
		$this->load->view('listar-trabalhos', $dados);
		$this->load->view('footer-admin');
	}


	public function listar_todos(){


		$table_header = array(

			array('icon' => '', 'label' => 'Nome'),
			array('icon' => 'fa fa-book', 'label' => 'Título Trabalho'),
			array('icon' => '', 'label' => 'Eixo'),
			array('icon' => '', 'label' => 'Tipo usuário'),
			array('icon' => '', 'label' => 'Status'),
			array('icon' => '', 'label' => 'Data de Submissão')

		);

		$table_body = array('nome', 'titulo', 'eixo', 'tipo', 'status', 'data');


		$data_input_modal = array(
			//array('name' => 'justificativa', 'label' 	=> 'Justificativa', 'type' => 'input_text'),
			array('name' => 'id_eixo', 'label' => '', 'type' => 'hidden'),
			array('name' => 'id', 'label' => 'ID', 'type' => 'input_text'),
			array('name' => 'nome', 'label' 	=> 'Nome','type' 	=> 'input_text'),
			array('name' => 'email', 'label' 	=> 'E-mail', 'type' => 'input_text'),
			array('name' => 'tipo', 'label' 	=> 'Tipo', 'type' => 'input_text'),
			array('name' => 'titulo', 'label' 	=> 'Titulo', 'type' => 'input_text'),
			array('name' => 'eixo', 'label' 	=> 'Eixo', 'type' => 'input_text'),
			array('name' => 'data', 'label' 	=> 'Data', 'type' => 'input_text'),
			array('name' => 'arquivo_sem_nome_autor', 'label' 	=> 'Arquivo Sem Nome Autor', 'type' => 'input_file'),
			array('name' => 'arquivo_com_nome_autor', 'label' 	=> 'Arquivo Com Nome Autor', 'type' => 'input_file'),
			array('name' => 'status', 'label' 	=> 'Status', 'type' => 'input_text')


		);



		$objects = $this->trabalho_model->get_all();


		//converter a data para PT-BR
		for($i = 0 ; $i < count($objects); $i++){
			$objects[$i]['data'] = date('d/m/Y H:i:s', strtotime($objects[$i]['data']));
			switch($objects[$i]['status']){
				case 0: $objects[$i]['status'] = 'Em Análise'; break;
				case 1: $objects[$i]['status'] = 'Válido'; break;
				case 2: $objects[$i]['status'] = 'Inválido'; break;
				case 3: $objects[$i]['status'] = 'Encaminhado para Parecerista'; break;
				case 4: $objects[$i]['status'] = 'Reenviar Trabalho Sem Autor'; break;
				case 5: $objects[$i]['status'] = 'Reenviar Trabalho Com Autor'; break;
				case 6: $objects[$i]['status'] = 'Reenviar Ambos os Trabalhos'; break;
				case 7: $objects[$i]['status'] = ''; break;
			}

			//switch($objects[$i]['status_coautores']){
			//	case 1: if ($objects[$i]['status'] == '') $objects[$i]['status'] = 'Alterar coautores';
			//	else $objects[$i]['status'] .= ' - Alterar coautores'; 
			//	break;
			//}
			//$objects[$i]['pareceristas'] = $this->get_pareceristas($objects[$i]['id_eixo']);
		}
		// print_r($objects); exit();

		$dados['table_header'] 		= $table_header;
		$dados['table_body']	 	= $table_body;
		$dados['objects'] 			= $objects;
		$dados['data_input_modal']  = $data_input_modal;


		$dados['funcao'] 			= 'listar_todos';
		$dados['titulo'] 			= 'TODOS os Trabalhos';

		$dados['quantidade'] 		= $this->trabalho_model->num_rows();
		$dados['mensagens'] 		= mensagens();




		//$dados['url'] = array('aprovar' => base_url('Trabalho/enviar_para_parecerista/'));
		$dados['url'] = array();
		$this->load->view('html-header-admin');
		$this->load->view('header-admin');		
		$this->load->view('modal/modal_listar_todos');
		$this->load->view('listar-trabalhos', $dados);
		$this->load->view('footer-admin');
	}

	public function remover_trabalho_parecerista($id_trabalho){
		$this->trabalho_model->remover_trabalho_parecerista($id_trabalho);

		$this->trabalho_model->set_trabalho_status($id_trabalho, 1);

		$this->session->set_flashdata('success', 'Trabalho removido do Parecerista e deve ser escolhido outro parecerista. <a href="'.base_url('Trabalho/listar_validados').'">CLIQUE AQUI PARA SER LEVADO PARA OS TRABALHOS VALIDADOS.</a>');

		redirect('Trabalho/listar_trabalhos_que_foram_enviados_para_pareceristas');
	}

	public function listar_trabalhos_que_foram_enviados_para_pareceristas(){


		$table_header = array(

			array('icon' => '', 'label' => 'Nome do Participante'),
			array('icon' => '', 'label' => 'Título Trabalho'),
			array('icon' => '', 'label' => 'Eixo'),
			array('icon' => '', 'label' => 'Tipo usuário'),
			array('icon' => '', 'label' => 'Status do Parecer'),
			array('icon' => '', 'label' => 'Nome do Parecerista'),
			array('icon' => '', 'label' => 'Data de Recebimento do Trabalho'),
			array('icon' => '', 'label' => 'Ativo'),
			array('icon' => '', 'label' => 'Justificativa')

		);

		$table_body = array('nome_participante', 'titulo', 'eixo', 'tipo', 'status', 'nome_parecerista', 'data', 'ativo', 'justificativa');


		$data_input_modal = array(

			array('name' => 'id_trabalho', 'label' => 'ID', 'type' => 'input_text'),
			array('name' => 'nome_participante', 'label' 	=> 'Nome do Participante','type' 	=> 'input_text'),
			array('name' => 'email', 'label' 	=> 'E-mail do Participante', 'type' => 'input_text'),
			array('name' => 'tipo', 'label' 	=> 'Tipo', 'type' => 'input_text'),
			array('name' => 'titulo', 'label' 	=> 'Titulo', 'type' => 'input_text'),
			array('name' => 'eixo', 'label' 	=> 'Eixo', 'type' => 'input_text'),
			array('name' => 'data', 'label' 	=> 'Data do Envio do Trabalho para o Parecerista', 'type' => 'input_text'),
			array('name' => 'status', 'label' 	=> 'Status do Parecer', 'type' => 'input_text'),
			array('name' => 'ativo', 'label' 	=> 'Ativo', 'type' => 'input_text'),
			array('name' => 'justificativa', 'label' 	=> 'Justificativa', 'type' => 'input_text'),
			array('name' => 'nome_parecerista', 'label' 	=> 'Nome do Parecerista','type' 	=> 'input_text'),

			array('name' => 'arquivo_sem_nome_autor', 'label' 	=> 'Arquivo Sem Nome Autor', 'type' => 'input_file'),
			array('name' => 'arquivo_com_nome_autor', 'label' 	=> 'Arquivo Com Nome Autor', 'type' => 'input_file')


		);



		$objects = $this->trabalho_model->get_all_trabalhos_que_foram_enviados_para_pareceristas();

		$date = date('Y-m-d');


		//converter a data para PT-BR
		for($i = 0 ; $i < count($objects); $i++){
			$diferenca = strtotime($date) - strtotime($objects[$i]['data']);


			$quantidade_de_dias = 1+floor($diferenca / (60 * 60 * 24));
			$objects[$i]['data'] = date('d/m/Y H:i:s', strtotime($objects[$i]['data'])).'<br>(há '.$quantidade_de_dias.' dias)';
			switch($objects[$i]['status']){
				case 0: $objects[$i]['status'] = 'Em Análise'; break;
				case 1: $objects[$i]['status'] = 'Aprovado'; break;
				case 2: $objects[$i]['status'] = 'Reprovado'; break;


			}

			switch($objects[$i]['ativo']){
				case 0: $objects[$i]['ativo'] = 'Não. Deve-se enviar este trabalho para outro Parecerista.'; break;
				case 1: $objects[$i]['ativo'] = 'Sim'; break;
			}
			//$objects[$i]['pareceristas'] = $this->get_pareceristas($objects[$i]['id_eixo']);
		}
		//echo '<pre>'; print_r($objects); echo '</pre>'; exit();


		$dados['table_header'] 		= $table_header;
		$dados['table_body']	 	= $table_body;
		$dados['objects'] 			= $objects;
		$dados['data_input_modal']  = $data_input_modal;


		$dados['funcao'] 			= 'listar_todos';
		$dados['titulo'] 			= 'TODOS os Trabalhos enviados para Pareceristas';

		$dados['quantidade'] 		= $this->trabalho_model->num_rows_enviados_para_pareceristas();
		$dados['mensagens'] 		= mensagens();
		$dados['aprovar'] = array('label' => 'Enviar Trabalho p/ Validado','url' => base_url('Trabalho/remover_trabalho_parecerista/'));
		//$dados['url'] = array();
		$this->load->view('html-header-admin');
		$this->load->view('header-admin');
		$this->load->view('listar-trabalhos-enviador-para-parecerista', $dados);
		$this->load->view('footer-admin');
	}


	public function listar_para_validacao(){
		$status = 0; //0 é status EM ANÁLISE


		$table_header = array(

			array('icon' => '', 'label' => 'Nome'),
			array('icon' => '', 'label' => 'Eixo'),
			array('icon' => '', 'label' => 'Data de Submissão')

		);

		$table_body = array('nome', 'eixo', 'data');


		$data_input_modal = array(
			//array('name' => 'justificativa', 'label' 	=> 'Justificativa', 'type' => 'input_text'),
			array('name' => 'id_eixo', 'label' => '', 'type' => 'hidden'),
			array('name' => 'id', 'label' => 'ID', 'type' => 'input_text'),
			array('name' => 'nome', 'label' 	=> 'Nome','type' 	=> 'input_text'),
			array('name' => 'email', 'label' 	=> 'E-mail', 'type' => 'input_text'),
			array('name' => 'tipo', 'label' 	=> 'Tipo', 'type' => 'input_text'),
			array('name' => 'titulo', 'label' 	=> 'Titulo', 'type' => 'input_text'),
			array('name' => 'eixo', 'label' 	=> 'Eixo', 'type' => 'input_text'),
			array('name' => 'data', 'label' 	=> 'Data', 'type' => 'input_text'),
			array('name' => 'arquivo_sem_nome_autor', 'label' 	=> 'Arquivo Sem Nome Autor', 'type' => 'input_file'),
			array('name' => 'arquivo_com_nome_autor', 'label' 	=> 'Arquivo Com Nome Autor', 'type' => 'input_file'),
			array('name' => 'reenviar_trabalho_com_autor', 'label' 	=> '', 'type' => 'special_button'),
			array('name' => 'reenviar_trabalho_sem_autor', 'label' 	=> '', 'type' => 'special_button'),
			array('name' => 'reenviar_ambos_trabalhos', 'label' 	=> '', 'type' => 'special_button'),
			array('name' => 'aceitar_trabalhos', 'label' 	=> '', 'type' => 'special_button'),
			array('name' => 'mensagem', 'label' 	=> '', 'type' => 'textarea'),
			array('name' => 'data_limite', 'label' => '', 'type' => 'date')

		);



		$objects = $this->trabalho_model->get_all_where_status($status);


		//converter a data para PT-BR
		for($i = 0 ; $i < count($objects); $i++){
			$objects[$i]['data'] = date('d/m/Y H:i:s', strtotime($objects[$i]['data']));
			//$objects[$i]['pareceristas'] = $this->get_pareceristas($objects[$i]['id_eixo']);
		}
		// print_r($objects); exit();

		$dados['table_header'] 		= $table_header;
		$dados['table_body']	 	= $table_body;
		$dados['objects'] 			= $objects;
		$dados['data_input_modal']  = $data_input_modal;

		$dados['funcao'] 			= 'listar_para_validacao';
		$dados['titulo'] 			= 'Trabalhos Para Validação';

		$dados['quantidade'] 		= $this->trabalho_model->num_rows_where_status($status);
		$dados['mensagens'] 		= mensagens();
		$dados['url'] = array('aprovar' => base_url('Trabalho/validar/'), 'reprovar' => base_url('Trabalho/enviar_email_participante/'));

		$this->load->view('html-header-admin');
		$this->load->view('header-admin');
		$this->load->view('modal/modal_listar_trabalhos');
		$this->load->view('listar-trabalhos-para-validacao', $dados);
		$this->load->view('footer-admin');
	}

	public function getCoautoresTrabalho($id_trabalho){
		$coautores = $this->trabalho_model->getCoautoresTrabalho($id_trabalho);
		$html = "";
		?><ul id="coautores"><?php
		if(count($coautores) == 0){
			?><li style="list-style: initial">Não há coautores</li><?php			
		}
		foreach ($coautores as $key => $value) {			 
      ?><li style="list-style: initial"><?=$value['nome']?></li><?php
		}
		?></ul><?php
	}

	public function listar_validados(){
		$status = 1; //1 é status VÁLIDO


		$table_header = array(

			array('icon' => '', 'label' => 'Nome'),
			array('icon' => 'fa fa-book', 'label' => 'Título Trabalho'),
			array('icon' => '', 'label' => 'Eixo'),
			array('icon' => '', 'label' => 'Tipo usuário'),
			array('icon' => '', 'label' => 'Data de Submissão')

		);

		$table_body = array('nome', 'titulo', 'eixo', 'tipo', 'data');


		$data_input_modal = array(
			//array('name' => 'justificativa', 'label' 	=> 'Justificativa', 'type' => 'input_text'),
			array('name' => 'id_eixo', 'label' => '', 'type' => 'hidden'),
			array('name' => 'id', 'label' => 'ID', 'type' => 'input_text'),
			array('name' => 'nome', 'label' 	=> 'Nome','type' 	=> 'input_text'),
			array('name' => 'email', 'label' 	=> 'E-mail', 'type' => 'input_text'),
			array('name' => 'tipo', 'label' 	=> 'Tipo', 'type' => 'input_text'),
			array('name' => 'titulo', 'label' 	=> 'Titulo', 'type' => 'input_text'),
			array('name' => 'eixo', 'label' 	=> 'Eixo', 'type' => 'input_text'),
			array('name' => 'data', 'label' 	=> 'Data', 'type' => 'input_text'),
			array('name' => 'arquivo_sem_nome_autor', 'label' 	=> 'Arquivo Sem Nome Autor', 'type' => 'input_file'),
			array('name' => 'arquivo_com_nome_autor', 'label' 	=> 'Arquivo Com Nome Autor', 'type' => 'input_file'),
			array('name' => 'pareceristas', 'label' => 'Selecione o parecerista', 'type' => 'special_select', 'url' => ''.base_url('Trabalho/get_pareceristas/'), 'id' => 'id_eixo')


		);



		$objects = $this->trabalho_model->get_all_where_status($status);


		//converter a data para PT-BR
		for($i = 0 ; $i < count($objects); $i++){
			$objects[$i]['data'] = date('d/m/Y H:i:s', strtotime($objects[$i]['data']));
			//$objects[$i]['pareceristas'] = $this->get_pareceristas($objects[$i]['id_eixo']);
		}
		// print_r($objects); exit();

		$dados['table_header'] 		= $table_header;
		$dados['table_body']	 	= $table_body;
		$dados['objects'] 			= $objects;
		$dados['data_input_modal']  = $data_input_modal;


		$dados['funcao'] 			= 'listar_validados';
		$dados['titulo'] 			= 'Trabalhos Validados';

		$dados['quantidade'] 		= $this->trabalho_model->num_rows_where_status($status);
		$dados['mensagens'] 		= mensagens();
		$dados['url'] = array('aprovar' => base_url('Trabalho/enviar_para_parecerista/'));

		$this->load->view('html-header-admin');
		$this->load->view('header-admin');
		$this->load->view('modal/modal_listar_validados');
		$this->load->view('listar-trabalhos', $dados);
		$this->load->view('footer-admin');
	}



	public function listar_invalidos(){
		$status = 2; //1 é status VÁLIDO


		$table_header = array(

			array('icon' => '', 'label' => 'Nome'),
			array('icon' => 'fa fa-book', 'label' => 'Título Trabalho'),
			array('icon' => '', 'label' => 'Eixo'),
			array('icon' => '', 'label' => 'Tipo usuário'),
			array('icon' => '', 'label' => 'Data de Submissão'),
			array('icon' => '', 'label' => 'Prazo para Reenvio'),
			array('icon' => '', 'label' => 'Justificativa'),
			array('icon' => '', 'label' => 'Status')



		);

		$table_body = array('nome', 'titulo', 'eixo', 'tipo', 'data', 'prazo', 'justificativa', 'status');


		$data_input_modal = array(
			//array('name' => 'justificativa', 'label' 	=> 'Justificativa', 'type' => 'input_text'),
			array('name' => 'id_eixo', 'label' => '', 'type' => 'hidden'),
			array('name' => 'id', 'label' => 'ID', 'type' => 'input_text'),
			array('name' => 'nome', 'label' 	=> 'Nome','type' 	=> 'input_text'),
			array('name' => 'email', 'label' 	=> 'E-mail', 'type' => 'input_text'),
			array('name' => 'tipo', 'label' 	=> 'Tipo', 'type' => 'input_text'),
			array('name' => 'titulo', 'label' 	=> 'Titulo', 'type' => 'input_text'),
			array('name' => 'eixo', 'label' 	=> 'Eixo', 'type' => 'input_text'),
			array('name' => 'data', 'label' 	=> 'Data', 'type' => 'input_text'),
			array('name' => 'arquivo_sem_nome_autor', 'label' 	=> 'Arquivo Sem Nome Autor', 'type' => 'input_file'),
			array('name' => 'arquivo_com_nome_autor', 'label' 	=> 'Arquivo Com Nome Autor', 'type' => 'input_file'),
			array('name' => 'prazo', 'label' => 'Prazo', 'type' => 'input_text'),
			array('name' => 'justificativa', 'label' => 'justificativa', 'type' => 'input_text')



		);



		$objects = $this->trabalho_model->get_all_where_refused();


		$date = date('Y-m-d');
		//converter a data para PT-BR
		for($i = 0 ; $i < count($objects); $i++){
			$objects[$i]['data'] = date('d/m/Y', strtotime($objects[$i]['data']));
			$diferenca = strtotime($objects[$i]['prazo']) - strtotime($date) ;


			$quantidade_de_dias = 1+ floor($diferenca / (60 * 60 * 24));
			$objects[$i]['prazo'] = date('d/m/Y', strtotime($objects[$i]['prazo'])).'<br>(faltam '.$quantidade_de_dias.' dias)';

			//$objects[$i]['prazo'] = date('d/m/Y', strtotime($objects[$i]['prazo']));

			switch($objects[$i]['status']){
				case 2: $status = 'Recusado'; break;
				case 4: $status = 'Reenviar Trabalho Sem Autor'; break;
				case 5: $status = 'Reenviar Trabalho Com Autor'; break;
				case 6: $status = 'Reenviar Ambos'; break;
				case 7: $status = ''; break;
			}
			/*switch($objects[$i]['status_coautores']){
				case 1: if ($status == '') $status = 'Alterar coautores';
				else $status .= ' - Alterar coautores'; 
				break;
			}*/
			$objects[$i]['status'] = $status;

		}


		$dados['table_header'] 		= $table_header;
		$dados['table_body']	 	= $table_body;
		$dados['objects'] 			= $objects;
		$dados['data_input_modal']  = $data_input_modal;


		$dados['funcao'] 			= 'listar_invalidados';
		$dados['titulo'] 			= 'Trabalhos Inválidos - Clique em "Aceitar" para que o trabalho seja Válido.';

		$dados['quantidade'] 		= $this->trabalho_model->num_rows_where_refused();
		$dados['mensagens'] 		= mensagens();
		$dados['url'] = array('aprovar' => base_url('Trabalho/aprovar_trabalho_invalido/'));

		$this->load->view('html-header-admin');
		$this->load->view('header-admin');
		$this->load->view('modal/modal_listar_invalidos');
		$this->load->view('listar-trabalhos', $dados);
		$this->load->view('footer-admin');
	}

	public function aprovar_trabalho_invalido($id_trabalho){
		$this->db->where('id_participante', $id_trabalho);
		$dados['status'] = 1;
		$this->db->update('trabalho', $dados);

		$this->db->where('id_participante', $id_trabalho);
		$trabalho = $this->db->get('trabalho')->row();


		$this->session->set_flashdata('success', 'O trabalho <b>"'.$trabalho->titulo.'"</b> foi alterado para <b>VÁLIDO</b>.');
		$this->log_model->insert_admin('Trabalho :', $id_participante.' alterado para valido.');


		redirect('Trabalho/listar_invalidos');

	}

	public function validar($id_participante){
		$this->db->where('id_participante', $id_participante);
		$dados['status'] = 1;
		$this->db->update('trabalho', $dados);

		$this->db->where('id_participante', $id_participante);
		$trabalho = $this->db->get('trabalho')->row();


		$this->session->set_flashdata('success', 'O trabalho <b>"'.$trabalho->titulo.'"</b> foi validado com sucesso!');
		$this->log_model->insert_admin('Validado o trabalho de :', $id_participante);

		redirect('Trabalho/listar_para_validacao');

	}

	public function enviar_para_parecerista($id_participante){

		if($this->input->post('pareceristas') != ''){

			$update['status'] = '3';//Status enviado para o parecerista
			$this->db->where('id_participante', $id_participante);
			$this->db->update('trabalho', $update);

			$dados['id_trabalho'] = $id_participante;
			$dados['id_parecerista'] = $this->input->post('pareceristas');

			$this->db->insert('trabalho_parecerista', $dados);

			$this->db->where('id_participante', $id_participante);
			$this->db->select('titulo');
			$trabalho = $this->db->get('trabalho')->row();

			$this->db->where('id',$this->input->post('pareceristas'));
			$parecerista = $this->db->get('parecerista')->row();

			$this->enviar_email_parecerista($parecerista, $trabalho);


			$this->session->set_flashdata('success', 'Trabalho '.$trabalho->nome.' adicionado ao parecerista '.$parecerista->nome.'.');
		}else{
			$this->session->set_flashdata('danger', 'Selecione um parecerista.');

		}
		redirect('Trabalho/listar_validados');
	}

	public function enviar_email_participante()
	{
		$id_participante = $this->input->post('id');
		$status = $this->input->post('status');
		$status_coautores = $this->input->post('status_coautores');
		
		$justificativa = $this->input->post('mensagem');

		$data_limite = $this->input->post('data_limite'); //prazo

		$this->trabalho_model->reenviar_trabalhos($id_participante, $status, $status_coautores, $data_limite, $justificativa);
		$titulo = "Trabalho Reprovado Na Fase de Validação";
		$mensagem = "<h2>Olá Congressista! <br> Seu trabalho não passou na Fase de Validação. </h2> <br> Mensagem: <br>";
		$mensagem .= $this->input->post('mensagem');
		$mensagem .= "<h3> Atenção! Você tem até o <strong>DIA ".date('d/m/Y', strtotime($data_limite))."</strong> para reenviar seu trabalho!";
		$email = $this->input->post('email');
		$resposta = $this->send_email_with_title($titulo, $mensagem, $email);
		if($resposta){
			$this->log_model->insert_admin('Foi enviado o e-mail de reenvio de trabalho para o participante.', $id_participante);
			$this->session->set_flashdata('success', 'Email enviado com sucesso!');

		}
		else{
			$this->log_model->insert_admin('Houve um erro no envio do e-mail para o participante.', $id_participante);
			$this->session->set_flashdata('danger', htmlspecialchars($resposta));

		}
	}

	public function enviar_email_parecerista($parecerista, $trabalho)
	{
		//Envia e-mail para parecerista, avisando que um novo trabalho necessita de seu parecer
		$titulo = "Novo Trabalho para Parecer";
		$mensagem  = "<h2>Olá " . $parecerista->nome . "!</h2>";
		$mensagem .= "<p>O trabalho <strong>\"" . $trabalho->titulo . "\"</strong> necessita do seu parecer.</p>";
		$mensagem .= "<p>Acesse o painel do parecerista clicando <a href='http://pedagogiahistoricocritica.com.br/Login/'>aqui</a></p>";
		$mensagem .= "<br><br><br>";
		$mensagem .= "<p>Atensiosamente, <strong>COORDENAÇÃO GERAL DO CONGRESSO PEDAGOGIA HISTÓRICO-CRÍTICA</strong>.<p>";
		echo $mensagem;
		$email = $parecerista->email;
		$resposta = $this->send_email_with_title($titulo, $mensagem, $email);
		if($resposta){
			$this->log_model->insert_admin('Foi enviado o e-mail notificação de trabalho para parecer.', $parecerista->id);
			$this->session->set_flashdata('success', 'Email enviado com sucesso!');

		}
		else{
			$this->log_model->insert_admin('Houve um erro no envio do e-mail de notificação de trabalho para parecer.', $id_participante);
			$this->session->set_flashdata('danger', htmlspecialchars($resposta));

		}
	}

	public function setar_trabalho_manualmente(){

		$objects = $this->participante_model->participantes_submeter_trabalho();
		$data = array();
		//print_r($objects);
		foreach($objects as $object){
            //$data[] = new stdClass(); 
			$aux = (object) array('value' => $object->id,'cpf'=> $object->cpf, 'label' => $object->nome." - ".$object->email);
			$data[] = $aux;
		}

		$data['objects'] = $data;
		$data['mensagens'] = mensagens();
		$data['eixos'] = $this->trabalho_model->get_eixos_trabalhos();


		$this->load->view('html-header-admin');
		$this->load->view('header-admin');
		$this->load->view('setar-trabalho', $data);
		$this->load->view('footer-admin');
	}

	public function do_upload_article($name){

		$upload_path = 'uploads/artigo';

		$config['upload_path']          = $upload_path;
		$config['allowed_types']        = 'doc|docx|pdf';
		$config['max_size']             = 10000;
		$config['encrypt_name']         = TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($name))
		{
			$resposta['deu_certo'] = false;
			$resposta['message'] = $this->upload->display_errors();
		}
		else
		{   
			$resposta['deu_certo'] = true;
			$resposta['message'] = $this->upload->data('file_name');
		}
		return $resposta;
	}
	public function getcouator($cpf)
	{
		if ($cpf!="") {
			$this->db->where('cpf', $cpf);
			$this->db->where('(status_inscricao = 1 OR status_inscricao = 3)');
			$this->db->select('id, nome');
			return $this->db->get('participante')->row();
		}
		return "";
	}

	public function coautor($cpf=""){
		if ($cpf!="") {
			$participante = $this->getcouator($cpf);
			echo json_encode($participante);
		}
	}
	public function exists_coautores($coautores){
		foreach ($coautores as $cpf) {
			$qcoaut = $this->getcouator($cpf);
			if(!$qcoaut)
				return false;
		}
		return true;
	}
	public function cpf_diferente($coautores, $cpf_participante){
		foreach ($coautores as $cpf) {
			if($cpf ==  $cpf_participante->cpf){
				return false;
			}		
		}
		return true;
	}

	public function enviar_trabalho_participante(){
		$resposta1 = $this->do_upload_article('artigo_com_autor');
		$resposta2 = $this->do_upload_article('artigo_sem_autor');


		if($resposta1['deu_certo'] && $resposta2['deu_certo']){
			$data['arquivo_com_nome_autor'] = $resposta1['message'];
			$data['arquivo_sem_nome_autor'] = $resposta2['message'];
			$data['titulo'] = $this->input->post('titulo');
			$data['id_eixo'] = $this->input->post('eixo');
			$coautores = $this->input->post('coautoresCPF');
			$data['id_participante'] = $this->input->post('participante');
			if($this->cpf_diferente($coautores, $this->participante_model->get_cpf($data['id_participante']))){ //cpf do participante diferente do coautor
				if($this->exists_coautores($coautores)){ //se o coautor existe como pago
					if(!$this->trabalho_model->get_trabalho($data['id_participante'])){
						
						$this->db->where("id_participante", $data['id_participante']);
						$this->db->insert('trabalho', $data);

					}
					else{
						$this->db->where("id_participante",$data['id_participante']);
						$this->db->set("arquivo_com_nome_autor",$data['arquivo_com_nome_autor']);
						$this->db->set("arquivo_sem_nome_autor",$data['arquivo_sem_nome_autor']);
						$this->db->set("titulo",$data['titulo']);
						$this->db->set("id_eixo",$data['id_eixo']);
						$this->db->update('trabalho');
					}
					$cdata['id_trabalho'] = $data['id_participante'];

					$cpf_participante = $this->participante_model->get_cpf($data['id_participante']);
					foreach ($coautores as $cpf) {
			        	if($cpf != $cpf_participante){ //se o cpf do coautor for diferente do CPF do usuário:
			        		$qcoaut = $this->getcouator($cpf);
			        		if($qcoaut){
			        			$cdata['id_participante'] = $qcoaut->id;
			        			$this->db->insert('coautor', $cdata);
			        		}
			        	}
			        }

			        $this->log_model->insert('O participante enviou o artigo.', $data['id_participante']);
			        $this->session->set_flashdata('success', 'Artigo enviado para análise.');
			    }else{
			    	$this->session->set_flashdata('danger', "Não foi possível enviar o arquivo, pois o coautor não teve o pagamento confirmado");
			    }
			}else{
				$this->session->set_flashdata('danger', "O participante não pode ser coautor do seu próprio trabalho!");
			}
		}else{

			if($resposta1['deu_certo'] != true) $this->session->set_flashdata('danger', $resposta1['message']);
			if($resposta2['deu_certo'] != true) $this->session->set_flashdata('danger', $resposta2['message']);
		}

		redirect(base_url('Trabalho/setar_trabalho_manualmente'));
	}

	public function listar_pareceres_aprovados(){
		$this->load->view('html-header-admin');
		$this->load->view('header-admin');
		$this->load->view('modal/modal_listar_pareceres');
		$this->load->view('listar-pareceres');
		$this->load->view('footer-admin');
	}
}


?>