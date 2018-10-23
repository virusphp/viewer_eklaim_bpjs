SELECT nama_pegawai FROM dbo.user_login_sep;

select ROW_NUMBER() OVER(ORDER BY rj.no_reg ASC) as antrian, rj.no_reg, rj.kd_poliklinik, r.tgl_reg from dbo.Registrasi as r inner join dbo.Rawat_Jalan as rj on r.no_reg=rj.no_reg where rj.kd_poliklinik='4' and r.no_reg like '01040818%';

SELECT noantrian FROM (
  SELECT
    ROW_NUMBER() OVER (ORDER BY rj.no_reg ASC) AS noantrian, rj.no_reg, rj.kd_poliklinik
    FROM dbo.Registrasi as r inner join dbo.Rawat_Jalan as rj on r.no_reg=rj.no_reg where rj.kd_poliklinik='4' and r.tgl_reg = '2018-08-04'
)  AS regis_pasien
WHERE no_reg = '010408180279' 
Go