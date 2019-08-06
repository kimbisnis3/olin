<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekappenawaranperiode extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata['sioin'] == TRUE)
        {
        }
        else
        {
            $this->session->set_flashdata('message', '<div style="color : red;">Login Terlebih Dahulu</div>');
            redirect('auth');
        }

        $this->load->model('Pengadaan/M_rekappenawaranperiode');
        $this->load->helper('indonesian_date');
        $this->load->model('M_sidebar'); 
    }

    public function index(){
        $data['title']      = 'Rekap Penawaran Periode | ';
        $nik = $this->session->userdata('nik');
        $this->load->view('Pengadaan/rekappenawaranperiode/v_rekappenawaranperiode', $data);  
    }

    public function setView(){
        $awal   = date('Y-m-d', strtotime($this->input->post('awal')));
        $akhir  = date('Y-m-d', strtotime($this->input->post('akhir')));
        $result     = $this->M_rekappenawaranperiode->getSemua($awal, $akhir);
        $list       = array();

        foreach ($result as $r) {
            $row    = array(
                        'namaagen' => $r->namaagen,
                        'header' => "<b style='font-weight : bolder;'>Departemen /  Distrik :  ".$r->namaagen."</b>"
            );

            $list[] = $row;
        }   
        echo json_encode(array('data' => $list));
    }

    public function setDetail(){
        $namaagen   = $this->input->post('namaagen');
        $result = $this->M_rekappenawaranperiode->getDetail($namaagen);
        $no         = 1;
        $str        = '<table class="table table-hover">
                        <tr>
                            <th>No. </th>
                            <th>Tanggal</th>
                            <th>Kode</th>
                            <th>Supplier</th>
                            <th>No Penawaran</th>
                            <th>Petugas</th>
                            <th>Keterangan</th>
                        </tr>';
        foreach ($result as $r) {

            $str    .= '<tr>
                            <td>'.$no.'.</td>
                            <td>'.date('d-m-Y', strtotime($r->tgl)).'</td>
                            <td>'.$r->kodex.'</td>
                            <td>'.$r->namasup.'</td>
                            <td>'.$r->nopenawaran.'</td>
                            <td>'.$r->namakar.'</td>
                            <td>'.$r->ket.'</td>
                        </tr>';

            $no++;
        }

        $str        .= '</table>';
        echo $str;
    }

    public function printf(){
        $data['title']      = 'Rekap Penawaran Periode ';
        $awal   = date('Y-m-d', strtotime($this->input->post('awal')));
        $akhir  = date('Y-m-d', strtotime($this->input->post('akhir')));
        $data['awal'] = indonesian_date($awal);
        $data['akhir'] = indonesian_date($akhir);
        $data['rpp']     = $this->M_rekappenawaranperiode->getcetak($awal, $akhir);
        $this->load->view('Pengadaan/rekappenawaranperiode/p_rekappenawaranperiode',$data);
    }

    public function emailpdf()
    {
        //Process Create PDF

        $mpdf = new mPDF('utf-8', 'A4-L');
        $path = base_url('uploads');
        $awal   = date('Y-m-d', strtotime($this->input->post('awalx')));
        $akhir  = date('Y-m-d', strtotime($this->input->post('akhirx')));
        $emailadd  = $this->input->post('email');
        $data['awal'] = indonesian_date($awal);
        $data['akhir'] = indonesian_date($akhir);
        $data['awalx'] = $awal;
        $data['akhirx'] = $akhir;
        $data['rpp']     = $this->M_rekappenawaranperiode->getcetak($awal, $akhir);
        $data['title']      = 'Rekap Penawaran Periode ';
        $html = $this->load->view('Pengadaan/rekappenawaranperiode/pdf_rekappenawaranperiode',$data, true);
        $filename = "Rekap_Penawaran_Periode".time();
        $mpdf->WriteHTML($html);
        $mpdf->shrink_tables_to_fit=1;
        $mpdf->Output("./uploads/".$filename.".pdf", "F");
        
        //Process Emailing

        $config = Array( 
                'protocol' => 'smtp', 
                'smtp_host' => 'ssl://smtp.gmail.com', 
                'smtp_port' => 465, 
                'smtp_user' => 'sioutra2@gmail.com', 
                'smtp_pass' => 'rigit2017utra',
                'mailtype' => 'html', 
                'charset' => 'iso-8859-1', 
                'wordwrap' => TRUE 
                ); 

        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        $to     = $this->input->post('email');
        $this->email->from('sioutra2@gmail.com', 'SIO UTRA');
        $this->email->to($emailadd);
        $this->email->subject('<no reply> Rekap Penawaran Periode');
        $this->email->message('Email ini dihasilkan dari SIO (Sistem Integrasi Online) PT. Guwatirta Sejahtera (UTRA). Jangan membalas melalui email ini, tetapi silahkan menghubungi kontak perusahaan atau melalui website www.utra.co.id');
        $this->email->attach("./uploads/".$filename.".pdf");
        if ($this->email->send()) {
                echo json_encode(array("email" => TRUE));  
                unlink("./uploads/".$filename.".pdf"); 
        }else{
                print_r($this->email->print_debugger());
        }
    }

}
