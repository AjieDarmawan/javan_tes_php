<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Navbar {
	
	private $menu;
	private $menuActive;
	private $subMenuActive;
	protected $controller;
	protected $sess = array();
	
    public function __construct() {
		$this->controller = & get_instance();
		if($this->controller->ion_auth->logged_in())
		{
			//echo "<pre>";
			$this->sess = $this->controller->session->userdata('session');
			// print_r($this->sess['role']->id);die();

			switch($this->sess['role']->id)
			{
				case 1:
					$this->allowAdmin();
					break;
				case 3:
					$this->allowVerifikator();
					break;
				case 4:
					$this->allowHCM();
					break;
				default:
					$this->allowKaryawan();
					break;
			}

		}
    }
	
	private function allowAdmin()
	{
		$this->setMenuBeranda();
		$this->setMenuDashboard();
		$this->setMenuDataKaryawan();
		$this->setMenuDistinctJobManual();
		// $this->setMenuUlangTahunDinas();
		$this->setMenuAssessment();
		$this->setMenuKontrak();
		$this->setMenuOrganisasiJabatan();
		$this->setMenuKinerja();
		$this->setMenuCuti();
		$this->setMenuSPJ();
		$this->setMenuPresensi();
		$this->setMenuPengumuman();
		$this->setMenuPendi();
		$this->setMenuPengguna();
		$this->setMenuReferensi();
		$this->setMenuReferensiSO();
		$this->setMenuSO();
	}

	private function allowKaryawan()
	{
		$this->setMenuBeranda();
		$this->setMenuProfilKaryawan();
		$this->setMenuDataKaryawan();
		// $this->setMenuUlangTahunDinas();
		$this->setMenuKaryawanAssessment();
		$this->setMenuKaryawanUsulanCuti();
		$this->setMenuKaryawanUsulanSPJ();
		$this->setMenuKaryawanPresensi();
		$this->setMenuPendi();
	}

	private function allowVerifikator()
	{
		$this->setMenuBeranda();
		$this->setMenuKaryawanUsulanCuti();
		$this->setMenuKaryawanUsulanSPJ();
		$this->setMenuKaryawanPresensi();
		$this->setMenuPendi();
	}

	private function allowHCM()
	{
		$this->setMenuBeranda();
		$this->setMenuDataKaryawan();
		$this->setMenuKontrak();
		$this->setMenuKaryawanUsulanCuti();
		$this->setMenuKaryawanUsulanSPJ();
		$this->setMenuKaryawanPresensi();
		$this->setMenuPendi();
		$this->setMenuSO();
	}

	private function setMenuKaryawanUsulanCuti()
	{
		$this->menu['cuti'] = array(
			"name" => 'Cuti Karyawan',
			"url"=>base_url('usulan_cuti'),
			"status"=>"", 
			"class"=>"fa fa-black-tie",
			"submenu"=> array(
				"usulan_cuti" => array(
					"name"=> "Usulan Cuti",
					"url"=>base_url('usulan_cuti'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"rekap_cuti" => array(
					"name"=> "Rekap Cuti",
					"url"=>base_url('usulan_cuti/daftar_cuti_karyawan/')."?karyawan_id=".encode_url($this->sess['user']->m_karyawan_id),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
			),
		);
	}

	private function setMenuDistinctJobManual()
	{
		$this->menu['djm'] = array(
			"name" => 'Distinct Job Manual',
			"url" =>base_url('djm'),
			"status" => "",
			"class" => "fa fa-book",
			"submenu" => null
		);
	}

	private function setMenuUlangTahunDinas()
	{
		$this->menu['utd'] = array(
			"name"=>'Ulang Tahun Dinas',
			"url"=>base_url('ulang_tahun_dinas'),
			"status"=>"",
			"class"=>"fa fa-birthday-cake",
			"submenu"=>null,
		);
	}

	private function setMenuKaryawanAssessment()
	{
		$this->menu['assessment'] = array(
			"name"=>"Assessment",
			"url"=>base_url('assessment/list_assessment'),
			"status"=>"",
			"class"=>"fa fa-lightbulb-o",
			"submenu"=>null,
		);
	}

	private function setMenuAssessment()
	{
		$this->menu['assessment'] = array(
			"name"=>"Assessment",
			"url"=>base_url('assessment'),
			"status"=>"",
			"class"=>"fa fa-lightbulb-o",
			"submenu"=>null,
		);
	}

	private function setMenuKaryawanUsulanSPJ()
	{
		$this->menu['spj'] = array(
			"name" => 'Usulan SPPD',
			"url"=>base_url('usulan_spj'),
			"status"=>"", 
			"class"=>"fa fa-user-secret",
			"submenu"=>null);
	}
	
	public function setMenuKaryawanPresensi()
	{
		$this->menu['presensi'] = array(
			"name" => 'Presensi',
			"url"=>base_url('rekap_kehadiran'),
			"status"=>"", 
			"class"=>"fa fa-clock-o",
			"submenu"=> array(
				"usulan_presensi" => array(
					"name"=> "Usulan Kehadiran",
					"url"=>base_url('usulan_presensi'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"rekap_kehadiran"=>array(
					"name"=>"Presensi",
					"url"=>base_url('rekap_kehadiran'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),		
			)
		);
	}

	private function setMenuProfilKaryawan()
	{
		$this->menu['profil_karyawan'] = array(
			"name" => 'Biodata',
			"url"=>base_url('biodata/view/').encode_url($this->sess['user']->m_karyawan_id),
			"status"=>"", 
			"class"=>"fa fa-user",
			"submenu"=>null);
	}
	
	private function setMenuBeranda()
	{
		$this->menu['beranda'] = array(
			"name" => 'Beranda',
			"url"=>base_url('home'),
			"status"=>"", 
			"class"=>"glyphicon glyphicon-home",
			"submenu"=>null);
	}

	private function setMenuDashboard()
	{
		$this->menu['dashboard'] = array(
			"name" => 'Dashboard',
			"url"=>base_url('home/chart'),
			"status"=>"", 
			"class"=>"fa fa-bar-chart-o",
			"submenu"=>null);
	}

	private function setMenuKontrak()
	{
		$this->menu['kontrak_karyawan'] = array(
			"name" => 'Kontrak Karyawan',
			"url"=>base_url('kontrak_karyawan'),
			"status"=>"", 
			"class"=>"fa fa-calendar",
			"submenu"=>null);
	}
	
	private function setMenuDataKaryawan()
	{
		$this->menu['data_karyawan']= array(
			"name" => 'Data Karyawan',
			"url" => base_url('karyawan'),
			"status"=>"", 
			"class"=>"fa fa-users",
			"submenu"=>array(
				"karyawan_aktif" => array(
					"name"=> "Karyawan Aktif",
					"url"=>base_url('karyawan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"karyawan_nonaktif" => array(
					"name"=> "Karyawan Non Aktif",
					"url"=>base_url('karyawan/nonaktif'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"karyawan_tetap"=>array(
					"name"=>"Karyawan Tetap",
					"url"=>base_url('karyawan/tetap'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"karyawan_kontrak"=>array(
					"name"=>"Karyawan Kontrak",
					"url"=>base_url('karyawan/kontrak'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"karyawan_outsource"=>array(
					"name"=>"Karyawan Outsource",
					"url"=>base_url('karyawan/outsource'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),	
				"karyawan_berhenti"=>array(
					"name"=>"Karyawan Berhenti",
					"url"=>base_url('karyawan/berhenti'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),							
			)
		);
	}

	private function setMenuOrganisasiJabatan()
	{
		$this->menu['organisasi_jabatan']= array(
			"name" => "Organisasi & Jabatan",
			"url" => '',
			"status"=>"", 
			"class"=>"fa fa-fw fa-cubes",
			"submenu"=>array(
				"organisasi" => array(
					"name"=> "Organisasi",
					"url"=>base_url('organisasi'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"jabatan"=>array(
					"name"=>"Jabatan",
					"url"=>base_url('jabatan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"kelompok_jabatan"=>array(
					"name"=>"Kelompok Jabatan",
					"url"=>base_url('kelompok_jabatan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"validator_jabatan"=>array(
					"name"=>"Validator Jabatan SPPD",
					"url"=>base_url('jabatan/validator_spj'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),								
			)
		);
	}

	private function setMenuKinerja()
	{
		$this->menu['kinerja']= array(
			"name" => "Best Employee",
			"url" => '',
			"status"=>"", 
			"class"=>"fa fa-fw fa-cubes",
			"submenu"=>array(
				"periode_kinerja" => array(
					"name"=> "Periode Best Employee",
					"url"=>base_url('periode_kinerja'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"pengurang_kinerja"=>array(
					"name"=>"Pengurang Best Employee",
					"url"=>base_url('pengurang_kinerja'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"kategori_kinerja"=>array(
					"name"=>"Kategori Best Employee",
					"url"=>base_url('kategori_kinerja'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),								
			)
		);
	}

	private function setMenuCuti()
	{
		$this->menu['cuti']= array(
			"name" => "Cuti Karyawan",
			"url" => '',
			"status"=>"", 
			"class"=>"fa fa-black-tie",
			"submenu"=>array(
				"usulan_cuti" => array(
					"name"=> "Usulan Cuti",
					"url"=>base_url('usulan_cuti'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"rekap_cuti" => array(
					"name"=> "Rekap Cuti",
					"url"=>base_url('usulan_cuti/rekap_cuti'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"jenis_cuti" => array(
					"name"=> "Jenis Cuti",
					"url"=>base_url('jenis_cuti'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"satuan_cuti"=>array(
					"name"=>"Satuan Cuti",
					"url"=>base_url('satuan_cuti'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"tipe_cuti"=>array(
					"name"=>"Tipe Cuti",
					"url"=>base_url('tipe_cuti'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),								
			)
		);
	}

	private function setMenuSPJ()
	{
		$this->menu['spj'] = array(
			"name" => "SPPD Karyawan",
			"url" => "",
			"status" => "",
			"class" => "fa fa-user-secret",
			"submenu" => array(
				"usulan_spj" => array(
					"name"=> "Usulan SPPD",
					"url"=>base_url('usulan_spj'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"pembayaran_spj" => array(
					"name"=> "Pembayaran SPPD",
					"url"=>base_url('usulan_spj/pembayaran'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"tahun_anggaran" => array(
					"name"=> "Tahun Anggaran",
					"url"=>base_url('tahun_anggaran'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"jenis_transportasi" => array(
					"name"=> "Jenis Transportasi",
					"url"=>base_url('jenis_transportasi'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"zona_spj" => array(
					"name"=> "Zona SPPD",
					"url"=>base_url('zona_spj'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"alat_transportasi" => array(
					"name"=> "Alat Transportasi",
					"url"=>base_url('alat_transportasi'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"keperluan_spj" => array(
					"name"=> "Keperluan SPPD",
					"url"=>base_url('keperluan_spj'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"kode_akun" => array(
					"name"=> "Kode Akun",
					"url"=>base_url('kode_akun'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"lokasi_akun" => array(
					"name"=> "Lokasi Akun",
					"url"=>base_url('lokasi_akun'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"kategori_zona" => array(
					"name"=> "Kategori Zona",
					"url"=>base_url('kategori_zona'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"item_spj" => array(
					"name"=> "Item SPPD",
					"url"=>base_url('item_spj'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"tarif_spj" => array(
					"name"=> "Tarif SPPD",
					"url"=>base_url('tarif_spj'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"keberangkatan_spj" => array(
					"name"=> "Keberangkatan SPPD",
					"url"=>base_url('keberangkatan_spj'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"jarak_spj" => array(
					"name"=> "Jarak SPPD",
					"url"=>base_url('jarak_spj'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
			)
		);
	}

	private function setMenuPengumuman()
	{
		$this->menu['pengumuman']= array(
			"name" => "Pengumuman",
			"url" => '',
			"status"=>"", 
			"class"=>"fa fa-bullhorn",
			"submenu"=>array(
				"artikel" => array(
					"name"=> "Artikel",
					"url"=>base_url('artikel'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"kategori_artikel"=>array(
					"name"=>"Kategori Artikel",
					"url"=>base_url('kategori_artikel'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
			)
		);
	}

	private function setMenuPendi()
	{
		$this->menu['pendi'] = array(
			"name" => 'SimulasiPensiun Dini',
			"url"=>base_url('pendi'),
			"status"=>"", 
			"class"=>"fa fa-fw fa-calendar-times-o",
			"submenu"=>null);
	}


	private function setMenuPengguna()
	{
		$this->menu['pengguna']= array(
			"name" => "Manajemen Pengguna",
			"url" => '',
			"status"=>"", 
			"class"=>"fa fa-users",
			"submenu"=>array(
				"users" => array(
					"name"=> "Pengguna",
					"url"=>base_url('users'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"groups"=>array(
					"name"=>"Grup Pengguna",
					"url"=>base_url('groups'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"groups_jabatan"=>array(
					"name"=>"Grup Jabatan Pengguna",
					"url"=>base_url('groups_jabatan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"groups_karyawan"=>array(
					"name"=>"Grup Karyawan Pengguna",
					"url"=>base_url('groups_karyawan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"fungsi_kelompok"=>array(
					"name"=>"Fungsi Kelompok",
					"url"=>base_url('fungsi_kelompok'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"fungsi_pengguna"=>array(
					"name"=>"Fungsi Pengguna",
					"url"=>base_url('fungsi_pengguna'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
			)
		);
	}

	private function setMenuPresensi()
	{
		$this->menu['presensi']= array(
			"name" => "Presensi Karyawan",
			"url" => '',
			"status"=>"", 
			"class"=>"fa fa-clock-o",
			"submenu"=>array(
				"usulan_presensi"=>array(
					"name"=>"Usulan Kehadiran",
					"url"=>base_url('usulan_presensi'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"kehadiran_source"=>array(
					"name"=>"Asal Kehadiran",
					"url"=>base_url('kehadiran_source'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"riwayat_hari_libur" => array(
					"name"=> "Riwayat Hari Libur",
					"url"=>base_url('riwayat_hari_libur'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"hari_libur" => array(
					"name"=> "Hari Libur",
					"url"=>base_url('hari_libur'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"bulan"=>array(
					"name"=>"Bulan",
					"url"=>base_url('Bulan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"rekap_kehadiran"=>array(
					"name"=>"Rekap Kehadiran",
					"url"=>base_url('rekap_kehadiran'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
			)
		);
	}

	private function setMenuReferensi()
	{
		$this->menu['referensi']= array(
			"name" => "Referensi",
			"url" => '',
			"status"=>"", 
			"class"=>"glyphicon glyphicon-cog",
			"submenu"=>array(
				"agama" => array(
					"name"=> "Agama",
					"url"=>base_url('agama'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"bank"=>array(
					"name"=>"Bank",
					"url"=>base_url('bank'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"instansi_pendidikan"=>array(
					"name"=>"Instansi Pendidikan",
					"url"=>base_url('instansi_pendidikan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"jenis_kelamin"=>array(
					"name"=>"Jenis Kelamin",
					"url"=>base_url('jenis_kelamin'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"jenis_kontak"=>array(
					"name"=>"Jenis Kontak",
					"url"=>base_url('jenis_kontak'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"jenis_organisasi"=>array(
					"name"=>"Jenis Organisasi",
					"url"=>base_url('jenis_organisasi'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"jenjang_pendidikan"=>array(
					"name"=>"Jenjang Pendidikan",
					"url"=>base_url('jenjang_pendidikan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"level_penghargaan"=>array(
					"name"=>"Level Penghargaan",
					"url"=>base_url('level_penghargaan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"lokasi_kerja"=>array(
					"name"=>"Lokasi Kerja",
					"url"=>base_url('lokasi_kerja'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"status_karyawan"=>array(
					"name"=>"Status Karyawan",
					"url"=>base_url('status_karyawan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"status_nikah"=>array(
					"name"=>"Status Nikah",
					"url"=>base_url('status_nikah'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
			)
		);
	}

	private function setMenuReferensiSO()
	{
		$this->menu['referensi_so']= array(
			"name" => "Referensi SO",
			"url" => '',
			"status"=>"", 
			"class"=>"glyphicon glyphicon-cog",
			"submenu"=>array(
				"item" => array(
					"name"=> "Item",
					"url"=>base_url('Referensi_so/item'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"klasifikasi" => array(
					"name"=> "Klasifikasi",
					"url"=>base_url('Referensi_so/klasifikasi'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"perangkat"=>array(
					"name"=>"Perangkat",
					"url"=>base_url('Referensi_so/perangkat'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"perangkat_layanan"=>array(
					"name"=>"Layanan Perangkat",
					"url"=>base_url('Referensi_so/perangkat_layanan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"klasifikasi_layanan"=>array(
					"name"=>"Klasifikasi Layanan",
					"url"=>base_url('Referensi_so/klasifikasi_layanan'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"zona"=>array(
					"name"=>"Zona",
					"url"=>base_url('Referensi_so/zona'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
			)
		);
	}

	private function setMenuSO()
	{
		$this->menu['so'] = array(
			"name" => "Service Order",
			"url" => "",
			"status" => "",
			"class" => "fa fa-user-secret",
			"submenu" => array(
				"usulan_so" => array(
					"name"=> "Usulan SO",
					"url"=>base_url('usulan_service_order'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
				"usulan_spb" => array(
					"name"=> "Usulan SPB",
					"url"=>base_url('usulan_spb'),
					"status"=>"", 
					"class"=>"fa fa-circle-o",
				),
			)
		);
	}

	public function setMenuActive($index)
	{
		$this->menuActive = $index;
	}
	public function setSubMenuActive($index)
	{
		$this->subMenuActive = $index;
	}

	public function getMenuActive()
	{
		return $this->menuActive;
	}

	public function getSubMenuActive()
	{
		return $this->subMenuActive;
	}

	public function getMenu()
	{
		if($this->menuActive!==null)
		{
			if(isset($this->menu[$this->menuActive]))
			{
				$this->menu[$this->menuActive]["status"] = "active";
				if($this->subMenuActive!==null)
				{
					if(is_array($this->menu[$this->menuActive]["submenu"]))
					{
						if(isset($this->menu[$this->menuActive]["submenu"][$this->subMenuActive]))
						{
							$this->menu[$this->menuActive]["submenu"][$this->subMenuActive]["status"] = "active";
						}
					}
				}
			}
		}
		return $this->menu;
	}
}
