<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require("Navbar.php");
class Navigation extends Navbar{
	
	private $breadcrumb;
    public function __construct() {
			parent::__construct();
			$this->controller = & get_instance();
	}
	
	public function setBreadcrumbBeranda()
	{
		$this->breadcrumb = array(
			'Beranda' => base_url('home')
		);
	}

	public function setBreadcrumbDashboard()
	{
		$this->breadcrumb = array(
			'Dashboard' => base_url('home/chart')
		);
	}

	public function setBreadcrumbKaryawan($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Data Karyawan' => base_url('karyawan'),
		);

		if($change == 'karyawan_aktif')
		{
			$this->breadcrumb['Karyawan Aktif'] = base_url('karyawan');
		}
		elseif($change=='karyawan_nonaktif')
		{
			$this->breadcrumb['Karyawan Non Aktif'] = base_url('karyawan/nonaktif');
		}
		elseif($change=='karyawan_berhenti')
		{
			$this->breadcrumb['Karyawan Berhenti'] = base_url('karyawan/berhenti');
		}
		elseif($change=='karyawan_kontrak')
		{
			$this->breadcrumb['Karyawan Kontrak'] = base_url('karyawan/kontrak');
		}
		elseif($change=='karyawan_outsource')
		{
			$this->breadcrumb['Karyawan Outsource'] = base_url('karyawan/outsource');
		}
		elseif($change=='karyawan_tetap')
		{
			$this->breadcrumb['Karyawan Tetap'] = base_url('karyawan/tetap');
		}
		elseif($change == 'biodata')
		{
			switch($param->r_status_karyawan_id)
			{
				case 2:
					$base_url = base_url('karyawan/kontrak'); break;
				case 3:
					$base_url = base_url('karyawan/outsource'); break;
				default:
					$base_url = base_url('karyawan'); break;
			}
			$this->breadcrumb[$param->nama_status_karyawan] = $base_url;
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
		}
		elseif($change == 'kontak')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Kontak'] = null;
		}
		elseif($change == 'alamat')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Alamat'] = null;
		}
		elseif($change == 'anak')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Anak'] = null;
		}
		elseif($change == 'pasangan')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['pasangan'] = null;
		}
		elseif($change == 'orang_tua')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Orang Tua'] = null;
		}
		elseif($change == 'pendidikan')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Pendidikan'] = null;
		}
		elseif($change == 'pelatihan')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Pelatihan'] = null;
		}
		elseif($change == 'mutasi')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Riwayat Karir'] = null;
		}
		elseif($change == 'kontrak')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Kontrak'] = null;
		}
		elseif($change == 'keluar')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Keluar'] = null;
		}
		elseif($change == 'lokasi_kerja')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Lokasi Kerja'] = null;
		}
		elseif($change == 'penghargaan')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Penghargaan'] = null;
		}
		elseif($change == 'pengalaman_kerja')
		{
			$this->breadcrumb[$param->nama] = base_url('biodata/view/').encode_url($param->id);
			$this->breadcrumb['Pengalaman Kerja'] = null;
		}

		if($action=="create")
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action=="delete")
		{
			$this->breadcrumb['Hapus'] = null;
		}
			
	}

	public function setBreadcrumbKontrak($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Kontrak Karyawan' => base_url('kontrak_karyawan')
		);

		if($change == 'dua_bulan_terakhir')
		{
			$this->breadcrumb['Dua Bulan Terakhir'] = base_url('kontrak_karyawan/dua_bulan_terakhir');
		}
		elseif($change == 'kontrak_berlaku')
		{
			$this->breadcrumb['Kontrak Berlaku'] = base_url('kontrak_karyawan');
		}
		elseif($change == 'kontrak_berakhir')
		{
			$this->breadcrumb['Kontrak Berakhir'] = base_url('kontrak_karyawan/dua_bulan_terakhir');
		}
	}

	public function setBreadcrumbOrganisasiJabatan($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Jabatan & Organisasi' => base_url()
		);

		if($change == 'jabatan')
		{
			$this->breadcrumb['Jabatan Karyawan'] = base_url('jabatan');
		}
		elseif($change == 'organisasi')
		{
			$this->breadcrumb['Organisasi Karyawan'] = base_url('organisasi');	
		}
		elseif($change == 'kelompok_jabatan')
		{
			$this->breadcrumb['Kelompok Jabatan Karyawan'] = base_url('kelompok_jabatan');	
		}
		elseif($change == 'validator_jabatan')
		{
			$this->breadcrumb['Validator SPPD Jabatan'] = base_url('jabatan/validator_spj');	
		}

		if($action=='create')
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=='edit')
		{
			$this->breadcrumb[$param->nama] = null;
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action=='delete')
		{
			$this->breadcrumb['Hapus'] = null;
		}
	}

	public function setBreadcrumbKinerja($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Best Employee' => base_url()
		);

		if($change == 'periode_kinerja')
		{
			$this->breadcrumb['Periode Best Employee'] = base_url('periode_kinerja');
		}
		elseif($change == 'pengurang_kinerja')
		{
			$this->breadcrumb['Pengurang Best Employee'] = base_url('pengurang_kinerja');
		}
		elseif($change == 'kategori_kinerja')
		{
			$this->breadcrumb['Kategori Best Employee'] = base_url('kategori_kinerja');
		}
		elseif($change == 'penilaian')
		{
			$this->breadcrumb['Periode Best Employee'] = base_url('periode_kinerja');
			$this->breadcrumb['Penilaian Periode '.$param['tahun']] = base_url('penilaian/index/').$param['id'];
		}

		if($action=="create")
		{
			if($change == 'penilaian')
			{
				$this->breadcrumb[$param['nama']] = base_url('biodata/view/').$param['karyawan_id'];
			}
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			if($change == 'periode_kinerja')
			{
				$this->breadcrumb[$param->tahun] = null;	
			}
			elseif($change == 'penilaian')
			{
				$this->breadcrumb[$param['nama']] = base_url('biodata/view/').$param['karyawan_id'];	
			}
			else
			{
				$this->breadcrumb[$param->nama] = null;
			}
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action == 'range_kinerja')
		{
			$this->breadcrumb[$param['tahun']] = base_url('periode_kinerja/index/').$param['periode_kinerja_id'];
			$this->breadcrumb[$param['nama']] = base_url().'range_kinerja/index'.$param['id'];
		}
		elseif($action == 'periode_kategori')
		{
			$this->breadcrumb[$param->tahun] = base_url('periode_kategori_kinerja/index/').encode_url($param->id);
		}
		elseif($action == 'view')
		{
			if($change == 'penilaian')
			{
				$this->breadcrumb[$param['nama']] = base_url('biodata/view/').$param['karyawan_id'];
			}
		}
	}

	public function setBreadcrumbCuti($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Cuti Karyawan' => base_url()
		);

		if($change == 'jenis_cuti')
		{
			$this->breadcrumb['Jenis Cuti'] = base_url('jenis_cuti');
		}
		elseif($change == 'satuan_cuti')
		{
			$this->breadcrumb['Satuan Cuti'] = base_url('satuan_cuti');	
		}
		elseif($change == 'tipe_cuti')
		{
			$this->breadcrumb['Tipe Cuti'] = base_url('tipe_cuti');	
		}
		elseif($change == 'usulan_cuti')
		{
			$this->breadcrumb['Usulan Cuti'] = base_url('usulan_cuti');
		}
		elseif($change == 'rekap_cuti')
		{
			$this->breadcrumb['Rekapitulasi Cuti'] = base_url('usulan_cuti/rekap_cuti');
		}
		elseif($change == 'daftar_cuti')
		{
			$this->breadcrumb['Daftar Cuti'] = base_url('usulan_cuti/daftar_cuti');
		}
		elseif($change == 'form_pengajuan')
		{
			$this->breadcrumb['Form Pengajuan'] = base_url('usulan_cuti/form_pengajuan');
			$this->breadcrumb[$param->nama_jenis_cuti] = base_url('usulan_cuti/form_pengajuan/'.encode_url($param->h_cuti_karyawan_id));
		}


		if($action=="create")
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			$this->breadcrumb[$param->nama] = null;
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action=="delete")
		{
			$this->breadcrumb['Hapus'] = null;
		}
		elseif($action=="view")
		{
			$this->breadcrumb['View'] = base_url('usulan_cuti/view/').encode_url($param->id);
			$this->breadcrumb[$param->nama] = null;
		}
	}

	public function setBreadcrumbSPJ($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'SPPD Karyawan' => base_url()
		);

		if($change == 'jenis_transportasi')
		{
			$this->breadcrumb['Jenis Transportasi'] = base_url('jenis_transportasi');
		}
		elseif($change == 'zona_spj')
		{
			$this->breadcrumb['Zona'] = base_url('Zona_spj');	
		}
		elseif($change == 'alat_transportasi')
		{
			$this->breadcrumb['Alat Transportasi'] = base_url('alat_transportasi');	
		}
		elseif($change == 'keperluan_spj')
		{
			$this->breadcrumb['Keperluan'] = base_url('keperluan_spj');
		}
		elseif($change == 'tahun_anggaran')
		{
			$this->breadcrumb['Tahun Anggaran'] = base_url('tahun_anggaran');
		}
		elseif($change == 'akun_spj')
		{
			$this->breadcrumb['Tahun Anggaran'] = base_url('tahun_anggaran');
			$this->breadcrumb[$param['tahun']] = base_url('akun_spj/index/').$param['id'];
		}
		elseif($change == 'kode_akun')
		{
			$this->breadcrumb['Kode Akun'] = base_url('kode_akun');
		}
		elseif($change == 'lokasi_akun')
		{
			$this->breadcrumb['Lokasi Akun'] = base_url('lokasi_akun');
		}
		elseif($change == 'kategori_zona')
		{
			$this->breadcrumb['Kategori Zona'] = base_url('kategori_zona');
		}
		elseif($change == 'item_spj')
		{
			$this->breadcrumb['Item SPPD'] = base_url('item_spj');
		}
		elseif($change == 'tarif_spj')
		{
			$this->breadcrumb['Tarif SPPD'] = base_url('tarif_spj');
		}
		elseif($change == 'usulan_spj')
		{
			$this->breadcrumb['Usulan SPPD'] = base_url('usulan_spj');
		}
		elseif($change == 'keberangkatan_spj')
		{
			$this->breadcrumb['Keberangkatan SPPD'] = base_url('keberangkatan_spj');
		}
		elseif($change == 'jarak_spj')
		{
			$this->breadcrumb['Jarak SPPD'] = base_url('jarak_spj');
		}

		if($action=="create")
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			$this->breadcrumb[$param->nama] = null;
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action=="delete")
		{
			$this->breadcrumb['Hapus'] = null;
		}
		elseif($action=="view")
		{
			$this->breadcrumb['Lihat Usulan SPPD'] = base_url('usulan_spj/view/').encode_url($param->id);
			$this->breadcrumb[$param->nama] = null;
		}
	}

	public function setBreadcrumbPengumuman($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Pengumuman' => base_url()
		);

		if($change == 'artikel')
		{
			$this->breadcrumb['Artikel'] = base_url('artikel');	
		}
		elseif($change == 'kategori_artikel')
		{
			$this->breadcrumb['Kategori Artikel'] = base_url('kategori_artikel');	
		}
	}

	public function setBreadcrumbPendi()
	{
		$this->breadcrumb = array(
			'Simulasi Pensiun Dini' => base_url('pendi')
		);
	}

	public function setBreadcrumbBispro($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Bisnis Proses' => base_url('bispro')
		);

		if($change == 'bisproversion')
		{
			$this->breadcrumb['Revisi Bisnis Proses'] = base_url('bispro');
		}elseif($change == 'bispro_kategori')
		{
			$this->breadcrumb['Kategori Bisnis Proses'] = base_url('bispro_kategori');
		}
	}

	public function setBreadcrumbPengguna($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Manajemen Pengguna' => base_url()
		);

		if($change == 'groups')
		{
			$this->breadcrumb['Grup Pengguna'] = base_url('groups');	
		}
		elseif($change == 'groups_fungsi')
		{
			$this->breadcrumb['Group Pengguna'] = base_url('groups');
			$this->breadcrumb[$param->name] = base_url('groups/fungsi/'.$param->id);	
		}
		elseif($change == 'users')
		{
			$this->breadcrumb['Pengguna'] = base_url('users');	
		}
		elseif($change == 'fungsi_kelompok')
		{
			$this->breadcrumb['Fungsi Kelompok'] = base_url('fungsi_kelompok');	
		}
		elseif($change == 'fungsi_pengguna')
		{
			$this->breadcrumb['Fungsi Pengguna'] = base_url('fungsi_pengguna');	
		}
		elseif($change == 'fungsi_dependency')
		{
			$this->breadcrumb['Fungsi Pengguna'] = base_url('fungsi_pengguna');
			$this->breadcrumb[$param->nama] = base_url('fungsi_pengguna/dependency'.$param->id);
			$this->breadcrumb['Fungsi Dependency'] = base_url();
		}
		elseif($change == 'fungsi_karyawan')
		{
			$this->breadcrumb['Fungsi Pengguna'] = base_url('fungsi_pengguna');
			$this->breadcrumb[$param->nama] = base_url('fungsi_pengguna/karyawan'.$param->id);
			$this->breadcrumb['Fungsi Karyawan'] = base_url();
		}
		elseif($change == 'fungsi_include')
		{
			$this->breadcrumb['Fungsi Pengguna'] = base_url('fungsi_pengguna');
			$this->breadcrumb[$param->nama] = base_url('fungsi_pengguna/includes'.$param->id);
			$this->breadcrumb['Fungsi Include'] = base_url();
		}
		elseif($change == 'groups_jabatan')
		{
			$this->breadcrumb['Grup Jabatan'] = base_url('groups_jabatan');	
		}
		elseif($change == 'groups_karyawan')
		{
			$this->breadcrumb['Grup Karyawan'] = base_url('groups_karyawan');	
		}
	}

	public function setBreadcrumbReferensi($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Pengumuman' => base_url()
		);

		if($change == 'agama')
		{
			$this->breadcrumb['Agama'] = base_url('agama');	
		}
		elseif($change == 'bank')
		{
			$this->breadcrumb['Bank'] = base_url('Bank');	
		}
		elseif($change == 'instansi_pendidikan')
		{
			$this->breadcrumb['Instansi Pendidikan'] = base_url('instansi_pendidikan');	
		}
		elseif($change == 'jenis_kelamin')
		{
			$this->breadcrumb['Jenis Kelamin'] = base_url('jenis_kelamin');	
		}
		elseif($change == 'jenis_kontak')
		{
			$this->breadcrumb['Jenis Kontak'] = base_url('jenis_kontak');	
		}
		elseif($change == 'jenis_organisasi')
		{
			$this->breadcrumb['Jenis Organisasi'] = base_url('jenis_organisasi');	
		}
		elseif($change == 'jenis_pendidikan')
		{
			$this->breadcrumb['Jenis Pendidikan'] = base_url('jenis_pendidikan');	
		}
		elseif($change == 'jenjang_pendidikan')
		{
			$this->breadcrumb['Jenjang Pendidikan'] = base_url('jenjang_pendidikan');	
		}
		elseif($change == 'level_penghargaan')
		{
			$this->breadcrumb['Level Penghargaan'] = base_url('level_penghargaan');	
		}
		elseif($change == 'lokasi_kerja')
		{
			$this->breadcrumb['Lokasi Kerja'] = base_url('lokasi_kerja');	
		}
		elseif($change == 'status_karyawan')
		{
			$this->breadcrumb['Status Karyawan'] = base_url('status_karyawan');	
		}
		elseif($change == 'status_nikah')
		{
			$this->breadcrumb['Status Nikah'] = base_url('status_nikah');	
		}

		if($action=="create")
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			$this->breadcrumb[$param->nama] = null;
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action=="delete")
		{
			$this->breadcrumb['Hapus'] = null;
		}
	}

	public function setBreadcrumbPresensi($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Presensi Karyawan' => base_url()
		);

		if($change == 'bulan')
		{
			$this->breadcrumb['Bulan'] = base_url('bulan');
		}
		elseif($change == 'hari_libur')
		{
			$this->breadcrumb['Hari Libur'] = base_url('hari_libur');	
		}
		elseif($change == 'riwayat_hari_libur')
		{
			$this->breadcrumb['Riwayat Hari Libur'] = base_url('riwayat_hari_libur');	
		}
		elseif($change == 'kehadiran_source')
		{
			$this->breadcrumb['Asal Kehadiran'] = base_url('kehadiran_source');	
		}
		elseif($change == 'hari_ini')
		{
			$this->breadcrumb['Rekap Kehadiran'] = base_url('rekap_kehadiran');
			$this->breadcrumb['Kehadiran Hari ini'] = base_url('rekap_kehadiran');
		}
		elseif($change == 'daftar_kehadiran')
		{
			$this->breadcrumb['Rekap Kehadiran'] = base_url('rekap_kehadiran');
			$this->breadcrumb['Kehadiran dalam Sebulan'] = base_url('rekap_kehadiran/daftar');
		}
		elseif($change == 'rekap_kehadiran')
		{
			$this->breadcrumb['Rekap Kehadiran'] = base_url('rekap_kehadiran');
			$this->breadcrumb['Kehadiran Per Bulan'] = base_url('rekap_kehadiran/rekap');
		}
		elseif($change == 'usulan_presensi')
		{
			$this->breadcrumb['Usulan Kehadiran'] = base_url('usulan_presensi');
		}


		if($action=="create")
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			$this->breadcrumb[$param->nama] = null;
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action=="delete")
		{
			$this->breadcrumb['Hapus'] = null;
		}
		elseif($action=="view")
		{
			$this->breadcrumb['Lihat Usulan Presensi'] = base_url('usulan_presensi/view/').encode_url($param->id);
			$this->breadcrumb[$param->nama] = null;
		}
	}

	public function setBreadcrumbDJM($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Job Distinct Manual' => base_url('djm')
		);

		// if($change == 'dua_bulan_terakhir')
		// {
		// 	$this->breadcrumb['Dua Bulan Terakhir'] = base_url('kontrak_karyawan/dua_bulan_terakhir');
		// }

		if($action=="create")
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			$this->breadcrumb[$param->jabatan] = null;
		$this->breadcrumb['Edit'] = null;
		}
		elseif($action=="delete")
		{
			$this->breadcrumb['Hapus'] = null;
		}
		elseif($action=="view")
		{
			$this->breadcrumb['Job Distinct Manual'] = base_url('djm');
			$this->breadcrumb[$param->jabatan] = null;
		}
	}

	public function setBreadcrumbAssesment($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Assessment' => base_url('assessment')
		);

		if($change == 'assessment_lembaga')
		{
			$this->breadcrumb['Lembaga Assessment'] = base_url('kontrak_karyawan/assessment_lembaga');
		}
		elseif($change == 'assessment_kesimpulan')
		{
			$this->breadcrumb['Kesimpulan Assessment'] = base_url('kontrak_karyawan/assessment_kesimpulan');
		}
		elseif($change == 'assessment_kategori')
		{
			$this->breadcrumb['Kategori Assessment'] = base_url('kontrak_karyawan/assessment_kategori');
		}
		elseif($change == 'assessment_hasil')
		{
			$this->breadcrumb['Hasil Assessment'] = base_url('kontrak_karyawan/assessment_hasil');
		}
		elseif($change == 'assessment_jenis')
		{
			$this->breadcrumb['Jenis Assessment'] = base_url('kontrak_karyawan/assessment_jenis');
		}

		if($action=="create")
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			$this->breadcrumb[$param->nama] = null;
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action=="delete")
		{
			$this->breadcrumb['Hapus'] = null;
		}
		elseif($action=="view")
		{
			$this->breadcrumb['Assesment'] = base_url('assessment/').encode_url($param->id);
			$this->breadcrumb[$param->nama] = null;
		}
	}

	public function setBreadcrumbReferensiSO($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Referensi SO' => base_url()
		);

		if($change == 'klasifikasi')
		{
			$this->breadcrumb['klasifikasi'] = base_url('/Referensi_so/klasifikasi');	
		}
		elseif($change == 'item')
		{
			$this->breadcrumb['item'] = base_url('/Referensi_so/item');	
		}
		elseif($change == 'klasifikasi_layanan')
		{
			$this->breadcrumb['klasifikasi layanan'] = base_url('/Referensi_so/klasifikasi_layanan');	
		}
		elseif($change == 'perangkat')
		{
			$this->breadcrumb['perangkat'] = base_url('/Referensi_so/perangkat');	
		}
		elseif($change == 'perangkat_layanan')
		{
			$this->breadcrumb['perangkat layanan'] = base_url('/Referensi_so/perangkat_layanan');	
		}
		elseif($change == 'zona')
		{
			$this->breadcrumb['zona'] = base_url('/Referensi_so/zona');	
		}
		elseif($change == 'tarif')
		{
			$this->breadcrumb['tarif'] = base_url('/Referensi_so/tarif');	
		}

		if($action=="create")
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			$this->breadcrumb[$param->nama] = null;
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action=="delete")
		{
			$this->breadcrumb['Hapus'] = null;
		}
	}

	public function setBreadcrumbSO($change,$action=null,$param=null)
	{
		$this->breadcrumb = array(
			'Service Order' => base_url('usulan_service_order')
		);

		if($action=="create")
		{
			$this->breadcrumb['Tambah'] = null;
		}
		elseif($action=="edit")
		{
			$this->breadcrumb['Edit'] = null;
		}
		elseif($action=="view")
		{
			$this->breadcrumb['View'] = null;
		}
		elseif($action=="delete")
		{
			$this->breadcrumb['Hapus'] = null;
		}
	}

	public function getNavbar(){
		return parent::getMenu();
	}
	public function getBreadcrumb(){
		return $this->breadcrumb;
	}
}
