<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_m extends CI_Model {

	public function load_form_rules() {
		$form_rules = array(
			array(
				'field' => 'u_name',
				'label' => 'username',
				'rules' => 'required'
				),
			array(
				'field' => 'pass_word',
				'label' => 'password',
				'rules' => 'required'
				),
			);
		return $form_rules;
	}

	public function validasi() {
		$form = $this->load_form_rules();
		$this->form_validation->set_rules($form);

		if ($this->form_validation->run()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

    // cek status user, login atau tidak?
	public function cek_user() {
		$u_name = strtolower($this->input->post('u_name'));
		$pass_word = $this->input->post('pass_word');
		
		$username = $this->converter->encode($u_name);
		$password = $this->converter->encode($pass_word);		
		//$query = $this->db->select('admin.*')
		$query = $this->db->select('admin.*,level.*')
		->join('level','level.id=admin.level','left')		
		->where('admin.username', $username)
		->where('admin.password', $password)
		->where('admin.status', '1')
		->where('admin.deleted_at', null)
		->limit(1)
		->get('admin');
		error_log($this->db->last_query());
		if ($query->num_rows() == 1) {
			$row = $query->row();
			
			$data = array(
				'login'				=> TRUE,
				'u_name' 			=> ucwords($u_name), 
				'operator_id' 		=> $row->operator_id,
				'id_merchant' 		=> $row->id_merchant,
				'level_name'		=> $row->level_name,
				'level'				=> $row->level,
				'principal'			=> $row->principal,
				'category'			=> $row->category,
				'product'			=> $row->product,
				'paket'				=> $row->paket,
				'members'			=> $row->members,
				'chat'				=> $row->chat,
				'waiting_payment'	=> $row->waiting_payment,
				'payment_complete'	=> $row->payment_complete,
				'dikirim'			=> $row->dikirim,
				'sampai_tujuan'		=> $row->sampai_tujuan,
				'complete'			=> $row->complete,
				'reject'			=> $row->reject,
				'tagihan'			=> $row->tagihan,
				'angsuran'			=> $row->angsuran,
				'reporting'			=> $row->reporting,
				'master_bank'		=> $row->master_bank,
				'tempo_payment'		=> $row->tempo_payment,
				'area'				=> $row->area,
				'brand'				=> $row->brand,
				'tier'				=> $row->tier,
				'province'			=> $row->province,
				'banner'			=> $row->banner,
				'level_role'		=> $row->level_role,
				'setting'			=> $row->setting,
				'users'				=> $row->users
			);
			
			// simpan data session jika login benar
			$this->session->set_userdata($data);
			return TRUE;
		} else {
			return FALSE;
		}
		
	}

	// public function logout() {
		// $this->session->unset_userdata(array('u_name' => '', 'login' => FALSE));
		// $this->session->sess_destroy();
	// }
}
