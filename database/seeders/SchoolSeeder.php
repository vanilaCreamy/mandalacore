<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools_data = [
            ['school_code' => '001/I/SKL-CPK','school_name' => 'KOBER AL HIDAYAH','address' => 'Dsn. Balandongan Rt.03 Rw. 02 Ds. Mandalare Kec. Panjalu Kab. Ciamis','school_level' => 'I','pic_name' => 'Imas Samrotul Fuadah, S.Pd','pic_position' => 'Kepala Sekolah','pic_phone_number' => '81222271307','pic_email' => 'imassamrotul09@gmail.com'],
            ['school_code' => '002/III/SKL-CPK','school_name' => 'SDN 4 CIOMAS','address' => 'Dsn. Ciomas Landeuh Rt 20/ 19 Desa Ciomas Kec. Panjalu','school_level' => 'III','pic_name' => 'Herlin, S.P','pic_position' => 'Guru','pic_phone_number' => '81321261283','pic_email' => 'herlin521@guru.sd.belajar.id'],
            ['school_code' => '003/I/SKL-CPK','school_name' => 'KOBER RIYADLUL JANNAH','address' => 'Dusun Baros Rt 16 Rw 07 Desa Ciomas Kecamatan Panjalu Kabupaten Ciamis','school_level' => 'I','pic_name' => 'Syifa Iklima','pic_position' => 'Operator/ Guru','pic_phone_number' => '85861023832','pic_email' => 'syifaiklima6@gmail.com'],
            ['school_code' => '004/III/SKL-CPK','school_name' => 'SD NEGERI 7 PANJALU','address' => 'Dsn. Parcariang Desa/Kec. Panjalu Kab. Ciamis','school_level' => 'III','pic_name' => 'Guntur Irianto, S.Pd.I','pic_position' => 'Guru','pic_phone_number' => '82120034993','pic_email' => 'gunturgamarazta@gmail.com'],
            ['school_code' => '005/II/SKL-CPK','school_name' => 'TK NURUL HUDA','address' => 'Dusun Banjar Rt 20 Rw 07','school_level' => 'II','pic_name' => 'Aan Nurjasanah','pic_position' => 'Guru','pic_phone_number' => '81298817871','pic_email' => 'aanelestohary14@gmail.com'],
            ['school_code' => '006/III/SKL-CPK','school_name' => 'SDN 2 MANDALARE','address' => 'Balandongan','school_level' => 'III','pic_name' => 'EVI NOVIANA, S.Pd.I.','pic_position' => 'GURU','pic_phone_number' => '85295325932','pic_email' => 'evinoviana699@gmail.com'],
            ['school_code' => '007/III/SKL-CPK','school_name' => 'SDN 3 KERTAMANDALA','address' => 'Dusun Banjarlangenan Desa Kertamandala','school_level' => 'III','pic_name' => 'TUTI SUGIARTI, S.Pd.I','pic_position' => 'GURU','pic_phone_number' => '81221425163','pic_email' => 'sugiartituti8@gmail.com'],
            ['school_code' => '008/I/SKL-CPK','school_name' => 'KOBER MIFTAHUL HUDA','address' => 'Dsn Cikareo Ds. Ciomas Kec.Panjalu Kab. Ciamis','school_level' => 'I','pic_name' => 'Yanti Barokah lastri','pic_position' => 'Guru','pic_phone_number' => '85211813893','pic_email' => 'yantibarokah942@gmail.com'],
            ['school_code' => '009/I/SKL-CPK','school_name' => 'KOBER AL-ISTIQOMAH','address' => 'Dusun Ciomas Rt 003/Rw 002 Desa Ciomas Kec. Panjalu Kab. Ciamis','school_level' => 'I','pic_name' => 'Pipih Ratnasari, S. Pd','pic_position' => 'Kepala Sekolah','pic_phone_number' => '85322499507','pic_email' => 'pipihratnasari377@gmail.com'],
            ['school_code' => '010/II/SKL-CPK','school_name' => 'TKA. NURUL ULUM','address' => 'Dusun Selauni, Jalan Cicangkrung Rt.015/Rw.005 Kertamandala - Panjalu - Ciamis','school_level' => 'II','pic_name' => 'Eva Suryani','pic_position' => 'Guru','pic_phone_number' => '8979729133','pic_email' => 'evafaal@gmail.com'],
            ['school_code' => '011/II/SKL-CPK','school_name' => 'RA AL HIKMAH','address' => 'Jln.Panjalu-Kawali, Ds.Ciomas, Kec.Panjalu, Kab.Ciamis','school_level' => 'II','pic_name' => 'Oom Maryani, S.Pd.I','pic_position' => 'Kepala Sekolah','pic_phone_number' => '85723690300','pic_email' => 'jj0434072@gmail.com'],
            ['school_code' => '012/III/SKL-CPK','school_name' => 'MIS BABUSSALAM','address' => 'Dusun Hanjatan Desa Ciomas Kecamatan Panjalu Kabupaten Ciamis','school_level' => 'III','pic_name' => 'Sri Ratnasari, S.Pd.','pic_position' => 'Guru','pic_phone_number' => '85890767564','pic_email' => 'sriratna532@gmail.com'],
            ['school_code' => '013/I/SKL-CPK','school_name' => 'KOBER BABUSSALAM','address' => 'Dusun Hanjatan Rt/Rw 21/10 Desa Ciomas,Kecamatan Panjalu,Kabupaten Ciamis','school_level' => 'I','pic_name' => 'Utin Sutinah','pic_position' => 'Guru','pic_phone_number' => '85320693322','pic_email' => 'sutinahutin3@gmail.com'],
            ['school_code' => '014/III/SKL-CPK','school_name' => 'SDN 2 KERTAMANDALA','address' => 'Dusun Cibugur, Rt. 004/Rw, 001, Desa Kertamandala, Kec. Panjalu, Kab. Ciamis','school_level' => 'III','pic_name' => 'Anggie Prabusenja, S.Pd.I','pic_position' => 'Guru','pic_phone_number' => '81294949705','pic_email' => 'anggieprabusenja88@guru.sd.belajar.id'],
            ['school_code' => '015/II/SKL-CPK','school_name' => 'TK AL FALAH','address' => 'Kp.Kertabraya, Desa Kertandala,Kec.Panjalu,Kab.Ciamis','school_level' => 'II','pic_name' => 'Ade sri sadiah','pic_position' => 'Guru','pic_phone_number' => '85310718347','pic_email' => 'ilhamazamfariz@gmail.com'],
            ['school_code' => '016/IV/SKL-CPK','school_name' => 'SMP IT AL-AMANAH','address' => 'Dusun Garahang Rt 29 Rw 13 Desa Panjalu Kec.Panjalu Kab.Ciamis','school_level' => 'IV','pic_name' => 'Zakaria S.Pd','pic_position' => 'Kepala Sekolah','pic_phone_number' => '82310368533','pic_email' => 'lactobacilusprotektus@gmail.com'],
            ['school_code' => '017/I/SKL-CPK','school_name' => 'KOBER NURLUKMAN 2','address' => 'Dusun Cibungur Rt/Rw 03/01 Desa.Kertamandala Kec.Panjalu Kab.Ciamis','school_level' => 'I','pic_name' => 'Widi febriani','pic_position' => 'Guru','pic_phone_number' => '85927322643','pic_email' => 'febrianiwidi44@gmail.com'],
            ['school_code' => '018/I/SKL-CPK','school_name' => 'KOBER RIYADUL HUDA','address' => 'Dusun Bojong Sari Rt/Rw 26/12, Desa Ciomas, Kec. Panjalu, Kab. Ciamis, Prov. Jawa Barat','school_level' => 'I','pic_name' => 'Ai Eti Sukmawati','pic_position' => 'Guru Pengajar','pic_phone_number' => '82315899282','pic_email' => 'etisukmawati406@gmail.com'],
            ['school_code' => '019/I/SKL-CPK','school_name' => 'KOBER AL HIKMAH','address' => 'Dusun Paricariang Desa Panjalu','school_level' => 'I','pic_name' => 'Ai Sukaesih, S.Pd','pic_position' => 'Kepala Sekolah','pic_phone_number' => '81321525811','pic_email' => 'aisukaesih81@gmail.com'],
            ['school_code' => '020/II/SKL-CPK','school_name' => 'RA NURUL HUDA','address' => 'Dusun Bojongsereh Rt/Rw.33/15 Desa Ciomas Kecamatan Panjalu','school_level' => 'II','pic_name' => 'Yuyu yuliati, S.Pd.','pic_position' => 'Kepala sekolah','pic_phone_number' => '82216519098','pic_email' => 'yuyuyuliati1234@gmail.com'],
            ['school_code' => '021/II/SKL-CPK','school_name' => 'TK AL-IMAN NUR LUKMAN','address' => 'Dsn Reumalega Rt 08/02 Ds Kertamandala Kec Panjalu Kab Ciamis','school_level' => 'II','pic_name' => 'Yuli Sulastri Suparman, S.Pd','pic_position' => 'Kepala Sekolah','pic_phone_number' => '81394381961','pic_email' => 'sulastriyuli47@gmail.coma'],
            ['school_code' => '022/I/SKL-CPK','school_name' => 'PAUD KOBER AL AMIN','address' => 'Dusun Banjar Rt 21 Rw 08 Desa Kertamandala Kec Panjalu Kab Ciamis','school_level' => 'I','pic_name' => 'Ai latifatussadiah','pic_position' => 'Guru','pic_phone_number' => '82219960861','pic_email' => 'ailatifatussadiah@gmail.com'],
            ['school_code' => '023/II/SKL-CPK','school_name' => 'RA MUSLIMIN PANJALU','address' => 'Jln. Raya Panjalu Dusun Cukangpadung Rt/Rw 008/004 Desa Panjalu, Kec. Panjalu Kab. Ciamis','school_level' => 'II','pic_name' => 'Wida Farida, S. SOS','pic_position' => 'Kepala Sekolah','pic_phone_number' => '81321225216','pic_email' => 'widafaridara@gmail.com'],
            ['school_code' => '024/III/SKL-CPK','school_name' => 'SDN 1 KERTAMANDALA','address' => 'Dusun Mandala Rt 17/Rw 06','school_level' => 'III','pic_name' => 'Nopianti,S.Pd.I','pic_position' => 'Guru','pic_phone_number' => '82120316278','pic_email' => 'nopianti04@guru.sd.belajar.id'],
            ['school_code' => '025/III/SKL-CPK','school_name' => 'SDN 3 CIOMAS','address' => 'Dusun Ciceuri Desa Ciomas Kecamatan Panjalu Kab. Ciamis','school_level' => 'III','pic_name' => 'Suci Nurlina, S.Pd.','pic_position' => 'Guru PJOK','pic_phone_number' => '6282126975563','pic_email' => 'sdnciomas376@gmail.com'],
            ['school_code' => '026/II/SKL-CPK','school_name' => 'RA ALQURAN ALHIDAYAH','address' => 'Dusun Garahang Rt 27 Rw 12 Desa Panjalu Kec.Panjalu Kab.Ciamis','school_level' => 'II','pic_name' => 'Ai Nurhayati','pic_position' => 'Guru kelas','pic_phone_number' => '85221372206','pic_email' => 'hasanjengkol54@gmail.com'],
            ['school_code' => '027/III/SKL-CPK','school_name' => 'SDN 2 CIOMAS','address' => 'Dusun Bojongsereh Desa Ciomas Kecamatan Panjalu Kabupaten Ciamis','school_level' => 'III','pic_name' => 'ACE DIDIN KOMARUDIN,S.Pd','pic_position' => 'KEPALA SEKOLAH','pic_phone_number' => '6285223299663','pic_email' => 'acedidi04@gmail.com'],
            ['school_code' => '028/I/SKL-CPK','school_name' => 'KOBER NURUL HIKMAH','address' => 'Dusin Tembong Rt 010 / 003 Kertamandala Panjalu Ciamis','school_level' => 'I','pic_name' => 'Nunung','pic_position' => 'Pengelola','pic_phone_number' => '81220315524','pic_email' => 'nunungid8943@gmail.com'],
            ['school_code' => '029/II/SKL-CPK','school_name' => 'RA NURUL HIDAYAH','address' => 'Dusun Mandala Rt 018 Rw 006 Desa Kertamandala Kecamatan Panjalu Kabupaten Ciamis','school_level' => 'II','pic_name' => 'Senny Anggraeni Lukmansyah','pic_position' => 'Guru / Operator','pic_phone_number' => '81321133041','pic_email' => 'sennyanggraeni30@gmail.com'],
            ['school_code' => '030/I/SKL-CPK','school_name' => 'PAUD KOBER NURUL HIDAYAH','address' => 'Dsn Ciomaslandeuh Rt.20 Rw.09 Desa Ciomas Kec Panjalu Kab Ciamis','school_level' => 'I','pic_name' => 'Agus Hamdani, S.Pd.I','pic_position' => 'Kepala/Ketua Pengelola','pic_phone_number' => '85224562073','pic_email' => 'agushamdani130780@gmail.com'],
            ['school_code' => '031/I/SKL-CPK','school_name' => 'POS PAUD CEMPAKA','address' => 'Ciroyom Rt19 Rw 09, Mandalare, Panjalu, Ciamis','school_level' => 'I','pic_name' => 'Dian Trisnawati','pic_position' => 'Pendidik','pic_phone_number' => '82119477221','pic_email' => 'diantrisnawati1981@gmail.com'],
            ['school_code' => '032/V/SKL-CPK','school_name' => 'SMK PUTRA PANJALU','address' => 'Jalan Panjalu-Kawali Dusun Garahang Rt/Rw: 028/012 Desa Panjalu Kecamatan Panjalu','school_level' => 'V','pic_name' => 'Ade Halimah, S.Sos, Gr','pic_position' => 'Guru','pic_phone_number' => '85707152250','pic_email' => 'shanumel42@gmail.com'],
            ['school_code' => '033/V/SKL-CPK','school_name' => 'SMK INDUSTRI PERUNGGASAN PANJALU','address' => 'Dsn. Mandala Rt/Rw 18/06 Desa Kertamandala Kec. Panjalu, Kab. Ciamis Prov. Jawa Barat','school_level' => 'V','pic_name' => 'Triyan Holilur Rohman, S.Pd.','pic_position' => 'Operator','pic_phone_number' => '81210613439','pic_email' => 'triyanholilurrohman5@gmail.com'],
            ['school_code' => '034/III/SKL-CPK','school_name' => 'SDN 1 MANDALARE','address' => 'Dusun Panyingkiran Desa Mandalare Kec. Panjalu','school_level' => 'III','pic_name' => 'Fikri Maulana Herdi. S.Pd','pic_position' => 'Guru','pic_phone_number' => '81324251227','pic_email' => 'fikriaang2@gmail.com'],
            ['school_code' => '035/I/SKL-CPK','school_name' => 'KOBER NURUL ZANNAH','address' => 'Dusun Garahang Rt/Rw 28/12 Ds. Panjalu Kec. Panjalu Kab. Ciamis','school_level' => 'I','pic_name' => 'Siti Julaeha','pic_position' => 'Kepala Sekolah','pic_phone_number' => '82123866514','pic_email' => 'aisitijulaeha47@gmail.com'],
            ['school_code' => '036/IV/SKL-CPK','school_name' => 'SMP MIFTAHUL KHOER BOARDING SCHOOL','address' => 'Jl. Kertamandala No 56 Dusun Mandala Rt 017 Rw 006 Desa Kertamandala Kecamatan Panjalu Kabupaten Ciamis','school_level' => 'IV','pic_name' => 'Lala latifah','pic_position' => 'Guru','pic_phone_number' => '85624883706','pic_email' => 'lalamufty@gmail.com'],
            ['school_code' => '037/V/SKL-CPK','school_name' => 'SMA MIFTAHUL KHOER BOARDING SCHOOL','address' => 'Jl. Kertamandala No 56 Dusun Mandala Rt 017 Rw 006 Desa Kertamandala Kecamatan Panjalu Kabupaten Ciamis','school_level' => 'V','pic_name' => 'Kiki Baehaqi Saepul millah S.Pd.','pic_position' => 'Kepala Sekolah','pic_phone_number' => '82127952012','pic_email' => 'baihakki2015@gmail.com'],
            ['school_code' => '038/I/SKL-CPK','school_name' => 'KOBER MIFTAHUL FALAH','address' => 'Bojong Sereh Rt/Rw 32/15,Ciomas ,Panjalu,Ciamis','school_level' => 'I','pic_name' => 'Iin inarotulhuda','pic_position' => 'Guru','pic_phone_number' => '82215008562','pic_email' => 'inarotulhuda.1984@gmail.com'],
            ['school_code' => '039/VI/SKL-CPK','school_name' => 'PONPES AL MUKHTARIYAH','address' => 'Panjalu','school_level' => 'VI','pic_name' => 'Unkown','pic_position' => '','pic_phone_number' => '','pic_email' => ''],
            ['school_code' => '040/VI/SKL-CPK','school_name' => 'PONPES MAN BAUTTOYIBAH','address' => 'Panjalu','school_level' => 'VI','pic_name' => 'Unkown','pic_position' => '','pic_phone_number' => '','pic_email' => ''],
            ['school_code' => '041/I/SKL-CPK','school_name' => 'PAUD CRISANT PURI','address' => 'Panjalu','school_level' => 'I','pic_name' => 'Unkown','pic_position' => '','pic_phone_number' => '','pic_email' => ''],
            ['school_code' => '042/II/SKL-CPK','school_name' => 'RA AL ABGHANI','address' => 'Panjalu','school_level' => 'II','pic_name' => 'Unkown','pic_position' => '','pic_phone_number' => '','pic_email' => ''],
            ['school_code' => '043/II/SKL-CPK','school_name' => 'TK ALRIYADOH','address' => 'Panjalu','school_level' => 'II','pic_name' => 'Unkown','pic_position' => '','pic_phone_number' => '','pic_email' => ''],
            ['school_code' => '044/V/SKL-CPK','school_name' => 'MA BAHRUL ULUM','address' => 'Panjalu','school_level' => 'V','pic_name' => 'Unkown','pic_position' => '','pic_phone_number' => '','pic_email' => ''],
            ['school_code' => '045/IV/SKL-CPK','school_name' => 'MTS BAHRUL ULUM','address' => 'Panjalu','school_level' => 'IV','pic_name' => 'Unkown','pic_position' => '','pic_phone_number' => '','pic_email' => ''],
    
        ];


        foreach ($schools_data as $value) {
            School::create([
                'school_code' => $value['school_code'],
                'school_name' => $value['school_name'],
                'address' => $value['address'],
                'school_level' => $value['school_level'],
                'pic_name' => $value['pic_name'],
                'pic_position' => $value['pic_position'],
                'pic_phone_number' => $value['pic_phone_number'],
                'pic_email' => $value['pic_email'],
            ]);
        }
    }
}
